<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseSession;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Assignment;
use App\Models\Kelas;

class AttendanceController extends Controller
{
    public function index($sessionId)
{
    $session = CourseSession::with('attendances')
        ->findOrFail($sessionId);

    $mahasiswa = auth('mahasiswa')->user();

    $myAttendance = Attendance::where('course_session_id', $sessionId)
        ->where('mahasiswa_id', $mahasiswa->id)
        ->first();

    $stats = [
        'hadir' => $session->attendances()->where('status', 'hadir')->count(),
        'izin'  => $session->attendances()->where('status', 'izin')->count(),
        'sakit' => $session->attendances()->where('status', 'sakit')->count(),
        'alpha' => $session->attendances()->where('status', 'alpha')->count(),
    ];

    return view('mahasiswa.presensi', compact(
        'session',
        'stats',
        'myAttendance'
    ));
}

public function store($id, $status)
{
    $allowed = ['hadir', 'izin', 'sakit'];

    if (!in_array($status, $allowed)) {
        return response()->json([
            'message' => 'Status tidak valid'
        ], 400);
    }

    $mahasiswa = auth('mahasiswa')->user();

    if (!$mahasiswa) {
        return response()->json([
            'message' => 'Akses hanya untuk mahasiswa'
        ], 403);
    }

    $session = CourseSession::findOrFail($id);

    $attendance = Attendance::updateOrCreate(
        [
            'course_session_id' => $id,
            'mahasiswa_id' => $mahasiswa->id,
        ],
        [
            'status' => $status,
            'waktu_absen' => now(), // ✅ PENTING
        ]
    );

    return response()->json([
        'message' => 'Presensi berhasil dicatat sebagai ' . ucfirst($status)
    ]);
}

    /**
     * Halaman presensi mahasiswa
     */
   public function attendance($id)
{
    $session = CourseSession::with([
        'kelas.mataKuliah',
        'kelas.dosen',
    ])->findOrFail($id);

    $mahasiswa = auth('mahasiswa')->user();

    // 🔹 Ambil semua sesi dalam kelas urut ASC (1,2,3,...)
    $allSessions = CourseSession::where('kelas_id', $session->kelas_id)
        ->orderBy('urutan', 'asc')
        ->get();

    // 🔹 Ambil sesi terbaru (urutan terbesar)
    $currentSession = $allSessions->last();

    // 🔹 Susun: terbaru di atas, sisanya tetap ASC
    $sessions = collect([$currentSession])
        ->merge(
            $allSessions->where('id', '!=', optional($currentSession)->id)
        );

    // 🔹 Ambil semua attendance mahasiswa untuk semua sesi
    $myAttendances = Attendance::whereIn('course_session_id', $allSessions->pluck('id'))
        ->where('mahasiswa_id', $mahasiswa->id)
        ->get()
        ->keyBy('course_session_id');

    // 🔹 Hitung statistik sinkron
    $stats = [
        'hadir' => $myAttendances->where('status', 'hadir')->count(),
        'izin'  => $myAttendances->where('status', 'izin')->count(),
        'sakit' => $myAttendances->where('status', 'sakit')->count(),
        'alpha' => $allSessions->count() - $myAttendances->count(),
    ];

    return view('course_attendance', compact(
        'session',
        'sessions',
        'currentSession',
        'stats',
        'myAttendances'
    ));
}  

public function assignments(Kelas $kelas)
{
    // Ambil sesi terbaru (karena Blade butuh $session)
    $session = CourseSession::where('kelas_id', $kelas->id)
        ->latest()
        ->first();

    if (!$session) {
        abort(404, 'Sesi kelas belum tersedia');
    }

    // Ambil tugas aktif
    $assignments = Assignment::where('kelas_id', $kelas->id)
        ->where('status', 'published')
        ->orderBy('deadline')
        ->get();

    return view('course_assignments', compact(
        'kelas',
        'session',
        'assignments'
    ));
}
}
