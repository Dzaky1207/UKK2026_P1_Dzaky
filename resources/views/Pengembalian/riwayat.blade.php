@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Riwayat Pengembalian</h4>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama User</th>
                                <th>Alat</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Kondisi</th>
                                <th>Bukti</th>
                                <th>Poin Pelanggaran</th>
                                <th>Denda</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengembalians as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->peminjaman->user->name ?? '-' }}</td>
                                <td>{{ $item->peminjaman->alat->nama_alat ?? '-' }}</td>
                                <td>{{ $item->tanggal_kembali ?? '-' }}</td>

                                <td>
                                    @if($item->status == 'menunggu')
                                    <span class="badge bg-warning">Menunggu</span>
                                    @elseif($item->status == 'disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                    @elseif($item->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                    @else
                                    <span class="badge bg-secondary">Tidak diketahui</span>
                                    @endif
                                </td>


                                <td>{{ $item->kondisiUnit->kondisi ?? '-' }}</td>
                                <td>
                                    <img src="{{ asset($item->bukti) }}" width="60">
                                </td>
                                <td>{{ $item->pelanggaran->poin ?? 0 }}</td>
                                <td>
                                    @if($item->pelanggaran)
                                    @if($item->pelanggaran->hari_terlambat > 0)
                                    <span class="badge bg-danger">
                                        {{ $item->pelanggaran->hari_terlambat }} hari |
                                        Rp {{ number_format($item->pelanggaran->denda, 0, ',', '.') }}
                                    </span>
                                    @else
                                    <span class="badge bg-success">
                                        Tidak Terlambat
                                    </span>
                                    @endif
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>{{ $item->kondisiUnit->catatan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection