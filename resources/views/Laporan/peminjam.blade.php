@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title mb-3">Laporan Data Peminjam</h4>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Peminjam</th>
                                <th>Email</th>
                                <th style="width: 120px;">No. HP</th>
                                <th style="width: 100px;">Jumlah Peminjaman</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjams as $peminjam)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $peminjam->name }}</strong>
                                    </td>
                                    <td>{{ $peminjam->email ?? '-' }}</td>
                                    <td>{{ $peminjam->no_hp ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $peminjam->peminjaman->count() }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('Peminjaman.detailPeminjam', $peminjam->id) }}" class="btn btn-info btn-sm">
                                            <i class="feather icon-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('Peminjaman.printDetailPeminjam', $peminjam->id) }}" class="btn btn-danger btn-sm" target="_blank">
                                            <i class="feather icon-printer"></i> Print
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data peminjam</td>
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
