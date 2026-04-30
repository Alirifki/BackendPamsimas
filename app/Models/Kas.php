<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    use HasFactory;
    protected $table = 'kas';

    protected $fillable = [
        'tagihan_id',
        'jenis',
        'nominal',
        'keterangan',
        'tanggal'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'decimal:2'
    ];

    // 🔗 Relasi ke Tagihan
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }
}
