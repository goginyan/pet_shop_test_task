<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Product::with('category')->get();
    }

    public function show(string $productUuid): Product|\Illuminate\Http\JsonResponse
    {
        return (Product::where('uuid', $productUuid)->first() ?? response()->json(['status' => 'error', 'message' => 'Product not found'], 404));
    }

    public function store(ProductRequest $request): mixed
    {
        return Product::factory()->create([
            'category_uuid' => $request->category_uuid,
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
            'metadata' => json_encode(['brand' => $request->brand_uuid]),
        ]);
    }

    public function update(ProductRequest $request): \Illuminate\Http\JsonResponse
    {
        $product = Product::where('uuid', $request->uuid);
        if ($product->exists()) {
            $product->update([
                'category_uuid' => $request->category_uuid,
                'title' => $request->title,
                'price' => $request->price,
                'description' => $request->description,
                'metadata' => json_encode(['brand' => $request->brand_uuid]),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'OK',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }
    }

    public function destroy(string $productUuid): \Illuminate\Http\JsonResponse
    {
        $product = Product::where('uuid', $productUuid);
        if ($product->exists()) {
            $product->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'OK',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }
    }
}
