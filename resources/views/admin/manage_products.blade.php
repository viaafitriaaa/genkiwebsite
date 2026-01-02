@extends('admin.layout')
@section('admin-content')
<h1 class="text-3xl font-bold mb-6">Pengelolaan Produk</h1>

@if(session('success'))
  <div class="alert alert-success text-sm">{{ session('success') }}</div>
@endif
@if($errors->any())
  <div class="alert alert-danger text-sm">
    <ul class="mb-0">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2 p-4 rounded-2xl" style="background:#0f172a; border:1px solid #1f2937;">
    <h2 class="text-xl font-semibold mb-3">Daftar Produk</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm text-white">
        <thead class="text-slate-300">
          <tr>
            <th class="py-2 text-left">Nama</th> 
            <th class="py-2 text-left">Harga</th>
            <th class="py-2 text-left">Deskripsi</th>
            <th class="py-2 text-left">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($products as $p)
          <tr class="border-b border-slate-800">
            <td class="py-2">{{ $p->name }}</td>
            <td class="py-2">Rp {{ number_format($p->price,0,',','.') }}</td>
            <td class="py-2 text-slate-400">{{ \Illuminate\Support\Str::limit($p->description, 80) }}</td>
            <td class="py-2">
              <a href="{{ route('admin.manage.products.edit', $p) }}" class="text-xs text-emerald-400 underline me-2">Edit</a>
              <form action="{{ route('admin.manage.products.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus produk ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs text-rose-400 underline">Hapus</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="py-3 text-center text-slate-400">Belum ada produk.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="mt-3">{{ $products->links() }}</div>
  </div>

  <div class="p-4 rounded-2xl" style="background:#0f172a; border:1px solid #1f2937;">
    <h2 class="text-xl font-semibold mb-3">Tambah Produk Baru</h2>
    <form method="POST"
      action="{{ route('admin.manage.products.store') }}"
      enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Harga</label>
        <input type="number" name="price" class="form-control" min="0" required value="{{ old('price') }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Kategori</label>
        <select name="category" class="form-control" required>
          <option value="">-- pilih kategori --</option>
          <option value="smoothie" {{ old('category')=='smoothie' ? 'selected' : '' }}>Smoothie</option>
          <option value="food" {{ old('category')=='food' ? 'selected' : '' }}>Makanan</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Deskripsi (opsional)</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
   <div class="mb-3">
    <label class="form-label">Gambar Produk</label>
    <input type="file" name="image" class="form-control">
  </div>

  <button type="submit" class="btn btn-primary w-100">Simpan</button>
</form>
@endsection
