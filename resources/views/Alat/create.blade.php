@extends('menu.navbar')

@section('content')
<?php
use Illuminate\Support\Facades\DB;
?>
<div class="pc-container">
    <div class="pc-content">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ isset($alat) ? 'Edit Alat' : 'Tambah Alat' }}</h4>
                <form
                    action="{{ isset($alat) ? route('Alat.update', $alat) : route('Alat.store') }}"
                    method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    @if(isset($alat))
                    @method('PUT')
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Nama Alat</label>
                        <input type="text" name="nama_alat" class="form-control" value="{{ old('nama_alat', $alat->nama_alat ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="id_kategori" class="form-control">
                            <option value="">Pilih kategori</option>
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('id_kategori', $alat->id_kategori ?? '') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Item</label>
                        <select name="jenis_item" id="jenis_item" class="form-control" required>
                            @php
                            $jenis = ['individu', 'bundel'];
                            @endphp
                            @foreach($jenis as $item)
                            <option value="{{ $item }}" {{ old('jenis_item', $alat->jenis_item ?? '') == $item ? 'selected' : '' }}>{{ ucfirst($item) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sub-Bundle Section -->
                    <div class="mb-3" id="bundel_section" style="display: {{ old('jenis_item', $alat->jenis_item ?? '') == 'bundel' ? 'block' : 'none' }};">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Daftar Sub-Bundle</h5>
                            </div>
                            <div class="card-body">
                                <div id="bundel_items">
                                    @if(isset($alat) && $alat->jenis_item == 'bundel')
                                        @php
                                            $bundel_items = DB::table('bundel_alat')
                                                ->where('id_bundle', $alat->id)
                                                ->get();
                                        @endphp
                                        @foreach($bundel_items as $bundle_item)
                                        <div class="bundel-item mb-3 p-3 border rounded" data-index="{{ $loop->index }}">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label class="form-label">Pilih Alat</label>
                                                    <select name="bundel[{{ $loop->index }}][id_alat]" class="form-control">
                                                        <option value="">-- Pilih Alat --</option>
                                                        @foreach($allAlat as $item)
                                                        <option value="{{ $item->id }}" {{ $bundle_item->id_alat == $item->id ? 'selected' : '' }}>{{ $item->nama_alat }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Jumlah</label>
                                                    <input type="number" name="bundel[{{ $loop->index }}][jumlah]" class="form-control" value="{{ $bundle_item->jumlah ?? 1 }}" min="1">
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end">
                                                    <button type="button" class="btn btn-danger btn-sm w-100 remove-bundel">
                                                        <i class="feather icon-trash-2"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn btn-primary" id="add_bundel">
                                    <i class="feather icon-plus"></i> Tambah Sub-Bundle
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Maksimal Poin Pelanggaran</label>
                        <input type="number" name="maksimal_poin_pelanggaran" class="form-control" value="{{ old('maksimal_poin_pelanggaran', $alat->maksimal_poin_pelanggaran ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $alat->deskripsi ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto Alat</label>
                        <input type="file" name="foto" class="form-control">
                        @if(isset($alat) && $alat->path_foto)
                        <img src="{{ asset($alat->path_foto) }}" class="img-fluid mt-2" style="max-height:100px;" alt="Foto Alat">
                        @endif
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <a href="{{ route('Alat.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jenisItemSelect = document.getElementById('jenis_item');
    const bundelSection = document.getElementById('bundel_section');
    const bundelItems = document.getElementById('bundel_items');
    const addBundelBtn = document.getElementById('add_bundel');

    const allAlat = @json($allAlat);

    // Toggle bundel section visibility
    jenisItemSelect.addEventListener('change', function() {
        if (this.value === 'bundel') {
            bundelSection.style.display = 'block';
        } else {
            bundelSection.style.display = 'none';
        }
    });

    // Add bundel item
    addBundelBtn.addEventListener('click', function() {
        const index = bundelItems.children.length;
        const bundleItemHTML = `
            <div class="bundel-item mb-3 p-3 border rounded" data-index="${index}">
                <div class="row">
                    <div class="col-md-8">
                        <label class="form-label">Pilih Alat</label>
                        <select name="bundel[${index}][id_alat]" class="form-control">
                            <option value="">-- Pilih Alat --</option>
                            ${allAlat.map(alat => `<option value="${alat.id}">${alat.nama_alat}</option>`).join('')}
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="bundel[${index}][jumlah]" class="form-control" value="1" min="1">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm w-100 remove-bundel">
                            <i class="feather icon-trash-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        bundelItems.insertAdjacentHTML('beforeend', bundleItemHTML);
        attachRemoveListeners();
    });

    // Remove bundel item
    function attachRemoveListeners() {
        document.querySelectorAll('.remove-bundel').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                this.closest('.bundel-item').remove();
            });
        });
    }

    // Attach listeners on page load
    attachRemoveListeners();
});
</script>
@endsection