<?php

use App\Models\Notification;

if (!function_exists('notifyMahasiswa')) {
    function notifyMahasiswa(
        int $mahasiswaId,
        string $type,
        string $title,
        string $message,
        ?string $url = null
    ): void {

        $mahasiswa = \App\Models\Mahasiswa::findOrFail($mahasiswaId);

        Notification::create([
            'mahasiswa_id' => $mahasiswaId,
            'type'         => $type,
            'title'        => $title,
            'message'      => $message,
            'url'          => $url,
            'is_read'      => false,
        ]);
    }
}