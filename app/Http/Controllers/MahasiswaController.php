<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function joinKelas(Request $request)
{
    $request->validate([
        'kode_akses' => 'required|string'
    ]);

    $kelas = \App\Models\Kelas::where('kode_akses', $request->kode_akses)->first();

    if (!$kelas) {
        return back()->with('error', 'Kode tidak ditemukan');
    }

    $mahasiswa = auth()->guard('mahasiswa')->user();

    if ($kelas->mahasiswa()->where('mahasiswa_id', $mahasiswa->id)->exists()) {
        return back()->with('error', 'Sudah tergabung');
    }

    $kelas->mahasiswa()->attach($mahasiswa->id);

    return back()->with('success', 'Berhasil bergabung');
}

public function joinByCode(Request $request)
{
    $request->validate([
        'kode_akses' => 'required'
    ]);

    $kelas = \App\Models\Kelas::where('kode_akses', $request->kode_akses)->first();

    if (!$kelas) {
        return back()->with('error', 'Kode tidak valid');
    }

    $mahasiswa = auth()->guard('mahasiswa')->user();

    if ($kelas->mahasiswa()->where('mahasiswa_id', $mahasiswa->id)->exists()) {
        return back()->with('error', 'Sudah tergabung');
    }

    $kelas->mahasiswa()->attach($mahasiswa->id);

    return back()->with('success', 'Berhasil bergabung');
}

}
