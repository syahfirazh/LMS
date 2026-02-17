<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilDosenController extends Controller
{
    public function index()
{
    /** @var \App\Models\Dosen $dosen */
    $dosen = auth()->guard('dosen')->user();

    return view('dosen_profile', compact('dosen'));
}

public function edit()
{
    /** @var \App\Models\Dosen $dosen */
    $dosen = auth()->guard('dosen')->user();

    return view('dosen_profile_edit', compact('dosen'));
}


    public function update(Request $request)
    {
        /** @var Dosen $dosen */
        $dosen = auth()->guard('dosen')->user();

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'nidn' => 'required|string|max:50',
            'homebase' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'bidang_keahlian' => 'nullable|array',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('dosen', 'public');
        }

        $dosen->update($data);

        return redirect()
            ->route('dosen.profile')
            ->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        /** @var Dosen $dosen */
        $dosen = auth()->guard('dosen')->user();

        $dosen->password = Hash::make($request->password);
        $dosen->save();

        return back()->with('success', 'Password berhasil diubah');
    }
}
