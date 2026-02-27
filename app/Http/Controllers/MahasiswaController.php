<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Kelas;
use App\Models\CourseSession;
use App\Models\Discussion; 
use App\Models\Dosen;
use App\Models\Submission; 
use App\Models\SubmissionMessage; 
use App\Models\Notification;
use App\Models\DosenNotification;
use App\Models\Assignment;

class MahasiswaController extends Controller
{
    // ============================
    // LIST KELAS MAHASISWA
    // ============================
    public function index()
    {
        /** @var \App\Models\Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if (!$mahasiswa) {
            abort(403, 'Mahasiswa belum login');
        }

        $kelas = $mahasiswa->kelas()
            ->with(['mataKuliah', 'courseSessions.materis'])
            ->get()
            ->map(function ($k, $i) {
                $totalSession = $k->courseSessions->count();
                $completedSession = 0;

                foreach ($k->courseSessions as $session) {
                    if ($session->materis->isNotEmpty()) {
                        $completedSession++;
                    }
                }
                $progress = $totalSession > 0 ? round(($completedSession / $totalSession) * 100) : 0;

                return [
                    'nomor'      => $i + 1,
                    'id'         => $k->id,
                    'nama'       => $k->mataKuliah->nama ?? '-',
                    'kode'       => $k->mataKuliah->kode ?? '-',
                    'sks'        => $k->mataKuliah->sks ?? 0,
                    'deskripsi'  => $k->mataKuliah->deskripsi ?? '',
                    'sampul'     => $k->sampul ?? null,
                    'progress'   => $progress,
                ];
            });

        return view('courses', compact('kelas'));
    }

    // ============================
    // DETAIL KELAS
    // ============================
    public function show($id)
    {
        $kelas = Kelas::with([
            'dosen',
            'mataKuliah',
            'courseSessions' => function ($q) {
                $q->orderBy('urutan', 'asc');
            }
        ])->findOrFail($id);

        $totalSession = $kelas->courseSessions->count();
        $completedSession = 0;

        foreach ($kelas->courseSessions as $sesi) {
            if (method_exists($sesi, 'materis') && $sesi->materis()->exists()) {
                $completedSession++;
            } else {
                break; 
            }
        }

        $progress = $totalSession > 0 ? round(($completedSession / $totalSession) * 100) : 0;
        
        $session = $kelas->courseSessions->first();

        return view('course_detail', compact('kelas', 'progress', 'completedSession', 'totalSession', 'session'));
    }

    // ============================
    // DISKUSI TOPIK KELAS
    // ============================
    public function topic(Kelas $kelas, $sessionId)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        $session = CourseSession::with(['materis', 'discussions.sender'])
                    ->where('kelas_id', $kelas->id)
                    ->where('id', $sessionId)
                    ->firstOrFail();
                    
        $onlineUsers = $kelas->mahasiswa()->count();

        $messages = collect();
        if ($session) {
            $messages = Discussion::where('session_id', $session->id)
                        ->orderBy('created_at', 'asc')
                        ->get();
        }

        return view('topic_detail', compact('kelas', 'session', 'onlineUsers', 'messages', 'mahasiswa'));
    }

    // ============================
    // ANGGOTA KELAS
    // ============================
    public function members(Kelas $kelas)
    {
        $kelas->load(['mataKuliah', 'dosen', 'mahasiswa', 'courseSessions']);
        $session = $kelas->courseSessions()->orderBy('urutan', 'asc')->first();

        return view('course_members', [
            'kelas'        => $kelas,
            'session'      => $session,
            'mataKuliah'   => $kelas->mataKuliah,
            'dosen'        => $kelas->dosen,
            'members'      => $kelas->mahasiswa,
            'totalMembers' => $kelas->mahasiswa->count(),
        ]);
    }

    // ============================
    // PENCARIAN DOSEN UNTUK JAPRI
    // ============================
    public function searchDosen(Request $request)
    {
        $keyword = $request->query('q');

        if (empty(trim($keyword))) {
            return response()->json([]);
        }

        $dosens = Dosen::where('nama', 'LIKE', "%{$keyword}%")
                       ->orWhere('nidn', 'LIKE', "%{$keyword}%") 
                       ->limit(10)
                       ->get(['id', 'nama']); 

        return response()->json($dosens);
    }

    // ============================
    // CHAT DISKUSI PRIVAT TUGAS 
    // ============================
    public function sendMessage(Request $request, $kelasId, $assignmentId)
    {
        try {
            $request->validate([
                'message' => 'nullable|string',
                'image'   => 'nullable|image|max:2048',
                'voice'   => 'nullable|file|max:5120',
            ]);

            /** @var \App\Models\Mahasiswa $mahasiswa */
            $mahasiswa = Auth::guard('mahasiswa')->user();
            $mahasiswaId = $mahasiswa->id;

            $kelasData = Kelas::findOrFail($kelasId);
            $dosenId = $kelasData->dosen_id;

            $submission = Submission::firstOrCreate([
                'assignment_id' => $assignmentId,
                'mahasiswa_id'  => $mahasiswaId
            ]);

            $pathImage = $request->hasFile('image')
                ? $request->file('image')->store('diskusi_tugas/images', 'public')
                : null;

            $pathVoice = $request->hasFile('voice')
                ? $request->file('voice')->store('diskusi_tugas/voices', 'public')
                : null;

            if (!$request->message && !$pathImage && !$pathVoice) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'error' => 'Pesan tidak boleh kosong.']);
                }
                return back()->with('error', 'Pesan tidak boleh kosong.');
            }

            $submissionMessage = SubmissionMessage::create([
                'submission_id' => $submission->id,
                'from'          => 'mahasiswa',
                'body'          => $request->message,
                'image'         => $pathImage,
                'voice'         => $pathVoice,
            ]);

            // NOTIF KE DOSEN (Teks Sederhana)
            try {
                DosenNotification::create([
                    'dosen_id' => $dosenId,
                    'type'     => 'info',
                    'title'    => 'Diskusi Tugas',
                    'message'  => 'Ada 1 pesan diskusi tugas.',
                    'url'      => route('dosen.assignment.grade', ['kelas' => $kelasId, 'assignment' => $assignmentId, 'mahasiswa' => $mahasiswaId]),
                    'is_read'  => false,
                ]);
            } catch (\Exception $notifErr) {
                Log::error("Gagal kirim Notif Chat Tugas: " . $notifErr->getMessage());
            }

            if ($request->ajax() || $request->wantsJson()) {
                $fotoPath = $mahasiswa->foto_profil ?? $mahasiswa->foto ?? null;
                $avatarUrl = $fotoPath ? asset('storage/' . $fotoPath) : null;

                return response()->json([
                    'success' => true,
                    'diskusi' => [
                        'id'            => $submissionMessage->id,
                        'message'       => $submissionMessage->body,
                        'image'         => $submissionMessage->image ? asset('storage/' . $submissionMessage->image) : null,
                        'voice'         => $submissionMessage->voice ? asset('storage/' . $submissionMessage->voice) : null,
                        'time'          => $submissionMessage->created_at->format('H:i'),
                        'from'          => 'mahasiswa',
                        'sender_avatar' => $avatarUrl, 
                    ]
                ]);
            }

            return back()->with('success', 'Pesan berhasil dikirim.');

        } catch (\Exception $e) {
            Log::error("Chat Tugas Error: " . $e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'error' => 'System Error: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    // ============================
    // KUMPULKAN TUGAS
    // ============================
    public function submitAssignment(Request $request, $kelas, $assignment)
    {
        $request->validate([
            'file' => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240',
            'text_submission' => 'nullable|string',
            'voice_submission' => 'nullable|file|mimes:webm|max:10240',
        ]);

        $assignmentData = Assignment::with('kelas')->findOrFail($assignment);
        $kelasData = $assignmentData->kelas;
        $dosenId   = $kelasData->dosen_id;

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('submissions/files', 'public');
        }

        $voicePath = null;
        if ($request->hasFile('voice_submission')) {
            $voicePath = $request->file('voice_submission')->store('submissions/voices', 'public');
        }

        Submission::create([
            'assignment_id'   => $assignmentData->id,
            'mahasiswa_id'    => auth()->guard('mahasiswa')->id(),
            'file_path'       => $filePath,
            'text_submission' => $request->text_submission,
            'voice_path'      => $voicePath,
            'status'          => 'submitted',
        ]);

        // NOTIF KE DOSEN (Teks Sederhana)
        try {
            DosenNotification::create([
                'dosen_id' => $dosenId,
                'type'     => 'success',
                'title'    => 'Tugas',
                'message'  => 'Ada 1 tugas dikumpulkan.',
                'url'      => route('dosen.assignment.grade', ['kelas' => $kelasData->id, 'assignment' => $assignmentData->id, 'mahasiswa' => auth()->guard('mahasiswa')->id()]),
                'is_read'  => false,
            ]);
        } catch (\Exception $e) {
            Log::error("Notif Submit Tugas Error: " . $e->getMessage());
        }

        return back()->with('success', 'Tugas berhasil dikumpulkan.');
    }
}