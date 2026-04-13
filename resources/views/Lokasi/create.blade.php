@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ isset($lokasi) ? 'Edit Lokasi' : 'Tambah Lokasi' }}</h4>
                <form action="{{ isset($lokasi) ? route('Lokasi.update', $lokasi->id) : route('Lokasi.store') }}" method="POST">
                    @csrf
                    @if(isset($lokasi))
                        @method('PUT')
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Nama Lokasi</label>
                        <input 
                            type="text" 
                            name="lokasi" 
                            class="form-control @error('lokasi') is-invalid @enderror" 
                            value="{{ old('lokasi', $lokasi->lokasi ?? '') }}" 
                            placeholder="Masukkan nama lokasi"
                            required>
                        @error('lokasi')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-primary" type="submit">
                            <i class="feather icon-save"></i> Simpan
                        </button>
                        <a href="{{ route('Lokasi.index') }}" class="btn btn-secondary ms-2">
                            <i class="feather icon-x"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
