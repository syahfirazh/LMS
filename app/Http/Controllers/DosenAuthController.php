<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dosen;
use Laravel\Socialite\Facades\Socialite;

class DosenAuthController extends Controller
{
    // =======================================================
    // 1. LOGIN MANUAL (BISA EMAIL ATAU NIDN)
    // =======================================================
    public function login(Request $request)
    {
        // Ubah 'nidn' di frontend kamu menjadi name="login_id" (atau sesuaikan)
        $loginId = $request->input('login_id'); 
        $password = $request->input('password');

        // Cek apakah yang diketik user adalah format email, kalau bukan anggap itu NIDN
        $fieldType = filter_var($loginId, FILTER_VALIDATE_EMAIL) ? 'email' : 'nidn';

        if (Auth::guard('dosen')->attempt([$fieldType => $loginId, 'password' => $password])) {
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'redirect' => route('dosen.dashboard')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email/NIDN atau password salah'
        ], 401);
    }

    // =======================================================
    // 2. REDIRECT KE HALAMAN GOOGLE
    // =======================================================
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // =======================================================
    // 3. PROSES DATA BALIKAN DARI GOOGLE
    // =======================================================
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Cari Dosen berdasarkan email Google yang diklik
            $dosen = Dosen::where('email', $googleUser->getEmail())->first();

            if ($dosen) {
                // Update google_id jika sebelumnya kosong
                if (!$dosen->google_id) {
                    $dosen->update(['google_id' => $googleUser->getId()]);
                }
                
                // Login sebagai dosen
                Auth::guard('dosen')->login($dosen);
                return redirect()->route('dosen.dashboard');
            } else {
                // Jika email tidak terdaftar di database dosen
                return redirect()->route('login.dosen')->with('error', 'Email tidak terdaftar sebagai Dosen. Hubungi Admin.');
            }
        } catch (\Exception $e) {
            return redirect()->route('login.dosen')->with('error', 'Gagal login dengan Google.');
        }
    }
}