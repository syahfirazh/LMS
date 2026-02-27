<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class MahasiswaNotificationController extends Controller
{
    public function index()
    {
        $mahasiswaId = Auth::guard('mahasiswa')->id();

        // Mengambil data yang cocok dengan mahasiswa_id ATAU kombinasi user_id & user_type
        $notifications = Notification::where('mahasiswa_id', $mahasiswaId)
                                     ->orWhere(function($query) use ($mahasiswaId) {
                                         $query->where('user_id', $mahasiswaId)
                                               ->where('user_type', 'mahasiswa');
                                     })
                                     ->orderBy('created_at', 'DESC')
                                     ->get();

        $unreadCount = $notifications->where('is_read', false)->count();

        return view('notifications', compact('notifications', 'unreadCount'));
    }

    public function markAllRead()
    {
        $mahasiswaId = Auth::guard('mahasiswa')->id();

        // Menandai pesan terbaca untuk mahasiswa_id ATAU kombinasi user_id & user_type
        Notification::where('mahasiswa_id', $mahasiswaId)
                    ->orWhere(function($query) use ($mahasiswaId) {
                        $query->where('user_id', $mahasiswaId)
                              ->where('user_type', 'mahasiswa');
                    })
                    ->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi ditandai telah dibaca.');
    }
}