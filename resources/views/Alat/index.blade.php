@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="card mb-4">
            <div class="card-body">
                @php $role = strtolower(auth()->user()->role); @endphp
                <h4 class="card-title">Daftar Alat</h4>
                @if($role == 'admin' || $role == 'petugas')
                <a href="{{ route('Alat.create') }}" class="btn btn-primary mb-3">Tambah Alat</a>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto Alat</th>
                                <th>Nama Alat</th>
                                <th>Kategori</th>
                                <th>Jenis</th>
                                <th>Poin Pelanggaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($alats as $alat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><img src="{{ asset($alat->path_foto) }}" class="img-fluid" style="max-height:100px;" alt="Foto Alat"></td>
                                <td>{{ $alat->nama_alat }}</td>
                                <td>{{ $alat->kategori->nama_kategori ?? '-' }}</td>
                                <td>{{ ucfirst($alat->jenis_item) }}</td>
                                <td>{{ $alat->maksimal_poin_pelanggaran }}</td>
                                <td>
                                    {{-- ADMIN & PETUGAS --}}
                                    @if($role == 'admin' || $role == 'petugas')

                                    <a href="{{ route('Alat.edit', $alat->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('Alat.destroy', $alat->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus alat?')">Hapus</button>
                                    </form>

                                    @endif

                                    {{-- SEMUA ROLE BISA LIHAT DETAIL --}}
                                    @if($alat->jenis_item == 'bundel')
                                    <a href="{{ route('Alat.show', $alat->id) }}" class="btn btn-info btn-sm">
                                        Detail
                                    </a>
                                    @else
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $alat->id }}">
                                        Detail
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Data alat belum tersedia.</td>
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