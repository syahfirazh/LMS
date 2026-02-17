<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\CourseSession;
use App\Models\User;

class CourseSessionController extends Controller
{
    /**
     * 🔒 Helper: pastikan kelas milik dosen login
     */
    protected function authorizeKelas(Kelas $kelas)
    {
        if ($kelas->dosen_id !== auth('dosen')->id()) {
            abort(403, 'Anda tidak berhak mengakses kelas ini');
        }
    }

    /**
     * =====================================================
     * DETAIL SESSION (AMAN, BERDASARKAN SESSION ID)
     * =====================================================
     */
    public function show($sessionId)
    {
        $session = CourseSession::with(['materis', 'discussions.user', 'kelas.mataKuliah'])
            ->whereHas('kelas', function ($q) {
                $q->where('dosen_id', auth('dosen')->id());
            })
            ->findOrFail($sessionId);

        $kelas = $session->kelas;

        $this->authorizeKelas($kelas);

        // Hitung user online (aktif 5 menit terakhir)
        $onlineUsers = User::where('last_seen', '>=', now()->subMinutes(5))->count();

        return view('dosen.session.detail', compact('session', 'kelas', 'onlineUsers'));
    }

    /**
     * =====================================================
     * DETAIL SESSION (BERDASARKAN KELAS + SESSION)
     * =====================================================
     */
    public function detail($kelasId, $sessionId)
    {
        $kelas = Kelas::where('id', $kelasId)
            ->where('dosen_id', auth('dosen')->id())
            ->firstOrFail();

        $session = $kelas->courseSessions()
            ->with(['materis', 'discussions.user', 'kelas.mataKuliah'])
            ->findOrFail($sessionId);

        // Hitung user online
        $onlineUsers = User::where('last_seen', '>=', now()->subMinutes(5))->count();

        return view('dosen_manage_session_detail', compact('session', 'kelas', 'onlineUsers'));
    }
}
