<?php

namespace App\Exports;

use App\Models\ExamResult;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class HasilUjianExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $examId;

    public function __construct($examId)
    {
        $this->examId = $examId;
    }

    public function collection()
    {
        // Ambil data ujian yang sudah "selesai" beserta data mahasiswanya
        return ExamResult::with('mahasiswa')
                ->where('exam_id', $this->examId)
                ->where('status', 'selesai')
                ->get();
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama Mahasiswa',
            'Status',
            'Waktu Mulai',
            'Waktu Selesai',
            'Nilai Akhir'
        ];
    }

    public function map($result): array
    {
        return [
            $result->mahasiswa->nim ?? '-',
            $result->mahasiswa->nama ?? '-',
            strtoupper($result->status),
            $result->waktu_mulai ? Carbon::parse($result->waktu_mulai)->format('d/m/Y H:i:s') : '-',
            $result->waktu_selesai ? Carbon::parse($result->waktu_selesai)->format('d/m/Y H:i:s') : '-',
            $result->nilai ?? 0
        ];
    }
}