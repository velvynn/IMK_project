<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\ChatController; // TAMBAHKAN INI

// ==================== ADMIN CONTROLLERS ====================
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\VoucherController as AdminVoucherController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ChatController as AdminChatController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| USER PAGE ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/kategori/{slug?}', [PageController::class, 'kategori'])->name('kategori');
Route::get('/product/{slug}', [PageController::class, 'productDetail'])->name('product.detail');
Route::get('/product-detail.html', [PageController::class, 'productDetailById'])->name('product.detail.byid');
Route::get('/cart', [PageController::class, 'cart'])->name('cart');
Route::get('/cart.html', [PageController::class, 'cart'])->name('cart.html');
Route::get('/checkout', [PageController::class, 'checkout'])->name('checkout');
Route::get('/checkout.html', [PageController::class, 'checkout'])->name('checkout.html');
Route::get('/order-success', [PageController::class, 'orderSuccess'])->name('order.success');
Route::get('/order-success.html', [PageController::class, 'orderSuccess'])->name('order.success.html');
Route::get('/order-detail', [PageController::class, 'orderDetail'])->name('order.detail');
Route::get('/order-detail.html', [PageController::class, 'orderDetail'])->name('order.detail.html');
Route::get('/order-detail/{id}', [PageController::class, 'orderDetail'])->name('order.detail.withid');
Route::get('/profile', [PageController::class, 'profile'])->name('profile');
Route::get('/profile.html', [PageController::class, 'profile'])->name('profile.html');
Route::get('/deals', [PageController::class, 'deals'])->name('deals');
Route::get('/deals.html', [PageController::class, 'deals'])->name('deals.html');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/about.html', [PageController::class, 'about'])->name('about.html');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/contact.html', [PageController::class, 'contact'])->name('contact.html');
Route::get('/shop', [PageController::class, 'shop'])->name('shop');
Route::get('/shop.html', [PageController::class, 'shop'])->name('shop.html');
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::get('/login.html', [PageController::class, 'login'])->name('login.html');
Route::get('/register', [PageController::class, 'register'])->name('register');
Route::get('/register.html', [PageController::class, 'register'])->name('register.html');

// ==================== CHAT ROUTES ====================
Route::get('/chat', [ChatController::class, 'index'])->name('chat');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| API ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('api')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/check', [AuthController::class, 'checkSession']);
    Route::post('/auth/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/auth/change-password', [AuthController::class, 'changePassword']);
    Route::get('/auth/address', [AuthController::class, 'getUserAddress']);
    Route::post('/auth/address', [AuthController::class, 'saveUserAddress']);
    
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::get('/products/slug/{slug}', [ProductController::class, 'showBySlug']);
    Route::get('/products/category/{slug}', [ProductController::class, 'byCategory']);
    Route::get('/products/flash-sale', [ProductController::class, 'flashSale']);
    Route::get('/products/search', [ProductController::class, 'search']);
    Route::get('/brands', [ProductController::class, 'getBrands']);
    
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::put('/cart/{id}', [CartController::class, 'update']);
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);
    Route::delete('/cart', [CartController::class, 'clear']);
    Route::post('/cart/sync', [CartController::class, 'sync']);
    
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::get('/orders/number/{orderNumber}', [OrderController::class, 'showByNumber']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel']);
    Route::post('/orders/{id}/confirm-payment', [OrderController::class, 'confirmPayment']);
    
    Route::get('/vouchers', [VoucherController::class, 'index']);
    Route::post('/vouchers/validate', [VoucherController::class, 'validateVoucher']);
    
    // ==================== CHAT API ROUTES ====================
    Route::get('/chat/{id}', [ChatController::class, 'getChat']);
    Route::post('/chat/{id}/send', [ChatController::class, 'sendMessage']);
    Route::post('/chat/{id}/pin', [ChatController::class, 'togglePin']);
    Route::post('/chat/{id}/archive', [ChatController::class, 'archive']);
    Route::delete('/chat/{id}', [ChatController::class, 'destroy']);
    Route::get('/chat/unread-count', [ChatController::class, 'getUnreadCount']);
});