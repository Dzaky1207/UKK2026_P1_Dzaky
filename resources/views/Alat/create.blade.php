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
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control"
                            value="{{ old('harga', $alat->harga ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Item</label>
                        <select name="jenis_item" id="jenis_item" class="form-control" required>
                            @php
                            $jenis = ['bundel', 'single', 'bundel_alat'];
                            @endphp
                            @foreach($jenis as $item)
                            <option value="{{ $item }}" {{ old('jenis_item', $alat->jenis_item ?? '') == $item ? 'selected' : '' }}>{{ ucfirst($item) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sub-Bundle Section -->
                    <div class="mb-3" id="bundel_section" style="display: {{ old('jenis_item', $alat->jenis_item ?? '') == 'bundel' ? 'block' : 'none' }};">
                        <div class="card border border-primary">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Isi Bundle Alat</h5>
                                <button type="button" class="btn btn-primary btn-sm" id="add_bundel">
                                    <i class="feather icon-plus"></i> Tambah Baris
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Pilih Alat</th>
                                                <th style="width: 100px;">Qty</th>
                                                <th style="width: 50px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bundel_items">
                                            @if(isset($alat) && $alat->jenis_item == 'bundel')
                                            @php
                                            $bundel_items = DB::table('bundel_alat')->where('id_bundle', $alat->id)->get();
                                            @endphp
                                            @foreach($bundel_items as $index => $item)
                                            <tr class="bundel-item">
                                                <td>
                                                    <select name="bundel[{{ $index }}][id_alat]" class="form-control" required>
                                                        <option value="">-- Pilih Alat --</option>
                                                        @foreach($allAlat as $a)
                                                        <option value="{{ $a->id }}" {{ $item->id_alat == $a->id ? 'selected' : '' }}>{{ $a->nama_alat }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="bundel[{{ $index }}][jumlah]" class="form-control" value="{{ $item->jumlah ?? 1 }}" min="1">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm remove-bundel"><i class="feather icon-trash-2"></i></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
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

        jenisItemSelect.addEventListener('change', function() {
            bundelSection.style.display = (this.value === 'bundel') ? 'block' : 'none';
        });

        addBundelBtn.addEventListener('click', function() {
            const index = bundelItems.children.length;
            const row = `
            <tr class="bundel-item">
                <td>
                    <select name="bundel[${index}][id_alat]" class="form-control" required>
                        <option value="">-- Pilih Alat --</option>
                        @foreach($allAlat as $a)
                        <option value="{{ $a->id }}">{{ $a->nama_alat }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="bundel[${index}][jumlah]" class="form-control" value="1" min="1"></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-bundel"><i class="feather icon-trash-2"></i></button></td>
            </tr>`;
            bundelItems.insertAdjacentHTML('beforeend', row);
        });

        bundelItems.addEventListener('click', function(e) {
            if (e.target.closest('.remove-bundel')) {
                e.target.closest('tr').remove();
            }
        });
    });
</script>
@endsection