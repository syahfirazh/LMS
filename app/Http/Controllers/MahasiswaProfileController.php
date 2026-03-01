<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function update(Request $request)
    {
        // Validasi input form edit kontak
        $request->validate([
            'no_hp' => 'nullable|string|max:20',
            'email_pribadi' => 'nullable|email|max:255',
        ], [
            'email_pribadi.email' => 'Format email pribadi tidak valid.',
        ]);

        // MENGGUNAKAN MODEL LANGSUNG AGAR VS CODE TIDAK ERROR MERAH
        $user = Mahasiswa::find(Auth::guard('mahasiswa')->id());

        // Mengupdate record di database
        $user->no_hp = $request->no_hp;
        $user->email_pribadi = $request->email_pribadi;
        $user->save();

        // Kembalikan ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Informasi kontak berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        // Validasi form ganti password
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'new_password.min' => 'Password baru minimal harus 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        // MENGGUNAKAN MODEL LANGSUNG AGAR VS CODE TIDAK ERROR MERAH
        $user = Mahasiswa::find(Auth::guard('mahasiswa')->id());

        // Pengecekan apakah password lama yang dimasukkan sesuai dengan yang ada di database
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama yang Anda masukkan salah.']);
        }

        // Jika benar, ubah password lama menjadi hash password yang baru
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password Anda berhasil diperbarui!');
    }
}