<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\GradeWeight;
use Illuminate\Http\Request;

class RekapNilaiController extends Controller
{
    // =========================================================
    // REKAP NILAI PER KELAS (AMAN MULTI DOSEN)
    // =========================================================
    public function index(Kelas $kelas)
    {
        // 🔒 Pastikan kelas milik dosen login
        if ($kelas->dosen_id !== auth('dosen')->id()) {
            abort(403);
        }

        $kelas->load(['mahasiswa', 'gradeWeight']);

        // Bobot default
        $bobot = $kelas->gradeWeight ?? (object) [
            'absen' => 10,
            'tugas' => 20,
            'uts'   => 30,
            'uas'   => 40,
        ];

        $mahasiswas = [];

        foreach ($kelas->mahasiswa as $mhs) {

            $absen = $mhs->pivot->absen ?? 0;
            $tugas = $mhs->pivot->tugas ?? 0;
            $uts   = $mhs->pivot->uts   ?? 0;
            $uas   = $mhs->pivot->uas   ?? 0;

            $akhir =
                ($absen * $bobot->absen / 100) +
                ($tugas * $bobot->tugas / 100) +
                ($uts   * $bobot->uts   / 100) +
                ($uas   * $bobot->uas   / 100);

            $mahasiswas[] = [
                'id'    => $mhs->id,
                'nama'  => $mhs->nama,
                'nim'   => $mhs->nim,
                'absen' => $absen,
                'tugas' => $tugas,
                'uts'   => $uts,
                'uas'   => $uas,
                'akhir' => round($akhir, 2),
                'huruf' => $this->konversiHuruf($akhir),
            ];
        }

        $nilaiAkhir = collect($mahasiswas)->pluck('akhir');

        $rataRata = $nilaiAkhir->count()
            ? round($nilaiAkhir->avg(), 2)
            : null;

        $tertinggi = collect($mahasiswas)->sortByDesc('akhir')->first();
        $terendah  = collect($mahasiswas)->sortBy('akhir')->first();

        return view('dosen_course_grades', compact(
            'kelas',
            'mahasiswas',
            'bobot',
            'rataRata',
            'tertinggi',
            'terendah'
        ));
    }

    // =========================================================
    // SETTING BOBOT NILAI
    // =========================================================
    public function settings(Kelas $kelas)
    {
        if ($kelas->dosen_id !== auth('dosen')->id()) {
            abort(403);
        }

        $bobot = GradeWeight::firstOrCreate(
            ['kelas_id' => $kelas->id],
            ['absen' => 10, 'tugas' => 20, 'uts' => 30, 'uas' => 40]
        );

        return view('dosen_course_grades_settings', compact('kelas', 'bobot'));
    }

    // =========================================================
    // UPDATE BOBOT NILAI
    // =========================================================
    public function updateSettings(Request $request, Kelas $kelas)
    {
        if ($kelas->dosen_id !== auth('dosen')->id()) {
            abort(403);
        }

        $data = $request->validate([
            'absen' => 'required|integer|min:0|max:100',
            'tugas' => 'required|integer|min:0|max:100',
            'uts'   => 'required|integer|min:0|max:100',
            'uas'   => 'required|integer|min:0|max:100',
        ]);

        if (array_sum($data) !== 100) {
            return back()->withErrors([
                'total' => 'Total bobot harus 100%'
            ]);
        }

        GradeWeight::updateOrCreate(
            ['kelas_id' => $kelas->id],
            $data
        );

        return redirect()
            ->route('dosen.grades.recap', $kelas->id)
            ->with('success', 'Bobot nilai berhasil diperbarui');
    }

    // =========================================================
    // KONVERSI NILAI HURUF
    // =========================================================
    private function konversiHuruf($nilai)
    {
        return match (true) {
            $nilai >= 85 => 'A',
            $nilai >= 70 => 'B',
            $nilai >= 60 => 'C',
            $nilai >= 50 => 'D',
            default      => 'E',
        };
    }
}
