<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Attendance;
use App\Models\CourseSession;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * 🔒 Pastikan kelas milik dosen login
     */
    protected function authorizeKelas($kelas)
    {
        $loggedInId = auth()->guard('dosen')->id() ?? auth()->id();
        
        if ($kelas->dosen_id != $loggedInId) {
            abort(403, "Anda tidak berhak mengakses kelas ini.");
        }
    }

    /**
     * =========================================================
     * INDEX - HALAMAN ABSENSI PER KELAS
     * =========================================================
     */
    public function index($kelas_id)
    {
        $kelas = Kelas::with(['dosen', 'mataKuliah', 'mahasiswa', 'courseSessions'])->findOrFail($kelas_id);
        $this->authorizeKelas($kelas);

        $totalMahasiswa = $kelas->mahasiswa->count();

        $sessions = $kelas->courseSessions()
            ->orderBy('urutan', 'asc')
            ->get();

        // Pertemuan aktif = urutan terbesar
        $todaySession = $sessions->sortByDesc('urutan')->first();

        if ($todaySession) {
            $todaySession->pertemuan = $todaySession->urutan;
        }

        $riwayat = $sessions->count() > 1
            ? $sessions->slice(0, -1)->reverse()
            : collect();

        $session1 = $riwayat->first();

        // 🔧 STATUS DISERAGAMKAN (H, I, S, A)
        $hadir1 = $session1
            ? $session1->attendances()->where('status', 'H')->count()
            : 0;

        return view('dosen_course_attendance', compact(
            'kelas',
            'todaySession',
            'riwayat',
            'session1',
            'hadir1',
            'totalMahasiswa'
        ));
    }

    /**
     * =========================================================
     * HISTORY - RIWAYAT ABSENSI PER SESSION
     * =========================================================
     */
    public function history($session_id)
    {
        $session = CourseSession::with([
            'attendances.mahasiswa',
            'kelas.mahasiswa',
            'kelas.mataKuliah'
        ])->findOrFail($session_id);

        $this->authorizeKelas($session->kelas);

        $kelas = $session->kelas;

        $rekap = [
            'hadir' => $session->attendances->where('status', 'H')->count(),
            'izin'  => $session->attendances->where('status', 'I')->count(),
            'sakit' => $session->attendances->where('status', 'S')->count(),
            'alpha' => $session->attendances->where('status', 'A')->count(),
        ];

        $detail = $kelas->mahasiswa->map(function ($mhs) use ($session) {
            $absen = $session->attendances
                ->firstWhere('mahasiswa_id', $mhs->id);

            return (object) [
                'nim'    => $mhs->nim,
                'nama'   => $mhs->nama,
                'status' => $absen->status ?? 'A',
            ];
        });

        return view('dosen_attendance_history', compact(
            'kelas',
            'session',
            'rekap',
            'detail'
        ));
    }

    /**
     * =========================================================
     * FORM INPUT MANUAL
     * =========================================================
     */
    public function manual($session_id)
    {
        $session = CourseSession::with('kelas.mahasiswa')->findOrFail($session_id);
        
        $this->authorizeKelas($session->kelas);

        $kelas = $session->kelas;
        $mahasiswa = $kelas->mahasiswa;

        $attendances = Attendance::where('course_session_id', $session->id)
            ->get()
            ->keyBy('mahasiswa_id');

        return view('dosen_attendance_input', compact(
            'kelas',
            'session',
            'mahasiswa',
            'attendances'
        ));
    }

    /**
     * =========================================================
     * SIMPAN MANUAL
     * =========================================================
     */
    public function storeManual(Request $request, $session_id)
    {
        $session = CourseSession::with('kelas')->findOrFail($session_id);
        $this->authorizeKelas($session->kelas);

        $validated = $request->validate([
            'attendance'   => 'required|array',
            'attendance.*' => 'required|in:H,I,S,A'
        ]);

        foreach ($validated['attendance'] as $mahasiswaId => $status) {
            Attendance::updateOrCreate(
                [
                    'course_session_id' => $session->id,
                    'mahasiswa_id'      => $mahasiswaId,
                ],
                [
                    'status' => $status
                ]
            );
        }

        return redirect()
            ->route('dosen.attendance.history', $session->id)
            ->with('success', 'Presensi berhasil disimpan');
    }
}