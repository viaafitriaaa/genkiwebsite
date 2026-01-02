@extends('layouts.app')

@section('content')
@php
  $contactComplete = $order->customer_name && $order->customer_email && $order->customer_phone;
@endphp

<style>
  body { background:#1a0033 !important; }
  .checkout-bg { background:#1a0033; color:#e5e7eb; min-height:100vh; }
  .checkout-heading { color:#ffffff; }
  .checkout-label { color:#94a3b8; }
</style>

<div class="container my-4" style="max-width:1100px;">
  <div class="mb-3">
    <h2 class="checkout-heading mb-1">Checkout #{{ $order->id }}</h2>
    <p class="text-secondary mb-0">Lengkapi kontak, lalu lanjutkan ke pembayaran.</p>
  </div>

  {{-- ALERT --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="row g-4">

    {{-- ================= LEFT : RINGKASAN ================= --}}
    <div class="col-lg-6">
      <div class="p-3 rounded-3" style="background:#0f172a;border:1px solid #1f2937;">
        <h5 class="checkout-heading mb-3">Ringkasan Pesanan</h5>

        <ul class="list-group list-group-flush mb-3">
          @foreach($order->items as $it)
            <li class="d-flex justify-content-between py-3 border-bottom"
                style="border-color:#1f2937;">
              <div>
                <div class="fw-semibold text-white">
                  {{ $it->product->name ?? 'Bundle #'.$it->bundle_id }}
                </div>
                <small class="text-muted">Qty: {{ $it->quantity }}</small>
              </div>

              <div class="text-end fw-semibold text-white">
                Rp {{ number_format($it->price,0,',','.') }}
              </div>
            </li>
          @endforeach
        </ul>

        {{-- TOTAL --}}
        <div class="d-flex justify-content-between align-items-center">
          <span class="fw-semibold text-white">Total</span>
          <span class="fw-bold fs-5 text-white">
            @if($order->total_after_promo)
              <span style="text-decoration:line-through;color:#94a3b8;font-size:14px;">
                Rp {{ number_format($order->total,0,',','.') }}
              </span>
              Rp {{ number_format($order->total_after_promo,0,',','.') }}
            @else
              Rp {{ number_format($order->total,0,',','.') }}
            @endif
          </span>
        </div>

        @if($order->promo_verified_at)
          <div class="mt-2 text-success">
            Promo mahasiswa telah diterapkan ✔
          </div>
        @endif
      </div>
    </div>

    {{-- ================= RIGHT : DATA KONTAK ================= --}}
    <div class="col-lg-6">
      <div class="p-3 rounded-3" style="background:#0f172a;border:1px solid #1f2937;">
        <h5 class="checkout-heading mb-3">Data Kontak</h5>

        <form method="POST" action="{{ route('checkout.update_contact', $order) }}">
          @csrf
          <input type="hidden" name="redirect_to_pay" value="1">

          <div class="mb-3">
            <label class="checkout-label">Nama</label>
            <input type="text" class="form-control"
              name="customer_name"
              value="{{ old('customer_name', $order->customer_name) }}" required>
          </div>

          <div class="mb-3">
            <label class="checkout-label">Email</label>
            <input type="email" class="form-control"
              name="customer_email"
              value="{{ old('customer_email', $order->customer_email) }}" required>
          </div>

          <div class="mb-3">
            <label class="checkout-label">No. HP</label>
            <input type="text" class="form-control"
              name="customer_phone"
              value="{{ old('customer_phone', $order->customer_phone) }}" required>
          </div>

          <div class="mb-3">
            <label class="checkout-label">Alamat (opsional)</label>
            <input type="text" class="form-control"
              name="customer_address"
              value="{{ old('customer_address', $order->customer_address) }}">
          </div>

          @php
            $payDisabled = $order->is_promo
              && $order->promo_proof_path
              && !$order->promo_verified_at;
          @endphp

          @if($payDisabled)
            <div class="alert alert-info">
              Bukti promo sudah dikirim. Menunggu verifikasi admin.
            </div>
          @endif

          <div class="d-grid gap-2">
            <a href="{{ route('order.promo.form', $order) }}"
               class="btn btn-success fw-semibold">
              Claim Promo (Mahasiswa)
            </a>

            <button type="submit"
              class="btn btn-warning fw-semibold text-dark"
              {{ $payDisabled ? 'disabled' : '' }}>
              Lanjutkan Pembayaran
            </button>
          </div>

          <small class="d-block mt-2 text-muted">
            Data disimpan lalu diarahkan ke Midtrans.
          </small>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection
