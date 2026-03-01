<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Hasil Ujian | Portal Dosen</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .safe-fade-in { animation: fadeIn 0.4s ease-out forwards; opacity: 0; }
    </style>
</head>

<body class="m-0 font-['Plus_Jakarta_Sans'] bg-slate-50 text-slate-800 antialiased h-screen flex flex-col overflow-hidden">
    
    {{-- HEADER STICKY --}}
    <header class="bg-white/90 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm w-full shrink-0">
        <div class="max-w-7xl mx-auto flex items-center justify-between relative">
            
            {{-- Tombol Back di Kiri --}}
            <div class="flex items-center gap-4 relative z-10 w-auto justify-start">
                <a href="{{ route('dosen.exams') }}" class="w-11 h-11 md:w-12 md:h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm shrink-0 group border border-slate-200 hover:border-blue-600">
                    <svg class="w-5 h-5 md:w-6 md:h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </a>
            </div>

            {{-- Judul di Tengah (Absolute) --}}
            <div class="text-center absolute left-1/2 transform -translate-x-1/2 w-full max-w-[60%] md:max-w-md hidden sm:block">
                <h1 class="text-lg md:text-xl font-black text-slate-900 tracking-tight leading-tight truncate">
                    Rekapitulasi Hasil Ujian
                </h1>
                <div class="flex items-center justify-center gap-2 mt-1">
                    <span class="text-[9px] md:text-[10px] font-bold text-blue-700 uppercase tracking-widest bg-blue-100 px-2 py-0.5 rounded-md truncate border border-blue-200">
                        {{ $exam->judul ?? 'Ujian' }}
                    </span>
                    <span class="text-[10px] md:text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        • {{ $exam->kelas->mataKuliah->nama ?? 'Kelas' }}
                    </span>
                </div>
            </div>

            {{-- Tombol Export di Kanan --}}
            <div class="flex items-center relative z-10 w-auto justify-end">
                {{-- TOMBOL EXPORT SUDAH DIPERBAIKI MENJADI LINK --}}
                <a href="{{ route('dosen.exams.results.export', $exam->id) }}" class="px-5 sm:px-6 py-2.5 sm:py-3 bg-emerald-600 text-white font-black rounded-xl text-[10px] sm:text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-md shadow-emerald-200 flex items-center gap-2 transform active:scale-95">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span class="hidden sm:inline">Export Excel</span>
                    <span class="sm:hidden">Export</span>
                </a>
            </div>
        </div>
    </header>

    {{-- KONTEN UTAMA --}}
    <main class="flex-1 overflow-y-auto custom-scrollbar p-4 sm:p-6 lg:p-8 relative bg-slate-50/50">
        <div class="w-full max-w-7xl mx-auto space-y-6 safe-fade-in relative z-10">
            
            @php
                // Hitung Rata-rata, Tertinggi, Terendah
                $nilaiRataRata = $exam->results->avg('nilai') ?? 0;
                $nilaiTertinggi = $exam->results->max('nilai') ?? 0;
                $nilaiTerendah = $exam->results->min('nilai') ?? 0;
            @endphp

            {{-- Statistik Hasil Ujian --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-600 to-blue-800 p-6 rounded-[1.5rem] shadow-md flex flex-col justify-between text-white relative overflow-hidden">
                    <div class="absolute right-[-10%] top-[-20%] opacity-10">
                        <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <p class="text-[10px] font-black text-blue-200 uppercase tracking-widest relative z-10">Rata-rata Kelas</p>
                    <h3 class="text-4xl font-black mt-2 relative z-10">{{ number_format($nilaiRataRata, 1) }}</h3>
                </div>
                <div class="bg-white p-6 rounded-[1.5rem] border border-slate-200 shadow-sm flex flex-col justify-center">
                    <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-1">Nilai Tertinggi</p>
                    <h3 class="text-3xl font-black text-slate-800">{{ number_format($nilaiTertinggi, 0) }}</h3>
                </div>
                <div class="bg-white p-6 rounded-[1.5rem] border border-slate-200 shadow-sm flex flex-col justify-center">
                    <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-1">Nilai Terendah</p>
                    <h3 class="text-3xl font-black text-slate-800">{{ number_format($nilaiTerendah, 0) }}</h3>
                </div>
            </div>

            {{-- Tabel Hasil / Nilai --}}
            <div class="bg-white rounded-[1.5rem] border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <h3 class="font-black text-slate-800">Daftar Nilai Mahasiswa</h3>
                    
                    {{-- Search Input Sederhana --}}
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" placeholder="Cari nama / NIM..." class="pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full sm:w-64 transition-all">
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white border-b border-slate-100 text-[10px] uppercase tracking-widest text-slate-400 font-black">
                                <th class="p-4 pl-6">Mahasiswa</th>
                                <th class="p-4">Waktu Submit</th>
                                <th class="p-4">Benar / Salah</th>
                                <th class="p-4 text-right pr-6">Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- LOOPING DATA DARI DATABASE --}}
                            @forelse($exam->results as $result)
                                <tr class="border-b border-slate-50 hover:bg-slate-50 transition-colors">
                                    <td class="p-4 pl-6">
                                        <div class="font-bold text-slate-800 text-sm">{{ $result->mahasiswa->nama ?? 'Nama Tidak Ditemukan' }}</div>
                                        <div class="text-[10px] font-bold text-slate-400 mt-0.5">NIM: {{ $result->mahasiswa->nim ?? '-' }}</div>
                                    </td>
                                    <td class="p-4 text-sm font-medium text-slate-600">
                                        {{ $result->waktu_selesai ? \Carbon\Carbon::parse($result->waktu_selesai)->format('H:i') . ' WIB' : '-' }}
                                    </td>
                                    <td class="p-4 text-sm font-medium text-slate-600">
                                        <span class="text-emerald-600 font-bold">{{ $result->benar }} Benar</span> / <span class="text-red-500 font-bold">{{ $result->salah }} Salah</span>
                                    </td>
                                    <td class="p-4 text-right pr-6">
                                        <span class="text-xl font-black {{ $result->nilai >= 70 ? 'text-emerald-600' : 'text-red-500' }}">
                                            {{ rtrim(rtrim(number_format($result->nilai, 2, '.', ''), '0'), '.') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-12 text-center text-slate-500 font-medium">
                                        Belum ada data nilai.<br>
                                        <span class="text-xs opacity-70">(Belum ada mahasiswa yang mengumpulkan jawaban ujian ini)</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</body>
</html>