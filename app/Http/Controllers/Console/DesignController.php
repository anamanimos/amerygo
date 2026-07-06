<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\DesignCategory;
use App\Models\Color;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DesignController extends Controller
{
    private function getLimit()
    {
        return (int) (Setting::where('key', 'limit_designs')->value('value') ?? 20);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Design::with(['categories', 'colors']);

            // Searching
            if ($request->has('search') && !empty($request->search['value'])) {
                $searchValue = $request->search['value'];
                $query->where('name', 'like', "%{$searchValue}%");
            }

            // Count total and filtered
            $totalRecords = Design::count();
            $filteredRecords = $query->count();

            // Ordering
            if ($request->has('order')) {
                $orderColumnIndex = $request->order[0]['column'];
                $orderDirection = $request->order[0]['dir'];
                $columns = ['id', 'name', 'categories', 'is_active', 'created_at', 'id'];
                $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';
                
                if ($orderColumn !== 'categories') {
                    $query->orderBy($orderColumn, $orderDirection);
                } else {
                    $query->latest();
                }
            } else {
                $query->latest();
            }

            // Pagination
            if ($request->has('start') && $request->has('length')) {
                if ($request->length != -1) {
                    $query->skip($request->start)->take($request->length);
                }
            }

            $designs = $query->get();

            $data = [];
            foreach ($designs as $design) {
                $imageUrl = $design->image ? Storage::disk('public')->url(str_replace('storage/', '', $design->image)) : 'https://ui-avatars.com/api/?name=Design&background=random';
                $categoriesStr = $design->categories->pluck('name')->implode(', ') ?: '-';
                
                $statusBadge = $design->is_active ? '<span class="badge badge-light-success">Aktif</span>' : '<span class="badge badge-light-warning">Nonaktif</span>';
                
                $editUrl = route('console.designs.edit', $design->id);
                $deleteUrl = route('console.designs.destroy', $design->id);
                
                $actions = '
                    <a href="'.$editUrl.'" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                        <i class="ki-duotone ki-pencil fs-2"><span class="path1"></span><span class="path2"></span></i>
                    </a>
                    <form action="'.$deleteUrl.'" method="POST" class="d-inline form-delete">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm">
                            <i class="ki-duotone ki-trash fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                        </button>
                    </form>
                ';

                $data[] = [
                    'checkbox' => '<div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input select-row" type="checkbox" value="'.$design->id.'" /></div>',
                    'design' => '
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-50px me-3">
                                <img src="'.$imageUrl.'" style="object-fit: cover;" alt="" />
                            </div>
                            <div class="d-flex justify-content-start flex-column">
                                <a href="'.$editUrl.'" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">'.$design->name.'</a>
                            </div>
                        </div>',
                    'categories' => $categoriesStr,
                    'status' => $statusBadge,
                    'created_at' => $design->created_at ? $design->created_at->format('d M Y') : '-',
                    'actions' => $actions,
                ];
            }

            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data
            ]);
        }

        $currentCount = Design::count();
        $limit = $this->getLimit();
        $categories = DesignCategory::where('is_active', true)->get();
        $colors = Color::all();
        return view('console.designs.index', compact('currentCount', 'limit', 'categories', 'colors'));
    }

    public function create()
    {
        $limit = $this->getLimit();
        if (Design::count() >= $limit) {
            return redirect()->route('console.designs.index')->with('error', 'Batas maksimal ' . $limit . ' desain telah tercapai.');
        }
        $categories = DesignCategory::where('is_active', true)->get();
        $colors = Color::all();
        return view('console.designs.form', compact('categories', 'colors'));
    }

    public function store(Request $request)
    {
        $limit = $this->getLimit();
        if (Design::count() >= $limit) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Batas maksimal ' . $limit . ' desain telah tercapai.'], 403);
            }
            return redirect()->route('console.designs.index')->with('error', 'Batas maksimal ' . $limit . ' desain telah tercapai.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'categories' => 'required|array',
            'categories.*' => 'exists:design_categories,id',
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id',
            'description' => 'nullable|string',
            'cropped_image' => 'required|string',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['name']);
        
        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $count = 1;
        while (Design::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $count;
            $count++;
        }

        $data['is_active'] = $request->has('is_active');

        if ($request->filled('cropped_image')) {
            $base64Image = $request->input('cropped_image');
            $imageParts = explode(";base64,", $base64Image);
            $imageTypeAux = explode("image/", $imageParts[0]);
            $imageType = $imageTypeAux[1];
            $imageBase64 = base64_decode($imageParts[1]);
            
            $filename = uniqid() . '.' . $imageType;
            
            Storage::disk('public')->put('designs/' . $filename, $imageBase64);
            $data['image'] = 'storage/designs/' . $filename;
        }

        $design = Design::create($data);

        $design->categories()->sync($request->categories);
        if ($request->has('colors')) {
            $design->colors()->sync($request->colors);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Desain jersey berhasil ditambahkan.']);
        }

        return redirect()->route('console.designs.index')->with('success', 'Desain jersey berhasil ditambahkan.');
    }

    public function edit(Design $design)
    {
        $categories = DesignCategory::where('is_active', true)->get();
        $colors = Color::all();
        return view('console.designs.form', compact('design', 'categories', 'colors'));
    }

    public function update(Request $request, Design $design)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'categories' => 'required|array',
            'categories.*' => 'exists:design_categories,id',
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id',
            'description' => 'nullable|string',
            'cropped_image' => 'nullable|string',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['name']);
        
        // Ensure slug is unique (ignoring current)
        $originalSlug = $data['slug'];
        $count = 1;
        while (Design::where('slug', $data['slug'])->where('id', '!=', $design->id)->exists()) {
            $data['slug'] = $originalSlug . '-' . $count;
            $count++;
        }

        $data['is_active'] = $request->has('is_active');

        if ($request->filled('cropped_image')) {
            if ($design->image) {
                Storage::disk('public')->delete(str_replace('storage/', '', $design->image));
            }
            $base64Image = $request->input('cropped_image');
            $imageParts = explode(";base64,", $base64Image);
            $imageTypeAux = explode("image/", $imageParts[0]);
            $imageType = $imageTypeAux[1];
            $imageBase64 = base64_decode($imageParts[1]);
            
            $filename = uniqid() . '.' . $imageType;
            
            Storage::disk('public')->put('designs/' . $filename, $imageBase64);
            $data['image'] = 'storage/designs/' . $filename;
        } elseif ($request->input('avatar_remove') == '1') {
            if ($design->image) {
                Storage::disk('public')->delete(str_replace('storage/', '', $design->image));
            }
            $data['image'] = null;
        }

        $design->update($data);

        $design->categories()->sync($request->categories);
        if ($request->has('colors')) {
            $design->colors()->sync($request->colors);
        } else {
            $design->colors()->detach();
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Desain jersey berhasil diperbarui.']);
        }

        return redirect()->route('console.designs.index')->with('success', 'Desain jersey berhasil diperbarui.');
    }

    public function destroy(Design $design)
    {
        if ($design->image) {
            Storage::disk('public')->delete(str_replace('storage/', '', $design->image));
        }
        $design->delete();
        return redirect()->route('console.designs.index')->with('success', 'Desain jersey berhasil dihapus.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,add_category,add_color',
            'design_ids' => 'required|array',
            'design_ids.*' => 'exists:designs,id'
        ]);

        $action = $request->action;
        $designIds = $request->design_ids;
        $designs = Design::whereIn('id', $designIds)->get();

        if ($action === 'delete') {
            foreach ($designs as $design) {
                if ($design->image) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $design->image));
                }
                $design->delete();
            }
            return response()->json(['success' => true, 'message' => 'Desain terpilih berhasil dihapus.']);
        }

        if ($action === 'add_category') {
            $request->validate(['category_ids' => 'required|array', 'category_ids.*' => 'exists:design_categories,id']);
            foreach ($designs as $design) {
                $design->categories()->syncWithoutDetaching($request->category_ids);
            }
            return response()->json(['success' => true, 'message' => 'Kategori berhasil ditambahkan ke desain terpilih.']);
        }

        if ($action === 'add_color') {
            $request->validate(['color_ids' => 'required|array', 'color_ids.*' => 'exists:colors,id']);
            foreach ($designs as $design) {
                $design->colors()->syncWithoutDetaching($request->color_ids);
            }
            return response()->json(['success' => true, 'message' => 'Warna berhasil ditambahkan ke desain terpilih.']);
        }

        return response()->json(['success' => false, 'message' => 'Aksi tidak valid.'], 400);
    }
}
