@extends('layouts.app')
@section('content')
<div class="min-h-screen flex text-white" style="background: radial-gradient(circle at 20% 20%, #111827, #0b1220 45%);">
  <aside class="w-64 p-6 flex flex-col" style="background:#0f172a; border-right:1px solid #1f2937;">
    <div class="mb-6">
      <h2 class="text-xl font-bold">Admin Panel</h2>
      <p class="text-xs text-slate-400">Kelola pesanan & promo</p>
    </div>
    <nav class="space-y-2 text-sm flex-1">
      <a href="{{ route('admin.orders') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('admin.orders') ? 'bg-slate-800 border border-slate-700' : '' }}">Pesanan</a>
      <a href="{{ route('admin.promo_confirm') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('admin.promo_confirm') ? 'bg-slate-800 border border-slate-700' : '' }}">Konfirmasi Promo</a>
      <div class="mt-4 text-xs uppercase text-slate-400">Pengelolaan</div>
      <a href="{{ route('admin.manage.products') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('admin.manage.products') ? 'bg-slate-800 border border-slate-700' : '' }}">Produk</a>
      <a href="{{ route('admin.manage.bundles') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('admin.manage.bundles') ? 'bg-slate-800 border border-slate-700' : '' }}">Bundles</a>
      <a href="{{ route('admin.manage.promos') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('admin.manage.promos') ? 'bg-slate-800 border border-slate-700' : '' }}">Promo</a>
      <a href="{{ route('admin.manage.users') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-800 {{ request()->routeIs('admin.manage.users') ? 'bg-slate-800 border border-slate-700' : '' }}">Users (Admin)</a>
    </nav>
    <div class="mt-6 pt-4 border-t border-slate-800">
      <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit" class="w-full px-3 py-2 rounded-lg font-semibold" style="background:linear-gradient(135deg,#ef4444,#b91c1c); border:1px solid #fca5a5;">
          Logout
        </button>
      </form>
    </div>
  </aside>
  <main class="flex-1 p-6">
    @yield('admin-content')
  </main>
</div>
@endsection
