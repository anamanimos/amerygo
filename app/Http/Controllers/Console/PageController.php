<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->get();
        $currentCount = $pages->count();
        $limit = 10;
        return view('console.pages.index', compact('pages', 'currentCount', 'limit'));
    }

    public function create()
    {
        if (Page::count() >= 10) {
            return redirect()->route('console.pages.index')->with('error', 'Batas maksimal 10 halaman telah tercapai.');
        }
        return view('console.pages.create');
    }

    public function store(Request $request)
    {
        if (Page::count() >= 10) {
            return redirect()->route('console.pages.index')->with('error', 'Batas maksimal 10 halaman telah tercapai.');
        }
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (Page::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        Page::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('console.pages.index')->with('success', 'Halaman berhasil dibuat.');
    }

    public function edit(Page $page)
    {
        return view('console.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $slug = Str::slug($request->title);
        if ($slug !== $page->slug) {
            $originalSlug = $slug;
            $count = 1;
            while (Page::where('slug', $slug)->where('id', '!=', $page->id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
        }

        $page->update([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('console.pages.index')->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('console.pages.index')->with('success', 'Halaman berhasil dihapus.');
    }
}
