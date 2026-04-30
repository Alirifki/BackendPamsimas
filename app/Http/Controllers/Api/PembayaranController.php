<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        return Pembayaran::with('tagihan.pelanggan')->latest()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tagihan_id' => 'required|exists:tagihan,id',
            'jumlah_bayar' => 'required|numeric'
        ]);

        $tagihan = Tagihan::findOrFail($data['tagihan_id']);

        // kode transaksi
        $data['kode_transaksi'] = 'TRX-' . time();
        $data['tanggal_bayar'] = now();

        $pembayaran = Pembayaran::create($data);

        // 🔥 update status tagihan
        $tagihan->update([
            'status' => 'lunas'
        ]);

        return $pembayaran;
    }

    public function show($id)
    {
        return Pembayaran::with('tagihan.pelanggan')->findOrFail($id);
    }

    public function destroy($id)
    {
        Pembayaran::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
