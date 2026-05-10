<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API ROUTES
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// ==================== AUTHENTICATION ====================
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/logout', [AuthController::class, 'logout']);
Route::get('/auth/check', [AuthController::class, 'checkSession']);
Route::post('/auth/update-profile', [AuthController::class, 'updateProfile']);
Route::post('/auth/change-password', [AuthController::class, 'changePassword']);
Route::get('/auth/address', [AuthController::class, 'getUserAddress']);
Route::post('/auth/address', [AuthController::class, 'saveUserAddress']);

// ==================== PRODUCTS ====================
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/slug/{slug}', [ProductController::class, 'showBySlugApi']);
Route::get('/products/category/{category}', [ProductController::class, 'byCategory']);
Route::get('/products/flash-sale', [ProductController::class, 'flashSale']);
Route::get('/products/search', [ProductController::class, 'search']);
Route::get('/brands', [ProductController::class, 'getBrands']);

// ==================== CART ====================
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart', [CartController::class, 'store']);
Route::put('/cart/{id}', [CartController::class, 'update']);
Route::delete('/cart/{id}', [CartController::class, 'destroy']);
Route::delete('/cart', [CartController::class, 'clear']);
Route::post('/cart/sync', [CartController::class, 'sync']);

// ==================== ORDERS ====================
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::get('/orders/number/{orderNumber}', [OrderController::class, 'showByNumber']);
Route::post('/orders', [OrderController::class, 'store']);
Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel']);
Route::post('/orders/{id}/confirm-payment', [OrderController::class, 'confirmPayment']);

// ==================== VOUCHERS ====================
Route::get('/vouchers', [VoucherController::class, 'index']);
Route::post('/vouchers/validate', [VoucherController::class, 'validateVoucher']);

// ==================== CHAT API ROUTES ====================
Route::get('/chat/{id}', [ChatController::class, 'getChat']);
Route::post('/chat/{id}/send', [ChatController::class, 'sendMessage']);
Route::post('/chat/{id}/pin', [ChatController::class, 'togglePin']);
Route::post('/chat/{id}/archive', [ChatController::class, 'archive']);
Route::delete('/chat/{id}', [ChatController::class, 'destroy']);
Route::get('/chat/unread-count', [ChatController::class, 'getUnreadCount']);

// ==================== NOTIFICATION API ROUTES ====================
Route::get('/notifications', [NotificationController::class, 'index']);
Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount']);
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);
Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);