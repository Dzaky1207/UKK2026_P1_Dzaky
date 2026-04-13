@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Daftar Lokasi</h4>
                <a href="{{ route('Lokasi.create') }}" class="btn btn-primary mb-3">
                    <i class="feather icon-plus"></i> Tambah Lokasi
                </a>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Lokasi</th>
                                <th style="width: 200px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lokasis as $lokasi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $lokasi->lokasi }}</td>
                                    <td>
                                        <a href="{{ route('Lokasi.edit', $lokasi->id) }}" class="btn btn-warning btn-sm">
                                            <i class="feather icon-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('Lokasi.destroy', $lokasi->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus lokasi?')">
                                                <i class="feather icon-trash-2"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Data lokasi belum tersedia.</td>
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
