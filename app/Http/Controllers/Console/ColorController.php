<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view('console.colors.index', compact('colors'));
    }

    public function create()
    {
        return view('console.colors.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'hex_code' => 'nullable|string|max:7',
        ]);
        
        $color = Color::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true, 
                'message' => 'Warna berhasil ditambahkan.',
                'color' => $color
            ]);
        }

        return redirect()->route('console.colors.index')->with('success', 'Warna berhasil ditambahkan.');
    }

    public function edit(Color $color)
    {
        return view('console.colors.form', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'hex_code' => 'nullable|string|max:7',
        ]);
        
        $color->update($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Warna berhasil diperbarui.']);
        }

        return redirect()->route('console.colors.index')->with('success', 'Warna berhasil diperbarui.');
    }

    public function destroy(Color $color)
    {
        $color->delete();
        return redirect()->route('console.colors.index')->with('success', 'Warna berhasil dihapus.');
    }
}
