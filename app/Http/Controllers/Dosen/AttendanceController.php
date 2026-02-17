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
    protected function authorizeKelas(Kelas $kelas)
    {
        if ($kelas->dosen_id !== auth('dosen')->id()) {
            abort(403, 'Anda tidak berhak mengakses kelas ini');
        }
    }

    /**
     * =========================================================
     * INDEX - HALAMAN ABSENSI PER KELAS
     * =========================================================
     */
    public function index(Kelas $kelas)
    {
        $this->authorizeKelas($kelas);

        $kelas->load(['dosen', 'mataKuliah', 'mahasiswa', 'courseSessions']);

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
    public function history(Kelas $kelas, CourseSession $session)
    {
        $this->authorizeKelas($kelas);

        if ($session->kelas_id !== $kelas->id) {
            abort(404);
        }

        $session->load([
            'attendances.mahasiswa',
            'kelas.mahasiswa',
            'kelas.mataKuliah'
        ]);

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
    public function manual(Kelas $kelas, CourseSession $session)
    {
        $this->authorizeKelas($kelas);

        if ($session->kelas_id !== $kelas->id) {
            abort(404);
        }

        $session->load('kelas.mahasiswa');

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
    public function storeManual(Request $request, Kelas $kelas, CourseSession $session)
    {
        $this->authorizeKelas($kelas);

        if ($session->kelas_id !== $kelas->id) {
            abort(404);
        }

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
            ->route('dosen.attendance.history', [$kelas->id, $session->id])
            ->with('success', 'Presensi berhasil disimpan');
    }

    /**
     * =========================================================
     * SAVE CEPAT
     * =========================================================
     */
    public function save(Request $request, Kelas $kelas, CourseSession $session)
    {
        $this->authorizeKelas($kelas);

        if ($session->kelas_id !== $kelas->id) {
            abort(404);
        }

        if (!$request->attendance) {
            return back()->with('error', 'Tidak ada data presensi.');
        }

        foreach ($request->attendance as $mahasiswaId => $status) {
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
            ->route('dosen.attendance.history', [$kelas->id, $session->id])
            ->with('success', 'Presensi berhasil disimpan.');
    }

    /**
     * =========================================================
     * RESET ABSENSI
     * =========================================================
     */
    public function reset(Kelas $kelas, CourseSession $session)
    {
        $this->authorizeKelas($kelas);

        if ($session->kelas_id !== $kelas->id) {
            abort(404);
        }

        Attendance::where('course_session_id', $session->id)->delete();

        return back()->with('success', 'Presensi berhasil direset.');
    }
}
