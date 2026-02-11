<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    protected $table = "produk";
    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'stok',
        'foto',
    ];
    public function penjualan()
    {
        return $this->belongsToMany(Penjualan::class, 'detail_penjualan', 'produk_id', 'penjualan_id')
                    ->withPivot('jumlah', 'harga_saat_itu', 'subtotal')
                    ->withTimestamps();
    }
}
