<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KaryawanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('produk', ProdukController::class);
        Route::resource('karyawan', KaryawanController::class);

        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');
    });

    Route::middleware(['role:admin,karyawan'])->group(function () {
        Route::resource('penjualan', PenjualanController::class);
        Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');
        Route::post('/penjualan/store', [PenjualanController::class, 'store'])->name('penjualan.store');
        Route::get('/kasir', [PenjualanController::class, 'kasir'])->name('kasir.index');
        Route::post('/kasir', [PenjualanController::class, 'store'])->name('kasir.store');
        Route::get('/kasir-row', function () {
            $produk = \App\Models\Produk::all();
            return view('kasir.partials.row', compact('produk'))->render();
        });
    });

    Route::middleware(['role:pelanggan'])->group(function () {

        Route::get('/pelanggan/home', [PelangganController::class, 'home'])
            ->middleware('role:pelanggan')
            ->name('pelanggan.home');


        Route::get('/pelanggan/produk', [PelangganController::class, 'produkIndex'])
            ->name('pelanggan.produk.index');

        Route::get('/pelanggan/produk/{id}', [PelangganController::class, 'show'])
            ->name('pelanggan.produk.show');


        Route::get('/pelanggan/riwayat', [RiwayatController::class, 'index'])->name('pelanggan.riwayat');
        Route::get('/pelanggan/riwayat/{id}', [RiwayatController::class, 'show'])->name('pelanggan.riwayat.show');
    });

});


require __DIR__.'/auth.php';
