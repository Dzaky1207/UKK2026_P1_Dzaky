@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Riwayat Pengembalian</h4>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead style="background-color:#0d6efd; color:white;">
                            <tr>
                                <th>No</th>
                                <th>Nama User</th>
                                <th>Alat</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Kondisi</th>
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
                                    @elseif($item->status == 'diterima')
                                    <span class="badge bg-success">Diterima</span>
                                    @else
                                    <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>

                                <td>{{ $item->kondisiUnit->kondisi ?? '-' }}</td>
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