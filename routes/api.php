<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::post('/midtrans/notification', [PaymentController::class, 'handlePaymentNotification']);
