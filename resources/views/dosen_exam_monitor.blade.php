<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Pantau Ujian | Portal Dosen</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />

    {{-- Auto Refresh Halaman Setiap 30 Detik untuk Pantau Live --}}
    <meta http-equiv="refresh" content="30">

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
                <h1 class="text-lg md:text-xl font-black text-slate-900 tracking-tight leading-tight truncate flex items-center justify-center gap-2">
                    <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-pulse"></span>
                    Pantau Ujian Live
                </h1>
                <div class="flex items-center justify-center gap-2 mt-1">
                    <span class="text-[9px] md:text-[10px] font-bold text-emerald-700 uppercase tracking-widest bg-emerald-100 px-2 py-0.5 rounded-md truncate border border-emerald-200">
                        {{ $exam->judul ?? 'Ujian' }}
                    </span>
                    <span class="text-[10px] md:text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        • {{ $exam->kelas->mataKuliah->nama ?? 'Kelas' }}
                    </span>
                </div>
            </div>

            {{-- Tombol Refresh di Kanan --}}
            <div class="flex items-center relative z-10 w-auto justify-end">
                <button onclick="window.location.reload()" class="px-5 sm:px-6 py-2.5 sm:py-3 bg-white border border-slate-200 text-slate-600 font-black rounded-xl text-[10px] sm:text-xs uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2 transform active:scale-95">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span class="hidden sm:inline">Refresh Data</span>
                </button>
            </div>
        </div>
    </header>

    {{-- KONTEN UTAMA --}}
    <main class="flex-1 overflow-y-auto custom-scrollbar p-4 sm:p-6 lg:p-8 relative bg-slate-50/50">
        <div class="w-full max-w-7xl mx-auto space-y-6 safe-fade-in relative z-10">
            
            @php
                // Hitung statistik dinamis dari database
                $totalMengerjakan = $exam->results->where('status', 'mengerjakan')->count();
                $totalSelesai = $exam->results->where('status', 'selesai')->count();
                $totalPeserta = $exam->results->count();
            @endphp

            {{-- Statistik Pemantauan --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-[1.5rem] border border-slate-200 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Total Peserta</p>
                        <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $totalPeserta }}</h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-[1.5rem] border border-slate-200 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-emerald-600/70 uppercase tracking-widest">Sedang Mengerjakan</p>
                        <h3 class="text-3xl font-black text-emerald-700 mt-1">{{ $totalMengerjakan }}</h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-[1.5rem] border border-slate-200 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-slate-100 text-slate-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Sudah Selesai</p>
                        <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $totalSelesai }}</h3>
                    </div>
                </div>
            </div>

            {{-- Tabel Peserta --}}
            <div class="bg-white rounded-[1.5rem] border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <h3 class="font-black text-slate-800">Status Peserta Ujian</h3>
                    <span class="text-xs font-bold text-slate-500">Otomatis refresh dalam 30 detik</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white border-b border-slate-100 text-[10px] uppercase tracking-widest text-slate-400 font-black">
                                <th class="p-4 pl-6">Mahasiswa</th>
                                <th class="p-4">Waktu Mulai</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-center">Keterangan</th>
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
                                        {{ $result->waktu_mulai ? \Carbon\Carbon::parse($result->waktu_mulai)->format('H:i') . ' WIB' : '-' }}
                                    </td>
                                    <td class="p-4">
                                        @if($result->status == 'mengerjakan')
                                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-full border border-emerald-200 animate-pulse">Sedang Mengerjakan</span>
                                        @else
                                            <span class="px-3 py-1 bg-slate-100 text-slate-700 text-[10px] font-bold rounded-full border border-slate-200">Selesai</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center text-xs font-bold text-slate-500">
                                        @if($result->status == 'selesai')
                                            Waktu Submit: {{ \Carbon\Carbon::parse($result->waktu_selesai)->format('H:i') }}
                                        @else
                                            Menunggu Submit...
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-12 text-center text-slate-500 font-medium">
                                        Belum ada mahasiswa yang masuk ke ujian ini.<br>
                                        <span class="text-xs opacity-70">(Data akan muncul otomatis di sini saat mahasiswa memasukkan token dan memulai ujian)</span>
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