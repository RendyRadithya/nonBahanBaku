<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = \App\Models\Product::where('vendor_id', auth()->id())->latest()->get();
        return view('dashboards.vendor.products', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $validated['vendor_id'] = auth()->id();
        
        \App\Models\Product::create($validated);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $product = \App\Models\Product::where('vendor_id', auth()->id())->findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $product->update($validated);

        return redirect()->back()->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $product = \App\Models\Product::where('vendor_id', auth()->id())->findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus');
    }
}
