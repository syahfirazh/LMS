<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilDosenController extends Controller
{
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();
        return view('dosen_profile', compact('dosen'));
    }

    public function update(Request $request)
    {
        /** @var Dosen $dosen */
        $dosen = Auth::guard('dosen')->user();

        $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:dosens,email,' . $dosen->id,
            'no_hp' => 'nullable|string|max:20',
            'foto'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['nama', 'email', 'no_hp']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($dosen->foto) {
                Storage::disk('public')->delete($dosen->foto);
            }
            $data['foto'] = $request->file('foto')->store('dosen/foto', 'public');
        }

        $dosen->update($data);

        return back()->with('success', 'Profil dan Email berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        /** @var Dosen $dosen */
        $dosen = Auth::guard('dosen')->user();

        // Cek apakah password lama benar
        if (!Hash::check($request->current_password, $dosen->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $dosen->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
}