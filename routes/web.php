<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'karyawan' => redirect()->route('kasir.index'),
        'pelanggan' => redirect()->route('pelanggan.home'),
        default => redirect('/'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('produk', ProdukController::class);
        Route::resource('user', UserController::class);

        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');
    });

    Route::middleware(['role:admin,karyawan'])->group(function () {
        Route::resource('penjualan', PenjualanController::class);
    });

    Route::middleware(['auth', 'role:karyawan'])->group(function () {
        Route::get('/kasir', [PenjualanController::class, 'kasir'])->name('kasir.index');
        Route::post('/kasir', [PenjualanController::class, 'store'])->name('kasir.store');
        Route::get('/kasir-row', function () {
            $produk = \App\Models\Produk::all();
            return view('kasir.partials.row', compact('produk'))->render();
        });
        Route::post('/kasir/konfirmasi/{id}', [PenjualanController::class, 'konfirmasiPesanan'])->name('kasir.konfirmasi');
        // ... route store pos lainnya
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

        Route::get('/pelanggan/cart', [CartController::class, 'index'])
         ->name('pelanggan.cart.index');

        Route::post('/pelanggan/cart/add', [CartController::class, 'add'])
            ->name('pelanggan.cart.add');

        Route::post('/pelanggan/cart/update', [CartController::class, 'update'])
            ->name('pelanggan.cart.update');

        Route::post('/pelanggan/cart/delete', [CartController::class, 'delete'])
            ->name('pelanggan.cart.delete');

        Route::get('/pelanggan/checkout', [CartController::class, 'checkoutPage'])
         ->name('pelanggan.checkout');

        Route::post('/pelanggan/checkout', [CartController::class, 'checkoutProcess'])
            ->name('pelanggan.checkout.process');
    });

});


require __DIR__.'/auth.php';
