<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dosen;

class DosenAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('nidn', 'password');

        // Pastikan menggunakan guard 'dosen'
        if (Auth::guard('dosen')->attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'success' => true, // WAJIB ADA agar dibaca oleh JavaScript
                'redirect' => route('dosen.dashboard')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'NIDN atau password salah'
        ], 401);
    }
}