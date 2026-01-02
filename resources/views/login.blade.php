@extends('layouts.app')

@section('title', 'Login - Genki Food & Drink')

@section('content')
<div class="w-full h-full flex items-center justify-center p-6 gradient-bg" style="font-family: 'Inter', sans-serif;">
    <div class="w-full max-w-md card rounded-2xl p-8 fade-in" style="background: #1e293b;">

        <div class="text-center mb-8">
            <span style="font-size: 48px;">🔐</span>
        </div>

        <h2 class="text-center font-bold mb-2" style="font-size: 32px; color: #7c3aed;">Masuk</h2>

        @if ($errors->has('login_error'))
            <div class="text-red-500 text-center mb-3">
                {{ $errors->first('login_error') }}
            </div>
        @endif

        <form action="{{ route('admin.login.process') }}" method="POST">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="block mb-2 font-medium" style="font-size: 16px; color: #f1f5f9;">Username</label>
                    <input type="text" name="username" class="w-full px-4 py-3 rounded-lg border border-gray-600"
                        style="background: #0f172a; color: white;" required>
                </div>

                <div>
                    <label class="block mb-2 font-medium" style="font-size: 16px; color: #f1f5f9;">Password</label>
                    <input type="password" name="password" class="w-full px-4 py-3 rounded-lg border border-gray-600"
                        style="background: #0f172a; color: white;" required>
                </div>

                <button type="submit" class="btn w-full font-semibold py-3 rounded-lg"
                    style="background: #7c3aed; color: white; font-size: 18px;">
                    Masuk
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
