<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\VendorDashboardController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
    // এখানে ভেন্ডরের অন্যান্য রাউট (যেমন: product management) যোগ হবে
});