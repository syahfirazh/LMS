<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // <--- WAJIB TAMBAHKAN INI
use App\Models\Kelas;
use App\Models\MataKuliah;
use Illuminate\Support\Str;

class KelasController extends Controller
{
    // =========================================================
    // STORE KELAS BARU
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
            'ruangan'          => 'nullable|string', // Ubah ke nullable
            'sampul'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // VALIDASI FOTO
        ]);

        $dosenId = Auth::guard('dosen')->id();

        // MATA KULIAH KHUSUS DOSEN
        $mataKuliah = MataKuliah::firstOrCreate(
            [
                'nama'     => $request->nama_mata_kuliah,
                'dosen_id' => $dosenId,
            ],
            [
                'kode' => strtoupper(substr($request->nama_mata_kuliah, 0, 3)),
                'sks'  => $request->sks,
            ]
        );

        // GENERATE KODE AKSES UNIK
        do {
            $kodeAkses = strtoupper(Str::random(3)) . '-' . rand(10, 99);
        } while (Kelas::where('kode_akses', $kodeAkses)->exists());

        // PROSES UPLOAD FOTO SAMPUL
        $sampulPath = null;
        if ($request->hasFile('sampul')) {
            $sampulPath = $request->file('sampul')->store('sampul_kelas', 'public');
        }

        // SIMPAN KELAS
        Kelas::create([
            'dosen_id'       => $dosenId,
            'mata_kuliah_id' => $mataKuliah->id,
            'kode_kelas'     => $request->kode_kelas,
            'kode_akses'     => $kodeAkses,
            'hari'           => $request->hari,
            'jam_mulai'      => $request->jam_mulai,
            'jam_selesai'    => $request->jam_selesai,
            'ruangan'        => $request->ruangan ?? '-',
            'sampul'         => $sampulPath, // SIMPAN PATH FOTO
        ]);

        return back()->with('success', 'Kelas berhasil dibuat');
    }

    // =========================================================
    // UPDATE KELAS (UNTUK MODAL EDIT)
    // =========================================================
    public function update(Request $request, $id)
    {
        $kelas = Kelas::where('id', $id)
            ->where('dosen_id', Auth::guard('dosen')->id())
            ->firstOrFail();

        $request->validate([
            'nama_mata_kuliah' => 'required|string|max:255',
            'kode_kelas'       => 'required|string|max:20',
            'hari'             => 'required|string',
            'jam_mulai'        => 'required',
            'jam_selesai'      => 'required',
            'ruangan'          => 'nullable|string',
            'sampul'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Cek dan Proses Update Mata Kuliah (jika nama diubah)
        if ($kelas->mataKuliah->nama !== $request->nama_mata_kuliah) {
             $mataKuliah = MataKuliah::firstOrCreate(
                ['nama' => $request->nama_mata_kuliah, 'dosen_id' => Auth::guard('dosen')->id()],
                ['kode' => strtoupper(substr($request->nama_mata_kuliah, 0, 3)), 'sks' => 3]
            );
            $kelas->mata_kuliah_id = $mataKuliah->id;
        }

        // Proses Ganti Foto Sampul
        if ($request->hasFile('sampul')) {
            // Hapus foto lama jika ada
            if ($kelas->sampul && Storage::disk('public')->exists($kelas->sampul)) {
                Storage::disk('public')->delete($kelas->sampul);
            }
            // Simpan foto baru
            $kelas->sampul = $request->file('sampul')->store('sampul_kelas', 'public');
        }

        // Update data lainnya
        $kelas->kode_kelas  = $request->kode_kelas;
        $kelas->hari        = $request->hari;
        $kelas->jam_mulai   = $request->jam_mulai;
        $kelas->jam_selesai = $request->jam_selesai;
        $kelas->ruangan     = $request->ruangan ?? '-';
        $kelas->save();

        return back()->with('success', 'Data kelas berhasil diupdate');
    }

    // =========================================================
    // HAPUS KELAS
    // =========================================================
    public function destroy($id)
    {
        $kelas = Kelas::where('id', $id)
            ->where('dosen_id', Auth::guard('dosen')->id())
            ->firstOrFail();

        // Hapus foto sampul dari storage jika ada
        if ($kelas->sampul && Storage::disk('public')->exists($kelas->sampul)) {
            Storage::disk('public')->delete($kelas->sampul);
        }

        $kelas->delete();

        return back()->with('success', 'Kelas berhasil dihapus');
    }
}