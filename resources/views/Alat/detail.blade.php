@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="card">
            <div class="card-body">
                
                <h4>Detail Bundel: {{ $alat->nama_alat }}</h4>

                <a href="{{ route('Alat.index') }}" class="btn btn-secondary mb-3">Kembali</a>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grandTotal = 0; @endphp

                        @foreach($bundel as $item)
                            @php
                                $grandTotal += $item->jumlah;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_alat ?? 'Item' }}</td>
                                <td>{{ $item->jumlah }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <th colspan="2" class="text-end">Total Jumlah</th>
                            <th>{{ $grandTotal }}</th>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection