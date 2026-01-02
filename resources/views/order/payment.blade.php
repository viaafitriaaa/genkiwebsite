@extends('layouts.app')
@section('content')
<h2>Pembayaran untuk Order #{{ $order->id }}</h2>
<p>Total: Rp {{ number_format($order->total,0,',','.') }}</p>

<div id="qris-reader" style="width:500px"></div>
<p id="scan-status">Arahkan kamera ke QRIS</p>

<script src="https://unpkg.com/html5-qrcode@2.3.8/minified/html5-qrcode.min.js"></script>
<script>
const reader = new Html5Qrcode("qris-reader");
Html5Qrcode.getCameras().then(cameras=>{
  const camId = cameras[0].id;
  reader.start(camId, { fps: 10, qrbox: 250 },
    decodedText => {
      document.getElementById('scan-status').innerText = "QR terdeteksi: " + decodedText;
      // kirim ke server untuk memproses pembayaran (demo)
      fetch("{{ url('/order/'.$order->id.'/pay') }}", {
        method:'POST',
        headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'},
        body: JSON.stringify({ qris_data: decodedText })
      }).then(r=>r.json()).then(res=>{
        if(res.ok){
          reader.stop();
          window.location = "{{ route('order.complete', $order) }}";
        } else {
          document.getElementById('scan-status').innerText = 'Pembayaran gagal';
        }
      });
    },
    err => {}
  ).catch(e => { document.getElementById('scan-status').innerText = 'Tidak bisa akses kamera'; });
}).catch(e => { document.getElementById('scan-status').innerText = 'Tidak ada kamera'; });
</script>
@endsection
