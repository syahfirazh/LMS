<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    protected function authorizeKelas(Kelas $kelas)
    {
        if ($kelas->dosen_id !== auth('dosen')->id()) {
            abort(403, 'Anda tidak berhak mengakses kelas ini');
        }
    }

   public function index(Kelas $kelas)
{
    $this->authorizeKelas($kelas);

    $assignments = $kelas->assignments()->latest()->get();

    return view('dosen_course_assignments', compact('kelas', 'assignments'));
}

     public function show($kelasId, $assignmentId)
{
    $kelas = Kelas::findOrFail($kelasId);

    $assignment = Assignment::where('kelas_id', $kelasId)
        ->findOrFail($assignmentId);

    $mahasiswaId = Auth::guard('mahasiswa')->id();

    $submission = Submission::with(['messages' => function($q) {
        $q->orderBy('created_at', 'asc');
    }])
    ->where('assignment_id', $assignmentId)
    ->where('mahasiswa_id', $mahasiswaId)
    ->first();

    return view('assignment_detail', compact('kelas', 'assignment', 'submission'));
}

    public function create(Kelas $kelas)
    {
        $this->authorizeKelas($kelas);
        return view('dosen_create_assignment', compact('kelas'));
    }

    public function store(Request $request, Kelas $kelas)
    {
        $this->authorizeKelas($kelas);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline_tanggal' => 'required|date',
            'deadline_jam' => 'required',
            'poin' => 'required|integer|min:1',
            'tipe_pengumpulan' => 'required|in:file,text,both',
            'file' => 'nullable|file|max:10240',
        ]);

        $deadline = $request->deadline_tanggal . ' ' . $request->deadline_jam;

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments', 'public');
        }

        $assignment = $kelas->assignments()->create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $deadline,
            'poin' => $request->poin,
            'tipe_pengumpulan' => $request->tipe_pengumpulan,
            'file_path' => $filePath,
            'status' => $request->action === 'publish' ? 'published' : 'draft',
        ]);

       $dosenNama      = $kelas->dosen->nama;
$mataKuliahNama = $kelas->mataKuliah->nama;

// AMBIL SESSION ID DARI ASSIGNMENT

foreach ($kelas->mahasiswa as $mhs) {
    notifyMahasiswa(
    $mhs->id,
    'assignment',
    'Tugas Baru Tersedia',
    "Dosen {$dosenNama} menambahkan tugas baru pada mata kuliah {$mataKuliahNama}: {$assignment->judul}",
    route('mahasiswa.assignment.detail', [
        'kelas' => $kelas->id,
        'assignment' => $assignment->id
    ])
);
}

        return redirect()
            ->route('dosen.course.assignments', $kelas->id)
            ->with('success', 'Tugas berhasil dibuat.');
    }

    public function edit(Kelas $kelas, $assignmentId)
    {
        $this->authorizeKelas($kelas);

        $assignment = $kelas->assignments()->findOrFail($assignmentId);
        return view('dosen_edit_assignment', compact('kelas', 'assignment'));
    }

    public function update(Request $request, Kelas $kelas, $assignmentId)
    {
        $this->authorizeKelas($kelas);

        $assignment = $kelas->assignments()->findOrFail($assignmentId);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline_tanggal' => 'required|date',
            'deadline_jam' => 'required',
            'poin' => 'required|integer|min:0',
            'tipe_pengumpulan' => 'required|in:file,text,both',
            'file' => 'nullable|file|max:10240',
        ]);

        $assignment->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline_tanggal . ' ' . $request->deadline_jam,
            'poin' => $request->poin,
            'tipe_pengumpulan' => $request->tipe_pengumpulan,
        ]);

        if ($request->hasFile('file')) {
            if ($assignment->file_path && Storage::disk('public')->exists($assignment->file_path)) {
                Storage::disk('public')->delete($assignment->file_path);
            }

            $assignment->file_path = $request->file('file')->store(
                'assignments',
                'public'
            );
            $assignment->save();
        }

        return redirect()
            ->route('dosen.course.assignments', $kelas->id)
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    public function publish(Kelas $kelas, $assignmentId)
    {
        $this->authorizeKelas($kelas);

        $assignment = $kelas->assignments()->findOrFail($assignmentId);
        $assignment->update(['status' => 'published']);

        foreach ($kelas->mahasiswa as $mhs) {
            notifyMahasiswa(
                $mhs->id,
                'assignment',
                'Tugas Baru Tersedia',
                "Dosen menambahkan tugas baru: {$assignment->judul}",
                route('mahasiswa.assignment.detail', ['kelas' => $kelas->id,'assignment' => $assignment->id])
            );
        }

        return redirect()
            ->route('dosen.course.assignments', $kelas->id)
            ->with('success', 'Tugas berhasil dipublish.');
    }

    public function destroy(Kelas $kelas, $assignmentId)
    {
        $this->authorizeKelas($kelas);

        $assignment = $kelas->assignments()->findOrFail($assignmentId);

        if ($assignment->file_path && Storage::disk('public')->exists($assignment->file_path)) {
            Storage::disk('public')->delete($assignment->file_path);
        }

        $assignment->delete();

        return redirect()
            ->route('dosen.course.assignments', $kelas->id)
            ->with('success', 'Tugas berhasil dihapus.');
    }

    public function recap($kelas_id)
    {
        $kelas = Kelas::with(['mataKuliah', 'dosen', 'mahasiswa'])->findOrFail($kelas_id);

        $assignments = Assignment::with('submissions')
            ->where('kelas_id', $kelas_id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('dosen_assignment_recap', compact('kelas', 'assignments'));
    }
}