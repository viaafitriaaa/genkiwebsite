@extends('layouts.app')

@section('title', 'Genki Food & Drink')

@section('content')
    <div class="w-full h-full flex items-center justify-center p-6 gradient-bg" style="font-family: 'Inter', sans-serif;">
        <div class="w-full max-w-4xl card rounded-3xl p-12 text-center fade-in" style="background: #1e293b;">
            <div class="mb-6">
                <span style="font-size: 64px;"></span>
            </div>
            <h1 class="font-bold mb-6" style="font-size: 40px; color: #7c3aed;">Genki Food & Drink</h1>
            <p class="mb-8 leading-relaxed" style="font-size: 18px; color: #f1f5f9; max-width: 600px; margin: 0 auto;">
                Sajikan momen istimewa dengan setiap tegukan yang memanjakan lidah. Rasakan kesegaran alami yang menyegarkan hari-harimu!
            </p>
            <button onclick="goToLogin()" class="btn font-bold py-4 px-12 rounded-xl" style="background: #7c3aed; color: white; font-size: 20px;">
                Mulai Sekarang
            </button>
        </div>
    </div>
@endsection
<script>
    function goToLogin() {
        window.location.href = "{{ route('menu.index') }}";
    }
</script>
