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
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $lokasi->name ?? '') }}"
                            placeholder="Masukkan nama lokasi"
                            required>

                        @error('name')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Detail Lokasi</label>
                        <textarea
                            name="detail"
                            class="form-control @error('detail') is-invalid @enderror"
                            placeholder="Masukkan detail lokasi"
                            rows="3">{{ old('detail', $lokasi->detail ?? '') }}</textarea>
                        @error('detail')
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