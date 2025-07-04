<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // List products có phân trang (10 sản phẩm/trang)
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Product list',
            'data' => $products,
        ]);
    }

    // Tạo mới product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',  // image file, max 2MB
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image_url'] = Storage::url($path);
        }

        $product = Product::create($validated);

        return response()->json(['data' => $product], 201);
    }

    // Hiển thị chi tiết product (với model binding)
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Product details',
            'data' => $product,  // bọc product trong 'data'
        ]);
    }



    // Cập nhật product
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($product->image_url) {
                $oldPath = str_replace('/storage/', '', $product->image_url);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('products', 'public');
            $validated['image_url'] = Storage::url($path);
        }

        $product->update($validated);

        return response()->json(['data' => $product]);
    }


    // Xóa product
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully',
        ]);
    }
}
