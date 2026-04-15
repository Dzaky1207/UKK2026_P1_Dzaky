@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">


        <div class="card mb-4">
            @php
            $role = auth()->user()->role;
            @endphp
            <div class="card-body">
                <h4 class="card-title">Data Peminjaman</h4>

                @if($role == 'user')
                <a href="{{ route('Peminjaman.create') }}" class="btn btn-primary">
                    Ajukan Peminjaman
                </a>
                @endif

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
                                @if($role == 'admin' || $role == 'petugas')
                                <th>Aksi</th>
                                @endif
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
                                    @elseif($p->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>{{ $p->tanggal_pinjam }}</td>
                                <td>{{ $p->tanggal_jatuh_tempo }}</td>
                                <td>
                                    <div class="d-flex gap-2">

                                        @if($role == 'admin' || $role == 'petugas')
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
                                        @endif

                                        @if($role == 'petugas' && $p->status == 'dipinjam')
                                        <button class="btn btn-info btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalKembali{{ $p->id }}">
                                            Kembalikan
                                        </button>
                                        @endif

                                        @if($role == 'admin')
                                        <form method="POST" action="{{ route('Peminjaman.destroy', $p->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                        @endif

                                    </div>
                                </td>
                            </tr>

                            {{-- ✅ MODAL HARUS DI SINI --}}
                            @if($p->status == 'dipinjam')
                            <div class="modal fade" id="modalKembali{{ $p->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('Pengembalian.store') }}" enctype="multipart/form-data">
                                            @csrf

                                            <div class="modal-header">
                                                <h5 class="modal-title">Pengembalian Alat</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <input type="hidden" name="id_peminjaman" value="{{ $p->id }}">
                                                <input type="hidden" name="tanggal_kembali" value="{{ date('Y-m-d') }}">

                                                <div class="mb-3">
                                                    <label>Upload Bukti</label>
                                                    <input type="file" name="bukti" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Kirim</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif

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
                                <th>Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengembalians as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ optional(optional($p->peminjaman)->pengguna)->name ?? '-' }}</td>
                                <td>{{ optional(optional($p->peminjaman)->alat)->nama_alat ?? '-' }}</td>
                                <td>{{ $p->tanggal_kembali }}</td>
                                <td>{{ optional($p->petugas)->name }}</td>
                                <td>
                                    @if($p->bukti && file_exists(public_path($p->bukti)))
                                    <img src="{{ asset($p->bukti) }}" width="60">
                                    @else
                                    <span class="text-danger">Tidak ada gambar</span>
                                    @endif
                                </td>
                            </tr>
                            <div class="modal fade" id="modalKembali{{ $p->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('Pengembalian.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Pengembalian Alat</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <input type="hidden" name="id_peminjaman" value="{{ $p->id }}">
                                                <input type="hidden" name="tanggal_kembali" value="{{ date('Y-m-d') }}">

                                                <div class="mb-3">
                                                    <label class="form-label">Upload Bukti (Foto)</label>
                                                    <input type="file" name="bukti" class="form-control" accept="image/*" required>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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