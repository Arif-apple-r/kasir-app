<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detailPenjualan extends Model
{
    protected $table = "detail_penjualan";
    protected $fillable = [
        'penjualan_id',
        'produk_id',
        'jumlah',
        'harga_saat_itu',
        'subtotal'
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }

    public function produk()
    {
        return $this->belongsTo(produk::class, 'produk_id');
    }
}
