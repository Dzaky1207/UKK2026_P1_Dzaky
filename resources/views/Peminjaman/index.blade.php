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
                                <td>{{ optional($p->user)->name }}</td>
                                <td>{{ optional($p->alat)->nama_alat }}</td>
                                <td>
                                    @php
                                    $status = strtolower(trim($p->status));
                                    @endphp

                                    @if($status == 'menunggu')
                                    <span class="badge bg-warning">Menunggu</span>
                                    @elseif($status == 'diterima')
                                    <span class="badge bg-success">Diterima</span>
                                    @elseif($status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                    @else
                                    <span class="badge bg-secondary">{{ $p->status }}</span>
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

                                        @if($role == 'user' && $p->status == 'dipinjam')
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
                                                <h5 class="modal-title">Ajukan Pengembalian</h5>
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
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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

        @if($role == 'petugas' || $role == 'admin')

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
                                <th>Status Pengembalian</th>
                                <th>Tanggal Kembali</th>
                                <th>Petugas</th>
                                <th>Kondisi Barang</th>
                                <th>Catatan</th>
                                <th>Bukti</th>
                                <th>Poin Pelanggaran</th>
                                <th>Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengembalians as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ optional(optional($p->peminjaman)->user)->name ?? '-' }}</td>
                                <td>{{ optional(optional($p->peminjaman)->alat)->nama_alat ?? '-' }}</td>
                                <td>
                                    @if($p->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif($p->status == 'disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                    @elseif($p->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>{{ $p->tanggal_kembali }}</td>
                                <td>{{ optional($p->petugas)->name }}</td>
                                <td>
                                    @if(optional($p->kondisiUnit)->kondisi == 'baik')
                                    <span class="badge bg-success">Baik</span>
                                    @elseif(optional($p->kondisiUnit)->kondisi == 'rusak_ringan')
                                    <span class="badge bg-warning text-dark">Rusak Ringan</span>
                                    @elseif(optional($p->kondisiUnit)->kondisi == 'rusak_berat')
                                    <span class="badge bg-danger">Rusak Berat</span>
                                    @else
                                    -
                                    @endif
                                </td>

                                <td>{{ optional($p->kondisiUnit)->catatan ?? '-' }}</td>
                                <td>
                                    @if($p->bukti)
                                    <img src="{{ asset($p->bukti) }}" width="60">
                                    @else
                                    <span class="text-danger">Tidak ada gambar</span>
                                    @endif
                                </td>

                                <td>
                                    {{ optional($p->pelanggaran)->poin ?? 0 }}
                                </td>
                                <td>Rp {{ optional($p->pelanggaran)->denda ?? 0 }}</td>
                                <td>
                                    @if($p->status == 'menunggu')
                                    <button class="btn btn-primary btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalProses{{ $p->id }}">
                                        Proses
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            <div class="modal fade" id="modalProses{{ $p->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('Pengembalian.proses', $p->id) }}">
                                            @csrf

                                            <div class="modal-header">
                                                <h5 class="modal-title">Proses Pengembalian</h5>
                                                <button class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">

                                                {{-- Info jatuh tempo sebagai referensi petugas --}}
                                                <div class="alert alert-info mb-3">
                                                    <strong>Jatuh Tempo:</strong>
                                                    {{ optional($p->peminjaman)->tanggal_jatuh_tempo ?? '-' }}
                                                </div>

                                                <input type="date" name="tanggal_kembali"
                                                    class="form-control tanggal-kembali"
                                                    data-id="{{ $p->id }}"
                                                    data-tempo="{{ optional($p->peminjaman)->tanggal_jatuh_tempo }}"
                                                    value="{{ date('Y-m-d') }}"
                                                    required>
                                                <div class="mb-3">
                                                    <label>Poin Pelanggaran</label>
                                                    <input type="text" id="poin{{ $p->id }}" class="form-control" readonly value="0">
                                                </div>

                                                <div class="mb-3">
                                                    <label>Denda (Rp)</label>
                                                    <input type="text" id="denda{{ $p->id }}" class="form-control" readonly value="0">
                                                </div>

                                                <div class="mb-3">
                                                    <label>Kondisi Barang </label>
                                                    <select name="kondisi" class="form-control" required>
                                                        <option value="">-- Pilih --</option>
                                                        <option value="baik">Baik</option>
                                                        <option value="rusak_ringan">Rusak Ringan</option>
                                                        <option value="rusak_berat">Rusak Berat</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label>Catatan</label>
                                                    <textarea name="catatan" class="form-control"></textarea>
                                                </div>

                                            </div>

                                            <div class="modal-footer">
                                                <button name="aksi" value="tolak" class="btn btn-danger">Tolak</button>
                                                <button name="aksi" value="setujui" class="btn btn-success">Setujui</button>
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
        @endif
    </div>
</div>
<script>
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('tanggal-kembali')) {

            let id = e.target.dataset.id;
            let jatuhTempo = e.target.dataset.tempo;

            let tglKembali = new Date(e.target.value);
            let tempo = new Date(jatuhTempo);

            let selisih = Math.floor((tglKembali - tempo) / (1000 * 60 * 60 * 24));

            if (selisih < 0) selisih = 0;

            let poin = selisih * 5;
            let denda = poin * 600;

            let dendaFormatted = denda.toLocaleString('id-ID');

            document.getElementById('denda' + id).value = dendaFormatted;

            document.getElementById('poin' + id).value = poin;
            document.getElementById('denda' + id).value = denda;
        }
    });
</script>
@endsection