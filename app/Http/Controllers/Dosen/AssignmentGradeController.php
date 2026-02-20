<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Submission;
use App\Models\Message;

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

    public function sendMessage(Request $request, $submissionId)
    {
        // 🔒 Pastikan submission milik kelas dosen
        $submission = Submission::where('id', $submissionId)
            ->whereHas('assignment.kelas', function ($q) {
                $q->where('dosen_id', auth('dosen')->id());
            })
            ->firstOrFail();

        $pathImage = null;
        $pathVoice = null;

        // Simpan gambar jika ada
        if ($request->hasFile('image')) {
            $pathImage = $request->file('image')->store('diskusi_tugas', 'public');
        }

        // Simpan voice/rekaman suara jika ada
        if ($request->hasFile('voice')) {
            $pathVoice = $request->file('voice')->store('diskusi_tugas', 'public');
        }

        // Simpan pesan ke database
        $message = Message::create([
            'submission_id' => $submission->id,
            'from'          => 'dosen',
            'body'          => $request->body,
            'image'         => $pathImage,
            'voice'         => $pathVoice,
        ]);

        // Jika request berasal dari AJAX (fetch API di frontend)
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => [
                    'id'    => $message->id,
                    'body'  => $message->body,
                    'image' => $message->image ? asset('storage/' . $message->image) : null,
                    'voice' => $message->voice ? asset('storage/' . $message->voice) : null,
                    'time'  => $message->created_at->format('H:i')
                ]
            ]);
        }

        // Fallback jika tidak pakai javascript
        return back()->with('success', 'Pesan berhasil dikirim');
    }
}