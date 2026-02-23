<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\CourseSession;

Broadcast::channel('session.{sessionId}', function ($user, $sessionId) {

    $session = CourseSession::find($sessionId);
    if (!$session) return false;

    // cek dosen
    if ($user instanceof \App\Models\Dosen) {
        return $session->kelas->dosen_id === $user->id;
    }

    // cek mahasiswa
    if ($user instanceof \App\Models\Mahasiswa) {
        return $session->kelas->mahasiswas
            ->contains('id', $user->id);
    }

    return false;
});
