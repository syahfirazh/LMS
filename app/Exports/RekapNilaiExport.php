<?php

namespace App\Exports;

use App\Models\Kelas;
use App\Models\Grade;
use App\Models\GradeWeight;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RekapNilaiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $kelasId;
    protected $bobot;

    public function __construct($kelasId)
    {
        $this->kelasId = $kelasId;
        // Ambil data bobot kelas ini, atau gunakan default jika belum diatur
        $this->bobot = GradeWeight::where('kelas_id', $kelasId)->first() ?? (object) [
            'absen' => 10, 'tugas' => 20, 'uts' => 30, 'uas' => 40
        ];
    }

    public function collection()
    {
        // Ambil kelas beserta mahasiswanya dan pivot absen/tugas (meskipun kita pakai tabel Grade)
        $kelas = Kelas::with(['mahasiswa'])->findOrFail($this->kelasId);
        return $kelas->mahasiswa;
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama Mahasiswa',
            'Nilai Absen (' . $this->bobot->absen . '%)',
            'Nilai Tugas (' . $this->bobot->tugas . '%)',
            'Nilai UTS (' . $this->bobot->uts . '%)',
            'Nilai UAS (' . $this->bobot->uas . '%)',
            'Nilai Akhir',
            'Grade (Huruf)'
        ];
    }

    public function map($mahasiswa): array
    {
        // Ambil nilai dari tabel grades berdasarkan mahasiswa dan kelas ini
        $nilai = Grade::where('kelas_id', $this->kelasId)->where('mahasiswa_id', $mahasiswa->id)->first();

        $absen = $nilai->absen ?? 0;
        $tugas = $nilai->tugas ?? 0;
        $uts   = $nilai->uts ?? 0;
        $uas   = $nilai->uas ?? 0;

        // Hitung nilai akhir sesuai persentase bobot
        $akhir = ($absen * $this->bobot->absen / 100) + 
                 ($tugas * $this->bobot->tugas / 100) + 
                 ($uts * $this->bobot->uts / 100) + 
                 ($uas * $this->bobot->uas / 100);

        // Tentukan huruf mutu
        $huruf = match (true) {
            $akhir >= 85 => 'A',
            $akhir >= 70 => 'B',
            $akhir >= 60 => 'C',
            $akhir >= 50 => 'D',
            default      => 'E',
        };

        return [
            $mahasiswa->nim,
            $mahasiswa->nama,
            $absen,
            $tugas,
            $uts,
            $uas,
            round($akhir, 2),
            $huruf
        ];
    }
}