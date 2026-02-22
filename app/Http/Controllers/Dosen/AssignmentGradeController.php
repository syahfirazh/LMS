<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Submission;
use App\Models\SubmissionMessage; // Pastikan ini mengarah ke model SubmissionMessage

class AssignmentGradeController extends Controller
{
    public function show($kelasId, $assignmentId, $mahasiswaId = null)
    {
        // 🔒 Pastikan kelas milik dosen
        $kelas = Kelas::where('id', $kelasId)
            ->where('dosen_id', auth('dosen')->id())
            ->firstOrFail();

        // 🔒 Ambil assignment hanya dari kelas ini
        $assignment = $kelas->assignments()
            ->where('id', $assignmentId)
            ->firstOrFail();

        $mahasiswas = $kelas->mahasiswa()->get();

        if ($mahasiswas->isEmpty()) {
            return view('dosen_grade_assignment', [
                'kelas' => $kelas,
                'assignment' => $assignment,
                'mahasiswas' => collect(),
                'activeMahasiswa' => null,
                'submission' => null,
                'activeMahasiswaId' => null,
            ]);
        }

        $activeMahasiswa = $mahasiswaId
            ? $mahasiswas->where('id', $mahasiswaId)->first()
            : $mahasiswas->first();

        if (!$activeMahasiswa) {
            $activeMahasiswa = $mahasiswas->first();
        }

        // 🔒 Submission HARUS milik assignment & mahasiswa aktif
        $submission = Submission::where('assignment_id', $assignment->id)
            ->where('mahasiswa_id', $activeMahasiswa->id)
            ->first();

        return view('dosen_grade_assignment', compact(
            'kelas',
            'assignment',
            'mahasiswas',
            'activeMahasiswa',
            'submission'
        ))->with('activeMahasiswaId', $activeMahasiswa->id);
    }

    public function store(Request $request, $kelasId, $assignmentId, $mahasiswaId)
    {
        $request->validate([
            'nilai' => 'nullable|integer|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        // 🔒 Validasi kelas & assignment
        $kelas = Kelas::where('id', $kelasId)
            ->where('dosen_id', auth('dosen')->id())
            ->firstOrFail();

        $assignment = $kelas->assignments()
            ->where('id', $assignmentId)
            ->firstOrFail();

        // 🔒 Submission HARUS dari assignment ini
        $submission = Submission::where('assignment_id', $assignment->id)
            ->where('mahasiswa_id', $mahasiswaId)
            ->first();

        if (!$submission) {
            return back()->with('error', 'Mahasiswa belum mengumpulkan tugas');
        }

        $submission->update([
            'nilai' => $request->nilai,
            'feedback' => $request->feedback,
        ]);

        return back()->with('success', 'Nilai berhasil disimpan');
    }

    /**
     * =========================================================
     * SIMPAN PESAN DISKUSI TUGAS (Mendukung Voice & Image)
     * =========================================================
     */
    public function storeMessage(Request $request, $assignmentId, $mahasiswaId)
    {
        try {
            $request->validate([
                'body'  => 'nullable|string',
                'image' => 'nullable|image|max:5120',
                'voice' => 'nullable|file|max:5120'
            ]);

            if (empty($request->body) && !$request->hasFile('image') && !$request->hasFile('voice')) {
                return response()->json(['success' => false, 'message' => 'Pesan tidak boleh kosong.'], 400);
            }

            // 1. Validasi Keamanan: Pastikan tugas dan kelas ini milik dosen yang sedang login
            $dosenId = auth('dosen')->id();
            $assignment = \App\Models\Assignment::where('id', $assignmentId)
                ->whereHas('kelas', function($q) use ($dosenId) {
                    $q->where('dosen_id', $dosenId);
                })->firstOrFail();

            // 2. Cari atau Buat Submission. 
            // Jika mahasiswa belum mengumpulkan, ini akan membuatkan submission kosong agar bisa dichat.
            $submission = Submission::firstOrCreate(
                [
                    'assignment_id' => $assignment->id,
                    'mahasiswa_id'  => $mahasiswaId
                ]
            );

            // 3. Simpan file jika ada
            $imagePath = $request->hasFile('image') ? $request->file('image')->store('diskusi_tugas', 'public') : null;
            $voicePath = $request->hasFile('voice') ? $request->file('voice')->store('diskusi_tugas', 'public') : null;

            // 4. Buat Pesan di tabel submission_messages
            $message = SubmissionMessage::create([
                'submission_id' => $submission->id,
                'from'          => 'dosen',
                'body'          => $request->body,
                'image'         => $imagePath,
                'voice'         => $voicePath,
            ]);

            // 5. Kembalikan Response ke JS Frontend
            return response()->json([
                'success' => true,
                'diskusi' => [
                    'id'    => $message->id,
                    'body'  => $message->body,
                    'image' => $message->image ? asset('storage/' . $message->image) : null,
                    'voice' => $message->voice ? asset('storage/' . $message->voice) : null,
                    'time'  => $message->created_at->format('H:i')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}