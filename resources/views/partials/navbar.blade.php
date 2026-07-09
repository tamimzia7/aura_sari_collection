<nav class="aura-navbar navbar navbar-expand-lg fixed-top" id="mainNavbar">
    <div class="container">
        <a class="aura-navbar-brand navbar-brand" href="{{ route('home') }}">
            AURA
        </a>

        <button class="navbar-toggler aura-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 aura-nav-links">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('collection*') ? 'active' : '' }}" href="{{ route('collection') }}">Collections</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about*') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3 aura-nav-icons">
                <a href="{{ route('products.search') }}" class="nav-icon position-relative text-decoration-none" data-bs-toggle="tooltip" title="Search">
                    <i class="fas fa-search"></i>
                </a>

                <a href="{{ route('wishlist') }}" class="nav-icon position-relative text-decoration-none" data-bs-toggle="tooltip" title="Wishlist">
                    <i class="far fa-heart"></i>
                    @auth
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill aura-badge wishlist-count" id="wishlistCount">
                            {{ Auth::user()->wishlist()->count() }}
                        </span>
                    @endauth
                </a>

                <a href="{{ route('cart') }}" class="nav-icon position-relative text-decoration-none" data-bs-toggle="tooltip" title="Cart">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill aura-badge cart-count" id="cartCount">
                        {{ session('cart_count', session()->has('cart') ? count(session('cart')) : 0) }}
                    </span>
                </a>

                @auth
                    <div class="dropdown">
                        <button class="btn btn-link text-decoration-none p-0 dropdown-toggle aura-user-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="far fa-user-circle"></i>
                            <span class="d-none d-md-inline ms-1">{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end aura-dropdown">
                            <li><a class="dropdown-item" href="{{ route('dashboard.index') }}"><i class="fas fa-columns me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard.orders') }}"><i class="fas fa-box me-2"></i>Orders</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard.wishlist') }}"><i class="far fa-heart me-2"></i>Wishlist</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard.profile') }}"><i class="far fa-user me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider aura-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="d-flex gap-2">
                        <a href="{{ route('login') }}" class="aura-btn-outline">Login</a>
                        <a href="{{ route('register') }}" class="aura-btn-primary">Register</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

@push('styles')
<style>
/* ─── AURA NAVBAR ─── */
.aura-navbar {
    background: rgba(10, 10, 26, 0.95);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(212, 175, 55, 0.08);
    padding: 0.75rem 0;
    transition: all 0.3s ease;
    min-height: 60px;
}

.aura-navbar-brand {
    font-family: 'Playfair Display', serif;
    font-size: 1.6rem;
    font-weight: 700;
    letter-spacing: 0.3em;
    background: linear-gradient(135deg, #d4af37, #f0d68a, #d4af37);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.aura-navbar .nav-link {
    color: rgba(255, 255, 255, 0.65) !important;
    font-size: 0.8rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    font-weight: 500;
    padding: 0.5rem 1rem !important;
    transition: color 0.3s ease;
    position: relative;
}

.aura-navbar .nav-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 1rem;
    right: 1rem;
    height: 1px;
    background: #d4af37;
    transform: scaleX(0);
    transition: transform 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.aura-navbar .nav-link:hover,
.aura-navbar .nav-link.active {
    color: #d4af37 !important;
}

.aura-navbar .nav-link:hover::after,
.aura-navbar .nav-link.active::after {
    transform: scaleX(1);
}

.aura-nav-icons .nav-icon {
    color: rgba(255, 255, 255, 0.7);
    font-size: 1.1rem;
    transition: color 0.3s, transform 0.3s;
    position: relative;
}

.aura-nav-icons .nav-icon:hover {
    color: #d4af37;
    transform: scale(1.1);
}

.aura-badge {
    background: #d4af37;
    color: #0a0a1a;
    font-size: 0.6rem;
    font-weight: 700;
    min-width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.aura-user-btn {
    color: rgba(255, 255, 255, 0.7) !important;
    font-size: 0.9rem;
    transition: color 0.3s;
}

.aura-user-btn:hover {
    color: #d4af37 !important;
}

.aura-btn-outline {
    padding: 0.4rem 1.25rem;
    border: 1px solid rgba(212, 175, 55, 0.3);
    border-radius: 50px;
    color: #d4af37;
    font-size: 0.78rem;
    font-weight: 500;
    letter-spacing: 0.05em;
    text-decoration: none;
    transition: all 0.3s ease;
}

.aura-btn-outline:hover {
    border-color: #d4af37;
    background: rgba(212, 175, 55, 0.1);
    color: #d4af37;
}

.aura-btn-primary {
    padding: 0.4rem 1.25rem;
    background: linear-gradient(135deg, #d4af37, #c9a032);
    border: none;
    border-radius: 50px;
    color: #0a0a1a;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.05em;
    text-decoration: none;
    transition: all 0.3s ease;
}

.aura-btn-primary:hover {
    background: linear-gradient(135deg, #e0c04a, #d4af37);
    color: #0a0a1a;
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
}

.aura-dropdown {
    background: #0a0a1a;
    border: 1px solid rgba(212, 175, 55, 0.15);
    border-radius: 12px;
    padding: 0.5rem;
    min-width: 200px;
    margin-top: 0.5rem;
}

.aura-dropdown .dropdown-item {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.85rem;
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    transition: all 0.2s;
}

.aura-dropdown .dropdown-item:hover {
    background: rgba(212, 175, 55, 0.1);
    color: #d4af37;
}

.aura-divider {
    border-top-color: rgba(212, 175, 55, 0.15);
    margin: 0.25rem 0;
}

.aura-toggler {
    padding: 0.25rem;
}

.aura-toggler .navbar-toggler-icon {
    background-image: none;
    position: relative;
    width: 24px;
    height: 18px;
}

.aura-toggler .navbar-toggler-icon::before,
.aura-toggler .navbar-toggler-icon::after,
.aura-toggler .navbar-toggler-icon span {
    content: '';
    position: absolute;
    left: 0;
    width: 100%;
    height: 2px;
    background: #d4af37;
    border-radius: 2px;
    transition: all 0.3s;
}

.aura-toggler .navbar-toggler-icon::before { top: 0; }
.aura-toggler .navbar-toggler-icon span { top: 50%; transform: translateY(-50%); display: block; }
.aura-toggler .navbar-toggler-icon::after { bottom: 0; }

@media (max-width: 991.98px) {
    .aura-navbar {
        padding: 0.5rem 0;
    }

    .aura-nav-links {
        padding: 1rem 0;
    }

    .aura-nav-links .nav-link {
        padding: 0.75rem 0 !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .aura-nav-links .nav-link::after {
        display: none;
    }

    .aura-nav-icons {
        padding: 1rem 0;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        justify-content: center;
    }

    .navbar-collapse {
        background: rgba(10, 10, 26, 0.98);
        border-radius: 0 0 16px 16px;
        padding: 0 1rem 1rem;
    }
}
</style>
@endpush
