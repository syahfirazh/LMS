<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\GradeWeight;
use App\Models\Grade;
use Illuminate\Http\Request;

class RekapNilaiController extends Controller
{
    // =========================================================
    // 1. AKSES DARI SIDEBAR UTAMA (GLOBAL INPUT)
    // =========================================================
    public function globalInput(Request $request)
    {
        $dosenId = auth('dosen')->id();
        
        // Ambil semua kelas yang diajar dosen ini untuk Dropdown
        $listKelas = Kelas::with('mataKuliah')->where('dosen_id', $dosenId)->get();

        $selectedKelasId = $request->query('kelas_id');
        $kelas = null;
        $bobot = null;
        $grades = null;

        // Cek apakah dosen punya setidaknya 1 kelas
        if ($listKelas->count() > 0) {
            
            // Jika tidak ada parameter kelas_id di URL, pilih kelas pertama
            if (!$selectedKelasId) {
                $selectedKelasId = $listKelas->first()->id;
            }

            // Cari kelas berdasarkan ID yang dipilih DAN pastikan milik dosen tersebut
            $kelas = Kelas::with('mahasiswa')
                          ->where('id', $selectedKelasId)
                          ->where('dosen_id', $dosenId)
                          ->first();

            // Jika kelas ditemukan, ambil bobot dan nilainya
            if ($kelas) {
                $bobot = GradeWeight::firstOrCreate(
                    ['kelas_id' => $kelas->id],
                    ['absen' => 10, 'tugas' => 20, 'uts' => 30, 'uas' => 40]
                );

                $grades = Grade::where('kelas_id', $kelas->id)->get()->keyBy('mahasiswa_id');
            }
        }

        // Return ke view dosen_input_nilai, bukan dosen_grading
        // Karena desain dosen_input_nilai sekarang sudah pakai layout dropdown global
        return view('dosen_grading', compact('listKelas', 'kelas', 'bobot', 'grades'));
    }

    public function globalStore(Request $request, Kelas $kelas)
    {
        // Fungsi ini dipanggil jika submit dari halaman global
        return $this->storeInput($request, $kelas);
    }


    // =========================================================
    // 2. AKSES DARI DALAM KELAS (INPUT NILAI MASAL)
    // =========================================================
    public function input(Kelas $kelas)
    {
        if ($kelas->dosen_id !== auth('dosen')->id()) abort(403);

        $dosenId = auth('dosen')->id();
        
        // Tetap kirim listKelas agar dropdown berfungsi jika user iseng pakai dropdown
        $listKelas = Kelas::with('mataKuliah')->where('dosen_id', $dosenId)->get();

        $kelas->load('mahasiswa');
        $bobot = GradeWeight::firstOrCreate(
            ['kelas_id' => $kelas->id], 
            ['absen' => 10, 'tugas' => 20, 'uts' => 30, 'uas' => 40]
        );
        $grades = Grade::where('kelas_id', $kelas->id)->get()->keyBy('mahasiswa_id');

        return view('dosen_input_nilai', compact('listKelas', 'kelas', 'bobot', 'grades'));
    }

    public function storeInput(Request $request, Kelas $kelas)
    {
        if ($kelas->dosen_id !== auth('dosen')->id()) abort(403);

        // A. Simpan Bobot Terlebih Dahulu dari hidden input
        GradeWeight::updateOrCreate(
            ['kelas_id' => $kelas->id],
            [
                'absen' => $request->bobot_absen ?? 10,
                'tugas' => $request->bobot_tugas ?? 20,
                'uts'   => $request->bobot_uts ?? 30,
                'uas'   => $request->bobot_uas ?? 40,
            ]
        );

        // B. Simpan Nilai Tiap Mahasiswa
        if ($request->has('grades')) {
            foreach ($request->grades as $mahasiswaId => $nilai) {
                Grade::updateOrCreate(
                    ['kelas_id' => $kelas->id, 'mahasiswa_id' => $mahasiswaId],
                    [
                        'absen' => $nilai['absen'] ?? 0,
                        'tugas' => $nilai['tugas'] ?? 0,
                        'uts'   => $nilai['uts'] ?? 0,
                        'uas'   => $nilai['uas'] ?? 0,
                    ]
                );
            }
        }

        // ✅ PERUBAHAN DI SINI: Tetap di halaman yang sama setelah simpan masal
        return back()->with('success', 'Nilai seluruh mahasiswa & bobot berhasil disimpan!');
    }


