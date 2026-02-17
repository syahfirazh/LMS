<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use Carbon\Carbon;

class DashboardController extends Controller
{
   public function index()
{
    $dosen = Auth::guard('dosen')->user();

    $hariIni = now()->translatedFormat('l');
    $now = Carbon::now();

    // Ambil kelas dosen hari ini
    $kelasHariIni = Kelas::with('mataKuliah')
        ->where('dosen_id', $dosen->id)
        ->where('hari', $hariIni)
        ->orderBy('jam_mulai')
        ->get();

    $jadwalHariIni = $kelasHariIni
    ->filter(function ($kelas) use ($now) {
        $mulai = Carbon::parse($kelas->jam_mulai);
$selesai = Carbon::parse($kelas->jam_selesai);


        // tampilkan semua jadwal hari ini yang BELUM SELESAI
        return $now->lte($selesai);
    })
    ->map(function ($kelas) use ($now) {
       $mulai = Carbon::parse($kelas->jam_mulai);
$selesai = Carbon::parse($kelas->jam_selesai);

        if ($now->between($mulai, $selesai)) {
            $status = 'berlangsung';
        } elseif ($now->lt($mulai)) {
            $status = 'akan_datang';
        } else {
            $status = 'selesai';
        }

        return [
            'jam_mulai'   => $kelas->jam_mulai,
            'jam_selesai' => $kelas->jam_selesai,
            'mata_kuliah' => $kelas->mataKuliah->nama ?? '-',
            'kelas'       => $kelas->kode_kelas,
            'ruangan'     => $kelas->ruangan,
            'status'      => $status,
        ];
    });


    return view('dosen_dashboard', [
    'dosen'          => $dosen,
    'hariIni'        => now()->translatedFormat('l, d F Y'),
    'kelasDiampu'    => $dosen->kelas ?? collect(),

    'totalMatkul'    => optional($dosen->kelas)->count() ?? 0,

    'totalMahasiswa' => optional($dosen->kelas)
        ? $dosen->kelas->sum(fn ($k) => $k->mahasiswa->count())
        : 0,

    'totalPenilaian' => 0,
    'jadwalHariIni'  => $jadwalHariIni,
]);

}

    /**
     * Jadwal mengajar HARI INI (untuk dashboard)
     */
    private function jadwalHariIni($dosen)
    {
        $hariIni = Carbon::now()->translatedFormat('l'); // Senin, Selasa, dst
        $now = Carbon::now();

        $kelasHariIni = Kelas::with('mataKuliah')
            ->where('dosen_id', $dosen->id)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai')
            ->get();

        return $kelasHariIni->map(function ($kelas) use ($now) {
           $mulai = Carbon::parse($kelas->jam_mulai);
$selesai = Carbon::parse($kelas->jam_selesai);


            $status = 'akan_datang';
            if ($now->between($mulai, $selesai)) {
                $status = 'berlangsung';
            } elseif ($now->gt($selesai)) {
                $status = 'selesai';
            }

            return [
                'mata_kuliah' => $kelas->mataKuliah->nama_mk ?? '-',
                'kelas'       => $kelas->kode_kelas,
                'jam_mulai'   => $kelas->jam_mulai,
                'jam_selesai' => $kelas->jam_selesai,
                'ruangan'     => $kelas->ruangan,
                'status'      => $status,
            ];
        });
    }

    /**
     * Halaman Jadwal Mengajar (full week)
     */
    public function schedule()
    {
        $dosen = Auth::guard('dosen')->user();

        $jadwal = Kelas::with('mataKuliah')
            ->where('dosen_id', $dosen->id)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        $hariList = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
        ];

        return view('dosen_schedule', [
            'jadwal'   => $jadwal,
            'hariList' => $hariList,
        ]);
    }
}
