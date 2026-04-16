@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="card mb-4">
            <div class="card-body">
                @php $role = strtolower(auth()->user()->role); @endphp
                <h4 class="card-title">Daftar Alat</h4>
                @if($role == 'admin' || $role == 'petugas')
                <a href="{{ route('Alat.create') }}" class="btn btn-primary mb-3">
                    + Tambah Alat
                </a>
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
                                <th>Lokasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($alats as $index => $alat)

                            @php
                            $bundel = DB::table('bundel_alat')
                                ->leftJoin('alat', 'bundel_alat.id_alat', '=', 'alat.id')
                                ->where('bundel_alat.id_bundle', $alat->id)
                                ->select('alat.nama_alat', 'alat.harga', 'bundel_alat.jumlah')
                                ->get();
                            @endphp

                            <tr>
                                {{-- Kolom No + Toggle Bundle dalam 1 td --}}
                                <td class="text-center">
                                    {{ $index + 1 }}
                                    @if ($alat->jenis_item == 'bundel' && $bundel->count() > 0)
                                    <br>
                                    <button class="btn btn-link btn-sm p-0 text-decoration-none"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#row-bundle-{{ $alat->id }}">
                                        ▶
                                    </button>
                                    @endif
                                </td>

                                <td>
                                    @if ($alat->path_foto)
                                    <img src="{{ asset($alat->path_foto) }}" width="60" style="border-radius:6px;">
                                    @else
                                    -
                                    @endif
                                </td>

                                <td>{{ $alat->nama_alat }}</td>
                                <td>{{ $alat->kategori->nama_kategori ?? '-' }}</td>
                                <td>{{ ucfirst($alat->jenis_item) }}</td>
                                <td>{{ $alat->maksimal_poin_pelanggaran }}</td>
                                <td>{{ $alat->lokasi->name ?? '-' }}</td>

                                <td>
                                    @if($role == 'admin' || $role == 'petugas')
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editAlatModal{{ $alat->id }}">Edit</button>
                                    <form action="{{ route('Alat.destroy', $alat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus alat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                    @endif
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewAlatModal{{ $alat->id }}">Detail</button>
                                </td>
                            </tr>

                            {{-- COLLAPSE BUNDLE --}}
                            @if ($alat->jenis_item == 'bundel' && $bundel->count() > 0)
                            <tr class="collapse" id="row-bundle-{{ $alat->id }}">
                                <td colspan="8" class="bg-light">
                                    <div class="p-3 border-start border-4 border-primary">
                                        <b>Isi Bundel: {{ $alat->nama_alat }}</b>
                                        <table class="table table-sm table-bordered mt-2 mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Barang</th>
                                                    <th>Harga</th>
                                                    <th>Jumlah</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($bundel as $i => $item)
                                                <tr>
                                                    <td>{{ $i + 1 }}</td>
                                                    <td>{{ $item->nama_alat }}</td>
                                                    <td>Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}</td>
                                                    <td>{{ $item->jumlah }}</td>
                                                    <td>Rp {{ number_format(($item->harga ?? 0) * $item->jumlah, 0, ',', '.') }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            @endif

                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Data tidak ada</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL LIHAT DETAIL ALAT -->
@foreach($alats as $alat)
<div class="modal fade" id="viewAlatModal{{ $alat->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Alat: {{ $alat->nama_alat }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Foto Alat:</strong>
                        @if($alat->path_foto)
                        <img src="{{ asset($alat->path_foto) }}" class="img-fluid mt-2" style="max-height:150px;" alt="Foto Alat">
                        @else
                        <p class="mt-2 text-muted">Tidak ada foto</p>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="mb-2">
                            <strong>Nama Alat:</strong>
                            <p>{{ $alat->nama_alat }}</p>
                        </div>
                        <div class="mb-2">
                            <strong>Kategori:</strong>
                            <p>{{ $alat->kategori->nama_kategori ?? '-' }}</p>
                        </div>
                        <div class="mb-2">
                            <strong>Jenis Item:</strong>
                            <p>{{ ucfirst($alat->jenis_item) }}</p>
                        </div>
                        <div class="mb-2">
                            <strong>Harga:</strong>
                            <p>{{ $alat->harga ? 'Rp ' . number_format($alat->harga, 0, ',', '.') : '-' }}</p>
                        </div>
                        <div class="mb-2">
                            <strong>Poin Pelanggaran:</strong>
                            <p>{{ $alat->maksimal_poin_pelanggaran ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Deskripsi:</strong>
                    <p>{{ $alat->deskripsi ?? '-' }}</p>
                </div>

                @if($alat->jenis_item == 'bundel')
                <div class="mb-3">
                    <h6 class="border-bottom pb-2">Isi Bundle Alat:</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $bundel_detail = DB::table('bundel_alat')
                                    ->leftJoin('alat', 'bundel_alat.id_alat', '=', 'alat.id')
                                    ->where('bundel_alat.id_bundle', $alat->id)
                                    ->select('bundel_alat.*', 'alat.nama_alat')
                                    ->get();
                                $grandTotal = 0;
                                @endphp
                                @forelse($bundel_detail as $item)
                                @php $grandTotal += $item->jumlah; @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_alat ?? 'Item' }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Bundle kosong</td>
                                </tr>
                                @endforelse
                                @if($bundel_detail->count() > 0)
                                <tr class="table-light">
                                    <th colspan="2" class="text-end">Total Jumlah</th>
                                    <th>{{ $grandTotal }}</th>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                @if($alat->units->count() > 0)
                <div class="mb-3">
                    <h6 class="border-bottom pb-2">Unit Alat:</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Unit</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($alat->units as $unit)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $unit->kode_unit }}</td>
                                    <td>
                                        <span class="badge {{ $unit->status == 'tersedia' ? 'bg-success' : 'bg-warning' }}">
                                            {{ ucfirst($unit->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $unit->catatan ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada unit</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT ALAT -->
<div class="modal fade" id="editAlatModal{{ $alat->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Alat: {{ $alat->nama_alat }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('Alat.update', $alat->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
                    <div class="mb-3">
                        <label class="form-label">Nama Alat</label>
                        <input type="text" name="nama_alat" class="form-control" value="{{ old('nama_alat', $alat->nama_alat) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="id_kategori" class="form-control">
                            <option value="">Pilih kategori</option>
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('id_kategori', $alat->id_kategori) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" value="{{ old('harga', $alat->harga) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <select name="id_lokasi" class="form-control">
                            <option value="">Pilih lokasi</option>
                            @foreach($lokasis as $lokasi)
                            <option value="{{ $lokasi->id }}" {{ old('id_lokasi', $alat->id_lokasi) == $lokasi->id ? 'selected' : '' }}>
                                {{ $lokasi->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Item</label>
                        <select name="jenis_item" class="form-control jenis-item-modal" data-modal-id="{{ $alat->id }}" required>
                            @php $jenis = ['bundel', 'single', 'bundel_alat']; @endphp
                            @foreach($jenis as $item)
                            <option value="{{ $item }}" {{ old('jenis_item', $alat->jenis_item) == $item ? 'selected' : '' }}>
                                {{ ucfirst($item) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    @if(old('jenis_item', $alat->jenis_item) == 'bundel')
                    <div class="bundel-section-modal" id="bundel_section_{{ $alat->id }}">
                        <div class="card border border-primary">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Isi Bundle Alat</h5>
                                <button type="button" class="btn btn-primary btn-sm add-bundel-modal" data-modal-id="{{ $alat->id }}">
                                    <i class="feather icon-plus"></i> Tambah Baris
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Pilih Alat</th>
                                                <th>Qty</th>
                                                <th>Harga</th>
                                                <th style="width: 50px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bundel-items-modal" id="bundel_items_{{ $alat->id }}">
                                            @php
                                            $bundel_items = DB::table('bundel_alat')
                                                ->leftJoin('alat', 'bundel_alat.id_alat', '=', 'alat.id')
                                                ->where('bundel_alat.id_bundle', $alat->id)
                                                ->select('bundel_alat.*', 'alat.nama_alat')
                                                ->get();
                                            @endphp
                                            @foreach($bundel_items as $index => $item)
                                            <tr class="bundel-item-modal">
                                                <td>
                                                    <input type="text" name="bundel[{{ $index }}][nama_alat]" class="form-control" placeholder="Nama Alat" value="{{ $item->nama_alat ?? '' }}" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="bundel[{{ $index }}][jumlah]" class="form-control" value="{{ $item->jumlah ?? 1 }}" min="1">
                                                </td>
                                                <td>
                                                    <input type="number" name="bundel[{{ $index }}][harga]" class="form-control" value="{{ $item->harga ?? 0 }}" min="0">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm remove-bundel-modal">
                                                        <i class="feather icon-trash-2"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Maksimal Poin Pelanggaran</label>
                        <input type="number" name="maksimal_poin_pelanggaran" class="form-control" value="{{ old('maksimal_poin_pelanggaran', $alat->maksimal_poin_pelanggaran) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $alat->deskripsi) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto Alat</label>
                        <input type="file" name="foto" class="form-control">
                        @if($alat->path_foto)
                        <img src="{{ asset($alat->path_foto) }}" class="img-fluid mt-2" style="max-height:100px;" alt="Foto Alat">
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle jenis item change untuk modals
        document.querySelectorAll('.jenis-item-modal').forEach(select => {
            select.addEventListener('change', function() {
                const modalId = this.getAttribute('data-modal-id');
                const bundelSection = document.getElementById(`bundel_section_${modalId}`);
                bundelSection.style.display = (this.value === 'bundel') ? 'block' : 'none';
            });
        });

        // Handle add bundel baris untuk modals
        document.querySelectorAll('.add-bundel-modal').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const modalId = this.getAttribute('data-modal-id');
                const bundelItems = document.getElementById(`bundel_items_${modalId}`);
                const index = bundelItems.children.length;

                const row = `
                <tr class="bundel-item-modal">
                    <td>
                        <input type="text" name="bundel[${index}][nama_alat]" class="form-control" placeholder="Nama Alat" required>
                    </td>
                    <td>
                        <input type="number" name="bundel[${index}][jumlah]" class="form-control" value="1" min="1" required>
                    </td>
                    <td>
                        <input type="number" name="bundel[${index}][harga]" class="form-control" value="0" min="0" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-bundel-modal">
                            <i class="feather icon-trash-2"></i>
                        </button>
                    </td>
                </tr>`;
                bundelItems.insertAdjacentHTML('beforeend', row);
            });
        });

        // Handle remove bundel baris
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-bundel-modal')) {
                e.preventDefault();
                e.target.closest('tr').remove();
            }
        });
    });
</script>
@endsection