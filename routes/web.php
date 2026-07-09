<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CollectionController as AdminCollectionController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Collection/Products
Route::get('/collection', [ProductController::class, 'index'])->name('products.index');
Route::get('/collections/{slug}', [ProductController::class, 'collection'])->name('products.collection');
Route::get('/shop', [ProductController::class, 'index'])->name('collection');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/quick-view/{id}', [ProductController::class, 'quickView'])->name('products.quick-view');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::prefix('cart')->name('cart.')->group(function () {
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
    Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('apply-coupon');
    Route::get('/count', [CartController::class, 'getCount'])->name('count');
});

// Wishlist (authenticated)
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
Route::prefix('wishlist')->name('wishlist.')->group(function () {
    Route::post('/toggle', [WishlistController::class, 'add'])->name('toggle');
    Route::post('/remove', [WishlistController::class, 'remove'])->name('remove');
    Route::post('/move-to-cart', [WishlistController::class, 'moveToCart'])->name('move-to-cart');
});

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::view('/forgot-password', 'auth.passwords.email')->name('password.request');
});

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout');

// Static pages
Route::view('/contact', 'static.contact')->name('contact');
Route::view('/faq', 'static.faq')->name('faq');
Route::view('/shipping', 'static.shipping')->name('shipping');
Route::view('/returns', 'static.returns')->name('returns');
Route::view('/size-guide', 'static.size-guide')->name('size-guide');
Route::view('/privacy', 'static.privacy')->name('privacy');
Route::view('/terms', 'static.terms')->name('terms');
Route::view('/sitemap', 'static.sitemap')->name('sitemap');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{id}/track', [OrderController::class, 'track'])->name('orders.track');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Dashboard
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/orders', [DashboardController::class, 'orders'])->name('orders');
        Route::get('/orders/{id}', [DashboardController::class, 'orderDetails'])->name('order-details');
        Route::get('/addresses', [DashboardController::class, 'addresses'])->name('addresses');
        Route::post('/addresses', [DashboardController::class, 'storeAddress'])->name('addresses.store');
        Route::match(['patch', 'put'], '/addresses/{id}', [DashboardController::class, 'updateAddress'])->name('addresses.update');
        Route::delete('/addresses/{id}', [DashboardController::class, 'destroyAddress'])->name('addresses.destroy');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
        Route::put('/password', [DashboardController::class, 'updatePassword'])->name('password.update');
        Route::get('/wishlist', [DashboardController::class, 'wishlist'])->name('wishlist');
    });
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', AdminProductController::class);

    // Categories
    Route::resource('categories', AdminCategoryController::class);

    // Brands
    Route::resource('brands', AdminBrandController::class);

    // Collections
    Route::resource('collections', AdminCollectionController::class);

    // Banners
    Route::resource('banners', AdminBannerController::class);

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');

    // Customers
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');

    // Coupons
    Route::resource('coupons', AdminCouponController::class);

    // Reviews
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::patch('/reviews/{id}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::delete('/reviews/{id}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

    // Settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // Users
    Route::resource('users', AdminUserController::class);
});

// Fallback: alias collection route as an additional name
// Route::redirect('/', '/collection')...
