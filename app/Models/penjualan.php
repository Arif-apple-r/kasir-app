<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class penjualan extends Model
{
    protected $table = "penjualan";
    protected $fillable = [
        'user_id',
        'karyawan_id',
        'total_harga',
        'tanggal',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan_id');
    }

    public function detail()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualan_id');
    }
}
