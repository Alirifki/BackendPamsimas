<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
      protected $table = 'pembayaran';

    protected $fillable = [
        'kode_transaksi',
        'tagihan_id',
        'tanggal_bayar',
        'jumlah_bayar'
    ];

    // 🔗 ke Tagihan
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }
}
