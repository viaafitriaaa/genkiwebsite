@extends('layouts.app')
@section('content')
<div class="container my-5" style="max-width: 720px;">
  <div class="card shadow-sm" style="background:#0f172a; border:1px solid #1f2937; color:#e2e8f0;">
    <div class="card-body text-center">
      <h2 class="mb-3">Order #{{ $order->id }}</h2>

      <div id="status" class="mb-3">
        Memeriksa status pembayaran...
      </div>

      <div id="success-info" class="alert alert-success d-none">
         <strong>Pembayaran Berhasil!</strong><br>
        Pesanan kamu sudah diterima dan sedang diproses.
      </div>

      <a href="{{ route('menu.index') }}" class="btn btn-primary mt-3">
        Kembali ke Beranda
      </a>
    </div>
  </div>
</div>

<script>
async function checkStatus() {
  try {
    const res = await fetch("{{ url('/order/'.$order->id.'/status') }}");
    const j = await res.json();

    if (j.status === 'paid') {
      document.getElementById('status').innerText = "Status: PAID";
      document.getElementById('success-info').classList.remove('d-none');
    } else {
      document.getElementById('status').innerText = "Status: MENUNGGU PEMBAYARAN...";
      setTimeout(checkStatus, 5000);
    }
  } catch (e) {
    document.getElementById('status').innerText = "Gagal memeriksa status.";
  }
}

checkStatus();
</script>
@endsection
