@extends('partials.dashboard')

@section('content')
<div class="container py-4">
    <div class="card custom-card">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Manajemen User</h5>
            <a href="{{ route('dashboard.users.create') }}" class="btn btn-success btn-sm rounded-pill shadow-sm">
                <i class="bi bi-plus-lg"></i> Tambah Akun
            </a>
        </div>
        <div class="card-body bg-light-custom">

            @if(session('success'))
                <div class="alert alert-success mb-3 shadow-sm">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mb-3 shadow-sm">{{ session('error') }}</div>
            @endif

            <div class="mb-3">
                <form method="GET" action="{{ route('dashboard.users.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        class="form-control w-auto" placeholder="Cari nama atau email...">

                    <select name="role" class="form-select w-auto">
                        <option value="">-- Semua Role --</option>
                        <option value="dinas_pariwisata" {{ request('role') == 'dinas_pariwisata' ? 'selected' : '' }}>Dinas Pariwisata</option>
                        <option value="pengelola" {{ request('role') == 'pengelola' ? 'selected' : '' }}>Pengelola</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                    </select>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </form>
            </div>



            <div class="table-responsive">
                <table class="table table-hover align-middle table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td>{{ $users->firstItem() + $index }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-secondary rounded-pill px-3 py-2">
                                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($user->id === $currentUserId)
                                        <a href="{{ url('/profile/edit') }}" 
                                           class="btn btn-warning btn-sm rounded-pill shadow-sm me-1">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                    @endif

                                    @if($user->id !== $currentUserId)
                                        <form action="{{ route('dashboard.users.destroy', $user->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-outline-danger btn-sm rounded-pill shadow-sm">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Tidak ada user ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .custom-card {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        box-shadow: 0px 4px 12px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .bg-gradient-primary {
        background: linear-gradient(90deg, #0056b3, #1e88e5);
    }
    .bg-light-custom {
        background-color: #fafafa;
    }
    .btn-success {
        background: linear-gradient(90deg, #28a745, #5dd067);
        border: none;
    }
    .btn-success:hover {
        background: linear-gradient(90deg, #218838, #4cb85c);
    }
    .btn-warning {
        background: linear-gradient(90deg, #ffc107, #ffd45c);
        border: none;
        color: #000;
    }
    .btn-warning:hover {
        background: linear-gradient(90deg, #e0a800, #f1c04a);
    }
    .btn-outline-danger {
        border: 1px solid #dc3545;
        color: #dc3545;
    }
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
</style>

@endsection
