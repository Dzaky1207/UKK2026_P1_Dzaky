@extends('menu/navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">

        {{-- TABEL ATAS : USER AKTIF --}}
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Data User</h4>

                <div class="d-flex flex-wrap gap-2 mb-3">
                    <a href="{{ route('user.create') }}" class="btn btn-primary">
                        Create
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $u)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ ucfirst($u->role) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        {{-- Edit --}}
                                        <a href="{{ route('user.edit', $u->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        {{-- Hapus --}}
                                        <form method="POST" action="{{ route('user.destroy', $u->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin hapus user?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Tidak ada data user
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection