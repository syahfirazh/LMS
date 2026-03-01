<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\SubmissionMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; // Wajib ditambahkan untuk hapus file lama
use App\Models\Notification;

class AssignmentController extends Controller
{
    /**
     * 🔒 [KEAMANAN: IDOR PROTECTION]
     * Helper: Pastikan mahasiswa benar-benar terdaftar di kelas yang diakses
     */
    protected function cekAksesKelas($kelasId)
    {
        $mahasiswaId = Auth::guard('mahasiswa')->id();
        $kelas = Kelas::findOrFail($kelasId);
        
        // Cek relasi di tabel pivot
        if (!$kelas->mahasiswa()->where('mahasiswa_id', $mahasiswaId)->exists()) {
            abort(403, 'Akses Ditolak: Anda bukan peserta kelas ini.');
        }
        
        return $kelas;
    }

    // 1. FUNGSI INDEX (MENAMPILKAN DAFTAR TUGAS)
    public function index($kelasId)
    {
        $kelas = $this->cekAksesKelas($kelasId); // Gunakan helper keamanan
        $assignments = Assignment::where('kelas_id', $kelasId)->orderBy('deadline', 'asc')->get();
        
        // Ambil sesi pertama untuk kebutuhan layout sidebar (jika ada)
        $session = $kelas->courseSessions()->orderBy('urutan')->first();

        return view('course_assignments', compact('kelas', 'assignments', 'session'));
    }

    // 2. FUNGSI SHOW (MENAMPILKAN DETAIL TUGAS)
    public function show($kelasId, $assignmentId)
    {
        $kelas = $this->cekAksesKelas($kelasId); // Gunakan helper keamanan

        $assignment = Assignment::where('kelas_id', $kelasId)
            ->findOrFail($assignmentId);

        $mahasiswaId = Auth::guard('mahasiswa')->id();

        $submission = Submission::with(['messages' => function($q) {
            $q->orderBy('created_at', 'asc');
        }])->where('assignment_id', $assignmentId)
          ->where('mahasiswa_id', $mahasiswaId)
          ->first();

        // Bisa jadi tugas ini tidak terikat session spesifik, atau session-nya null
        $session = $assignment->session ?? $kelas->courseSessions()->orderBy('urutan')->first();

        return view('assignment_detail', compact(
            'kelas',
            'assignment',
            'submission',
            'session'
        ));
    }

    // 3. FUNGSI STORE (PENGUMPULAN & KIRIM ULANG TUGAS)
    public function store(Request $request, $kelasId, $assignmentId)
    {
        $kelas = $this->cekAksesKelas($kelasId); // Gunakan helper keamanan

        /** @var \App\Models\Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        // Cek apakah mahasiswa sudah pernah mengumpulkan tugas ini sebelumnya
        $submission = Submission::where('assignment_id', $assignmentId)
                                ->where('mahasiswa_id', $mahasiswa->id)
                                ->first();

        if ($submission) {
            // [PERBAIKAN] Jika sedang "Kirim Ulang", hapus file & voice lama di server agar storage tidak bengkak
            if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
                Storage::disk('public')->delete($submission->file_path);
            }
            if ($submission->voice_submission && Storage::disk('public')->exists($submission->voice_submission)) {
                Storage::disk('public')->delete($submission->voice_submission);
            }

            // Kosongkan data di database agar bersih sebelum ditimpa yang baru
            $submission->file_path = null;
            $submission->text_submission = null;
            $submission->voice_submission = null;
        } else {
            // Jika baru pertama kali kumpul, buat data baru
            $submission = new Submission();
            $submission->assignment_id = $assignmentId;
            $submission->mahasiswa_id = $mahasiswa->id;
        }

        // Masukkan data jawaban yang baru
        if ($request->hasFile('file')) {
            $submission->file_path = $request->file('file')->store('assignments/files', 'public');
        }
        if ($request->filled('text_submission')) {
            $submission->text_submission = $request->text_submission;
        }
        if ($request->hasFile('voice_submission')) {
            $submission->voice_submission = $request->file('voice_submission')->store('assignments/voices', 'public');
        }

        $submission->save();

        // Notifikasi ke Dosen
        try {
            if ($kelas->dosen_id) {
                Notification::create([
                    'user_id'   => $kelas->dosen_id,
                    'user_type' => 'dosen',
                    'type'      => 'info',
                    'title'     => 'Tugas Terkumpul / Diperbarui',
                    'message'   => 'Mahasiswa <b>' . $mahasiswa->nama . '</b> telah mengumpulkan/memperbarui jawaban tugasnya.',
                    'is_read'   => false,
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Gagal mengirim notif kumpul tugas: " . $e->getMessage());
        }

        return back()->with('success', 'Tugas berhasil dikumpulkan!');
    }

    // 4. FUNGSI SEND MESSAGE (KIRIM CHAT DISKUSI PRIVAT)
    public function sendMessage(Request $request, $kelasId, $assignmentId)
    {
        try {
            $kelas = $this->cekAksesKelas($kelasId); // Gunakan helper keamanan

            $request->validate([
                'message' => 'nullable|string',
                'image'   => 'nullable|image|max:2048',
                'voice'   => 'nullable|file|max:5120',
            ]);

            /** @var \App\Models\Mahasiswa $mahasiswa */
            $mahasiswa = Auth::guard('mahasiswa')->user();
            
            $submission = Submission::firstOrCreate([
                'assignment_id' => $assignmentId,
                'mahasiswa_id'  => $mahasiswa->id
            ]);

            $pathImage = $request->hasFile('image') ? $request->file('image')->store('diskusi_tugas/images', 'public') : null;
            $pathVoice = $request->hasFile('voice') ? $request->file('voice')->store('diskusi_tugas/voices', 'public') : null;

            if (!$request->message && !$pathImage && !$pathVoice) {
                return response()->json(['error' => 'Pesan tidak boleh kosong.'], 422);
            }

            $message = SubmissionMessage::create([
                'submission_id' => $submission->id,
                'from'          => 'mahasiswa', 
                'body'          => $request->message,
                'image'         => $pathImage,
                'voice'         => $pathVoice,
            ]);

            try {
                if ($kelas->dosen_id) {
                    Notification::create([
                        'user_id'   => $kelas->dosen_id,
                        'user_type' => 'dosen',
                        'type'      => 'info',
                        'title'     => 'Pesan Diskusi Tugas Baru',
                        'message'   => 'Mahasiswa <b>' . $mahasiswa->nama . '</b> mengirim pesan pada diskusi tugas.',
                        'is_read'   => false,
                    ]);
                }
            } catch (\Exception $e) {
                Log::error("Gagal mengirim notif chat tugas: " . $e->getMessage());
            }

            $fotoPath = $mahasiswa->foto_profil ?? $mahasiswa->foto ?? null;
            $avatarUrl = $fotoPath ? asset('storage/' . $fotoPath) : null;

            return response()->json([
                'success' => true,
                'diskusi' => [
                    'id'            => $message->id,
                    'message'       => $message->body, 
                    'image'         => $message->image ? asset('storage/' . $message->image) : null,
                    'voice'         => $message->voice ? asset('storage/' . $message->voice) : null,
                    'time'          => $message->created_at->format('H:i'),
                    'from'          => 'mahasiswa',
                    'sender_avatar' => $avatarUrl
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Backend Error: ' . $e->getMessage()], 500);
        }
    }
}