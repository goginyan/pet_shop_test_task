<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Requests\OrderRequest;

class OrderController extends Controller
{
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Order::with('orderStatus')->get();
    }

    public function show(string $orderUuid): Order|\Illuminate\Http\JsonResponse
    {
        return (Order::with('orderStatus')->where('uuid', $orderUuid)->first() ?? response()->json(['status' => 'error', 'message' => 'Order not found'], 404));
    }

    public function store(OrderRequest $request): mixed
    {
        return Order::factory()->create([
           'user_id' => $request->user_id,
           'payment_id' => $request->payment_id,
           'order_status_id' => $request->order_status_id,
           'products' => json_encode($request->products),
           'address' => json_encode($request->address),
           'amount' => $request->amount,
           'delivery_fee' => $request->delivery_fee,
        ]);
    }

    public function update(OrderRequest $request): \Illuminate\Http\JsonResponse
    {
        $order = Order::where('uuid', $request->uuid);
        if ($order->exists()) {
            $order->update([
                'user_id' => $request->user_id,
                'payment_id' => $request->payment_id,
                'order_status_id' => $request->order_status_id,
                'products' => json_encode($request->products),
                'address' => json_encode($request->address),
                'amount' => $request->amount,
                'delivery_fee' => $request->delivery_fee,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'OK',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }
    }

    public function destroy(string $orderUuid): \Illuminate\Http\JsonResponse
    {
        $order = Order::where('uuid', $orderUuid);
        if ($order->exists()) {
            $order->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'OK',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }
    }
}
