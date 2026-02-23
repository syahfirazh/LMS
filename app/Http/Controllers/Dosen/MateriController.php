<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\CourseSession;
use Illuminate\Support\Facades\Storage;
use App\Events\MateriCreated;

class MateriController extends Controller
{
    // =========================
    // STORE MATERI (FILE / LINK / VOICE / VIDEO)
    // =========================
    public function store(Request $request, $sessionId)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'type'  => 'required|in:file,link,voice,video',
        'file'  => 'nullable|file',
        'link'  => 'nullable|url'
    ]);

    $session = CourseSession::where('id', $sessionId)
        ->whereHas('kelas', function ($q) {
            $q->where('dosen_id', auth('dosen')->id());
        })
        ->firstOrFail();

    $data = [
        'session_id' => $session->id,
        'judul'      => $request->judul,
        'type'       => $request->type,
    ];

    if ($request->hasFile('file')) {

        $folder = match ($request->type) {
            'voice' => 'materi/voice',
            'video' => 'materi/video',
            default => 'materi/file',
        };

        $data['file'] = $request->file('file')
            ->store($folder, 'public');
    }

    if (in_array($request->type, ['link', 'video']) && $request->link) {
        $data['link'] = $request->link;
    }

    $materi = Materi::create($data);

    // 🔥 FIX DI SINI
    event(new MateriCreated($materi, $materi->session_id));

    return back()->with('success', 'Materi berhasil ditambahkan');
}

    // =========================
    // HAPUS MATERI
    // =========================
    public function destroy($materiId)
    {
        $materi = Materi::where('id', $materiId)
            ->whereHas('session.kelas', function ($q) {
                $q->where('dosen_id', auth('dosen')->id());
            })
            ->firstOrFail();

        if (in_array($materi->type, ['file', 'voice', 'video']) && $materi->file) {
            if (Storage::disk('public')->exists($materi->file)) {
                Storage::disk('public')->delete($materi->file);
            }
        }

        $materi->delete();

        return back()->with('success', 'Materi berhasil dihapus');
    }

    // =========================
    // UPDATE INSTRUKSI SESSION
    // =========================
    public function updateInstruksi(Request $request, $sessionId)
    {
        $request->validate([
            'instruksi' => 'nullable|string'
        ]);

        $session = CourseSession::where('id', $sessionId)
            ->whereHas('kelas', function ($q) {
                $q->where('dosen_id', auth('dosen')->id());
            })
            ->firstOrFail();

        $session->update([
            'instruksi' => $request->instruksi
        ]);

        return back()->with('success', 'Instruksi berhasil diperbarui');
    }
}