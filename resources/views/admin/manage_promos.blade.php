@extends('admin.layout')
@section('admin-content')
<h1 class="text-3xl font-bold mb-6">Pengelolaan Promo</h1>

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

<div class="p-4 rounded-2xl" style="background:#0f172a; border:1px solid #1f2937;">
  <h2 class="text-xl font-semibold mb-3">Daftar Promo</h2>
  <div class="overflow-x-auto">
    <table class="min-w-full text-sm text-white">
      <thead class="text-slate-300">
        <tr>
          <th class="py-2 text-left">Nama</th>
          <th class="py-2 text-left">Percent</th>
          <th class="py-2 text-left">Aktif</th>
          <th class="py-2 text-left">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($promos as $promo)
        <tr class="border-b border-slate-800">
          <td class="py-2">{{ $promo->name }}</td>
          <td class="py-2">{{ $promo->percent }}%</td>
          <td class="py-2">{{ $promo->is_active ? 'Ya' : 'Tidak' }}</td>
          <td class="py-2">
            <form action="{{ route('admin.manage.promos.update', $promo) }}" method="POST" class="d-inline-flex align-items-center gap-2">
              @csrf
              <input type="number" name="percent" class="form-control form-control-sm" min="0" max="100" value="{{ $promo->percent }}" style="width:100px;">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $promo->is_active ? 'checked' : '' }}>
              </div>
              <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="py-3 text-center text-slate-400">Belum ada promo.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
