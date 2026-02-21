<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseSession;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            'message' => 'Status tidak valid.'
        ], 400);
    }

    // ✅ Gunakan guard mahasiswa
    $mahasiswa = auth('mahasiswa')->user();

    if (!$mahasiswa) {
        return response()->json([
            'message' => 'Akses hanya untuk mahasiswa.'
        ], 403);
    }

    $attendance = Attendance::where('course_session_id', $id)
        ->where('mahasiswa_id', $mahasiswa->id)
        ->first();

    if ($attendance) {
        $attendance->update([
            'status' => $status
        ]);
    } else {
        Attendance::create([
            'course_session_id' => $id,
            'mahasiswa_id'      => $mahasiswa->id,
            'status'            => $status
        ]);
    }

    return response()->json([
        'message' => 'Presensi berhasil dicatat sebagai ' . ucfirst($status)
    ]);
}

public function attendance($id)
{
    $session = CourseSession::with([
        'kelas.mataKuliah',
        'kelas.dosen',
        'attendances'
    ])->findOrFail($id);

    $mahasiswa = Auth::guard('mahasiswa')->user();

    $myAttendance = Attendance::where('course_session_id', $id)
        ->where('mahasiswa_id', $mahasiswa->id)
        ->first();

    $stats = [
        'hadir' => $session->attendances()->where('status','hadir')->count(),
        'izin'  => $session->attendances()->where('status','izin')->count(),
        'sakit' => $session->attendances()->where('status','sakit')->count(),
        'alpha' => $session->attendances()->where('status','alpha')->count(),
    ];

    return view('course_attendance', compact(
        'session',
        'stats',
        'myAttendance'
    ));
}
}
