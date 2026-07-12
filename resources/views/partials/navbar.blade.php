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
                    <a class="nav-link {{ request()->routeIs('home') ? '' : '' }}" href="{{ request()->routeIs('home') ? '#collection' : route('home') . '#collection' }}">Collection</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ request()->routeIs('home') ? '#new' : route('home') . '#new' }}">New</a>
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
                            {{ Auth::user()->wishlists()->count() }}
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
                    <div class="dropdown" id="customerNotifWrapper">
                        <button class="nav-icon position-relative text-decoration-none btn btn-link p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="customerNotifBell" title="Notifications" style="background:none;color:rgba(255,255,255,0.7);font-size:1.1rem;">
                            <i class="far fa-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill aura-badge notif-count" id="customerNotifBadge" style="display:none;font-size:0.55rem;min-width:16px;height:16px;">0</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end aura-dropdown" style="width:340px;padding:0;border-radius:12px;" id="customerNotifDropdown">
                            <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom border-secondary border-opacity-10">
                                <span class="fw-semibold small" style="color:#d4af37;">Notifications</span>
                                <span class="small text-muted" id="customerNotifCount">0 new</span>
                            </div>
                            <div style="max-height:300px;overflow-y:auto;" id="customerNotifList">
                                <div class="text-center py-4 text-muted small">
                                    <i class="far fa-bell fa-lg mb-2"></i>
                                    <p class="mb-0">Loading...</p>
                                </div>
                            </div>
                            <div class="border-top border-secondary border-opacity-10 p-2 d-flex justify-content-between">
                                <button class="btn btn-sm btn-link text-decoration-none p-1" onclick="customerMarkAllRead()" style="font-size:11px;color:rgba(255,255,255,0.6);">
                                    <i class="fas fa-check-double me-1"></i>Mark All Read
                                </button>
                            </div>
                        </div>
                    </div>

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
                            @if(Auth::user()->isAdmin())
                                <li><hr class="dropdown-divider aura-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}" style="color:#d4af37;"><i class="fas fa-shield-alt me-2"></i>Admin Panel</a></li>
                            @endif
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
    transform: scale(1.15);
}
.aura-nav-icons .nav-icon i.fa-shopping-bag {
    font-size: 50px;
    line-height: 1;
    background: linear-gradient(135deg, #D4AF37, #F7E7A1);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    filter: drop-shadow(0 0 8px rgba(212,175,55,0.3));
    transition: filter 0.3s ease;
}
.aura-nav-icons .nav-icon:hover i.fa-shopping-bag {
    filter: drop-shadow(0 0 14px rgba(212,175,55,0.6));
}
.aura-nav-icons .nav-icon .cart-count {
    top: 8px;
    right: -8px;
    left: auto;
    transform: none;
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

#customerNotifDropdown .dropdown-item:hover {
    background: rgba(212, 175, 55, 0.05) !important;
}
#customerNotifDropdown::-webkit-scrollbar { width: 4px; }
#customerNotifDropdown::-webkit-scrollbar-thumb { background: #333; border-radius: 2px; }

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

@push('scripts')
<script>
    let customerLastNotifId = 0;
    let customerNotifSoundEnabled = {{ \App\Models\Setting::where('key', 'customer_notification_sound')->value('value') !== 'disabled' ? 'true' : 'false' }};

    function customerFetchNotifications() {
        const userId = {{ Auth::id() ?? 0 }};
        if (!userId) return;

        $.get('{{ route("notifications.fetch") }}', function(data) {
            const badge = document.getElementById('customerNotifBadge');
            const list = document.getElementById('customerNotifList');
            const countSpan = document.getElementById('customerNotifCount');

            if (data.unread_count > 0) {
                badge.style.display = '';
                badge.textContent = data.unread_count;
            } else {
                badge.style.display = 'none';
            }

            countSpan.textContent = data.unread_count + ' new';

            let html = '';
            if (data.notifications.length === 0) {
                html = '<div class="text-center py-4 text-muted small"><i class="far fa-bell fa-lg mb-2"></i><p class="mb-0">No new notifications</p></div>';
            } else {
                const n = data.notifications[0];
                const isNew = n.id > customerLastNotifId && !n.is_read;
                const icon = n.title.includes('Delivered') ? 'fa-check-circle' :
                             n.title.includes('Shipped') ? 'fa-truck' :
                             n.title.includes('Confirmed') ? 'fa-check' :
                             n.title.includes('Processing') ? 'fa-spinner' :
                             n.title.includes('Cancelled') ? 'fa-times-circle' :
                             n.title.includes('Verified') || n.title.includes('Paid') ? 'fa-money-bill-wave' : 'fa-bell';

                 const orderLink = n.order_id ? '{{ url("/orders") }}/' + n.order_id : '#';
                 html += '<a class="dropdown-item d-flex align-items-start gap-3 px-3 py-2 ' + (!n.is_read ? 'bg-dark bg-opacity-25' : '') + '" href="' + orderLink + '" style="border-bottom:1px solid rgba(255,255,255,0.05);">';
                html += '<div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:32px;height:32px;background:' + (!n.is_read ? 'rgba(212,175,55,0.15)' : 'rgba(255,255,255,0.05)') + ';">';
                html += '<i class="fas ' + icon + '" style="font-size:12px;color:' + (!n.is_read ? '#d4af37' : 'rgba(255,255,255,0.4)') + ';"></i></div>';
                html += '<div class="flex-grow-1 min-width-0"><div class="fw-semibold" style="font-size:12px;color:' + (!n.is_read ? '#fff' : 'rgba(255,255,255,0.6)') + ';">' + n.title + '</div>';
                html += '<div style="font-size:11px;color:rgba(255,255,255,0.4);white-space:normal;">' + (n.message || '') + '</div>';
                html += '<div style="font-size:10px;color:rgba(255,255,255,0.3);">' + customerTimeAgo(n.created_at) + '</div></div>';
                if (isNew) {
                    html += '<span class="badge rounded-pill" style="background:#d4af37;color:#0a0a1a;font-size:8px;">NEW</span>';
                }
                html += '</a>';

                html += '<a href="{{ route("notifications.index") }}" class="dropdown-item text-center py-2" style="font-size:11px;color:#d4af37;border-bottom:none;">View All Notifications <i class="fas fa-arrow-right ms-1"></i></a>';

                if (isNew && customerNotifSoundEnabled) {
                    playCustomerNotifSound();
                    showCustomerToast(n);
                }
            }
            list.innerHTML = html;
            if (data.latest_id > customerLastNotifId) {
                customerLastNotifId = data.latest_id;
            }
        });
    }

    function customerMarkAllRead() {
        $.post('{{ route("notifications.read-all") }}', {
            _token: '{{ csrf_token() }}'
        }, function() {
            document.getElementById('customerNotifBadge').style.display = 'none';
            document.getElementById('customerNotifCount').textContent = '0 new';
            document.querySelectorAll('#customerNotifList a').forEach(function(item) {
                item.classList.remove('bg-dark', 'bg-opacity-25');
            });
        });
    }

    function showCustomerToast(notification) {
        const container = document.getElementById('customerToastContainer') || (function() {
            const el = document.createElement('div');
            el.id = 'customerToastContainer';
            el.style.cssText = 'position:fixed;bottom:20px;right:20px;z-index:9999;display:flex;flex-direction:column-reverse;gap:8px;max-width:380px;';
            document.body.appendChild(el);
            return el;
        })();

        const toast = document.createElement('div');
        const isPositive = !notification.title.includes('Cancelled');
        const borderColor = notification.title.includes('Cancelled') ? '#dc3545' : (notification.title.includes('Delivered') || notification.title.includes('Verified') || notification.title.includes('Paid') ? '#198754' : '#d4af37');
        const bgIcon = notification.title.includes('Delivered') ? 'fa-check-circle' :
                        notification.title.includes('Shipped') ? 'fa-truck' :
                        notification.title.includes('Confirmed') ? 'fa-check' :
                        notification.title.includes('Cancelled') ? 'fa-times-circle' :
                        notification.title.includes('Verified') || notification.title.includes('Paid') ? 'fa-money-bill-wave' : 'fa-bell';

        toast.style.cssText = 'background:#1a1a2e;color:#fff;border-radius:12px;padding:16px 20px;box-shadow:0 8px 30px rgba(0,0,0,0.3);border-left:4px solid ' + borderColor + ';animation:slideUp 0.3s ease;display:flex;align-items:flex-start;gap:12px;';
        toast.innerHTML = '<div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:36px;height:36px;background:rgba(212,175,55,0.15);"><i class="fas ' + bgIcon + '" style="color:#d4af37;font-size:16px;"></i></div><div class="flex-grow-1"><div class="fw-bold small" style="color:#d4af37;">' + notification.title + '</div><div style="font-size:12px;color:rgba(255,255,255,0.6);">' + (notification.message || '') + '</div></div><button onclick="this.parentElement.remove()" style="background:none;border:none;color:rgba(255,255,255,0.3);cursor:pointer;font-size:16px;padding:0;">&times;</button>';
        container.appendChild(toast);

        setTimeout(function() {
            toast.style.transition = 'all 0.3s ease';
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
            setTimeout(function() { toast.remove(); }, 300);
        }, 1000);
    }

    function playCustomerNotifSound() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.type = 'sine';
            osc.frequency.setValueAtTime(523, ctx.currentTime);
            osc.frequency.setValueAtTime(659, ctx.currentTime + 0.1);
            osc.frequency.setValueAtTime(784, ctx.currentTime + 0.2);
            gain.gain.setValueAtTime(0.2, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.4);
            osc.start();
            osc.stop(ctx.currentTime + 0.4);
        } catch(e) {}
    }

    function customerTimeAgo(dateStr) {
        const now = new Date();
        const date = new Date(dateStr);
        const seconds = Math.floor((now - date) / 1000);
        if (seconds < 60) return 'just now';
        const minutes = Math.floor(seconds / 60);
        if (minutes < 60) return minutes + 'm ago';
        const hours = Math.floor(minutes / 60);
        if (hours < 24) return hours + 'h ago';
        const days = Math.floor(hours / 24);
        return days + 'd ago';
    }

    // Add keyframe animation for toast
    (function() {
        const s = document.createElement('style');
        s.textContent = '@keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }';
        document.head.appendChild(s);
    })();

    $(document).ready(function() {
        customerFetchNotifications();
        setInterval(customerFetchNotifications, 15000);
    });
</script>
@endpush
