<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\DosenNotification;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class DosenNotificationController extends Controller
{
    public function index()
{
    $dosenId = Auth::guard('dosen')->id();

    $notifications = DosenNotification::where('dosen_id', $dosenId)
        ->latest()
        ->get();

    return view('dosen_notifications', compact('notifications'));
}

    public function markAllRead()
    {
        $dosenId = Auth::guard('dosen')->id();

        Notification::where('user_type', 'dosen')
            ->where('user_id', $dosenId)
            ->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi ditandai telah dibaca.');
    }

    // 🔥 Tambahan: klik 1 notif → langsung read & redirect
    public function read($id)
    {
        $notif = Notification::findOrFail($id);

        if ($notif->user_type === 'dosen' && $notif->user_id === Auth::guard('dosen')->id()) {
            $notif->update(['is_read' => true]);
        }

        return redirect($notif->url ?? route('dosen.dashboard'));
    }
}