<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransService
{
    public function __construct()
    {
        // Set your Midtrans configuration (for Sandbox or Production environment)
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION') === 'true';
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Generate Snap Token for payment
     *
     * @param array $orderData
     * @return string|null
     */
    public function createSnapToken(array $orderData)
    {
        // Prepare the transaction details
        $transactionDetails = [
            'order_id' => $orderData['order_id'],
            'gross_amount' => $orderData['gross_amount'],
        ];

        // Prepare the items
        $items = [];
        foreach ($orderData['items'] as $item) {
            $items[] = [
                'id' => $item['id'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'name' => $item['name'],
            ];
        }

        // Prepare customer details
        $customerDetails = [
            'first_name' => $orderData['customer_name'],
            'email' => $orderData['customer_email'],
            'phone' => $orderData['customer_phone'],
        ];

        // Build the full transaction data
        $transactionData = [
            'transaction_details' => $transactionDetails,
            'item_details' => $items,
            'customer_details' => $customerDetails,
        ];

        try {
            // Request a Snap token from Midtrans
            $snapToken = Snap::getSnapToken($transactionData);
            return $snapToken;
        } catch (\Exception $e) {
            // Handle errors
            return null;
        }
    }

    /**
     * Handle Midtrans payment notification callback
     *
     * @param array $payload
     * @return string
     */
    public function handlePaymentNotification(array $payload)
    {
        // Handle the payment notification
        // For example, you can update your order status in the database here
        // Check the payment status and update your order accordingly
        $status = $payload['transaction_status'];

        if ($status === 'capture') {
            // Payment is successfully captured
            // Update order status to 'paid'
        } elseif ($status === 'settlement') {
            // Payment is successfully settled
            // Update order status to 'paid'
        } elseif ($status === 'pending') {
            // Payment is pending
            // Update order status to 'pending'
        } elseif ($status === 'expire') {
            // Payment expired
            // Update order status to 'expired'
        } elseif ($status === 'failed') {
            // Payment failed
            // Update order status to 'failed'
        }

        // Return the status to indicate that the payment notification has been processed
        return $status;
    }
}
