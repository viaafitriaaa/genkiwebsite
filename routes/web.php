<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// homepage / menu
Route::get('/', [MenuController::class, 'index'])->name('menu.index');

// add product / bundle ke cart
Route::post('/cart/add', [OrderController::class, 'addToCart'])->name('cart.add');
Route::post('/order/create', [OrderController::class, 'createFromCart'])->name('order.create');

// checkout page
Route::get('/checkout/{order}', [OrderController::class, 'checkout'])
    ->name('checkout');

// klaim promo (upload/scan KTM)
Route::get('/order/{order}/promo', [OrderController::class, 'promoForm'])
    ->name('order.promo.form');
Route::post('/order/{order}/promo', [OrderController::class, 'submitPromo'])
    ->name('order.promo.submit');

// simpan kontak pelanggan  
Route::post('/checkout/{order}', [OrderController::class, 'updateContact'])
    ->name('checkout.update_contact');

// cek status order
Route::get('/order/{order}/status', [OrderController::class, 'status'])
    ->name('order.status');

// halaman selesai
Route::get('/order/{order}/complete', [OrderController::class, 'completeView'])
    ->name('order.complete');


/*
|--------------------------------------------------------------------------
| PAYMENT ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/order/{order}/pay', [PaymentController::class, 'showPayment'])
    ->name('order.pay');

Route::post('/order/{order}/pay', [PaymentController::class, 'processPayment'])
    ->name('order.pay.process');

// midtrans notification 
Route::post('/midtrans/notification', [PaymentController::class, 'handlePaymentNotification'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);


/*
|--------------------------------------------------------------------------
| PROMO
|--------------------------------------------------------------------------
*/

Route::post('/order/{order}/claim-promo', [PromoController::class, 'claimPromo'])
    ->name('order.claim_promo');


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.process');

Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::get('/admin/register', [AuthController::class, 'showRegister'])->name('admin.register');
Route::post('/admin/register', [AuthController::class, 'register'])->name('admin.register.process');

// Admin dashboard & pages (protkksi)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/promo-confirm', [AdminController::class, 'promoConfirm'])->name('promo_confirm');
    Route::post('/promo-confirm/{order}/approve', [AdminController::class, 'approvePromo'])->name('promo_confirm.approve');
    Route::post('/promo-confirm/{order}/reject', [AdminController::class, 'rejectPromo'])->name('promo_confirm.reject');
    Route::post('/orders/{order}/status/{status}', [AdminController::class, 'updateOrderStatus'])->name('orders.update_status');
    Route::get('/manage/products', [AdminController::class, 'manageProducts'])->name('manage.products');
    Route::post('/manage/products', [AdminController::class, 'storeProduct'])->name('manage.products.store');
    Route::get('/manage/products/{product}/edit', [AdminController::class, 'editProduct'])->name('manage.products.edit');
    Route::post('/manage/products/{product}', [AdminController::class, 'updateProduct'])->name('manage.products.update');
    Route::delete('/manage/products/{product}', [AdminController::class, 'destroyProduct'])->name('manage.products.destroy');
    Route::get('/manage/bundles', [AdminController::class, 'manageBundles'])->name('manage.bundles');
    Route::post('/manage/bundles', [AdminController::class, 'storeBundle'])->name('manage.bundles.store');
    Route::get('/manage/bundles/{bundle}/edit', [AdminController::class, 'editBundle'])->name('manage.bundles.edit');
    Route::post('/manage/bundles/{bundle}', [AdminController::class, 'updateBundle'])->name('manage.bundles.update');
    Route::delete('/manage/bundles/{bundle}', [AdminController::class, 'destroyBundle'])->name('manage.bundles.destroy');
    Route::get('/manage/promos', [AdminController::class, 'managePromos'])->name('manage.promos');
    Route::post('/manage/promos/{promo}', [AdminController::class, 'updatePromo'])->name('manage.promos.update');
    Route::get('/manage/users', [AdminController::class, 'manageUsers'])->name('manage.users');
    Route::post('/manage/users', [AdminController::class, 'storeUser'])->name('manage.users.store');
    Route::get('/manage/users/{user}/edit', [AdminController::class, 'editUser'])->name('manage.users.edit');
    Route::post('/manage/users/{user}', [AdminController::class, 'updateUser'])->name('manage.users.update');
    Route::delete('/manage/users/{user}', [AdminController::class, 'destroyUser'])->name('manage.users.destroy');
});
