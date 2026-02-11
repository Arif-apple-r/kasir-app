<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users');
            // pelanggan

            $table->foreignId('karyawan_id')->nullable()->constrained('users');
            // kasir (NULL kalau pembelian online)

            $table->decimal('total_harga', 10, 2);

            $table->enum('metode_pembayaran', ['cash', 'transfer', 'qris'])->default('cash');

            $table->enum('status_pesanan', ['pending', 'diproses', 'selesai', 'dibatalkan'])
                ->default('pending');

            $table->dateTime('tanggal_penjualan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
