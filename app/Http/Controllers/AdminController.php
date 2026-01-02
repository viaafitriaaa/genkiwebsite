<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Promo;
use App\Models\Product;
use App\Models\Bundle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.orders');
    }

    public function orders()
    {
        $orders = Order::with('items.product', 'items.bundle')
            ->orderByDesc('created_at')
            ->paginate(10);

         $paidRevenue = Order::where('status', 'success')
        ->sum('total');
        $totalItemsSold = OrderItem::sum('quantity');

        $promoPending = Order::where('is_promo', true)
            ->whereNull('promo_verified_at')
            ->orderByDesc('created_at')
            ->get();

        $activePromos = Promo::where('is_active', true)->get();

        return view('admin.orders', [
            'orders' => $orders,
            'paidRevenue' => $paidRevenue,
            'totalItemsSold' => $totalItemsSold,
            'promoPending' => $promoPending,
            'activePromos' => $activePromos,
        ]);
    }

    public function updateOrderStatus(Order $order, string $status)
    {
        $allowed = ['processing', 'ready', 'completed'];
        if (!in_array($status, $allowed, true)) {
            return back()->withErrors(['status' => 'Status tidak valid']);
        }

        $current = $order->status;

        $canMove = match ($status) {
            'processing' => in_array($current, ['paid', 'pending']),
            'ready' => $current === 'processing',
            'completed' => $current === 'ready',
            default => false,
        };

        if ($current === 'completed') {
            return back()->withErrors(['status' => 'Order sudah selesai dan tidak dapat diubah.']);
        }

        if (!$canMove) {
            return back()->withErrors(['status' => "Tidak bisa ubah dari {$current} ke {$status}"]);
        }

        $order->update(['status' => $status]);

        return back()->with('success', "Order #{$order->id} diperbarui ke status {$status}");
    }

    public function promoConfirm()
    {
        $promoPending = Order::where('is_promo', true)
            ->whereNull('promo_verified_at')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.promo_confirm', compact('promoPending'));
    }



public function approvePromo(Order $order)
{
    DB::transaction(function () use ($order) {

        Log::info('=== APPROVE PROMO START ===', [
            'order_id' => $order->id
        ]);

        $order->load('items');

        foreach ($order->items as $item) {
            Log::info('ITEM DATA', [
                'item_id' => $item->id,
                'price' => $item->price,
                'qty' => $item->quantity,
            ]);
        }

        // total asli
        $total = $order->items()
            ->sum(DB::raw('quantity * price'));

        Log::info('TOTAL ASLI', [
            'order_id' => $order->id,
            'total' => $total
        ]);

        // total promo
        $totalAfterPromo = (int) round($total * 80 / 100);

        Log::info('TOTAL AFTER PROMO', [
            'order_id' => $order->id,
            'total_after_promo' => $totalAfterPromo
        ]);

        $order->update([
            'total' => $total,
            'total_after_promo' => $totalAfterPromo,
            'promo_verified_at' => now(),
        ]);

        Log::info('ORDER UPDATED', [
            'order_id' => $order->id,
            'total_db' => $order->fresh()->total,
            'total_after_promo_db' => $order->fresh()->total_after_promo,
        ]);

        Log::info('=== APPROVE PROMO END ===');
    });

    return back()->with('success', 'Promo approved');
}





    public function rejectPromo(Order $order)
    {
        $order->update([
            'is_promo' => false,
            'promo_proof_path' => null,
            'promo_verified_at' => null,
            'promo_discount_percent' => null,
        ]);

        return redirect()->route('admin.promo_confirm')->with('success', "Promo order #{$order->id} ditolak.");
    }

    public function manageProducts()
    {
        $products = Product::orderByDesc('id')->paginate(10);
        return view('admin.manage_products', compact('products'));
    }

    public function storeProduct(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'category' => 'required|in:smoothie,food',
        ]);

        Product::create($data);

        return redirect()->route('admin.manage.products')->with('success', 'Produk berhasil dibuat.');
    }

    public function editProduct(Product $product)
    {
        return view('admin.edit_product', compact('product'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'category' => 'required|in:smoothie,food',
        ]);

        $product->update($data);

        return redirect()->route('admin.manage.products')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroyProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.manage.products')->with('success', 'Produk dihapus.');
    }

    public function manageBundles()
    {
        $bundles = Bundle::orderByDesc('id')->paginate(10);
        return view('admin.manage_bundles', compact('bundles'));
    }

    public function managePromos()
    {
        $promos = Promo::orderBy('name')->get();
        return view('admin.manage_promos', compact('promos'));
    }

    public function manageUsers()
    {
        $users = User::orderByDesc('id')->paginate(10);
        return view('admin.manage_users', compact('users'));
    }

    public function updatePromo(Request $request, Promo $promo)
    {
        $data = $request->validate([
            'percent' => 'required|integer|min:0|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $promo->update([
            'percent' => $data['percent'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', "Promo {$promo->name} diperbarui.");
    }

    // Users CRUD (admin)
    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:5',
        ]);

        User::create([
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);

        return redirect()->route('admin.manage.users')->with('success', 'User admin berhasil dibuat.');
    }

    public function editUser(User $user)
    {
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:5',
        ]);

        $update = ['username' => $data['username']];
        if (!empty($data['password'])) {
            $update['password'] = bcrypt($data['password']);
        }

        $user->update($update);

        return redirect()->route('admin.manage.users')->with('success', 'User admin diperbarui.');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.manage.users')->with('success', 'User admin dihapus.');
    }

    // Bundles CRUD
    public function storeBundle(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'student_only' => 'nullable|boolean',
        ]);

        $data['student_only'] = $request->boolean('student_only');
        Bundle::create($data);

        return redirect()->route('admin.manage.bundles')->with('success', 'Bundle berhasil dibuat.');
    }

    public function editBundle(Bundle $bundle)
    {
        return view('admin.edit_bundle', compact('bundle'));
    }

    public function updateBundle(Request $request, Bundle $bundle)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'student_only' => 'nullable|boolean',
        ]);

        $data['student_only'] = $request->boolean('student_only');
        $bundle->update($data);

        return redirect()->route('admin.manage.bundles')->with('success', 'Bundle berhasil diperbarui.');
    }

    public function destroyBundle(Bundle $bundle)
    {
        $bundle->delete();
        return redirect()->route('admin.manage.bundles')->with('success', 'Bundle dihapus.');
    }
}
