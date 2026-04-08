<!-- Start Header Area -->
<header class="header shop">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-12">
                    <!-- Top Left -->
                    <div class="top-left">
                        <ul class="list-main">
                            <!-- <li><i class="ti-headphone-alt"></i> +62 895-3524-58583</li>
                            <li><i class="ti-email"></i> support@gmail.com</li> -->
                        </ul>
                    </div>
                    <!--/ End Top Left -->
                </div>
                <div class="col-lg-8 col-md-12 col-12">
                    <!-- Top Right -->
                    <div class="right-content">
                        <ul class="list-main">
                            @auth
                            <li><i class="ti-user"></i>
                                <a href="{{ route('auth.profile')}}">{{ Auth::user()->name ?? '' }}</a>
                            </li>
                            <li><i class="ti-power-off"></i>
                                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;">
                                        Logout
                                    </button>
                                </form>
                            </li>
                            @endauth

                            @guest
                            <li><i class="ti-user"></i>
                                <a href="#">Konserin</a>
                            </li>
                            <li><i class="ti-power-off"></i>
                                <a href="{{ route('login') }}">Login</a>
                            </li>
                            @endguest

                        </ul>
                    </div>
                    <!-- End Top Right -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->
    <div class="middle-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-12">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="{{ route('welcome') }}"><img src="{{ asset('assets/images/konserin.PNG') }}" alt="Logo"></a>
                    </div>
                    <!--/ End Logo -->
                    <!-- Search Form -->
                    <div class="search-top">
                        <div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
                        <!-- Search Form -->
                        <div class="search-top">
                            <form class="search-form">
                                <input type="text" placeholder="Search here..." name="search">
                                <button value="search" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                        <!--/ End Search Form -->
                    </div>
                    <!--/ End Search Form -->
                    <div class="mobile-nav"></div>
                </div>
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="search-bar-top">
                        <div class="search-bar">
                            <form>
                                <input name="search" placeholder="Search Products Here....." type="search">
                                <button class="btnn"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="right-bar">
                        <!-- Shopping Cart Icon -->
                        <div class="sinlge-bar shopping">
                            @php
                            $cartItems = collect($cartItems);
                            $totalCartItems = $cartItems->count(); // jumlah baris cart
                            $totalSubtotal = $cartItems->sum(fn($item) => $item->harga * $item->quantity);
                            @endphp


                            <a href="javascript:void(0)" class="single-icon">
                                <i class="ti-bag"></i>
                                <span class="total-count">{{ $totalCartItems }}</span>
                            </a>

                            <!-- Shopping Item Dropdown -->
                            <div class="shopping-item">
                                <div class="dropdown-cart-header">
                                    <span>{{ $totalCartItems }} Items</span>
                                    <a href="{{ route('cart.index') }}">View Cart</a>
                                </div>

                                <ul class="shopping-list">
                                    @foreach($cartItems as $item)
                                    @php
                                    $photos = !empty($item->photo) ? (is_array($item->photo) ? $item->photo : json_decode($item->photo, true)) : [];
                                    $img = !empty($photos) ? asset('storage/'.$photos[0]) : asset('assets/images/no-image.png');
                                    @endphp
                                    <li>
                                        <a href="{{ route('cart.remove', $item->barang_id) }}" class="remove" title="Remove this item">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <a class="cart-img" href="{{ route('detail', $item->barang_id) }}">
                                            <img src="{{ $img }}" alt="{{ $item->nama_barang }}">
                                        </a>
                                        <h4>
                                            <a href="{{ route('detail', $item->barang_id) }}">{{ $item->nama_barang }}</a>
                                        </h4>
                                        <p class="quantity">
                                            {{ $item->quantity }}x -
                                            <span class="amount">Rp{{ number_format($item->harga, 0, ',', '.') }}</span>
                                        </p>
                                    </li>
                                    @endforeach
                                </ul>

                                <div class="bottom">
                                    <div class="total">
                                        <span>Total</span>
                                        <span class="total-amount">Rp{{ number_format($totalSubtotal, 0, ',', '.') }}</span>
                                    </div>
                                    <a href="{{ route('cart.index') }}" class="btn animate">Checkout</a>
                                </div>
                            </div>
                            <!-- /Shopping Item Dropdown -->
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-9 col-12">
                        <div class="menu-area">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">
                                    <div class="nav-inner">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li><a href="{{ route('welcome') }}">Home</a></li>
                                            <li><a href="{{ route('about') }}">About Us</a></li>
                                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                            <li><a href="{{ route('tiket.index') }}">Tiket Saya</a></li>

                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!--/ End Main Menu -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>
<!-- End Header Area -->