<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
   
    protected $table = 'pelanggan';

    protected $fillable = [
        'nama',
        'alamat',
        'no_hp',
        'status'
    ];

    // 🔗 Relasi ke Meter Air
    public function meterAir()
    {
        return $this->hasMany(MeterAir::class);
    }

    // 🔗 Relasi ke Tagihan
    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

}
