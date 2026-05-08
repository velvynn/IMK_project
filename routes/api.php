<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\AuthController;

// ==================== AUTHENTICATION ====================
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/logout', [AuthController::class, 'logout']);
Route::get('/auth/check', [AuthController::class, 'checkSession']);

// ==================== PRODUCTS ====================
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/slug/{slug}', [ProductController::class, 'showBySlug']);
Route::get('/products/category/{category}', [ProductController::class, 'byCategory']);
Route::get('/products/flash-sale', [ProductController::class, 'flashSale']);
Route::get('/products/search', [ProductController::class, 'search']);

// ==================== CART ====================
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart', [CartController::class, 'store']);
Route::put('/cart/{id}', [CartController::class, 'update']);
Route::delete('/cart/{id}', [CartController::class, 'destroy']);

// ==================== ORDERS ====================
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::post('/orders', [OrderController::class, 'store']);

// ==================== VOUCHERS ====================
Route::get('/vouchers', [VoucherController::class, 'index']);
Route::post('/vouchers/validate', [VoucherController::class, 'validateVoucher']);