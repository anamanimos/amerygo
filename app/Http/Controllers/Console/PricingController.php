<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        $pricings = Pricing::all();
        return view('console.pricings.index', compact('pricings'));
    }

    public function create()
    {
        return view('console.pricings.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'original_price' => 'required|integer',
            'discounted_price' => 'required|integer',
            'is_best_seller' => 'boolean',
            'features' => 'nullable|array',
            'cta_text' => 'nullable|string|max:255',
            'cta_link' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['is_best_seller'] = $request->has('is_best_seller');
        
        // Ensure features is a properly formatted array if it exists
        if (isset($data['features']) && is_array($data['features'])) {
            $formattedFeatures = [];
            foreach ($data['features'] as $feature) {
                if (!empty($feature['name'])) {
                    $formattedFeatures[] = [
                        'name' => $feature['name'],
                        'included' => isset($feature['included']) ? true : false,
                    ];
                }
            }
            $data['features'] = $formattedFeatures;
        }

        Pricing::create($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Paket harga berhasil ditambahkan.']);
        }

        return redirect()->route('console.pricings.index')->with('success', 'Paket harga berhasil ditambahkan.');
    }

    public function edit(Pricing $pricing)
    {
        return view('console.pricings.form', compact('pricing'));
    }

    public function update(Request $request, Pricing $pricing)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'original_price' => 'required|integer',
            'discounted_price' => 'required|integer',
            'is_best_seller' => 'boolean',
            'features' => 'nullable|array',
            'cta_text' => 'nullable|string|max:255',
            'cta_link' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['is_best_seller'] = $request->has('is_best_seller');
        
        if (isset($data['features']) && is_array($data['features'])) {
            $formattedFeatures = [];
            foreach ($data['features'] as $feature) {
                if (!empty($feature['name'])) {
                    $formattedFeatures[] = [
                        'name' => $feature['name'],
                        'included' => isset($feature['included']) ? true : false,
                    ];
                }
            }
            $data['features'] = $formattedFeatures;
        } else {
            $data['features'] = [];
        }

        $pricing->update($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Paket harga berhasil diperbarui.']);
        }

        return redirect()->route('console.pricings.index')->with('success', 'Paket harga berhasil diperbarui.');
    }

    public function destroy(Pricing $pricing)
    {
        $pricing->delete();
        return redirect()->route('console.pricings.index')->with('success', 'Paket harga berhasil dihapus.');
    }
}
