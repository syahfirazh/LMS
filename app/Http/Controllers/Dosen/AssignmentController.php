<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

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

        $kelas->loadCount('mahasiswa');

        $assignments = $kelas->assignments()
            ->withCount(['submissions' => function ($query) {
                $query->whereNotNull('file_path')
                      ->orWhereNotNull('text_submission')
                      ->orWhereNotNull('voice_submission');
            }])
            ->latest()
            ->get();

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

        // MENGIRIM NOTIFIKASI SECARA AMAN
        try {
            $dosenNama      = $kelas->dosen->nama ?? 'Dosen';
            $mataKuliahNama = $kelas->mataKuliah->nama ?? 'Kelas';

            foreach ($kelas->mahasiswa as $mhs) {
                Notification::create([
                    'user_id'   => $mhs->id,
                    'user_type' => 'mahasiswa',
                    'type'      => 'info',
                    'title'     => 'Tugas Baru Tersedia',
                    'message'   => "Dosen {$dosenNama} menambahkan tugas baru pada mata kuliah {$mataKuliahNama}: {$assignment->judul}",
                    'is_read'   => false,
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Gagal mengirim notif tugas baru: " . $e->getMessage());
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

        // Tentukan status berdasarkan tombol yang diklik (Publish atau Draft)
        $status = $assignment->status; 
        if ($request->has('action')) {
            $status = $request->action === 'publish' ? 'published' : 'draft';
        }

        $assignment->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline_tanggal . ' ' . $request->deadline_jam,
            'poin' => $request->poin,
            'tipe_pengumpulan' => $request->tipe_pengumpulan,
            'status' => $status,
        ]);

        if ($request->hasFile('file')) {
            if ($assignment->file_path && Storage::disk('public')->exists($assignment->file_path)) {
                Storage::disk('public')->delete($assignment->file_path);
            }

            $assignment->file_path = $request->file('file')->store('assignments', 'public');
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

        try {
            foreach ($kelas->mahasiswa as $mhs) {
                Notification::create([
                    'user_id'   => $mhs->id,
                    'user_type' => 'mahasiswa',
                    'type'      => 'info',
                    'title'     => 'Tugas Baru Tersedia',
                    'message'   => "Dosen menambahkan tugas baru: {$assignment->judul}",
                    'is_read'   => false,
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Gagal mengirim notif tugas dipublish: " . $e->getMessage());
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

   public function exportPdf(\App\Models\Kelas $kelas)
{
    // Pastikan hanya dosen pengampu yang bisa cetak
    if ($kelas->dosen_id !== auth('dosen')->id()) {
        abort(403);
    }

    // Ambil data kelas beserta relasinya
    $kelas->load(['mataKuliah', 'assignments', 'mahasiswa.submissions']);

    // --- PERHATIKAN BAGIAN INI ---
    // Kita harus mengirimkan variabel 'is_pdf' => true agar file Blade
    // tahu bahwa ini sedang mencetak PDF, bukan menampilkan Web.
    $data = [
        'kelas'       => $kelas,
        'assignments' => $kelas->assignments,
        'is_pdf'      => true  // <--- INI KUNCI UTAMANYA BIAR RAPI!
    ];

    // Load view utama (karena kita pakai trik 1 file 2 wajah)
    $pdf = Pdf::loadView('dosen_assignment_recap', $data)
              ->setPaper('a4', 'landscape'); // Bikin kertasnya landscape/miring

    $namaFile = 'Rekap_Tugas_' . str_replace(' ', '_', $kelas->kode_kelas) . '.pdf';

    // Gunakan stream untuk preview di browser
    return $pdf->stream($namaFile);
}
}