<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class MahasiswaNotificationController extends Controller
{
    public function index()
{
    $mahasiswaId = auth()->guard('mahasiswa')->id();

    $notifications = Notification::where('mahasiswa_id', $mahasiswaId)
        ->latest()
        ->get();

    $unreadCount = $notifications->where('is_read', false)->count();

    return view('notifications', compact('notifications', 'unreadCount'));
}

    public function markAllRead()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        Notification::where('user_type', 'mahasiswa')
            ->where('user_id', $mahasiswa->id)
            ->update(['is_read' => true]);

        return back();
    }
}