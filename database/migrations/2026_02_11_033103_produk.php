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
        Schema::create("produk", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("nama");
            $table->string("deskripsi")->nullable();
            $table->decimal("harga", 15, 2);
            $table->integer("stok")->default(0);
            $table->string("foto")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("produks");
    }
};
