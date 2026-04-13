<!doctype html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>{{ Auth::check() ? Auth::user()->name.' | Datta Able' : 'Datta Able' }}</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
        name="description"
        content="Datta able is trending dashboard template made using Bootstrap 5 design framework. Datta able is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies." />
    <meta
        name="keywords"
        content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard" />
    <meta name="author" content="Codedthemes" />

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" />
    <!-- [Font] Family -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <!-- [phosphor Icons] https://phosphoricons.com/ -->
    <link rel="stylesheet" href="{{ asset ('assets/fonts/phosphor/regular/style.css') }}" />
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset ('assets/fonts/tabler-icons.min.css') }}" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset ('assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset ('assets/css/style-preset.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-14K1GBX9FG"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-14K1GBX9FG');
    </script>
    <!-- WiserNotify -->
    <script>
        !(function() {
            if (window.t4hto4) console.log('WiserNotify pixel installed multiple time in this page');
            else {
                window.t4hto4 = !0;
                var t = document,
                    e = window,
                    n = function() {
                        var e = t.createElement('script');
                        (e.type = 'text/javascript'),
                        (e.async = !0),
                        (e.src = 'https://pt.wisernotify.com/pixel.js?ti=1jclj6jkfc4hhry'),
                        document.body.appendChild(e);
                    };
                'complete' === t.readyState ? n() : window.attachEvent ? e.attachEvent('onload', n) : e.addEventListener('load', n, !1);
            }
        })();
    </script>
    <!-- Microsoft clarity -->
    <script type="text/javascript">
        (function(c, l, a, r, i, t, y) {
            c[a] =
                c[a] ||
                function() {
                    (c[a].q = c[a].q || []).push(arguments);
                };
            t = l.createElement(r);
            t.async = 1;
            t.src = 'https://www.clarity.ms/tag/' + i;
            y = l.getElementsByTagName(r)[0];
            y.parentNode.insertBefore(t, y);
        })(window, document, 'clarity', 'script', 'gkn6wuhrtb');
    </script>

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ Sidebar Menu ] start -->
    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="{{ route('dashboard') }}" class="b-brand text-primary">
                    <!-- ========   Change your logo from here   ============ -->
                    <img src="{{ asset('assets/images/favicon.svg') }}" alt="Datta Able" class="img-fluid">
                </a>
            </div>
            <div class="navbar-content">
                @auth
                @php
                $role = strtolower(auth()->user()->role);
                @endphp

                <ul class="pc-navbar">

                    {{-- ===== Navigation ===== --}}
                    <li class="pc-item pc-caption">
                        <label>Navigation</label>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('dashboard') }}" class="pc-link">
                            <span class="pc-micon"><i class="ph ph-house-line"></i></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>

                    {{-- ================= ADMIN ================= --}}
                    @if($role == 'admin')

                    <li class="pc-item pc-caption">
                        <label>Data Pengguna</label>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('User.user') }}" class="pc-link">
                            <i class="ph ph-user"></i>
                            <span class="pc-mtext">CRUD User</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Master</label>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('Alat.index') }}" class="pc-link">
                            <i class="ti ti-tools"></i>
                            <span class="pc-mtext">CRUD Alat</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('Kategori.index') }}" class="pc-link">
                            <i class="ti ti-list-check"></i>
                            <span class="pc-mtext">Kategori</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('Log_aktivitas.index') }}" class="pc-link">
                            <i class="ti ti-shield-check"></i>
                            <span class="pc-mtext">Log Aktivitas</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('Peminjaman.index') }}" class="pc-link">
                            <i class="ti ti-stack"></i>
                            <span class="pc-mtext">Monitoring Peminjaman</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('Pengembalian.index') }}" class="pc-link">
                            <i class="ti ti-refresh"></i>
                            <span class="pc-mtext">Pengembalian</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="#" class="pc-link">
                            <i class="ti ti-printer"></i>
                            <span class="pc-mtext">Cetak Laporan</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="#" class="pc-link">
                            <i class="ti ti-history"></i>
                            <span class="pc-mtext">Riwayat</span>
                        </a>
                    </li>

                    @endif


                    {{-- ================= PETUGAS ================= --}}
                    @if($role == 'petugas')

                    <li class="pc-item pc-caption">
                        <label>Data Pengguna</label>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('User.user') }}" class="pc-link">
                            <i class="ph ph-user"></i>
                            <span class="pc-mtext">CRUD User</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Master</label>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('Peminjaman.index') }}" class="pc-link">
                            <i class="ti ti-stack"></i>
                            <span class="pc-mtext">Monitoring Peminjaman</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('Pengembalian.index') }}" class="pc-link">
                            <i class="ti ti-refresh"></i>
                            <span class="pc-mtext">Pengembalian</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="#" class="pc-link">
                            <i class="ti ti-printer"></i>
                            <span class="pc-mtext">Cetak Laporan</span>
                        </a>
                    </li>

                    @endif


                    {{-- ================= PEMINJAM ================= --}}
                    @if($role == 'user')

                    <li class="pc-item pc-caption">
                        <label>Master</label>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('Alat.index') }}" class="pc-link">
                            <i class="ti ti-tools"></i>
                            <span class="pc-mtext">Lihat Alat</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('Peminjaman.create') }}" class="pc-link">
                            <i class="ti ti-plus"></i>
                            <span class="pc-mtext">Ajukan Peminjaman</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="#" class="pc-link">
                            <i class="ti ti-history"></i>
                            <span class="pc-mtext">Riwayat</span>
                        </a>
                    </li>

                    @endif

                </ul>
                @endauth
            </div>
        </div>
    </nav>
    <!-- [ Sidebar Menu ] end -->
    <!-- [ Header Topbar ] start -->
    <header class="pc-header">
        <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <li class="pc-h-item pc-sidebar-collapse">
                        <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                            <i class="ph ph-list"></i>
                        </a>
                    </li>
                    <li class="pc-h-item pc-sidebar-popup">
                        <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                            <i class="ph ph-list"></i>
                        </a>
                    </li>
                    <li class="dropdown pc-h-item">
                        <a
                            class="pc-head-link dropdown-toggle arrow-none m-0 trig-drp-search"
                            data-bs-toggle="dropdown"
                            href="#"
                            role="button"
                            aria-haspopup="false"
                            aria-expanded="false">
                            <i class="ph ph-magnifying-glass"></i>
                        </a>
                        <div class="dropdown-menu pc-h-dropdown drp-search">
                            <form class="px-3 py-2">
                                <input type="search" class="form-control border-0 shadow-none" placeholder="Search here. . ." />
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- [Mobile Media Block end] -->
            <div class="ms-auto">
                <ul class="list-unstyled">
                    <li class="dropdown pc-h-item">
                        <a
                            class="pc-head-link dropdown-toggle arrow-none me-0"
                            data-bs-toggle="dropdown"
                            href="#"
                            role="button"
                            aria-haspopup="false"
                            aria-expanded="false">
                            <i class="ph ph-bell"></i>
                            <span class="badge bg-success pc-h-badge"></span>
                        </a>
                        <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-header d-flex align-items-center justify-content-between">
                                <h5 class="m-0">Notifications</h5>
                                <a href="#!" class="btn btn-link btn-sm">Mark all read</a>
                            </div>
                            <div class="text-center py-2">
                                <a href="#!" class="link-danger">Clear all Notifications</a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown pc-h-item header-user-profile">
                        <a
                            class="pc-head-link dropdown-toggle arrow-none me-0"
                            data-bs-toggle="dropdown"
                            href="#"
                            role="button"
                            aria-haspopup="false"
                            data-bs-auto-close="outside"
                            aria-expanded="false">
                            <i class="ph ph-user-circle"></i>
                        </a>
                        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown p-0 overflow-hidden">
                            <div class="dropdown-header d-flex align-items-center justify-content-between bg-primary">
                                <div class="d-flex my-2">
                                    <div class="flex-shrink-0">
                                        <img src="{{ Auth::check() && Auth::user()->avatar 
                                             ? asset('storage/' . Auth::user()->avatar) 
                                            : asset('storage/profile/default.png') }}"
                                            alt="user-image" class="user-avatar wid-35" />
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-white mb-1">{{ Auth::user()->name ?? '' }}</h6>
                                        <span class="text-white text-opacity-75">{{ Auth::user()->email ?? '' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-body">
                                <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 225px)">
                                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                        <span>
                                            <i class="ph ph-gear align-middle me-2"></i>
                                            <span>Settings</span>
                                        </span>
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary d-grid my-2">
                                            <i class="mdi mdi-logout me-2"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- [ Header ] end -->

    <div class="main-panel">
        <div class="content-wrapper">
            @yield('content')
        </div>
        <footer class="pc-footer">
            <div class="footer-wrapper container-fluid">
                <div class="row">
                    <div class="col my-1">
                        <p class="m-0">Datta able &#9829; crafted by Team <a href="https://codedthemes.com/" target="_blank">Codedthemes</a></p>
                    </div>
                    <div class="col-md-auto my-1">
                        <ul class="list-inline footer-link mb-0">
                            <li class="list-inline-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>


    <!-- [Page Specific JS] start -->
    <!-- apexcharts js -->
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/world.js') }}"></script>

    <script src="{{ asset('assets/js/dashboard/dashboard-default.js') }}"></script>
    <!-- [Page Specific JS] end -->
    <!-- Required Js -->
    <!-- <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script> -->
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script> -->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        layout_change('light');
    </script>

    <script>
        change_box_container('false');
    </script>

    <script>
        layout_caption_change('true');
    </script>

    <script>
        layout_rtl_change('false');
    </script>

    <script>
        preset_change('preset-1');
    </script>

    <script>
        layout_theme_sidebar_change('false');
    </script>


</body>
<!-- [Body] end -->

</html>