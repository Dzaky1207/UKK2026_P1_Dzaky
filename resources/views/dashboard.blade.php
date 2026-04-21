@extends('menu/navbar')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="mb-0">Home</h5>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <ul class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0)">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Home</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">

            <!-- Jumlah User -->
            <div class="col-md-12 col-xl-4">
                <div class="card card-social">
                    <div class="card-body border-bottom">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-auto">
                                <i class="ti ti-user text-primary f-36"></i>
                            </div>
                            <div class="col text-end">
                                <h3>{{ $jumlahUser }}</h3>
                                <h5 class="text-success mb-0">
                                    Data <span class="text-muted">User</span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card card-social">
                    <div class="card-body border-bottom">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-auto">
                                <i class="ti ti-tool text-info f-36"></i>
                            </div>
                            <div class="col text-end">
                                <h3>{{ $jumlahAlat }}</h3>
                                <h5 class="text-info mb-0">
                                    Data <span class="text-muted">Alat</span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card card-social">
                    <div class="card-body border-bottom">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-auto">
                                <i class="ti ti-shopping-cart text-danger f-36"></i>
                            </div>
                            <div class="col text-end">
                                <h3>{{ $jumlahPeminjaman }}</h3>
                                <h5 class="text-danger mb-0">
                                    Data <span class="text-muted">Peminjaman</span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- [ Main Content ] end -->
    </div>
</div>
@endsection