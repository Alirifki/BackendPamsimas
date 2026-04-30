<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
     protected $table = 'tagihan';

    protected $fillable = [
        'pelanggan_id',
        'meter_air_id',
        'total_pemakaian',
        'tarif',
        'total_bayar',
        'status',
        'biaya_listrik',
        'biaya_kebersihan',
    ];

    // 🔗 ke Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    // 🔗 ke Meter Air
    public function meter()
    {
        return $this->belongsTo(MeterAir::class, 'meter_air_id');
    }

    // 🔗 ke Pembayaran
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function kas()
    {
        return $this->hasOne(Kas::class);
    }
    
}
