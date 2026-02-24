<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use App\Models\CourseSession;
use App\Models\Discussion; 
use App\Models\Message;
use App\Models\Dosen;
use App\Models\Submission; 
use App\Models\SubmissionMessage; 

class MahasiswaController extends Controller
{
    // ============================
    // LIST KELAS MAHASISWA
    // ============================
    public function index()
    {
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
    public function sendMessage(Request $request, $assignmentId)
    {
        try {
            $request->validate([
                'message' => 'nullable|string',
                'image'   => 'nullable|image|max:2048',
                'voice'   => 'nullable|file|max:5120',
            ]);

            $mahasiswaId = auth('mahasiswa')->id();
            
            // JIKA BELUM SUBMIT TUGAS, BUATKAN WADAH SUBMISSION KOSONG
            $submission = Submission::firstOrCreate([
                'assignment_id' => $assignmentId,
                'mahasiswa_id'  => $mahasiswaId
            ]);

            $pathImage = $request->hasFile('image') ? $request->file('image')->store('diskusi_tugas/images', 'public') : null;
            $pathVoice = $request->hasFile('voice') ? $request->file('voice')->store('diskusi_tugas/voices', 'public') : null;

            if (!$request->message && !$pathImage && !$pathVoice) {
                return response()->json(['error' => 'Pesan tidak boleh kosong.'], 422);
            }

            // SIMPAN KE SUBMISSION MESSAGE
            $message = SubmissionMessage::create([
                'submission_id' => $submission->id,
                'from'          => 'mahasiswa', // Sesuaikan dengan kolom 'from' di DB Anda
                'body'          => $request->message, // Pesan masuk ke kolom 'body'
                'image'         => $pathImage,
                'voice'         => $pathVoice,
            ]);

            return response()->json([
                'success' => true,
                'diskusi' => [
                    'id'      => $message->id,
                    'message' => $message->body, 
                    'image'   => $message->image ? asset('storage/' . $message->image) : null,
                    'voice'   => $message->voice ? asset('storage/' . $message->voice) : null,
                    'time'    => $message->created_at->format('H:i'),
                    'from'    => 'mahasiswa'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Backend Error: ' . $e->getMessage()], 500);
        }
    }
}