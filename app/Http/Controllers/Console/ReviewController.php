<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::all();
        return view('console.reviews.index', compact('reviews'));
    }

    public function create()
    {
        return view('console.reviews.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
            'is_active' => 'boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        Review::create($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Review berhasil ditambahkan.']);
        }

        return redirect()->route('console.reviews.index')->with('success', 'Review berhasil ditambahkan.');
    }

    public function edit(Review $review)
    {
        return view('console.reviews.form', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
            'is_active' => 'boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        $review->update($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Review berhasil diperbarui.']);
        }

        return redirect()->route('console.reviews.index')->with('success', 'Review berhasil diperbarui.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('console.reviews.index')->with('success', 'Review berhasil dihapus.');
    }
}
