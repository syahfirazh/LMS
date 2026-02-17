<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;

class MahasiswaAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'password' => 'required'
        ]);

        $mahasiswa = Mahasiswa::where('nim', $request->nim)->first();

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'NIM tidak terdaftar'
            ], 404);
        }

        if (!Hash::check($request->password, $mahasiswa->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Kata sandi salah'
            ], 401);
        }

        Auth::guard('mahasiswa')->login($mahasiswa);

        return response()->json([
            'success' => true,
            'redirect' => route('dashboard')
        ]);
    }
}
