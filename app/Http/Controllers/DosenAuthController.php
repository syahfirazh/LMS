<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Dosen;

class DosenAuthController extends Controller
{
    public function login(Request $request)
{
    $credentials = $request->only('nidn', 'password');

    if (Auth::guard('dosen')->attempt($credentials)) {
        $request->session()->regenerate();

        return response()->json([
            'redirect' => route('dosen.dashboard')
        ]);
    }

    return response()->json([
        'message' => 'NIDN atau password salah'
    ], 401);
}


}
