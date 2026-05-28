<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'location' => 'required|string',
            'label' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
        ]);

        $maxOrder = Menu::where('location', $request->location)->max('order');

        $menu = Menu::create([
            'location' => $request->location,
            'label' => $request->label,
            'url' => $request->url,
            'icon' => $request->icon,
            'is_new_tab' => $request->has('is_new_tab') || $request->is_new_tab == '1' || $request->is_new_tab === true,
            'order' => $maxOrder !== null ? $maxOrder + 1 : 0,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Menu item created successfully.', 'menu' => $menu]);
        }
        return back()->with('success', 'Menu item created successfully.');
    }

    public function updateAll(Request $request)
    {
        $request->validate([
            'menus' => 'required|array',
            'menus.*.label' => 'required|string|max:255',
            'menus.*.url' => 'nullable|string|max:255',
        ]);

        foreach ($request->menus as $id => $data) {
            $menu = Menu::find($id);
            if ($menu) {
                $menu->update([
                    'label' => $data['label'],
                    'url' => $data['url'] ?? null,
                    'icon' => $data['icon'] ?? null,
                    'is_new_tab' => isset($data['is_new_tab']) ? true : false,
                ]);
            }
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Semua menu berhasil disimpan.']);
        }
        return back()->with('success', 'Semua menu berhasil disimpan.');
    }

    public function destroy(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Menu item deleted successfully.']);
        }
        return back()->with('success', 'Menu item deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:menus,id',
        ]);

        foreach ($request->order as $index => $id) {
            Menu::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
