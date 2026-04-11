@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Input Pengembalian</h4>
                <form action="{{ route('pengembalian.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Peminjaman</label>
                        <select name="id_peminjaman" class="form-control" required>
                            <option value="">Pilih peminjaman</option>
                            @foreach($peminjamans as $item)
                                <option value="{{ $item->id }}">{{ $item->id }} - {{ $item->pengguna->name ?? '-' }} | {{ $item->alat->nama_alat ?? '-' }} | {{ $item->kode_unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3"></textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
