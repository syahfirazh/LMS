<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use App\Models\MataKuliah;
use Illuminate\Support\Str;

class KelasController extends Controller
{
    // =========================================================
    // STORE KELAS BARU (AMAN MULTI DOSEN)
    // =========================================================
    public function store(Request $request)
    {
        $request->validate([
            'nama_mata_kuliah' => 'required|string|max:255',
            'kode_kelas'       => 'required|string|max:20',
            'sks'              => 'required|integer|min:1',
            'hari'             => 'required|string',
            'jam_mulai'        => 'required',
            'jam_selesai'      => 'required',
        ]);

        $dosenId = Auth::guard('dosen')->id();

        // ===============================
        // MATA KULIAH KHUSUS DOSEN
        // ===============================
        $mataKuliah = MataKuliah::firstOrCreate(
            [
                'nama'     => $request->nama_mata_kuliah,
                'dosen_id' => $dosenId, // 🔒 PENGUNCI UTAMA
            ],
            [
                'kode' => strtoupper(substr($request->nama_mata_kuliah, 0, 3)),
                'sks'  => $request->sks,
            ]
        );

        // ===============================
        // GENERATE KODE AKSES UNIK
        // ===============================
        do {
            $kodeAkses = strtoupper(Str::random(3)) . '-' . rand(10, 99);
        } while (Kelas::where('kode_akses', $kodeAkses)->exists());

        // ===============================
        // SIMPAN KELAS
        // ===============================
        Kelas::create([
            'dosen_id'       => $dosenId,
            'mata_kuliah_id' => $mataKuliah->id,
            'kode_kelas'     => $request->kode_kelas,
            'kode_akses'     => $kodeAkses,
            'hari'           => $request->hari,
            'jam_mulai'      => $request->jam_mulai,
            'jam_selesai'    => $request->jam_selesai,
            'ruangan'        => '-',
        ]);

        return back()->with('success', 'Kelas berhasil dibuat');
    }

    // =========================================================
    // HAPUS KELAS (HANYA MILIK DOSEN LOGIN)
    // =========================================================
    public function destroy($id)
    {
        $kelas = Kelas::where('id', $id)
            ->where('dosen_id', Auth::guard('dosen')->id())
            ->firstOrFail();

        $kelas->delete();

        return back()->with('success', 'Kelas berhasil dihapus');
    }
}
