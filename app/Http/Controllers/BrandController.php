<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Requests\BrandRequest;

class BrandController extends Controller
{
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Brand::all();
    }

    public function show(string $brandUuid): Brand|\Illuminate\Http\JsonResponse
    {
        return (Brand::where('uuid', $brandUuid)->first() ?? response()->json(['status' => 'error','message' => 'Brand not found'], 404));
    }

    public function store(BrandRequest $request): mixed
    {
        return Brand::factory()->create([
            'title' => $request->title,
            'slug' => $request->slug,
        ]);
    }

    public function update(BrandRequest $request): \Illuminate\Http\JsonResponse
    {
        $brand = Brand::where('uuid', $request->uuid);
        if ($brand->exists()) {
            $brand->update([
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
                'message' => 'Brand not found',
            ], 404);
        }
    }

    public function destroy(string $brandUuid): \Illuminate\Http\JsonResponse
    {
        $brand = Brand::where('uuid', $brandUuid);
        if ($brand->exists()) {
            $brand->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'OK',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Brand not found',
            ], 404);
        }
    }
}
