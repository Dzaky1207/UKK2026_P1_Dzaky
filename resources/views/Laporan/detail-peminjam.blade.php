@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title mb-3">Detail Peminjaman - {{ $user->name }}</h4>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>Nama:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email ?? '-' }}</p>
                        <p><strong>No. HP:</strong> {{ $user->no_hp ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Alamat:</strong> {{ $user->alamat ?? '-' }}</p>
                        <p><strong>Total Peminjaman:</strong> <span class="badge bg-primary">{{ $user->peminjaman->count() }}</span></p>
                    </div>
                </div>

                <a href="{{ route('Peminjaman.laporanPeminjam') }}" class="btn btn-secondary mb-3">
                    <i class="feather icon-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('Peminjaman.printDetailPeminjam', $user->id) }}" class="btn btn-danger mb-3" target="_blank">
                    <i class="feather icon-printer"></i> Print
                </a>

                <hr>

                <h5 class="mb-3">Riwayat Peminjaman</h5>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Alat</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jatuh Tempo</th>
                                <th>Tujuan</th>
                                <th>Status</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($user->peminjaman as $pinjam)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ optional($pinjam->alat)->nama_alat ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d-m-Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->format('d-m-Y') }}</td>
                                    <td>{{ $pinjam->tujuan ?? '-' }}</td>
                                    <td>
                                        @if($pinjam->status == 'menunggu')
                                            <span class="badge bg-secondary">Menunggu</span>
                                        @elseif($pinjam->status == 'dipinjam')
                                            <span class="badge bg-warning text-dark">Dipinjam</span>
                                        @elseif($pinjam->status == 'ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @elseif($pinjam->status == 'dikembalikan')
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($pinjam->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ optional($pinjam->petugas)->name ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada riwayat peminjaman</td>
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
