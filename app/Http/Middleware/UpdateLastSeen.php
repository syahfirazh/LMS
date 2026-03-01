<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\User; // Tambahkan ini agar editor mengenali model User

class UpdateLastSeen
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            
            /** @var User $user */ // Komentar ini yang menghilangkan error merah di text editor
            $user = Auth::user();

            // Cek apakah last_seen masih kosong, atau apakah sudah lewat 5 menit sejak update terakhir
            if (!$user->last_seen || Carbon::parse($user->last_seen)->diffInMinutes(now()) >= 5) {
                
                // Matikan sementara kolom 'updated_at' agar tidak ikut ter-update
                $user->timestamps = false; 
                
                $user->last_seen = now();
                $user->save();
                
                // Nyalakan kembali timestamps untuk berjaga-jaga pada proses selanjutnya
                $user->timestamps = true; 
            }
        }

        return $next($request);
    }
}