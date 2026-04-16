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
            <div class="col-md-6 col-xl-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="mb-2">Total User</h5>
                        <h2 class="mb-0">{{ $jumlahUser }}</h2>
                    </div>
                </div>
            </div>

            <!-- Jumlah Alat -->
            <div class="col-md-6 col-xl-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="mb-2">Total Alat</h5>
                        <h2 class="mb-0">{{ $jumlahAlat }}</h2>
                    </div>
                </div>
            </div>

        </div>

        <!-- [ Main Content ] end -->
    </div>
</div>
@endsection