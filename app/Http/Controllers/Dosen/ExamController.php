<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Kelas;
use App\Models\ExamQuestion;
use App\Models\ExamOption;
use App\Models\ExamResult; // <-- Pastikan model ini sudah di-import
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    public function index()
    {
        $dosenId = Auth::guard('dosen')->id();
        $now = Carbon::now();

        $listKelas = Kelas::with('mataKuliah')->where('dosen_id', $dosenId)->get();
        $exams = Exam::with('kelas.mataKuliah')
                     ->where('dosen_id', $dosenId)
                     ->orderBy('created_at', 'desc')
                     ->get();

        $aktif = 0; $terjadwal = 0; $selesai = 0;

        foreach ($exams as $exam) {
            if ($exam->status === 'draft') {
                $exam->status_text = 'Draft';
                $exam->status_color = 'amber';
                $selesai++;
            } else {
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
        }
        return view('dosen_exams', compact('exams', 'aktif', 'terjadwal', 'selesai', 'listKelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required',
            'judul' => 'required|string',
            'kategori' => 'required',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'token' => 'required'
        ]);

        Exam::create([
            'dosen_id' => Auth::guard('dosen')->id(),
            'kelas_id' => $request->kelas_id,
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'token' => strtoupper($request->token),
            'status' => 'draft',
        ]);

        return back()->with('success', 'Draft ujian berhasil dibuat!');
    }

    public function publish(Exam $exam)
    {
        if ($exam->questions()->count() == 0) {
            return back()->with('error', 'Tidak bisa menerbitkan ujian tanpa soal.');
        }
        $exam->update(['status' => 'published']);
        return back()->with('success', 'Ujian berhasil diterbitkan.');
    }

    // Fungsi Hentikan Ujian
    public function stop(Exam $exam)
    {
        $exam->update(['waktu_selesai' => now()]);
        return back()->with('success', 'Ujian telah dihentikan.');
    }

    // Fungsi Hapus Ujian
    public function destroy(Exam $exam)
    {
        $exam->delete();
        return back()->with('success', 'Ujian berhasil dihapus.');
    }

    // --- BUILDER SOAL ---
    public function questions(Exam $exam)
    {
        $exam->load('questions.options');
        return view('dosen_exam_questions', compact('exam'));
    }

    public function storeQuestions(Request $request, Exam $exam)
    {
        $soalData = json_decode($request->soal_data, true);
        DB::beginTransaction();
        try {
            $exam->questions()->delete();
            foreach ($soalData as $data) {
                $question = $exam->questions()->create([
                    'tipe' => $data['type'],
                    'bobot' => $data['score'],
                    'teks_soal' => $data['text'],
                ]);
                if ($data['type'] === 'PG' && !empty($data['options'])) {
                    foreach ($data['options'] as $opt) {
                        $question->options()->create([
                            'teks_opsi' => $opt['text'],
                            'is_correct' => $opt['isCorrect'],
                        ]);
                    }
                }
            }
            DB::commit();
            return redirect()->route('dosen.exams')->with('success', 'Soal disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    // ========================================================================
    // FUNGSI PANTAU UJIAN DAN LIHAT HASIL TERINTEGRASI TABEL RESULT
    // ========================================================================
    
    public function monitor(Exam $exam)
    {
        // Menarik data kelas, mata kuliah, dan histori pengerjaan (results) beserta data mahasiswanya
        $exam->load(['kelas.mataKuliah', 'results.mahasiswa']);
        
        return view('dosen_exam_monitor', compact('exam'));
    }

    public function results(Exam $exam)
    {
        // Hanya ambil data result yang statusnya sudah 'selesai'
        $exam->load(['kelas.mataKuliah', 'results' => function($query) {
            $query->where('status', 'selesai')->with('mahasiswa');
        }]);

        return view('dosen_exam_results', compact('exam'));
    }
}