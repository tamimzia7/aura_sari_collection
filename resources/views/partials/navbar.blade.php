<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top" id="mainNavbar">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <span class="brand-text">AURA</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('collection*') ? 'active' : '' }}" href="{{ route('collection') }}">The Canvas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about*') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                </li>
            </ul>

            <div class="d-none d-lg-block mx-3" style="min-width: 200px;">
                <form class="position-relative" action="{{ route('products.search') }}" method="GET" id="searchForm">
                    <input class="form-control form-control-sm search-input" type="search" name="q" placeholder="Search sarees..." aria-label="Search" id="searchInput" autocomplete="off">
                    <button class="btn btn-link position-absolute top-50 end-0 translate-middle-y text-muted p-1 me-2" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                    <div class="search-results dropdown-menu w-100" id="searchResults" style="display: none;"></div>
                </form>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('wishlist') }}" class="nav-icon position-relative text-dark text-decoration-none" data-bs-toggle="tooltip" title="Wishlist">
                    <i class="far fa-heart"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger wishlist-count" id="wishlistCount">
                        {{-- {{ Cart::instance('wishlist')->count() }} --}}0
                    </span>
                </a>

                <a href="{{ route('cart') }}" class="nav-icon position-relative text-dark text-decoration-none" data-bs-toggle="tooltip" title="Cart">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark cart-count" id="cartCount">
                        {{-- {{ Cart::instance('default')->count() }} --}}0
                    </span>
                </a>

                @auth
                    <div class="dropdown">
                        <button class="btn btn-link text-dark dropdown-toggle text-decoration-none p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="far fa-user"></i>
                            <span class="d-none d-md-inline ms-1">{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('dashboard.index') }}"><i class="fas fa-columns me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard.orders') }}"><i class="fas fa-box me-2"></i>Orders</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard.wishlist') }}"><i class="far fa-heart me-2"></i>Wishlist</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard.profile') }}"><i class="far fa-user me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-dark btn-sm rounded-pill px-3 d-none d-md-block">Register</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<div class="d-lg-none bg-light py-2">
    <div class="container">
        <form class="position-relative" action="{{ route('products.search') }}" method="GET">
            <input class="form-control form-control-sm search-input" type="search" name="q" placeholder="Search sarees..." aria-label="Search" autocomplete="off">
            <button class="btn btn-link position-absolute top-50 end-0 translate-middle-y text-muted p-1 me-2" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>
