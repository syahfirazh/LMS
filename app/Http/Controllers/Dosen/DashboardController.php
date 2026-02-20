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

        // 1. Setting Waktu
        Carbon::setLocale('id');
        $hariIni = Carbon::now()->isoFormat('dddd'); 
        $tanggalLengkap = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $now = Carbon::now();

        // 2. Ambil Semua Kelas (Return: OBJECT Eloquent)
        $kelasDiampu = Kelas::with(['mataKuliah', 'mahasiswa'])
            ->where('dosen_id', $dosen->id)
            ->get();

        // 3. Ambil Jadwal Hari Ini (Return: Collection of Objects)
        $kelasHariIniRaw = Kelas::with('mataKuliah')
            ->where('dosen_id', $dosen->id)
            ->where('hari', $hariIni) 
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // 4. Proses Status Jadwal (Return: ARRAY hasil map)
        $jadwalHariIni = $kelasHariIniRaw->map(function ($kelas) use ($now) {
            $jamMulai = Carbon::parse($kelas->jam_mulai);
            $jamSelesai = Carbon::parse($kelas->jam_selesai);
            
            // Set tanggal ke hari ini agar perbandingan jam valid
            $jamMulai->setDate($now->year, $now->month, $now->day);
            $jamSelesai->setDate($now->year, $now->month, $now->day);
            
            if ($now->between($jamMulai, $jamSelesai)) {
                $status = 'berlangsung';
            } elseif ($now->gt($jamSelesai)) {
                $status = 'selesai';
            } else {
                $status = 'akan_datang';
            }

            return [
                'jam_mulai'   => $jamMulai->format('H:i'),
                'jam_selesai' => $jamSelesai->format('H:i'),
                'mata_kuliah' => $kelas->mataKuliah->nama ?? 'Mata Kuliah',
                'kelas'       => $kelas->kode_kelas,
                'ruangan'     => $kelas->ruangan,
                'status'      => $status,
            ];
        });

        // 5. Statistik
        $totalMatkul = $kelasDiampu->count();
        $totalMahasiswa = $kelasDiampu->flatMap->mahasiswa->unique('id')->count();
        $totalPenilaian = 0; 

        // 6. Kirim ke View
        return view('dosen_dashboard', compact(
            'dosen', 'hariIni', 'tanggalLengkap', 'kelasDiampu', 
            'jadwalHariIni', 'totalMatkul', 'totalMahasiswa', 'totalPenilaian'
        ));
    }

    public function notifications()
    {
        // Langsung ke view notifikasi (Sesuai dengan kode asli Anda)
        return view('dosen_notifications');
    }

    public function schedule()
    {
        $dosen = Auth::guard('dosen')->user();

        // 1. Ambil semua data dari database (diurutkan berdasarkan jam mulai)
        $jadwalRaw = Kelas::with('mataKuliah')
            ->where('dosen_id', $dosen->id)
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // 2. Siapkan wadah 7 hari pasti agar urutannya selalu Senin - Minggu
        $jadwalPerHari = [
            'Senin'  => [],
            'Selasa' => [],
            'Rabu'   => [],
            'Kamis'  => [],
            'Jumat'  => [],
            'Sabtu'  => [],
            'Minggu' => [],
        ];

        // 3. Masukkan jadwal ke masing-masing hari (Anti-Gagal & Kebal Spasi)
        foreach ($jadwalRaw as $kelas) {
            // Membersihkan teks: Hapus spasi, kecilkan huruf, lalu huruf awal besar
            $hariDB = ucfirst(strtolower(trim($kelas->hari))); 
            
            // Jika nama harinya valid, masukkan ke dalam wadah
            if (array_key_exists($hariDB, $jadwalPerHari)) {
                $jadwalPerHari[$hariDB][] = $kelas;
            }
        }

        // 4. Kirim ke View
        return view('dosen_schedule', compact('dosen', 'jadwalPerHari'));
    }
}