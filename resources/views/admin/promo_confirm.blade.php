@extends('admin.layout')
@section('admin-content')
<div class="min-h-screen p-6" style="background:#1a0033;">
<h1 class="text-3xl font-bold mb-6">Konfirmasi Promo</h1>

@if(session('success'))
  <div class="alert alert-success text-sm">{{ session('success') }}</div>
@endif

<div class="p-4 rounded-2xl"
     style="background: rgba(26, 0, 51, 0.85); border:1px solid #2e1065;">
  @forelse($promoPending as $ord)
    <div class="border border-slate-800 rounded-xl p-3 mb-3">
      <div class="flex justify-between items-center">
        <div>
          <div class="text-sm">Order #{{ $ord->id }}</div>
          <div class="text-xs text-slate-400 mb-2">{{ $ord->created_at }}</div>
          <div class="text-xs text-slate-300">User: {{ $ord->customer_name ?? '-' }}</div>
          <div class="text-xs text-slate-300">Status: {{ $ord->status }}</div>
        </div>
        @if($ord->promo_proof_path)
          <a href="{{ asset('storage/'.$ord->promo_proof_path) }}" target="_blank" class="text-emerald-400 text-xs underline">Lihat bukti</a>
        @endif
      </div>
      <div class="mt-2 text-xs text-slate-400">Bukti: <span class="text-amber-300">menunggu verifikasi</span></div>
      <div class="mt-3 flex gap-2">
        <form action="{{ route('admin.promo_confirm.approve', $ord) }}" method="POST">
          @csrf
          <button type="submit" class="px-3 py-2 rounded-lg text-xs font-semibold" style="background:#16a34a; color:#fff;">Setujui</button>
        </form>
        <form action="{{ route('admin.promo_confirm.reject', $ord) }}" method="POST">
          @csrf
          <button type="submit" class="px-3 py-2 rounded-lg text-xs font-semibold" style="background:#b91c1c; color:#fff;">Tolak</button>
        </form>
      </div>
    </div>
  @empty
    <p class="text-slate-400 text-sm">Tidak ada klaim promo yang menunggu.</p>
  @endforelse
</div>
@endsection
