<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\SubmissionMessage;

class AssignmentGradeController extends Controller
{
    // ============================
    // TAMPILKAN HALAMAN GRADE
    // ============================
    public function show($kelasId, $assignmentId, $mahasiswaId = null)
    {
        $kelas = Kelas::with('mahasiswa')->findOrFail($kelasId);
        $assignment = Assignment::findOrFail($assignmentId);
        $mahasiswas = $kelas->mahasiswa;

        $activeMahasiswaId = $mahasiswaId ?? ($mahasiswas->first()->id ?? null);
        $activeMahasiswa = $mahasiswas->firstWhere('id', $activeMahasiswaId);

        // Load riwayat pesan tugas untuk mahasiswa yang aktif
        $submission = Submission::with(['messages' => function($q) {
            $q->orderBy('created_at', 'asc');
        }])->where('assignment_id', $assignmentId)->where('mahasiswa_id', $activeMahasiswaId)->first();

        // Set status kumpul untuk daftar kiri
        foreach ($mahasiswas as $mhs) {
            $sub = Submission::where('assignment_id', $assignmentId)->where('mahasiswa_id', $mhs->id)->first();
            
            // Anggap "Sudah Kumpul" jika ada file ATAU teks ATAU voice
            $isSubmitted = $sub && ($sub->file_path || $sub->text_online || $sub->text_submission || $sub->voice_url || $sub->voice_submission);
            
            $mhs->status_pengumpulan = $isSubmitted ? 'tepat_waktu' : 'terlambat';
            $mhs->status_label = $isSubmitted ? 'Sudah' : 'Belum';
        }

        return view('dosen_grade_assignment', compact('kelas', 'assignment', 'mahasiswas', 'activeMahasiswaId', 'activeMahasiswa', 'submission'));
    }

    // ============================
    // SIMPAN NILAI DAN FEEDBACK DOSEN
    // ============================
    public function store(Request $request, $kelasId, $assignmentId, $mahasiswaId)
    {
        $submission = Submission::where('assignment_id', $assignmentId)->where('mahasiswa_id', $mahasiswaId)->firstOrFail();
        $submission->update([
            'nilai' => $request->nilai,
            'feedback' => $request->feedback
        ]);
        return back()->with('success', 'Nilai berhasil disimpan.');
    }

    // ============================
    // BALAS CHAT DISKUSI TUGAS DARI DOSEN
    // ============================
    public function storeMessage(Request $request, $assignmentId, $mahasiswaId)
    {
        try {
            $request->validate([
                'message' => 'nullable|string',
                'image'   => 'nullable|image|max:2048',
                'voice'   => 'nullable|file|max:5120',
            ]);

            $dosenId = auth('dosen')->id();
            
            // JIKA BELUM SUBMIT TUGAS, BUATKAN WADAH SUBMISSION KOSONG AGAR DOSEN BISA CHAT DULUAN
            $submission = Submission::firstOrCreate([
                'assignment_id' => $assignmentId, 
                'mahasiswa_id' => $mahasiswaId
            ]);

            $pathImage = $request->hasFile('image') ? $request->file('image')->store('diskusi_tugas/images', 'public') : null;
            $pathVoice = $request->hasFile('voice') ? $request->file('voice')->store('diskusi_tugas/voices', 'public') : null;

            if (!$request->message && !$pathImage && !$pathVoice) {
                return response()->json(['error' => 'Pesan tidak boleh kosong.'], 422);
            }

            // SIMPAN PESAN KE SUBMISSION MESSAGE
            $msg = SubmissionMessage::create([
                'submission_id' => $submission->id,
                'from'          => 'dosen',
                'body'          => $request->message,
                'image'         => $pathImage,
                'voice'         => $pathVoice,
            ]);

            return response()->json([
                'success' => true,
                'diskusi' => [
                    'id'          => $msg->id,
                    'message'     => $msg->body,
                    'image'       => $msg->image ? asset('storage/' . $msg->image) : null,
                    'voice'       => $msg->voice ? asset('storage/' . $msg->voice) : null,
                    'time'        => $msg->created_at->format('H:i'),
                    'from'        => 'dosen',
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Backend Error: ' . $e->getMessage()], 500);
        }
    }
}