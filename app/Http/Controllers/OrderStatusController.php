<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return OrderStatus::with('orders')->get();
    }

    public function show(string $orderStatusUuid): OrderStatus|\Illuminate\Http\JsonResponse
    {
        return (OrderStatus::with('orders')->where('uuid', $orderStatusUuid)->first() ?? response()->json(['status' => 'error', 'message' => 'Order status not found'], 404));
    }

    public function store(Request $request): mixed
    {
        return OrderStatus::factory()->create([
           'title' => $request->title,
        ]);
    }

    public function update(Request $request): \Illuminate\Http\JsonResponse
    {
        $orderStatus = OrderStatus::where('uuid', $request->uuid);
        if ($orderStatus->exists()) {
            $orderStatus->update([
                'title' => $request->title,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'OK',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Order status not found',
            ], 404);
        }
    }

    public function destroy(string $orderStatusUuid): \Illuminate\Http\JsonResponse
    {
        $orderStatus = OrderStatus::where('uuid', $orderStatusUuid);
        if ($orderStatus->exists()) {
            $orderStatus->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'OK',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Order status not found',
            ], 404);
        }
    }
}
