<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Requests\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Category::with('products')->get();
    }

    public function show(string $categoryUuid): Category|\Illuminate\Http\JsonResponse
    {
        return (Category::where('uuid', $categoryUuid)->with('products')->first() ?? response()->json(['status' => 'error', 'message' => 'Category not found'], 404));
    }

    public function store(CategoryRequest $request): mixed
    {
        return Category::factory()->create([
            'title' => $request->title,
            'slug' => $request->slug,
        ]);
    }

    public function update(CategoryRequest $request): \Illuminate\Http\JsonResponse
    {
        $category = Category::where('uuid', $request->uuid);
        if ($category->exists()) {
            $category->update([
                'title' => $request->title,
                'slug' => $request->slug,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'OK',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
            ], 404);
        }
    }

    public function destroy(string $categoryUuid): \Illuminate\Http\JsonResponse
    {
        $category = Category::where('uuid', $categoryUuid);
        if ($category->exists()) {
           $category->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'OK',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
            ], 404);
        }
    }
}
