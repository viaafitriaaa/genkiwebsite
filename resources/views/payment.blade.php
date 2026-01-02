<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Midtrans</title>
    @php
      $isProd = env('MIDTRANS_IS_PRODUCTION') === 'true';
      $snapUrl = $isProd ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js';
    @endphp
    <script src="{{ $snapUrl }}" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
</head>
<body style="font-family: Arial, sans-serif; background: #1a0033; color: #f8fafc; margin:0;">
  <div style="max-width: 520px; margin: 40px auto; background: #1e293b; padding: 24px; border-radius: 16px; border: 1px solid #334155;">
    <h2 style="margin-top:0; color:#a78bfa;">Pembayaran Pesanan #{{ $order->id }}</h2>

    @php
  $finalTotal = $order->total_after_promo ?? $order->total;
@endphp

<p style="margin: 8px 0 16px 0;">
  Total:
  @if($order->total_after_promo)
    <span style="text-decoration:line-through;color:#94a3b8;font-size:14px;">
      Rp {{ number_format($order->total,0,',','.') }}
    </span><br>
  @endif
  <strong>Rp {{ number_format($finalTotal,0,',','.') }}</strong>
</p>

  
    <p style="margin: 8px 0 16px 0;">Atas nama: <strong>{{ $order->customer_name }}</strong><br>Email: {{ $order->customer_email }}<br>HP: {{ $order->customer_phone }}</p>

    <input type="hidden" id="snap_token" value="{{ $snapToken ?? '' }}">
    @if(empty($snapToken))
      <div style="color: #f87171; margin-bottom: 12px;">Token pembayaran tidak tersedia.</div>
    @endif
    <button id="pay-button" style="width:100%; padding:12px 16px; border:none; border-radius:12px; background:#7c3aed; color:white; font-size:16px; font-weight:600; cursor:pointer; opacity:{{ empty($snapToken) ? '0.5' : '1' }};" {{ empty($snapToken) ? 'disabled' : '' }}>
      BAYAR DISINI
    </button>
    <a href="{{ route('checkout', $order) }}" style="display:block; text-align:center; margin-top:12px; color:#cbd5e1;">Kembali ke Checkout</a>
  </div>

  <script>
    const payButton = document.getElementById('pay-button');
    function triggerPay() {
      const snapToken = document.getElementById('snap_token').value;
      if (!snapToken) return;

      snap.pay(snapToken, {
        onSuccess: function (result) { 
          alert("Pembayaran berhasil!");
          console.log(result);
          window.location.href = "{{ route('order.complete', $order) }}";
        },
        onPending: function (result) {
          alert("Menunggu konfirmasi pembayaran.");
          console.log(result);
        },
        onError: function (result) {
          alert("Pembayaran gagal. Coba lagi.");
          console.log(result);
        }
      });
    }

    payButton?.addEventListener('click', triggerPay);

    // otomatis mulai pembayaran ketika halaman dibuka
    document.addEventListener('DOMContentLoaded', function() {
      if (document.getElementById('snap_token').value) {
        triggerPay();
      }
    });
  </script>
</body>
</html>
