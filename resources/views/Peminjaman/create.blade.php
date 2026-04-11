@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ isset($peminjaman) ? 'Edit Peminjaman' : 'Ajukan Peminjaman' }}</h4>
                <form action="{{ isset($peminjaman) ? route('Peminjaman.update', $peminjaman->id) : route('Peminjaman.store') }}" method="POST">
                    @csrf
                    @if(isset($peminjaman))
                        @method('PUT')
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Pengguna</label>
                        <select name="id_pengguna" class="form-control" required>
                            <option value="">Pilih pengguna</option>
                            @foreach($pengguna as $user)
                                <option value="{{ $user->id }}" {{ old('id_pengguna', $peminjaman->id_pengguna ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alat</label>
                        <select name="id_alat" class="form-control" required>
                            <option value="">Pilih alat</option>
                            @foreach($alat as $item)
                                <option value="{{ $item->id }}" {{ old('id_alat', $peminjaman->id_alat ?? '') == $item->id ? 'selected' : '' }}>{{ $item->nama_alat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Jatuh Tempo</label>
                        <input type="date" name="tanggal_jatuh_tempo" class="form-control" value="{{ old('tanggal_jatuh_tempo', $peminjaman->tanggal_jatuh_tempo ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tujuan</label>
                        <textarea name="tujuan" class="form-control" rows="3">{{ old('tujuan', $peminjaman->tujuan ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3">{{ old('catatan', $peminjaman->catatan ?? '') }}</textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <a href="{{ route('Peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
