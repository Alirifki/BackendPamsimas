<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeterAir extends Model
{
    protected $table = 'meter_air';

    protected $fillable = [
        'pelanggan_id',
        'bulan',
        'tahun',
        'meter_awal',
        'meter_akhir',
        'pemakaian',
    ];

    // 🔗 ke Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // 🔗 ke Tagihan
    public function tagihan()
    {
        return $this->hasOne(Tagihan::class);
    }

    // hitung tagihan otomatis
    protected static function booted()
    {
        static::saving(function ($meter) {
            $meter->pemakaian = $meter->meter_akhir - $meter->meter_awal;
        });
    }
}
