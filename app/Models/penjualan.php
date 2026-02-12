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

    protected $casts = [
        'tanggal_penjualan' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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

    public function scopeSelesai($query)
    {
        return $query->where('status_pesanan', 'selesai');
    }

    public function scopePending($query)
    {
        return $query->where('status_pesanan', 'pending');
    }
}
