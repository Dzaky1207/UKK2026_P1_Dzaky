@extends('menu.navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Log Aktivitas</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pengguna</th>
                                <th>Aksi</th>
                                <th>Modul</th>
                                <th>Deskripsi</th>
                                <th>Alamat IP</th>
                                <th>Dibuat Pada</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $log->pengguna->name ?? 'Sistem' }}</td>
                                    <td>{{ $log->aksi }}</td>
                                    <td>{{ $log->modul }}</td>
                                    <td>{{ $log->deskripsi }}</td>
                                    <td>{{ $log->alamat_ip }}</td>
                                    <td>{{ $log->created_at  }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada log aktivitas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
