@extends('admin.layout')
@section('admin-content')
<div class="flex items-center justify-between mb-6">
  <div>
    <h1 class="text-3xl font-bold">Pesanan</h1>
    <p class="text-slate-400 text-sm">Kelola pesanan dan status pembayaran.</p>
  </div>
  <span class="px-3 py-1 rounded-full text-xs" style="background:#111827; border:1px solid #1f2937;">Update: {{ now() }}</span>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
  <div class="p-4 rounded-2xl" style="background:#111827; border:1px solid #1f2937;">
    <p class="text-sm text-slate-300">Total Pendapatan (paid)</p>
    <p class="text-2xl font-bold">Rp {{ number_format($paidRevenue,0,',','.') }}</p>
  </div>
  <div class="p-4 rounded-2xl" style="background:#111827; border:1f2937;">
    <p class="text-sm text-slate-300">Produk Terjual</p>
    <p class="text-2xl font-bold">{{ $totalItemsSold }}</p>
  </div>
  <div class="p-4 rounded-2xl" style="background:#111827; border:1px solid #1f2937;">
    <p class="text-sm text-slate-300">Promo Aktif</p>
    <p class="text-2xl font-bold">{{ $activePromos->count() }}</p>
  </div>
</div>
<div class="p-4 rounded-2xl" style="background:#0f172a; border:1px solid #1f2937;">
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-semibold">Pesanan Terbaru</h2>
  </div>
  <div class="overflow-x-auto">
    <table class="min-w-full text-sm text-white">
      <thead class="text-slate-300">
        <tr>
          <th class="py-2 text-left">Order</th>
          <th class="py-2 text-left">Status</th>
          <th class="py-2 text-left">Total</th>
          <th class="py-2 text-left">Paid At</th>
          <th class="py-2 text-left">Promo</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $ord)
        <tr class="border-b border-slate-800">
          <td class="py-2">
            #{{ $ord->id }}<br>
            <span class="text-slate-400 text-xs">{{ $ord->created_at }}</span>
          </td>
          <td class="py-2 capitalize">{{ $ord->status }}</td>
          <td class="py-2">Rp {{ number_format($ord->total,0,',','.') }}</td>
          <td class="py-2">{{ $ord->paid_at ?? '-' }}</td>
          <td class="py-2">
            @if($ord->is_promo)
              <span class="text-emerald-400 text-xs">Promo</span>
              @if(!$ord->promo_verified_at)
                <span class="text-amber-400 text-xs">pending</span>
              @else
                <span class="text-emerald-300 text-xs">verified</span>
              @endif
            @else
              -
            @endif
          </td>
          <td class="py-2">

            @if($ord->paid_at)
              @if(!in_array($ord->status, ['success']))
              
                @if(in_array($ord->status, ['success','pending']))
                  <form action="{{ route('admin.orders.update_status', [$ord, 'processing']) }}" method="POST" class="inline" onsubmit="return confirm('Ubah ke Diproses?');">
                    @csrf
                    <button class="px-2 py-1 text-xs rounded bg-slate-700 hover:bg-slate-600">Diproses</button>
                  </form>
                @endif
                @if($ord->status === 'processing')
                  <form action="{{ route('admin.orders.update_status', [$ord, 'ready']) }}" method="POST" class="inline" onsubmit="return confirm('Ubah ke Pesanan Siap?');">
                    @csrf
                    <button class="px-2 py-1 text-xs rounded bg-slate-700 hover:bg-slate-600">Pesanan Siap</button>
                  </form>
                @endif
                @if($ord->status === 'success')
                  <form action="{{ route('admin.orders.update_status', [$ord, 'completed']) }}" method="POST" class="inline" onsubmit="return confirm('Tandai selesai? Ini tidak bisa dibatalkan.');">
                    @csrf
                    <button class="px-2 py-1 text-xs rounded bg-slate-700 hover:bg-slate-600">Selesai</button>
                  </form>
                @endif
              @else
                <span class="text-emerald-300 text-xs">Selesai</span>
              @endif
            @else
              <span class="text-slate-500 text-xs"></span>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="py-4 text-center text-slate-400">Belum ada pesanan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="mt-3">{{ $orders->links() }}</div>
</div>
@endsection
