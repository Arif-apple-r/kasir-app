<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';

    protected $fillable = [
        'user_id',
        'karyawan_id',
        'total_harga',
        'metode_pembayaran',
        'status_pesanan',
        'tanggal_penjualan',
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
        return $this->hasMany(DetailPenjualan::class);
    }
}
