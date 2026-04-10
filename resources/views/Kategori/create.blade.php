@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori' }}</h4>
                <form action="{{ isset($kategori) ? route('kategori.update', $kategori->id) : route('kategori.store') }}" method="POST">
                    @csrf
                    @if(isset($kategori))
                        @method('PUT')
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $kategori->deskripsi ?? '') }}</textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <a href="{{ route('Kategori.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
