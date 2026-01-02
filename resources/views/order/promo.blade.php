@extends('layouts.app')
@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center"
     style="background: linear-gradient(135deg, #1a0033, #2d1b4e);">

<div class="container my-5"
     style="
       max-width: 720px;
       background: linear-gradient(135deg, #1a0033, #845ec9ff);
       padding: 24px;
       border-radius: 24px;
     ">     
  <div class="card shadow-sm" style="background:#0f172a; border:1px solid #1f2937; color:#e2e8f0;">
    <div class="card-body">
      <h3 class="mb-3">Klaim Promo Mahasiswa/Pelajar</h3>
      <p class="text-secondary">Unggah foto KTM/pelajar Anda.</p>
      <form method="POST" action="{{ route('order.promo.submit', $order) }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label class="form-label">Ambil/Upload KTM/Pelajar (JPG/PNG, maks 2MB)</label>
          <input type="file" id="promoProof" name="promo_proof" class="form-control" accept="image/*" capture="environment" required>
          <small class="text-secondary">Gunakan kamera atau pilih file yang sudah ada.</small>
          @error('promo_proof')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-success fw-semibold">Kirim Bukti</button>
          <a href="{{ route('checkout', $order) }}" class="btn btn-outline-light">Kembali ke Checkout</a>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
@endsection
