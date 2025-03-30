<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PurchaseOrderController;


// Handle OPTIONS requests for CORS preflight
// Route::options('/{any}', function () {
//     return response()->noContent()
//         ->header('Access-Control-Allow-Origin', '*')
//         ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
//         ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
// })->where('any', '.*');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/profiles', [AuthController::class, 'profile']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('/locations', LocationController::class);
    Route::resource('/assets', AssetController::class);
    Route::resource('/maintenances', MaintenanceController::class);
    Route::resource('/transactions', TransactionController::class);
    Route::resource('/suppliers', SupplierController::class);
    Route::resource('/purchase-orders', PurchaseOrderController::class);
    Route::resource('/documents', DocumentController::class);
    Route::resource('/users', UserController::class);
});