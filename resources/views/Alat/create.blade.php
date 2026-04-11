@extends('menu.navbar')

@section('content')
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
                        <select name="jenis_item" class="form-control" required>
                            @php
                            $jenis = ['individu', 'bundel'];
                            @endphp
                            @foreach($jenis as $item)
                            <option value="{{ $item }}" {{ old('jenis_item', $alat->jenis_item ?? '') == $item ? 'selected' : '' }}>{{ ucfirst($item) }}</option>
                            @endforeach
                        </select>
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
@endsection