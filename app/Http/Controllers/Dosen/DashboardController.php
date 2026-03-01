<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use App\Models\Notification; // Import Model Notifikasi
use App\Models\Message;      // Import Model Message untuk hitung pesan belum dibaca
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; // <--- Import DOMPDF di sini

class DashboardController extends Controller
{
    /**
     * =========================================================
     * HALAMAN UTAMA (DASHBOARD)
     * =========================================================
     */
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

    /**
     * =========================================================
     * HALAMAN PEMBERITAHUAN (NOTIFIKASI)
     * =========================================================
     */
    public function notifications()
    {
        $dosenId = Auth::guard('dosen')->id();

        // 1. Ambil Notifikasi dari Database (Urutkan dari yang terbaru)
        $notifications = Notification::where('user_type', 'dosen')
            ->where('user_id', $dosenId)
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Hitung Pesan Masuk (Untuk indikator angka di sidebar)
        $unreadMessageCount = Message::where('receiver_type', 'dosen')
            ->where('receiver_id', $dosenId)
            ->where('is_read', 0)
            ->count();

        return view('dosen_notifications', compact('notifications', 'unreadMessageCount'));
    }

    /**
     * =========================================================
     * FUNGSI TANDAI SEMUA NOTIFIKASI DIBACA
     * =========================================================
     */
    public function markAllNotificationsRead()
    {
        $dosenId = Auth::guard('dosen')->id();
        
        // Update semua notifikasi milik dosen ini menjadi sudah dibaca (true / 1)
        Notification::where('user_type', 'dosen')
            ->where('user_id', $dosenId)
            ->update(['is_read' => true]);

        return back()->with('success', 'Semua pemberitahuan telah ditandai dibaca.');
    }

    /**
     * =========================================================
     * HALAMAN JADWAL MENGAJAR
     * =========================================================
     */
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

    /**
     * =========================================================
     * FUNGSI CETAK PDF JADWAL MENGAJAR (BARU)
     * =========================================================
     */
    public function exportSchedulePdf()
    {
        $dosen = Auth::guard('dosen')->user();

        // Ambil data mentah jadwal
        $jadwalRaw = Kelas::with('mataKuliah')
            ->where('dosen_id', $dosen->id)
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // Siapkan wadah 7 hari
        $jadwalPerHari = [
            'Senin'  => [], 'Selasa' => [], 'Rabu'   => [],
            'Kamis'  => [], 'Jumat'  => [], 'Sabtu'  => [], 'Minggu' => [],
        ];

        // Masukkan jadwal
        foreach ($jadwalRaw as $kelas) {
            $hariDB = ucfirst(strtolower(trim($kelas->hari))); 
            if (array_key_exists($hariDB, $jadwalPerHari)) {
                $jadwalPerHari[$hariDB][] = $kelas;
            }
        }

        // Data yang dikirim (Tambahkan saklar is_pdf)
        $data = [
            'dosen' => $dosen,
            'jadwalPerHari' => $jadwalPerHari,
            'is_pdf' => true // <-- SAKLAR PDF
        ];

        // Generate PDF dengan posisi kertas Portrait (Berdiri)
        $pdf = Pdf::loadView('dosen_schedule', $data)->setPaper('a4', 'portrait');

        $namaFile = 'Jadwal_Mengajar_' . str_replace(' ', '_', $dosen->nama) . '.pdf';

        return $pdf->stream($namaFile);
    }
}