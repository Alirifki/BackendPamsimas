<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kas;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
        public function index()
    {
       return Tagihan::with('pelanggan')
        ->orderByRaw("status = 'belum_bayar' DESC")
        ->get();
    }

    public function show($id)
    {
        return Tagihan::with('pelanggan', 'meter')->find($id);
    }

    public function update(Request $request, $id)
    {
        $tagihan = Tagihan::with('pelanggan')->findOrFail($id);

        // 🚫 cegah double bayar
        if ($tagihan->status == 'lunas') {
            return response()->json([
                'message' => 'Tagihan sudah lunas'
            ], 400);
        }

        // ✅ update status
        $tagihan->update([
            'status' => 'lunas'
        ]);

        // 💰 MASUKKAN KE KAS (SESUIKAN FIELD)
        Kas::create([
            'tagihan_id' => $tagihan->id,
            'jenis' => 'pemasukan',
            'nominal' => $tagihan->total_bayar,
            'keterangan' => 'Pembayaran Air - ' . $tagihan->pelanggan->nama,
            'tanggal' => now()
        ]);

        return response()->json([
            'message' => 'Pembayaran berhasil'
        ]);
    }
    public function destroy($id)
    {
        Tagihan::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    public function bayar($id)
    {
        $tagihan = Tagihan::findOrFail($id);

        $tagihan->update([
            'status' => 'lunas'
        ]);

        return response()->json([
            'message' => 'Pembayaran berhasil',
            'data' => $tagihan
        ]);
    }
}
