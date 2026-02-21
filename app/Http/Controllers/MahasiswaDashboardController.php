<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Assignment;
use App\Models\Grade;

class MahasiswaDashboardController extends Controller
{
    public function index()
    {
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if (!$mahasiswa) {
            abort(403, 'Mahasiswa belum login');
        }

        $kelas = $mahasiswa->kelas()->with('mataKuliah', 'dosen')->get();

        $jumlahMk = $kelas->count();

        $tugas = Assignment::whereIn(
                'kelas_id',
                $kelas->pluck('id')
            )
            ->latest()
            ->take(5)
            ->get();

        $nilai = Grade::where('mahasiswa_id', $mahasiswa->id)
            ->whereIn('kelas_id', $kelas->pluck('id'))
            ->get();

        return view('dashboard', compact(
            'mahasiswa',
            'jumlahMk',
            'kelas',
            'tugas',
            'nilai'
        ));
    }
}