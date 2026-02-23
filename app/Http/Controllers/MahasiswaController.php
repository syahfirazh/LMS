<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use App\Models\CourseSession;
use App\Models\User;
use App\Models\Message;

class MahasiswaController extends Controller
{
    // ============================
    // JOIN KELAS (KODE AKSES)
    // ============================
    public function joinKelas(Request $request)
    {
        $request->validate([
            'kode_akses' => 'required|string'
        ]);

        $kelas = Kelas::where('kode_akses', $request->kode_akses)->first();

        if (!$kelas) {
            return back()->with('error', 'Kode tidak ditemukan');
        }

        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($kelas->mahasiswa()->where('mahasiswa_id', $mahasiswa->id)->exists()) {
            return back()->with('error', 'Sudah tergabung');
        }

        $kelas->mahasiswa()->attach($mahasiswa->id);

        return back()->with('success', 'Berhasil bergabung');
    }

    // ============================
    // ALTERNATIF JOIN
    // ============================
    public function joinByCode(Request $request)
    {
        $request->validate([
            'kode_akses' => 'required|string'
        ]);

        $kelas = Kelas::where('kode_akses', $request->kode_akses)->first();

        if (!$kelas) {
            return back()->with('error', 'Kode tidak valid');
        }

        $mahasiswa = Auth::guard('mahasiswa')->user();

        if ($kelas->mahasiswa()->where('mahasiswa_id', $mahasiswa->id)->exists()) {
            return back()->with('error', 'Sudah tergabung');
        }

        $kelas->mahasiswa()->attach($mahasiswa->id);

        return back()->with('success', 'Berhasil bergabung');
    }

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
            ->with('mataKuliah')
            ->get()
            ->map(function ($k, $i) {
                return [
                    'nomor'      => $i + 1,
                    'id'         => $k->id,
                    'nama'       => $k->mataKuliah->nama ?? '-',
                    'kode'       => $k->mataKuliah->kode ?? '-',
                    'sks'        => $k->mataKuliah->sks ?? 0,
                    'deskripsi'  => $k->mataKuliah->deskripsi ?? '',
                    'progress'   => 0, // ❗ real progress dihitung di detail
                ];
            });

        return view('courses', compact('kelas'));
    }

    // ============================
    // DETAIL KELAS + PROGRESS
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

        // ============================
        // HITUNG PROGRESS
        // ============================

        $totalSession = $kelas->courseSessions->count();
        $completedSession = 0;

        foreach ($kelas->courseSessions as $session) {
            // dianggap selesai jika punya materi
            if (method_exists($session, 'materis') && $session->materis()->exists()) {
                $completedSession++;
            } else {
                break;
            }
        }

        $progress = $totalSession > 0
            ? round(($completedSession / $totalSession) * 100)
            : 0;

        return view('course_detail', compact(
            'kelas',
            'progress',
            'completedSession',
            'totalSession'
        ));
    }

    public function topic(Kelas $kelas)
{
    $mahasiswa = Auth::guard('mahasiswa')->user();

    $session = CourseSession::where('kelas_id', $kelas->id)
                ->orderBy('urutan', 'asc')
                ->first();

    $onlineUsers = $kelas->mahasiswa()->get();

    $messages = Message::where(function ($q) use ($mahasiswa, $kelas) {
            $q->where('sender_type', 'mahasiswa')
              ->where('sender_id', $mahasiswa->id)
              ->where('receiver_type', 'dosen')
              ->where('receiver_id', $kelas->dosen_id);
        })
        ->orWhere(function ($q) use ($mahasiswa, $kelas) {
            $q->where('sender_type', 'dosen')
              ->where('sender_id', $kelas->dosen_id)
              ->where('receiver_type', 'mahasiswa')
              ->where('receiver_id', $mahasiswa->id);
        })
        ->orderBy('created_at', 'asc')
        ->get();

    return view('topic_detail', compact(
        'kelas',
        'session',
        'onlineUsers',
        'messages',
        'mahasiswa' // 🔥 TAMBAHKAN INI
    ));
}

public function members($kelasId)
{
    $kelas = Kelas::with([
        'mataKuliah',
        'dosen',
        'mahasiswa',
        'courseSessions'
    ])->findOrFail($kelasId);

    $session = $kelas->courseSessions()
        ->orderBy('urutan')
        ->first();

    return view('course_members', [
        'kelas'        => $kelas,
        'session'      => $session,
        'mataKuliah'   => $kelas->mataKuliah,
        'dosen'        => $kelas->dosen,
        'members'      => $kelas->mahasiswa,
        'totalMembers' => $kelas->mahasiswa->count(),
    ]);
}

public function search(Request $request, $kelasId)
{
    $kelas = Kelas::findOrFail($kelasId);

    $members = $kelas->mahasiswa()
        ->where('nama', 'like', "%{$request->q}%")
        ->get();

    return response()->json($members);
}
}