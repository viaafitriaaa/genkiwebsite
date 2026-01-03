<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Order;

class PaymentController extends Controller
{


    public function showPayment(Order $order, MidtransService $midtransService)
    {
        if (!$order->customer_name || !$order->customer_email || !$order->customer_phone) {
            return redirect()->route('checkout', $order)
                ->withErrors(['contact' => 'Lengkapi data kontak sebelum pembayaran.']);
        }

        if ($order->is_promo && !$order->promo_verified_at) {
            return redirect()->route('checkout', $order)
                ->withErrors(['payment' => 'Promo belum diverifikasi. Tunggu verifikasi admin sebelum membayar.']);
        }

        $order->load('items.product', 'items.bundle');

        $gross = $order->total_after_promo ?? $order->total;

        \Log::info('MIDTRANS AMOUNT', [
            'order_id' => $order->id,
            'total' => $order->total,
            'total_after_promo' => $order->total_after_promo,
            'gross_amount' => $gross,
        ]);

        $items = [
            [
                'id' => 'ORDER-' . $order->id,
                'price' => $gross,
                'quantity' => 1,
                'name' => 'Total Pembayaran',
            ]
        ];

        $snapToken = $midtransService->createSnapToken([
            'order_id' => (string) $order->id,
            'gross_amount' => $gross,
            'customer_name' => $order->customer_name,
            'customer_email' => $order->customer_email,
            'customer_phone' => $order->customer_phone,
            'items' => $items,
        ]);

        if (!$snapToken) {
            return redirect()->route('checkout', $order)
                ->withErrors(['payment' => 'Gagal membuat token pembayaran.']);
        }

        return view('payment', [
            'order' => $order,
            'snapToken' => $snapToken,
        ]);
    }


    public function processPayment(Order $order, Request $request, MidtransService $midtransService)
    {
        return $this->showPayment($order, $midtransService);
    }

    //  payment notification (Midtrans)
    public function handlePaymentNotification(Request $request)
    {
        $payload = $request->all();

        Log::info('MIDTRANS NOTIFICATION', $payload);

        $orderId = $payload['order_id'];
        $statusCode = $payload['status_code'];
        $grossAmount = $payload['gross_amount'];
        $signatureKey = $payload['signature_key'];

        $serverKey = config('midtrans.server_key');

        $expectedSignature = hash(
            'sha512',
            $orderId . $statusCode . $grossAmount . $serverKey
        );

        if ($signatureKey !== $expectedSignature) {
            Log::warning('INVALID MIDTRANS SIGNATURE', $payload);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $order = Order::where('id', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        
        if ($order->status === 'paid') {
            return response()->json(['message' => 'Already paid']);
        }


        $transactionStatus = $payload['transaction_status'];

        match ($transactionStatus) {
            'capture', 'settlement' => $order->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]),
            'expire' => $order->update(['status' => 'expired']),
            'cancel', 'deny' => $order->update(['status' => 'failed']),
            default => null
        };

        return response()->json(['message' => 'OK']);
    }
}
