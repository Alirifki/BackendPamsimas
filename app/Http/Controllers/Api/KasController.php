<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kas;
use Illuminate\Http\Request;

class KasController extends Controller
    {
        // ✅ GET semua kas
        public function index()
        {
            $data = Kas::with('tagihan.pelanggan')
                ->orderBy('tanggal', 'desc')
                ->get();

            return response()->json($data);
        }

        // ✅ GET detail kas
        public function show($id)
        {
            $data = Kas::with('tagihan.pelanggan')
                ->findOrFail($id);

            return response()->json($data);
        }

        // ✅ POST tambah kas (manual)
        public function store(Request $request)
        {
            $request->validate([
                'jenis' => 'required|in:pemasukan,pengeluaran',
                'nominal' => 'required|numeric',
                'keterangan' => 'nullable|string'
            ]);

            $kas = Kas::create([
                'jenis' => $request->jenis,
                'nominal' => $request->nominal,
                'keterangan' => $request->keterangan,
                'tanggal' => now()
            ]);

            return response()->json([
                'message' => 'Kas berhasil ditambahkan',
                'data' => $kas
            ]);
        }

        // ✅ UPDATE kas
        public function update(Request $request, $id)
        {
            $kas = Kas::findOrFail($id);

            $kas->update([
                'jenis' => $request->jenis ?? $kas->jenis,
                'nominal' => $request->nominal ?? $kas->nominal,
                'keterangan' => $request->keterangan ?? $kas->keterangan,
            ]);

            return response()->json([
                'message' => 'Kas berhasil diupdate',
                'data' => $kas
            ]);
        }

        // ✅ DELETE kas
        public function destroy($id)
        {
            $kas = Kas::findOrFail($id);
            $kas->delete();

            return response()->json([
                'message' => 'Kas berhasil dihapus'
            ]);
        }

        // ✅ TOTAL SALDO
        public function saldo()
        {
            $pemasukan = Kas::where('jenis', 'pemasukan')->sum('nominal');
            $pengeluaran = Kas::where('jenis', 'pengeluaran')->sum('nominal');

            return response()->json([
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'saldo' => $pemasukan - $pengeluaran
            ]);
        
    }
}
