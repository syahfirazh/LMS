<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Detail Riwayat - Pertemuan {{ $session->urutan ?? $session->pertemuan }} | Portal Dosen</title>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="font-['Plus_Jakarta_Sans'] bg-[#f1f5f9] text-slate-800 min-h-full flex flex-col border-box overflow-x-hidden overflow-y-scroll selection:bg-blue-200">
    
    <div class="bg-white/90 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm transition-all w-full">
        <div class="max-w-7xl mx-auto flex items-center justify-between relative">
            
            <div class="flex items-center gap-4 relative z-10">
                <a href="{{ route('dosen.attendance.index', $kelas->id) }}" class="w-11 h-11 md:w-12 md:h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all shadow-sm shrink-0 group border border-slate-200 hover:border-blue-600">
                    <svg class="w-5 h-5 md:w-6 md:h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
            </div>

            <div class="text-center absolute left-1/2 transform -translate-x-1/2 w-full max-w-[60%] md:max-w-md">
                <h1 class="text-lg md:text-2xl font-black text-slate-900 tracking-tight leading-tight truncate">
                    Detail Riwayat
                </h1>
                <div class="flex items-center justify-center gap-2 mt-1">
                    <span class="text-[9px] md:text-[10px] font-bold text-blue-600 uppercase tracking-widest bg-blue-100 px-2 py-0.5 rounded-md">
                        Sesi {{ $session->urutan ?? $session->pertemuan }}
                    </span>
                    <span class="text-[10px] md:text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">
                        {{ $session->judul }}
                    </span>
                </div>
            </div>
            
            <div class="w-11 md:w-12 relative z-10"></div>
            
        </div>
    </div>

    <main class="flex-1 max-w-7xl mx-auto p-4 md:p-8 w-full space-y-8 mb-20">
        
        <div class="bg-white p-6 sm:p-8 md:p-10 rounded-[2rem] sm:rounded-[2.5rem] border border-slate-200 shadow-sm" data-aos="fade-down" data-aos-duration="600">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-slate-100 pb-6 sm:pb-8 mb-6 sm:mb-8">
                <div>
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-black text-slate-900 tracking-tight">
                        {{ $session->judul }}
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                        {{ $session->tanggal ? \Carbon\Carbon::parse($session->tanggal)->translatedFormat('l, d M Y') : '-' }} 
                        @if($session->jam_mulai)
                            <span class="inline-block mx-1">•</span> {{ \Carbon\Carbon::parse($session->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($session->jam_selesai)->format('H:i') }} WIB
                        @endif
                    </p>
                </div>
                
                <a href="{{ route('dosen.attendance.manual', [$kelas->id, $session->id]) }}" class="w-full md:w-auto px-6 py-3.5 bg-blue-50 text-blue-700 rounded-xl font-black text-[10px] sm:text-[11px] uppercase tracking-widest hover:bg-blue-600 hover:text-white transition-all shadow-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    Edit Absensi
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
                <div class="p-4 sm:p-6 rounded-[1.25rem] sm:rounded-[1.5rem] bg-emerald-50 border border-emerald-100 text-center hover:shadow-md transition-shadow">
                    <span class="block text-2xl sm:text-3xl font-black text-emerald-600 mb-1">{{ $rekap['hadir'] ?? 0 }}</span>
                    <span class="text-[9px] sm:text-[10px] font-black text-emerald-500 uppercase tracking-widest">Hadir</span>
                </div>
                <div class="p-4 sm:p-6 rounded-[1.25rem] sm:rounded-[1.5rem] bg-blue-50 border border-blue-100 text-center hover:shadow-md transition-shadow">
                    <span class="block text-2xl sm:text-3xl font-black text-blue-600 mb-1">{{ $rekap['izin'] ?? 0 }}</span>
                    <span class="text-[9px] sm:text-[10px] font-black text-blue-500 uppercase tracking-widest">Izin</span>
                </div>
                <div class="p-4 sm:p-6 rounded-[1.25rem] sm:rounded-[1.5rem] bg-amber-50 border border-amber-100 text-center hover:shadow-md transition-shadow">
                    <span class="block text-2xl sm:text-3xl font-black text-amber-600 mb-1">{{ $rekap['sakit'] ?? 0 }}</span>
                    <span class="text-[9px] sm:text-[10px] font-black text-amber-500 uppercase tracking-widest">Sakit</span>
                </div>
                <div class="p-4 sm:p-6 rounded-[1.25rem] sm:rounded-[1.5rem] bg-red-50 border border-red-100 text-center hover:shadow-md transition-shadow">
                    <span class="block text-2xl sm:text-3xl font-black text-red-600 mb-1">{{ $rekap['alpha'] ?? 0 }}</span>
                    <span class="text-[9px] sm:text-[10px] font-black text-red-500 uppercase tracking-widest">Alpha</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
            
            <div class="bg-slate-50/80 p-5 sm:p-6 md:px-8 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h3 class="font-black text-slate-800 text-xs sm:text-sm uppercase tracking-wider">
                    Detail Kehadiran Mahasiswa
                </h3>
                
                <div class="relative w-full sm:w-auto">
                    <input type="text" placeholder="Cari NIM atau Nama..." class="w-full sm:w-64 pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all shadow-sm" />
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <div class="divide-y divide-slate-100 p-2 sm:p-4">
                @forelse ($detail as $mhs)
                    <div class="p-4 md:p-5 flex items-center justify-between hover:bg-slate-50 rounded-2xl transition-colors group">
                        
                        <div class="flex items-center gap-4 sm:gap-5">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-base sm:text-lg shrink-0 border border-indigo-100 group-hover:bg-indigo-100 transition-colors">
                                {{ strtoupper(substr($mhs->nama, 0, 2)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm sm:text-base group-hover:text-blue-600 transition-colors mb-0.5 line-clamp-1">
                                    {{ $mhs->nama }}
                                </h4>
                                <p class="text-[10px] sm:text-xs font-mono text-slate-400 font-medium tracking-wide">
                                    {{ $mhs->nim }}
                                </p>
                            </div>
                        </div>

                        @php
                            // REVISI: Penyesuaian ke kata lengkap sesuai dengan data dari Controller/Database
                            $statusLabel = 'Alpha';
                            $statusClass = 'bg-red-50 border-red-100 text-red-600';
                            
                            if ($mhs->status == 'hadir') {
                                $statusLabel = 'Hadir';
                                $statusClass = 'bg-emerald-50 border-emerald-100 text-emerald-600';
                            } elseif ($mhs->status == 'izin') {
                                $statusLabel = 'Izin';
                                $statusClass = 'bg-blue-50 border-blue-100 text-blue-600';
                            } elseif ($mhs->status == 'sakit') {
                                $statusLabel = 'Sakit';
                                $statusClass = 'bg-amber-50 border-amber-100 text-amber-600';
                            }
                        @endphp

                        <span class="px-3 sm:px-4 py-1.5 sm:py-2 border rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest shadow-sm {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>
                    </div>
                @empty
                    <div class="p-10 text-center">
                        <p class="text-[10px] sm:text-sm font-bold text-slate-400 uppercase tracking-widest">Belum ada data mahasiswa.</p>
                    </div>
                @endforelse
            </div>
            
        </div>
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, easing: 'ease-out-cubic', duration: 800 });
    </script>
</body>
</html>