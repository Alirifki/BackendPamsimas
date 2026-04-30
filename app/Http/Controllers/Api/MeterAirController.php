<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MeterAir;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class MeterAirController extends Controller
{
    public function index()
    {
        return MeterAir::with('pelanggan')->latest()->get();
    }

    public function store(Request $request)
    {
    // VALIDASI
    $request->validate([
        'pelanggan_id' => 'required',
        'meter_awal' => 'required|numeric',
        'meter_akhir' => 'required|numeric'
    ]);

    // 🚫 CEK DOUBLE INPUT PERIODE
    $exists = MeterAir::where('pelanggan_id', $request->pelanggan_id)
        ->where('bulan', now()->month)
        ->where('tahun', now()->year)
        ->exists();

    if ($exists) {
        return response()->json([
            'message' => 'Meter bulan ini sudah diinput'
        ], 400);
    }

    // 💧 HITUNG PEMAKAIAN
    $pemakaian = $request->meter_akhir - $request->meter_awal;
    $biaya_air = $pemakaian * 2000;
    $listrik = 5000;
    $kebersihan = 5000;

    // 💰 HITUNG TAGIHAN (contoh tarif 2000)
    $total = $biaya_air + $listrik + $kebersihan;

    // 💾 SIMPAN METER
    $meter = MeterAir::create([
        'pelanggan_id' => $request->pelanggan_id,
        'bulan' => now()->month,
        'tahun' => now()->year,
        'meter_awal' => $request->meter_awal,
        'meter_akhir' => $request->meter_akhir,
    ]);

    // 💾 AUTO BUAT TAGIHAN
    Tagihan::create([
    'pelanggan_id' => $request->pelanggan_id,
    'meter_air_id' => $meter->id,
    'total_pemakaian' => $pemakaian,
    'tarif' => $biaya_air,
    'biaya_listrik' => $listrik,
    'biaya_kebersihan' => $kebersihan,
    'total_bayar' => $total,
]);

    return response()->json([
        'message' => 'Meter berhasil disimpan',
        'data' => $meter
    ]);
    }

    public function show($id)
    {
        return MeterAir::with('pelanggan', 'tagihan')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $meter = MeterAir::findOrFail($id);

        $meter->update($request->all());

        return $meter;
    }

    public function destroy($id)
    {
        MeterAir::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    public function lastMeter($pelanggan_id)
    {
        $last = MeterAir::where('pelanggan_id', $pelanggan_id)
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->first();

        return response()->json([
            'meter_awal' => $last ? $last->meter_akhir : 0
        ]);
    }
}
