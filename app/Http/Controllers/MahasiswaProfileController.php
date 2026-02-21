<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;

class MahasiswaProfileController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if (!$mahasiswa) {
            abort(403, 'Profil harus diakses melalui controller MahasiswaProfileController');
        }

        return view('profile', compact('mahasiswa'));
    }
}