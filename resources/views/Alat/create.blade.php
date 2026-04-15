@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Alat</h4>

                <form action="{{ route('Alat.store') }}" method="POST">
                    @csrf

                    <!-- Nama -->
                    <div class="mb-3">
                        <label>Nama Alat</label>
                        <input type="text" name="nama_alat" class="form-control" required>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="id_kategori" class="form-control">
                            <option value="">Pilih kategori</option>
                            @foreach($kategoris as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Harga -->
                    <div class="mb-3">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control">
                    </div>

                    <!-- Jenis -->
                    <div class="mb-3">
                        <label>Jenis Item</label>
                        <select name="jenis_item" id="jenis_item" class="form-control">
                            <option value="single">Single</option>
                            <option value="bundel">Bundel</option>
                        </select>
                    </div>

                    <!-- BUNDEL -->
                    <div id="bundel_section" style="display:none;">
                        <div class="card border border-primary">
                            <div class="card-header d-flex justify-content-between">
                                <b>Isi Bundel</b>
                                <button type="button" id="add_bundel" class="btn btn-primary btn-sm">
                                    + Tambah
                                </button>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama Alat</th>
                                            <th>Qty</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bundel_items"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Poin -->
                    <div class="mb-3">
                        <label>Maksimal Poin</label>
                        <input type="number" name="maksimal_poin_pelanggaran" class="form-control">
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control"></textarea>
                    </div>

                    <button class="btn btn-success">Simpan</button>
                    <a href="{{ route('Alat.index') }}" class="btn btn-secondary">Kembali</a>

                </form>
            </div>
        </div>

    </div>
</div>

<script>
document.getElementById('jenis_item').addEventListener('change', function() {
    document.getElementById('bundel_section').style.display =
        (this.value === 'bundel') ? 'block' : 'none';
});

document.getElementById('add_bundel').addEventListener('click', function() {
    const table = document.getElementById('bundel_items');
    const index = table.children.length;

    const row = `
    <tr>
        <td><input type="text" name="bundel[${index}][nama_alat]" class="form-control" required></td>
        <td><input type="number" name="bundel[${index}][jumlah]" value="1" class="form-control"></td>
        <td><button type="button" class="btn btn-danger remove">X</button></td>
    </tr>`;

    table.insertAdjacentHTML('beforeend', row);
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove')) {
        e.target.closest('tr').remove();
    }
});
</script>
@endsection