    // =========================================================
    // 3. HALAMAN REKAP NILAI & STATISTIK KELAS
    // =========================================================
    public function index(Kelas $kelas)
    {
        if ($kelas->dosen_id !== auth('dosen')->id()) abort(403);

        $kelas->load('mahasiswa');
        $bobot = GradeWeight::where('kelas_id', $kelas->id)->first() ?? (object) [
            'absen' => 10, 'tugas' => 20, 'uts' => 30, 'uas' => 40
        ];

        $gradeData = Grade::where('kelas_id', $kelas->id)->get()->keyBy('mahasiswa_id');

        $mahasiswas = [];
        $distribusi = ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0, 'E' => 0];

        foreach ($kelas->mahasiswa as $mhs) {
            $nilaiMhs = $gradeData[$mhs->id] ?? null;

            $absen = $nilaiMhs->absen ?? 0;
            $tugas = $nilaiMhs->tugas ?? 0;
            $uts   = $nilaiMhs->uts   ?? 0;
            $uas   = $nilaiMhs->uas   ?? 0;

            $akhir = ($absen * $bobot->absen / 100) + 
                     ($tugas * $bobot->tugas / 100) + 
                     ($uts * $bobot->uts / 100) + 
                     ($uas * $bobot->uas / 100);

            $huruf = $this->konversiHuruf($akhir);
            $distribusi[$huruf]++;

            $mahasiswas[] = [
                'id'    => $mhs->id,
                'nama'  => $mhs->nama,
                'nim'   => $mhs->nim,
                'absen' => $absen,
                'tugas' => $tugas,
                'uts'   => $uts,
                'uas'   => $uas,
                'akhir' => round($akhir, 2),
                'huruf' => $huruf,
            ];
        }

        $nilaiAkhir = collect($mahasiswas)->pluck('akhir');
        $rataRata = $nilaiAkhir->count() ? round($nilaiAkhir->avg(), 2) : 0;
        $tertinggi = collect($mahasiswas)->sortByDesc('akhir')->first();
        $terendah  = collect($mahasiswas)->sortBy('akhir')->first();

        $totalMhs = count($mahasiswas);
        $totalLulus = $distribusi['A'] + $distribusi['B'] + $distribusi['C'];
        $persentaseLulus = $totalMhs > 0 ? round(($totalLulus / $totalMhs) * 100) : 0;

        return view('dosen_course_grades', compact(
            'kelas', 'mahasiswas', 'bobot', 'rataRata', 'tertinggi', 'terendah', 'distribusi', 'persentaseLulus', 'totalMhs'
        ));
    }


    // =========================================================
    // 4. UPDATE VIA MODAL (POPUP) DI REKAP NILAI
    // =========================================================
    
    // Update Nilai 1 Mahasiswa
    public function update(Request $request, Kelas $kelas, $mahasiswaId)
    {
        if ($kelas->dosen_id !== auth('dosen')->id()) abort(403);

        Grade::updateOrCreate(
            ['kelas_id' => $kelas->id, 'mahasiswa_id' => $mahasiswaId],
            [
                'absen' => $request->absen ?? 0,
                'tugas' => $request->tugas ?? 0,
                'uts'   => $request->uts ?? 0,
                'uas'   => $request->uas ?? 0,
            ]
        );

        // ✅ Diperbaiki: Pesan disesuaikan karena ini khusus 1 mahasiswa
        return back()->with('success', 'Nilai mahasiswa berhasil diperbarui!'); 
    }

    // Update Bobot Permanen
    public function updateSettings(Request $request, Kelas $kelas)
    {
        if ($kelas->dosen_id !== auth('dosen')->id()) abort(403);

        $data = $request->validate([
            'absen' => 'required|integer|min:0|max:100',
            'tugas' => 'required|integer|min:0|max:100',
            'uts'   => 'required|integer|min:0|max:100',
            'uas'   => 'required|integer|min:0|max:100',
        ]);

        if (array_sum($data) !== 100) {
            return back()->with('error', 'Gagal! Total bobot harus tepat 100%.');
        }

        GradeWeight::updateOrCreate(['kelas_id' => $kelas->id], $data);
        return redirect()->route('dosen.grades.recap', $kelas->id)->with('success', 'Komposisi Bobot Nilai berhasil diperbarui!');
    }


    // =========================================================
    // FUNGSI BANTUAN
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