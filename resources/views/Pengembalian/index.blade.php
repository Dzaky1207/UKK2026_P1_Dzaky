@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Data Pengembalian</h4>
                <a href="{{ route('Pengembalian.create') }}" class="btn btn-primary mb-3">Input Pengembalian</a>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Peminjaman</th>
                                <th>Pengguna</th>
                                <th>Alat</th>
                                <th>Unit</th>
                                <th>Tanggal Kembali</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengembalians as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->peminjaman->id ?? '-' }}</td>
                                    <td>{{ $item->peminjaman->pengguna->name ?? '-' }}</td>
                                    <td>{{ $item->peminjaman->alat->nama_alat ?? '-' }}</td>
                                    <td>{{ $item->peminjaman->kode_unit ?? '-' }}</td>
                                    <td>{{ $item->tanggal_kembali }}</td>
                                    <td>{{ $item->petugas->name ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data pengembalian.</td>
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
