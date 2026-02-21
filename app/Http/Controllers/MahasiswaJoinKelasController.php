<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;

class MahasiswaJoinKelasController extends Controller
{
    public function join(Request $request)
    {
        $request->validate([
            'code' => 'required|min:3'
        ]);

        // Ambil mahasiswa login
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if (!$mahasiswa) {
            return back()->withErrors('Mahasiswa belum login');
        }

        // Cari kelas berdasarkan kode akses
        $kelas = Kelas::where('kode_akses', $request->code)->first();

        if (!$kelas) {
            return back()->withErrors('Kode kelas tidak ditemukan');
        }

        // Cegah join dua kali
        if ($kelas->mahasiswa()->where('mahasiswa_id', $mahasiswa->id)->exists()) {
            return back()->withErrors('Anda sudah terdaftar di kelas ini');
        }

        // Attach ke pivot
        $kelas->mahasiswa()->attach($mahasiswa->id, [
            'absen' => 0,
            'tugas' => 0,
            'uts' => 0,
            'uas' => 0
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Berhasil bergabung ke kelas');
    }
}