@extends('admin.layout')
@section('admin-content')
<h1 class="text-3xl font-bold mb-6">Edit User Admin</h1>

@if($errors->any())
  <div class="alert alert-danger text-sm">
    <ul class="mb-0">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="p-4 rounded-2xl" style="background:#0f172a; border:1px solid #1f2937; max-width: 640px;">
  <form method="POST" action="{{ route('admin.manage.users.update', $user) }}">
    @csrf
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" required value="{{ old('username', $user->username) }}">
    </div>
    <div class="mb-3">
      <label class="form-label">Password (kosongkan jika tidak diubah)</label>
      <input type="password" name="password" class="form-control" placeholder="••••••">
    </div>
    <div class="d-grid gap-2">
      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="{{ route('admin.manage.users') }}" class="btn btn-outline-light">Kembali</a>
    </div>
  </form>
</div>
@endsection
