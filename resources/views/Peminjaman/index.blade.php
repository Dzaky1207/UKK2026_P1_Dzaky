@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">

        {{-- TABEL ATAS : DATA PEMINJAMAN --}}
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Data Peminjaman</h4>

                <div class="d-flex flex-wrap gap-2 mb-3">
                    <a href="{{ route('Peminjaman.create') }}" class="btn btn-primary">
                        Ajukan Peminjaman
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pengguna</th>
                                <th>Alat</th>
                                <th>Status</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jatuh Tempo</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjamans as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ optional($p->pengguna)->name }}</td>
                                <td>{{ optional($p->alat)->nama_alat }}</td>
                                <td>
                                    @if($p->status == 'menunggu')
                                    <span class="badge bg-secondary">Menunggu</span>
                                    @elseif($p->status == 'dipinjam')
                                    <span class="badge bg-warning text-dark">Dipinjam</span>
                                    @endif
                                </td>
                                <td>{{ $p->tanggal_pinjam }}</td>
                                <td>{{ $p->tanggal_jatuh_tempo }}</td>
                                <td>
                                    <div class="d-flex gap-2">

                                        {{-- Approve / Reject --}}
                                        @if($p->status == 'menunggu')
                                        <form method="POST" action="{{ route('Peminjaman.approve', $p->id) }}">
                                            @csrf
                                            <button class="btn btn-success btn-sm">Setujui</button>
                                        </form>

                                        <form method="POST" action="{{ route('Peminjaman.reject', $p->id) }}">
                                            @csrf
                                            <button class="btn btn-secondary btn-sm">Tolak</button>
                                        </form>
                                        @endif

                                        {{-- Tombol Kembalikan --}}
                                        @if($p->status == 'dipinjam')
                                        <form method="POST" action="{{ route('Pengembalian.store') }}">
                                            @csrf
                                            <input type="hidden" name="id_peminjaman" value="{{ $p->id }}">
                                            <input type="hidden" name="tanggal_kembali" value="{{ date('Y-m-d') }}">
                                            <button class="btn btn-info btn-sm">Kembalikan</button>
                                        </form>
                                        @endif

                                        {{-- Hapus --}}
                                        <form method="POST" action="{{ route('Peminjaman.destroy', $p->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada peminjaman</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- TABEL BAWAH : DATA PENGEMBALIAN --}}
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Pengembalian</h4>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pengguna</th>
                                <th>Alat</th>
                                <th>Tanggal Kembali</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengembalians as $k)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ optional(optional($k->peminjaman)->pengguna)->name ?? '-' }}</td>
                                <td>{{ optional(optional($k->peminjaman)->alat)->nama_alat ?? '-' }}</td>
                                <td>{{ $k->tanggal_kembali }}</td>
                                <td>{{ optional($k->petugas)->name }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada pengembalian</td>
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