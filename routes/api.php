<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PurchaseOrderController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/profile', [AuthController::class, 'profile']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('/location', LocationController::class);
    Route::resource('/asset', AssetController::class);
    Route::resource('/maintenance', MaintenanceController::class);
    Route::resource('/transaction', TransactionController::class);
    Route::resource('/supplier', SupplierController::class);
    Route::resource('/purchase-order', PurchaseOrderController::class);
    Route::resource('/documents', DocumentController::class);
});