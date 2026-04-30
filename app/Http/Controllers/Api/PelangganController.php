<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Pelanggan::latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'nullable',
            'status' => 'boolean'
        ]);

        return Pelanggan::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         return Pelanggan::with('meterAir', 'tagihan')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $pelanggan = Pelanggan::findOrFail($id);

        $pelanggan->update($request->all());

        return $pelanggan;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Pelanggan::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    public function detail($id)
    {
        $pelanggan = \App\Models\Pelanggan::with([
            'meterAir' => function ($q) {
                $q->orderBy('tahun', 'desc')->orderBy('bulan', 'desc');
            },
            'tagihan' => function ($q) {
                $q->orderBy('created_at', 'desc');
            }
        ])->findOrFail($id);

        return response()->json($pelanggan);
    }
}
