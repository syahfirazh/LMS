<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index()
    {
        $dosenId = Auth::guard('dosen')->id();
        $now = Carbon::now();

        // Ambil data kelas untuk pilihan di form modal
        $listKelas = Kelas::with('mataKuliah')->where('dosen_id', $dosenId)->get();

        // Ambil semua ujian
        $exams = Exam::with('kelas.mataKuliah')
                     ->where('dosen_id', $dosenId)
                     ->orderBy('waktu_mulai', 'desc')
                     ->get();

        // Hitung Statistik
        $aktif = 0;
        $terjadwal = 0;
        $selesai = 0;

        foreach ($exams as $exam) {
            if ($now->between($exam->waktu_mulai, $exam->waktu_selesai)) {
                $aktif++;
                $exam->status_text = 'Sedang Berlangsung';
                $exam->status_color = 'emerald';
            } elseif ($now->lt($exam->waktu_mulai)) {
                $terjadwal++;
                $exam->status_text = 'Terjadwal';
                $exam->status_color = 'blue';
            } else {
                $selesai++;
                $exam->status_text = 'Selesai';
                $exam->status_color = 'slate';
            }
        }

        return view('dosen_exams', compact('exams', 'aktif', 'terjadwal', 'selesai', 'listKelas'));
    }

    // Fungsi untuk menyimpan Ujian Baru
    public function store(Request $request)
    {
        $request->validate([
            'kelas_id'      => 'required',
            'judul'         => 'required|string|max:255',
            'kategori'      => 'required|in:Kuis,UTS,UAS',
            'waktu_mulai'   => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'deskripsi'     => 'nullable|string'
        ]);

        Exam::create([
            'dosen_id'      => Auth::guard('dosen')->id(),
            'kelas_id'      => $request->kelas_id,
            'judul'         => $request->judul,
            'kategori'      => $request->kategori,
            'waktu_mulai'   => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'deskripsi'     => $request->deskripsi,
        ]);

        return back()->with('success', 'Ujian/Kuis baru berhasil dijadwalkan!');
    }
}