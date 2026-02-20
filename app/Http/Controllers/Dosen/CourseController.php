<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Kelas;
use App\Models\MataKuliah;
use App\Models\CourseSession;
use App\Models\Mahasiswa;

class CourseController extends Controller
{
    /**
     * 🔒 Helper: Pastikan kelas milik dosen yang sedang login
     */
    protected function authorizeKelas(Kelas $kelas)
    {
        if ($kelas->dosen_id !== Auth::guard('dosen')->id()) {
            abort(403, 'Anda tidak berhak mengakses kelas ini');
        }
    }

    // =========================================================
    // 1. LIST SEMUA KELAS DOSEN
    // =========================================================
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();

        $kelasDiampu = Kelas::with(['mataKuliah', 'mahasiswa'])
            ->where('dosen_id', $dosen->id)
            ->latest()
            ->get();

        return view('dosen_courses', compact('kelasDiampu'));
    }

    // =========================================================
    // 2. SIMPAN KELAS BARU (Upload Foto Sampul)
    // =========================================================
    public function store(Request $request)
    {
        $request->validate([
            'nama_mata_kuliah' => 'required|string|max:255',
            'kode_kelas'       => 'required|string|max:10',
            'sks'              => 'required|integer|min:1',
            'hari'             => 'required|string',
            'jam_mulai'        => 'required',
            'jam_selesai'      => 'required',
            'ruangan'          => 'required|string',
            'sampul'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $matkul = MataKuliah::firstOrCreate(
            ['nama' => $request->nama_mata_kuliah],
            ['sks' => $request->sks, 'kode' => strtoupper(substr($request->nama_mata_kuliah, 0, 3))]
        );

        $pathSampul = null;
        if ($request->hasFile('sampul')) {
            $pathSampul = $request->file('sampul')->store('covers', 'public');
        }

        Kelas::create([
            'dosen_id'       => Auth::guard('dosen')->id(),
            'mata_kuliah_id' => $matkul->id,
            'kode_kelas'     => $request->kode_kelas,
            'hari'           => $request->hari,
            'jam_mulai'      => $request->jam_mulai,
            'jam_selesai'    => $request->jam_selesai,
            'ruangan'        => $request->ruangan,
            'sampul'         => $pathSampul,
            'warna'          => collect(['blue', 'emerald', 'orange', 'purple', 'pink'])->random(),
        ]);

        return redirect()->back()->with('success', 'Kelas berhasil dibuat!');
    }

    // =========================================================
    // 3. HALAMAN MANAGE KELAS (Detail)
    // =========================================================
    public function manage($id)
    {
        $kelas = Kelas::with(['mataKuliah', 'courseSessions'])->findOrFail($id);
        $this->authorizeKelas($kelas);

        return view('dosen_course_manage', compact('kelas'));
    }

    // =========================================================
    // 4. UPDATE DESKRIPSI & SAMPUL MATA KULIAH
    // =========================================================
    public function updateDeskripsi(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $this->authorizeKelas($kelas);

        $request->validate([
            'deskripsi' => 'required|string',
            'sampul'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('sampul')) {
            // Hapus sampul lama jika ada
            if ($kelas->mataKuliah->sampul && Storage::disk('public')->exists($kelas->mataKuliah->sampul)) {
                Storage::disk('public')->delete($kelas->mataKuliah->sampul);
            }
            $path = $request->file('sampul')->store('sampul_mata_kuliah', 'public');
            $kelas->mataKuliah->update(['sampul' => $path]);
        }

        $kelas->mataKuliah->update(['deskripsi' => $request->deskripsi]);

        return back()->with('success', 'Informasi mata kuliah berhasil diperbarui');
    }

    // =========================================================
    // 5. TAMBAH SESSION (PERTEMUAN)
    // =========================================================
    public function storeSession(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $this->authorizeKelas($kelas);

        $request->validate(['judul' => 'required|string|max:255']);

        $urutanTerakhir = $kelas->courseSessions()->max('urutan') ?? 0;

        CourseSession::create([
            'kelas_id' => $kelas->id,
            'judul'    => $request->judul,
            'urutan'   => $urutanTerakhir + 1,
        ]);

        return back()->with('success', 'Pertemuan berhasil ditambahkan');
    }

    // =========================================================
    // 6. KELOLA MAHASISWA DI KELAS
    // =========================================================
    public function students($id)
    {
        $kelas = Kelas::with(['mahasiswa', 'mataKuliah'])->findOrFail($id);
        $this->authorizeKelas($kelas);

        return view('dosen_course_students', compact('kelas'));
    }

    public function addStudent(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $this->authorizeKelas($kelas);

        $request->validate(['nim' => 'required|string']);

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
    // 7. HALAMAN NILAI
    // =========================================================
    public function grades($id)
    {
        $kelas = Kelas::with('mahasiswa')->findOrFail($id);
        $this->authorizeKelas($kelas);

        $mahasiswas = $kelas->mahasiswa;

        return view('dosen_course_grades', compact('kelas', 'mahasiswas'));
    }

    // =========================================================
    // 8. HAPUS KELAS
    // =========================================================
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $this->authorizeKelas($kelas);

        if ($kelas->sampul && Storage::disk('public')->exists($kelas->sampul)) {
            Storage::disk('public')->delete($kelas->sampul);
        }

        $kelas->delete();

        return redirect()->back()->with('success', 'Kelas berhasil dihapus.');
    }
  // Tambahkan atau ganti fungsi destroySession kamu dengan ini
public function destroySession(Kelas $kelas, CourseSession $session)
{
    // Pastikan kelas ini milik dosen yang login
    $this->authorizeKelas($kelas);

    // Pastikan sesi ini memang milik kelas tersebut
    if ($session->kelas_id !== $kelas->id) {
        abort(404);
    }
    
    $session->delete();

    return back()->with('success', 'Pertemuan berhasil dihapus.');
}
}