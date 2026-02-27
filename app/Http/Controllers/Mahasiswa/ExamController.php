<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Exam; 
use App\Models\ExamResult; // <-- Wajib ada untuk menyimpan nilai

class ExamController extends Controller
{
    // 1. Menampilkan halaman daftar ujian
    public function index()
    {
        $exams = Exam::with('kelas.mataKuliah')
                    ->where('waktu_selesai', '>=', now())
                    ->orderBy('waktu_mulai', 'asc')
                    ->get();

        return view('exams', compact('exams')); 
    }

    // 2. Menampilkan halaman input token ujian
    public function join()
    {
        return view('join_exam');
    }

    // 3. Memproses pengecekan token
    public function verifyToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string'
        ]);

        $tokenInput = strtoupper(str_replace(' ', '', $request->token));
        
        $exam = Exam::where('token', $tokenInput)
                    ->where('waktu_selesai', '>=', now())
                    ->first();

        if ($exam) {
            return redirect()->route('exam.preparation', ['id' => $exam->id]);
        }

        return back()->with('error', 'Token Ujian tidak valid atau ujian sudah berakhir. Silakan coba lagi.');
    }

    // 4. Menampilkan halaman tata tertib / persiapan ujian
    public function preparation($id)
    {
        $exam = Exam::with(['kelas', 'kelas.dosen'])->findOrFail($id);
        return view('exam_start', compact('exam')); 
    }

    // 5. Memproses klik tombol "Mulai Mengerjakan"
    public function start(Request $request, $id)
    {
        $mahasiswaId = Auth::guard('mahasiswa')->id();

        // Catat ke database bahwa mahasiswa ini sudah mulai mengerjakan
        ExamResult::firstOrCreate(
            ['exam_id' => $id, 'mahasiswa_id' => $mahasiswaId],
            ['status' => 'mengerjakan', 'waktu_mulai' => now()]
        );

        return redirect()->route('exam.play', ['id' => $id]);
    }

    // 6. Menampilkan UI soal-soal ujian sesungguhnya
    public function play($id)
    {
        // WAJIB me-load relasi questions dan options agar soal tampil
        $exam = Exam::with('questions.options')->findOrFail($id);
        
        // Memanggil file UI Blade
        return view('mahasiswa_exam_play', compact('exam'));
    }

    // 7. [REVISI] Memproses pengumpulan jawaban dari Mahasiswa
    public function submit(Request $request, $id)
    {
        $mahasiswaId = Auth::guard('mahasiswa')->id();
        $exam = Exam::with('questions.options')->findOrFail($id);
        
        // Asumsi format jawaban_data dari frontend adalah JSON object: {"question_id": "option_id"}
        $jawabanData = json_decode($request->jawaban_data, true) ?? []; 

        $benar = 0;
        $salah = 0;
        $totalBobot = $exam->questions->sum('bobot');
        $nilaiDiperoleh = 0;

        // Loop untuk mencocokkan jawaban
        foreach($exam->questions as $q) {
            $jawabanMahasiswa = $jawabanData[$q->id] ?? null;
            $kunciJawaban = $q->options->where('is_correct', true)->first();

            if ($jawabanMahasiswa && $kunciJawaban && $jawabanMahasiswa == $kunciJawaban->id) {
                $benar++;
                $nilaiDiperoleh += $q->bobot;
            } else {
                $salah++;
            }
        }

        // Kalkulasi nilai ke skala 100
        $nilaiAkhir = $totalBobot > 0 ? ($nilaiDiperoleh / $totalBobot) * 100 : 0;

        // Update atau buat record ExamResult menjadi Selesai
        ExamResult::updateOrCreate(
            ['exam_id' => $id, 'mahasiswa_id' => $mahasiswaId],
            [
                'status' => 'selesai',
                'waktu_selesai' => now(),
                'benar' => $benar,
                'salah' => $salah,
                'nilai' => $nilaiAkhir,
                'jawaban_detail' => $jawabanData
            ]
        );

        return redirect()->route('exams')->with('success', 'Ujian selesai! Nilai berhasil disimpan.');
    }
}