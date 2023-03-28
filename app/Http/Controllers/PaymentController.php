<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Requests\PaymentRequest;

class PaymentController extends Controller
{
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Payment::with('order')->get();
    }

    public function show(string $paymentUuid): Payment|\Illuminate\Http\JsonResponse
    {
        return (Payment::with('order')->where('uuid', $paymentUuid)->first() ?? response()->json(['status' => 'error', 'message' => 'Payment not found'], 404));
    }

    public function store(PaymentRequest $request): mixed
    {
        return Payment::factory()->create([
            "type" => $request->type,
            "details" => json_encode($request->details),
        ]);
    }

    public function update(PaymentRequest $request): \Illuminate\Http\JsonResponse
    {
        $payment = Payment::where('uuid', $request->uuid);
        if ($payment->exists()) {
            $payment->update([
               "type" => $request->type,
               "details" => json_encode($request->details),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'OK',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment not found',
            ], 404);
        }
    }

    public function destroy(string $paymentUuid): \Illuminate\Http\JsonResponse
    {
        $payment = Payment::where('uuid', $paymentUuid);
        if ($payment->exists()) {
            $payment->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'OK',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment not found',
            ], 404);
        }
    }
}
