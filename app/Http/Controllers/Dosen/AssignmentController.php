<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    /**
     * 🔒 Pastikan kelas milik dosen login
     */
    protected function authorizeKelas(Kelas $kelas)
    {
        if ($kelas->dosen_id !== auth('dosen')->id()) {
            abort(403, 'Anda tidak berhak mengakses kelas ini');
        }
    }

    /* ===============================
       LIST ASSIGNMENT PER KELAS
    =============================== */
    public function index(Kelas $kelas)
    {
        $this->authorizeKelas($kelas);

        $kelas->loadCount('mahasiswa');

        $assignments = $kelas->assignments()
            ->withCount('submissions')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('dosen_course_assignments', compact('kelas', 'assignments'));
    }

    /* ===============================
       FORM CREATE
    =============================== */
    public function create(Kelas $kelas)
    {
        $this->authorizeKelas($kelas);

        return view('dosen_create_assignment', compact('kelas'));
    }

    /* ===============================
       STORE ASSIGNMENT
    =============================== */
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
            'file' => 'nullable|file|max:10240'
        ]);

        $deadline = $request->deadline_tanggal . ' ' . $request->deadline_jam;

        $filePath = null;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments', 'public');
        }

        $kelas->assignments()->create([
            'kelas_id' => $kelas->id, // 🔒 WAJIB
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $deadline,
            'poin' => $request->poin,
            'tipe_pengumpulan' => $request->tipe_pengumpulan,
            'file_path' => $filePath,
            'status' => $request->action === 'publish' ? 'published' : 'draft',
        ]);

        return redirect()
            ->route('dosen.course.assignments', $kelas->id)
            ->with('success', 'Tugas berhasil dibuat.');
    }

    /* ===============================
       EDIT
    =============================== */
    public function edit(Kelas $kelas, $assignmentId)
    {
        $this->authorizeKelas($kelas);

        $assignment = $kelas->assignments()->findOrFail($assignmentId);

        return view('dosen_edit_assignment', compact('kelas', 'assignment'));
    }

    /* ===============================
       UPDATE
    =============================== */
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

            $assignment->file_path = $request->file('file')->storeAs(
                'assignments',
                uniqid() . '_' . $request->file('file')->getClientOriginalName(),
                'public'
            );

            $assignment->save();
        }

        return redirect()
            ->route('dosen.course.assignments', $kelas->id)
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    /* ===============================
       PUBLISH
    =============================== */
    public function publish(Kelas $kelas, $assignmentId)
    {
        $this->authorizeKelas($kelas);

        $assignment = $kelas->assignments()->findOrFail($assignmentId);

        $assignment->update([
            'status' => 'published'
        ]);

        return redirect()
            ->route('dosen.course.assignments', $kelas->id)
            ->with('success', 'Tugas berhasil dipublish.');
    }

    /* ===============================
       DELETE
    =============================== */
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
            ->with('success', 'Tugas berhasil dihapus');
    }
}
