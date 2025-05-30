<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Danh sách sản phẩm
    public function index()
    {
        return response()->json(Product::all());
    }

    // Tạo sản phẩm mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:products,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|url',
        ]);

        $product = Product::create($validated);

        return response()->json($product, 201);
    }

    // Chi tiết sản phẩm
    public function show(Product $product)
    {
        return response()->json($product);
    }

    // Cập nhật sản phẩm
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|unique:products,name,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|url',
        ]);

        $product->update($validated);

        return response()->json($product);
    }

    // Xóa sản phẩm
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
