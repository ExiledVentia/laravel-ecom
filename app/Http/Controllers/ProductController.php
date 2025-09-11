<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Menampilkan semua produk (public list).
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan detail produk (public).
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan form tambah produk (admin).
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Simpan produk baru (admin).
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $image = $request->file('image');
        $imageName = $image->hashName();
        $image->storeAs('public/images', $imageName());

        Product::create([
            'image' => $imageName,
            'name'  => $validate['name'],
            'price' => $validate['price'],
            'stock' => $validate['stock'],
        ]);
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit produk (admin).
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update data produk (admin).
     */
    public function update(Request $request, $id, Product $product)
    {
        $validate = $request->validate([
            'image' => 'image|mimes:jpeg,jpg,png,webp|max:2048',
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);


        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageName = $image->hashName();
            $image->storeAs('public/images', $imageName);
            Storage::delete('public/images/' . $product->image);
            $validate['image'] = $imageName;
        }

        $product->update($validate);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk (admin).
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
