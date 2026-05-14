@extends('layouts.admin')

@section('admin-content')

<div class="admin-page-header">
    <h1>Kelola Pengguna</h1>
</div>

@if($users->count() > 0)
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Peran</th>
                    <th>Tanggal Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <strong>{{ $user->name }}</strong>
                            @if($user->id === auth()->id())
                                <span style="font-size:0.75rem;color:var(--primary);font-weight:600;">(Anda)</span>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>
                            @if($user->isAdmin())
                                <span class="badge badge-admin">Admin</span>
                            @else
                                <span class="badge badge-masyarakat">Masyarakat</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($user->isAdmin())
                                <span style="font-size:0.82rem;color:var(--text-light);">Dilindungi</span>
                            @else
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus pengguna &quot;{{ $user->name }}&quot;? Semua laporan terkait juga akan terpengaruh.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-destructive btn-sm">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="pagination">
            {{ $users->withQueryString()->links() }}
        </div>
    @endif
@else
    <div style="text-align:center;padding:60px 20px;background:white;border-radius:var(--radius-md);box-shadow:var(--shadow-sm);">
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5" style="margin:0 auto 16px;display:block;">
            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
        </svg>
        <h3 style="color:var(--text-medium);margin-bottom:8px;">Belum Ada Pengguna</h3>
        <p style="color:var(--text-light);">Belum ada pengguna yang terdaftar.</p>
    </div>
@endif

@endsection
