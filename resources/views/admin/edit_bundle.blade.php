@extends('admin.layout')
@section('admin-content')
<h1 class="text-3xl font-bold mb-6">Edit Bundle</h1>

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
  <form method="POST" action="{{ route('admin.manage.bundles.update', $bundle) }}">
    @csrf
    <div class="mb-3">
      <label class="form-label">Judul</label>
      <input type="text" name="title" class="form-control" required value="{{ old('title', $bundle->title) }}">
    </div>
    <div class="mb-3">
      <label class="form-label">Harga</label>
      <input type="number" name="price" class="form-control" min="0" required value="{{ old('price', $bundle->price) }}">
    </div>
    <div class="mb-3">
      <label class="form-label">Deskripsi (opsional)</label>
      <textarea name="description" class="form-control" rows="3">{{ old('description', $bundle->description) }}</textarea>
    </div>
    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" name="student_only" value="1" id="studentOnlyEdit" {{ old('student_only', $bundle->student_only) ? 'checked' : '' }}>
      <label class="form-check-label" for="studentOnlyEdit">Khusus mahasiswa/pelajar</label>
    </div>
    <div class="d-grid gap-2">
      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="{{ route('admin.manage.bundles') }}" class="btn btn-outline-light">Kembali</a>
    </div>
  </form>
</div>
@endsection
