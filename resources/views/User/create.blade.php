@extends('menu.navbar')

@section('content')

<form
    action="{{ isset($user)
        ? route('user.update', $user->id)
        : route('user.store') }}"
    method="POST">

    @csrf
    @if(isset($user))
    @method('PUT')
    @endif

    <div class="pc-container">
        <div class="pc-content">
            <h5 class="mb-4">
                {{ isset($user) ? 'Edit Data User' : 'Tambah Data User' }}
            </h5>

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $user->name ?? '') }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email', $user->email ?? '') }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Password {{ isset($user) ? '(Kosongkan jika tidak diubah)' : '' }}
                </label>
                <input type="password"
                    name="password"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-control" required>
                    @php
                    $roleLogin = auth()->user()->role;

                    if($roleLogin == 'admin'){
                    $roles = ['admin', 'petugas', 'user'];
                    } else {
                    $roles = ['petugas', 'user']; // admin disembunyikan
                    }

                    $current = old('role', $user->role ?? '');
                    @endphp

                    @foreach($roles as $r)
                    <option value="{{ $r }}" {{ $current == $r ? 'selected' : '' }}>
                        {{ ucfirst($r) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            <a href="{{ route('User.user') }}" class="btn btn-secondary mt-3 ms-2">
                Kembali
            </a>

        </div>
    </div>
</form>

@endsection