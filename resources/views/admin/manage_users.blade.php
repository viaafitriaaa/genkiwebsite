@extends('admin.layout')
@section('admin-content')
<h1 class="text-3xl font-bold mb-6">Pengelolaan Users (Admin)</h1>

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
    <h2 class="text-xl font-semibold mb-3">Daftar User Admin</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm text-white">
        <thead class="text-slate-300">
          <tr>
            <th class="py-2 text-left">Username</th>
            <th class="py-2 text-left">Dibuat</th>
            <th class="py-2 text-left">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $u)
          <tr class="border-b border-slate-800">
            <td class="py-2">{{ $u->username }}</td>
            <td class="py-2 text-slate-400">{{ $u->created_at }}</td>
            <td class="py-2">
              <a href="{{ route('admin.manage.users.edit', $u) }}" class="text-xs text-emerald-400 underline me-2">Edit</a>
              <form action="{{ route('admin.manage.users.destroy', $u) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus user ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs text-rose-400 underline">Hapus</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="3" class="py-3 text-center text-slate-400">Belum ada user admin.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="mt-3">{{ $users->links() }}</div>
  </div>

  <div class="p-4 rounded-2xl" style="background:#0f172a; border:1px solid #1f2937;">
    <h2 class="text-xl font-semibold mb-3">Tambah User Admin</h2>
    <form method="POST" action="{{ route('admin.manage.users.store') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required value="{{ old('username') }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Simpan</button>
    </form>
  </div>
</div>
@endsection
