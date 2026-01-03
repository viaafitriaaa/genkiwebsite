<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Bundle;
use App\Models\OrderItem;
use App\Models\Payment;

class OrderController extends Controller
{
    // ADD TO CART
    public function addToCart(Request $r)
    {
        $order = Order::firstOrCreate(
            ['status' => 'pending'],
            ['total' => 0]
        );

        if ($r->product_id) {
            $product = Product::findOrFail($r->product_id);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price
            ]);

            $order->total += $product->price;
        }

        if ($r->bundle_id) {
            $bundle = Bundle::findOrFail($r->bundle_id);

            OrderItem::create([
                'order_id' => $order->id,
                'bundle_id' => $bundle->id,
                'quantity' => 1,
                'price' => $bundle->price
            ]);

            $order->total += $bundle->price;
        }

        $order->save();

        return redirect()->route('checkout', $order);
    }

    // CHECKOUT PAGE
    public function checkout(Order $order)
    {
        $order->refresh();
        $order->load('items.product', 'items.bundle');
        return view('order.checkout', compact('order'));
    }

    public function updateContact(Request $request, Order $order)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:50',
            'customer_address' => 'nullable|string|max:255',
            'customer_city' => 'nullable|string|max:255',
            'customer_postal_code' => 'nullable|string|max:20',
        ]);

        $redirectToPay = $request->boolean('redirect_to_pay');

        $order->update($data);

        if ($redirectToPay) {
            return redirect()->route('order.pay', $order);
        }

        return redirect()->route('checkout', $order)->with('success', 'Data kontak tersimpan.');
    }

    // FORM PROMO
    public function promoForm(Order $order)
    {
        return view('order.promo', compact('order'));
    }

    // SUBMIT PROMO
    public function submitPromo(Request $request, Order $order)
    {
        $data = $request->validate([
            'promo_proof' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('promo_proof')->store('promo_proofs', 'public');

        $order->update([
            'is_promo' => true,
            'promo_proof_path' => $path,
            'promo_verified_at' => null,
            'promo_discount_percent' => 10,
        ]);

        return redirect()->route('checkout', $order)->with('success', 'Bukti promo terkirim, menunggu verifikasi admin.');
    }

    // BAYAR
    public function pay(Request $request, Order $order)
    {
        if (!$order->customer_name || !$order->customer_email || !$order->customer_phone) {
            return redirect()
                ->route('checkout', $order)
                ->withErrors(['contact' => 'Isi nama, email, dan nomor HP sebelum lanjut pembayaran.']);
        }

        Payment::create([
            'order_id' => $order->id,
            'method' => 'qris',
            'amount' => $order->total,
            'qris_data' => 'DUMMY_QRIS'
        ]);

        return redirect()->route('checkout', $order);
    }

    public function createFromCart(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.type' => 'required|in:product,bundle',
            'items.*.id' => 'required|integer',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:50',
            'customer_address' => 'nullable|string|max:255',
            'customer_city' => 'nullable|string|max:255',
            'customer_postal_code' => 'nullable|string|max:20',
            'go_to_pay' => 'nullable|boolean',
            'is_promo' => 'nullable|boolean',
        ]);

        $order = Order::create([
            'total' => 0,
            'status' => 'pending',
            'customer_name' => $data['customer_name'] ?? null,
            'customer_email' => $data['customer_email'] ?? null,
            'customer_phone' => $data['customer_phone'] ?? null,
            'customer_address' => $data['customer_address'] ?? null,
            'customer_city' => $data['customer_city'] ?? null,
            'customer_postal_code' => $data['customer_postal_code'] ?? null,
            'is_promo' => false,
            'promo_proof_path' => null,
            'promo_verified_at' => null,
            'promo_discount_percent' => null,
        ]);

        $total = 0;
        foreach ($data['items'] as $item) {
            if ($item['type'] === 'product') {
                $product = Product::findOrFail($item['id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price' => $product->price,
                ]);
                $total += $product->price;
            } else {
                $bundle = Bundle::findOrFail($item['id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'bundle_id' => $bundle->id,
                    'quantity' => 1,
                    'price' => $bundle->price,
                ]);
                $total += $bundle->price;
            }
        }

        $order->update(['total' => $total]);

        if (!empty($data['is_promo'])) {
            $order->update([
                'is_promo' => true,
                'promo_discount_percent' => 10,
                'promo_proof_path' => null,
                'promo_verified_at' => null,
            ]);
        }

        if (!empty($data['go_to_pay']) && !$order->is_promo) {
            return redirect()->route('order.pay', $order);
        }

        return redirect()->route('checkout', $order);
    }
    
    public function status(Order $order)
    {
        return response()->json([
            'status' => $order->status,
            'paid_at' => $order->paid_at,
        ]);
    }


    // COMPLETE VIEW
    public function completeView(Order $order)
    {
        $order->load('payment');
        return view('order.complete', compact('order'));
    }

}
