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
        $request->validate([
            'body' => 'required|string'
        ]);

        // 🔒 Pastikan submission milik kelas dosen
        $submission = Submission::where('id', $submissionId)
            ->whereHas('assignment.kelas', function ($q) {
                $q->where('dosen_id', auth('dosen')->id());
            })
            ->firstOrFail();

        Message::create([
            'submission_id' => $submission->id,
            'from' => 'dosen',
            'body' => $request->body
        ]);

        return back()->with('success', 'Pesan berhasil dikirim');
    }
}
