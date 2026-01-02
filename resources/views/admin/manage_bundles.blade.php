@extends('admin.layout')
@section('admin-content')
<h1 class="text-3xl font-bold mb-6">Pengelolaan Bundles</h1>

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
    <h2 class="text-xl font-semibold mb-3">Daftar Bundles</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm text-white">
        <thead class="text-slate-300">
          <tr>
            <th class="py-2 text-left">Judul</th>
            <th class="py-2 text-left">Harga</th>
            <th class="py-2 text-left">Student Only</th>
            <th class="py-2 text-left">Deskripsi</th>
            <th class="py-2 text-left">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($bundles as $b)
          <tr class="border-b border-slate-800">
            <td class="py-2">{{ $b->title }}</td>
            <td class="py-2">Rp {{ number_format($b->price,0,',','.') }}</td>
            <td class="py-2">{{ $b->student_only ? 'Ya' : 'Tidak' }}</td>
            <td class="py-2 text-slate-400">{{ \Illuminate\Support\Str::limit($b->description, 80) }}</td>
            <td class="py-2">
              <a href="{{ route('admin.manage.bundles.edit', $b) }}" class="text-xs text-emerald-400 underline me-2">Edit</a>
              <form action="{{ route('admin.manage.bundles.destroy', $b) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus bundle ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs text-rose-400 underline">Hapus</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="py-3 text-center text-slate-400">Belum ada bundles.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="mt-3">{{ $bundles->links() }}</div>
  </div>

  <div class="p-4 rounded-2xl" style="background:#0f172a; border:1px solid #1f2937;">
    <h2 class="text-xl font-semibold mb-3">Tambah Bundle Baru</h2>
    <form method="POST" action="{{ route('admin.manage.bundles.store') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Harga</label>
        <input type="number" name="price" class="form-control" min="0" required value="{{ old('price') }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Deskripsi (opsional)</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
      </div>
      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="student_only" value="1" id="studentOnlyCheck" {{ old('student_only') ? 'checked' : '' }}>
        <label class="form-check-label" for="studentOnlyCheck">Khusus mahasiswa/pelajar</label>
      </div>
      <button type="submit" class="btn btn-primary w-100">Simpan</button>
    </form>
  </div>
</div>
@endsection
