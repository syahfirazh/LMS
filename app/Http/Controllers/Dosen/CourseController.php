<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\CourseSession;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * 🔒 Helper: pastikan kelas milik dosen login
     */
    protected function authorizeKelas(Kelas $kelas)
    {
        if ($kelas->dosen_id !== auth('dosen')->id()) {
            abort(403, 'Anda tidak berhak mengakses kelas ini');
        }
    }

    // =========================================================
    // LIST SEMUA KELAS DOSEN
    // =========================================================
    public function index()
    {
        $kelasModel = Kelas::with(['mataKuliah', 'mahasiswa'])
            ->where('dosen_id', auth('dosen')->id())
            ->get();

        $kelasDiampu = $kelasModel->map(function ($kelas) {
            return [
                'id' => $kelas->id,
                'kode' => strtoupper(substr($kelas->mataKuliah->nama, 0, 3)),
                'nama' => $kelas->mataKuliah->nama,
                'kelas' => $kelas->kode_kelas,
                'jadwal' => $kelas->hari . ', ' . $kelas->jam_mulai . ' - ' . $kelas->jam_selesai,
                'mahasiswa' => $kelas->mahasiswa->count(),
                'warna' => 'blue',
            ];
        });

        return view('dosen_courses', compact('kelasDiampu'));
    }

    // =========================================================
    // HALAMAN MANAGE KELAS
    // =========================================================
    public function manage(Kelas $kelas)
    {
        $this->authorizeKelas($kelas);

        $kelas->load(['mataKuliah', 'courseSessions']);

        return view('dosen_manage_course', compact('kelas'));
    }

    // =========================================================
    // UPDATE DESKRIPSI & SAMPUL MATA KULIAH
    // =========================================================
    public function updateDeskripsi(Request $request, Kelas $kelas)
    {
        $this->authorizeKelas($kelas);

        $request->validate([
            'deskripsi' => 'required|string',
            'sampul' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [];

        if ($request->hasFile('sampul')) {
            if (
                $kelas->mataKuliah->sampul &&
                Storage::disk('public')->exists($kelas->mataKuliah->sampul)
            ) {
                Storage::disk('public')->delete($kelas->mataKuliah->sampul);
            }

            $data['sampul'] = $request
                ->file('sampul')
                ->store('sampul_mata_kuliah', 'public');
        }

        $kelas->mataKuliah->update([
            'deskripsi' => $request->deskripsi,
            'sampul' => $data['sampul'] ?? $kelas->mataKuliah->sampul,
        ]);

        return back()->with('success', 'Deskripsi & sampul berhasil diperbarui');
    }

    // =========================================================
    // UPDATE SAMPUL KELAS
    // =========================================================
    public function updateSampul(Request $request, Kelas $kelas)
    {
        $this->authorizeKelas($kelas);

        $request->validate([
            'sampul' => 'required|image|max:2048',
        ]);

        $path = $request->file('sampul')->store('kelas', 'public');

        $kelas->update([
            'sampul' => $path,
        ]);

        return back()->with('success', 'Sampul berhasil diperbarui');
    }

    // =========================================================
    // TAMBAH SESSION (PERTEMUAN)
    // =========================================================
    public function storeSession(Request $request, Kelas $kelas)
    {
        $this->authorizeKelas($kelas);

        $request->validate([
            'judul' => 'required|string|max:255',
        ]);

        $urutanTerakhir = $kelas->courseSessions()->max('urutan') ?? 0;

        CourseSession::create([
            'kelas_id' => $kelas->id,
            'judul' => $request->judul,
            'urutan' => $urutanTerakhir + 1,
        ]);

        return back()->with('success', 'Pertemuan berhasil ditambahkan');
    }

    // =========================================================
    // LIST MAHASISWA DI KELAS
    // =========================================================
    public function students(Kelas $kelas)
    {
        $this->authorizeKelas($kelas);

        $kelas->load(['mahasiswa', 'mataKuliah']);

        return view('dosen_course_students', compact('kelas'));
    }

    // =========================================================
    // TAMBAH MAHASISWA KE KELAS
    // =========================================================
    public function addStudent(Request $request, Kelas $kelas)
    {
        $this->authorizeKelas($kelas);

        $request->validate([
            'nim' => 'required|string'
        ]);

        $mahasiswa = Mahasiswa::where('nim', $request->nim)->first();

        if (!$mahasiswa) {
            return back()->with('error', 'Mahasiswa tidak ditemukan');
        }

        if ($kelas->mahasiswa()->where('mahasiswa_id', $mahasiswa->id)->exists()) {
            return back()->with('error', 'Mahasiswa sudah ada di kelas');
        }

        $kelas->mahasiswa()->attach($mahasiswa->id);

        return back()->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    // =========================================================
    // HALAMAN NILAI
    // =========================================================
    public function grades(Kelas $kelas)
    {
        $this->authorizeKelas($kelas);

        $mahasiswas = $kelas->mahasiswa()->get();

        return view('dosen_course_grades', compact(
            'kelas',
            'mahasiswas'
        ));
    }
}
