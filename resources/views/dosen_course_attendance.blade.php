<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Kelola Absensi | Portal Dosen</title>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="font-['Plus_Jakarta_Sans'] bg-[#f1f5f9] text-slate-800 min-h-full flex flex-col border-box overflow-x-hidden selection:bg-blue-200">
    
    <div class="bg-white/80 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm transition-all">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-5">
            
            <div class="flex items-center gap-4 w-full md:w-auto">
                <a href="{{ route('dosen.courses') }}" class="w-12 h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all shadow-sm shrink-0 group">
                    <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="overflow-hidden">
                    <h1 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight leading-tight truncate">
                        {{ $kelas->mataKuliah->nama ?? 'Nama Mata Kuliah' }}
                    </h1>
                    <div class="flex items-center gap-3 mt-1">
                        <span class="text-[10px] font-black text-blue-700 uppercase tracking-widest bg-blue-100 px-2.5 py-1 rounded-md">
                            Kelas {{ $kelas->kode_kelas ?? '-' }}
                        </span>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">
                            Dosen: {{ auth('dosen')->user()->nama ?? auth()->user()->nama ?? 'Dosen' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="hidden md:block w-px h-10 bg-slate-200"></div>

            <nav class="w-full md:w-auto flex p-1.5 bg-slate-100/80 rounded-2xl overflow-x-auto scrollbar-hide snap-x gap-2 border border-slate-200/50">
                <a href="{{ route('dosen.course.manage', $kelas->id) }}" class="snap-start shrink-0 px-6 py-2.5 rounded-xl text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/60 flex items-center justify-center">
                    Materi & Modul
                </a>
                
                <button class="snap-start shrink-0 px-6 py-2.5 rounded-xl bg-white text-blue-700 font-black text-[10px] uppercase tracking-widest shadow-sm border border-slate-200/60 whitespace-nowrap transition-all flex items-center justify-center cursor-default">
                    Absensi
                </button>

                <a href="{{ route('dosen.course.assignments', $kelas->id) }}" class="snap-start shrink-0 px-6 py-2.5 rounded-xl text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/60 flex items-center justify-center">
                    Penugasan
                </a>

                <a href="{{ route('dosen.course.students', $kelas->id) }}" class="snap-start shrink-0 px-6 py-2.5 rounded-xl text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/60 flex items-center justify-center">
                    Peserta
                </a>

                <a href="{{ route('dosen.grades.recap', $kelas->id) }}" class="snap-start shrink-0 px-6 py-2.5 rounded-xl text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/60 flex items-center justify-center">
                    Rekap Nilai
                </a>
            </nav>
        </div>
    </div>

    <main class="flex-1 max-w-7xl mx-auto p-4 md:p-8 w-full space-y-10 mb-20">
        
        <div class="bg-blue-600 rounded-[2.5rem] p-8 md:p-10 text-white shadow-xl shadow-blue-200 relative overflow-hidden" data-aos="fade-up" data-aos-duration="600">
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                
                <div class="text-center md:text-left">
                    @if ($todaySession)
                        <span class="inline-block px-4 py-1.5 bg-white/20 rounded-xl text-[10px] font-black uppercase tracking-widest mb-3 backdrop-blur-md border border-white/20">
                            Sedang Berlangsung • Pertemuan {{ $todaySession->pertemuan ?? $todaySession->urutan }}
                        </span>
                        <h2 class="text-3xl md:text-4xl font-black mb-2 tracking-tight">
                            {{ $todaySession->judul }}
                        </h2>
                        <p class="text-blue-100 font-medium text-sm">
                            {{ $todaySession->tanggal ? \Carbon\Carbon::parse($todaySession->tanggal)->translatedFormat('l, d F Y') : 'Hari Ini' }}
                        </p>
                    @else
                        <span class="inline-block px-4 py-1.5 bg-white/20 rounded-xl text-[10px] font-black uppercase tracking-widest mb-3 backdrop-blur-md border border-white/20">
                            Informasi Absensi
                        </span>
                        <h2 class="text-3xl md:text-4xl font-black mb-2 tracking-tight opacity-50">—</h2>
                        <p class="text-blue-100 font-medium text-sm">
                            Tidak ada pertemuan aktif untuk hari ini.
                        </p>
                    @endif
                </div>

                <div class="flex flex-wrap justify-center gap-3 w-full md:w-auto mt-4 md:mt-0">
                    <button @disabled(!$todaySession) class="bg-white text-blue-600 px-6 py-3.5 rounded-xl font-black text-[11px] uppercase tracking-widest hover:bg-blue-50 transition-all flex items-center gap-2 shadow-lg w-full md:w-auto justify-center disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        Buka QR Code
                    </button>

                    @if ($todaySession)
                        <a href="{{ route('dosen.attendance.manual', [$kelas->id, $todaySession->id]) }}" class="bg-slate-900 text-white px-6 py-3.5 rounded-xl font-black text-[11px] uppercase tracking-widest hover:bg-slate-800 transition-transform transform hover:-translate-y-0.5 shadow-lg w-full md:w-auto flex items-center justify-center">
                            Input Manual
                        </a>
                    @else
                        <button disabled class="bg-slate-800 text-white px-6 py-3.5 rounded-xl font-black text-[11px] uppercase tracking-widest shadow-lg w-full md:w-auto flex items-center justify-center cursor-not-allowed opacity-50 border border-slate-700">
                            Kamu tidak berhak
                        </button>
                    @endif
                </div>
            </div>

            <div class="absolute -right-10 -bottom-20 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-10 -top-10 w-40 h-40 bg-blue-400/20 rounded-full blur-2xl pointer-events-none"></div>
        </div>

        <div class="space-y-6">
            <div class="flex items-center justify-between px-2" data-aos="fade-right" data-aos-duration="600">
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Riwayat Absensi</h3>
                    <p class="text-xs font-bold text-slate-400 mt-1">Daftar presensi untuk sesi pertemuan yang telah berlalu.</p>
                </div>
            </div>

            <div class="space-y-4">
                @forelse($riwayat as $session)
                    @php
                        // Menghitung status persentase kehadiran
                        $hadir = $session->attendances()->where('status', 'H')->count() ?? 0;
                        $total = $totalMahasiswa ?? 0;
                        // Jika hadir semua (Perfect attendance)
                        $isPerfect = ($total > 0 && $hadir == $total);
                    @endphp

                    <a href="{{ route('dosen.attendance.history', [$kelas->id, $session->id]) }}" 
                       data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                       class="block bg-white border border-slate-200 rounded-[2rem] p-6 hover:shadow-xl hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
                        
                        <div class="absolute left-0 top-0 bottom-0 w-2 {{ $isPerfect ? 'bg-emerald-400 group-hover:bg-emerald-500' : 'bg-slate-200 group-hover:bg-blue-500' }} transition-colors duration-300"></div>

                        <div class="flex flex-col sm:flex-row items-center justify-between gap-6 pl-4">
                            
                            <div class="flex items-center gap-5 w-full sm:w-auto">
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center font-black text-2xl shrink-0 transition-colors {{ $isPerfect ? 'bg-emerald-50 text-emerald-600 border border-emerald-100 group-hover:bg-emerald-100' : 'bg-slate-50 text-slate-400 border border-slate-100 group-hover:bg-blue-50 group-hover:text-blue-600 group-hover:border-blue-200' }}">
                                    {{ sprintf("%02d", $session->pertemuan ?? $loop->iteration) }}
                                </div>
                                
                                <div>
                                    <h4 class="font-black text-lg text-slate-900 group-hover:text-blue-700 transition-colors mb-1 line-clamp-1">
                                        {{ $session->judul }}
                                    </h4>
                                    <div class="flex items-center gap-2 text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ $session->tanggal ? \Carbon\Carbon::parse($session->tanggal)->translatedFormat('d F Y') : '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between w-full sm:w-auto gap-6 sm:gap-8 bg-slate-50 sm:bg-transparent p-4 sm:p-0 rounded-2xl sm:rounded-none">
                                <div class="text-left sm:text-right flex-1 sm:flex-none">
                                    <span class="block text-3xl font-black {{ $isPerfect ? 'text-emerald-600' : 'text-slate-800' }} leading-none">
                                        {{ $hadir }}<span class="text-lg text-slate-400 font-bold">/{{ $total }}</span>
                                    </span>
                                    <span class="text-[9px] font-black uppercase tracking-widest mt-1 inline-block {{ $isPerfect ? 'text-emerald-500' : 'text-slate-400' }}">
                                        Mahasiswa Hadir
                                    </span>
                                </div>
                                
                                <div class="w-12 h-12 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-blue-600 group-hover:border-blue-600 group-hover:text-white transition-all shadow-sm shrink-0">
                                    <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>

                        </div>
                    </a>
                @empty
                    @if(!$todaySession)
                        <div class="p-16 flex flex-col items-center justify-center text-center bg-white border-2 border-dashed border-slate-200 rounded-[2.5rem]" data-aos="zoom-in">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-5 border border-slate-100">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-black text-slate-800 mb-1">Belum Ada Riwayat</h3>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Sesi pertemuan yang sudah lewat akan muncul di sini</p>
                        </div>
                    @endif
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