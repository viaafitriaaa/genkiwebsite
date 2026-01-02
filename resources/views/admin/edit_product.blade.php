@extends('admin.layout')
@section('admin-content')
<h1 class="text-3xl font-bold mb-6">Edit Produk</h1>

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
  <form method="POST" action="{{ route('admin.manage.products.update', $product) }}">
    @csrf
    <div class="mb-3">
      <label class="form-label">Nama</label>
      <input type="text" name="name" class="form-control" required value="{{ old('name', $product->name) }}">
    </div>
    <div class="mb-3">
      <label class="form-label">Harga</label>
      <input type="number" name="price" class="form-control" min="0" required value="{{ old('price', $product->price) }}">
    </div>
    <div class="mb-3">
      <label class="form-label">Kategori</label>
      <select name="category" class="form-control" required>
        <option value="smoothie" {{ old('category', $product->category)=='smoothie' ? 'selected' : '' }}>Smoothie</option>
        <option value="food" {{ old('category', $product->category)=='food' ? 'selected' : '' }}>Makanan</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Deskripsi (opsional)</label>
      <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
    </div>
    <div class="d-grid gap-2">
      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="{{ route('admin.manage.products') }}" class="btn btn-outline-light">Kembali</a>
    </div>
  </form>
</div>
@endsection
