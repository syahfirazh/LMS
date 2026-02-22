<!DOCTYPE html>
@php
    $dosenId = Auth::guard('dosen')->id();
    $unreadCount = \App\Models\Message::where('receiver_type', 'dosen')
                    ->where('receiver_id', $dosenId)
                    ->where('is_read', 0)
                    ->count();
@endphp
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Dashboard Dosen | LMS Inklusi UMMI</title>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
    </style>
</head>
<body class="m-0 font-['Plus_Jakarta_Sans'] bg-slate-50 text-slate-800 antialiased h-screen flex overflow-hidden">
    
    <div id="mobileBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden transition-opacity"></div>

    <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-80 bg-white border-r border-slate-200 flex flex-col h-full transform -translate-x-full lg:translate-x-0 transition-transform duration-300 shrink-0 shadow-2xl lg:shadow-none">
        <div class="p-8 border-b border-slate-100 flex items-center gap-4 shrink-0">
            <img src="{{ asset('images/logo-ummi.png') }}" class="w-10 h-10 object-contain" alt="Logo" onerror="this.src='https://ui-avatars.com/api/?name=UMMI&background=0D8ABC&color=fff'" />
            <div>
                <h1 class="text-lg font-black text-slate-900 tracking-tight leading-none">LMS Inklusi</h1>
                <p class="text-[9px] font-bold text-blue-600 uppercase tracking-widest mt-1">Portal Dosen</p>
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden ml-auto text-slate-400 hover:text-slate-600 bg-slate-50 p-2 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <nav class="flex-1 p-6 space-y-3 overflow-y-auto custom-scrollbar">
            <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-4 p-4 bg-blue-50 text-blue-700 rounded-2xl font-bold transition-all shadow-sm border border-blue-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span>Beranda</span>
            </a>
            <a href="{{ route('dosen.courses') }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span>Mata Kuliah</span>
            </a>
            <a href="{{ route('dosen.schedule') ?? '#' }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Jadwal Mengajar</span>
            </a>
            <a href="{{ route('dosen.grading') ?? '#' }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span>Input Nilai</span>
            </a>
            <a href="{{ route('dosen.exams') ?? '#' }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Kelola Ujian</span>
            </a>
            <a href="{{ route('dosen.messages') }}" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    <span>Pesan</span>
                </div>
                @if($unreadCount > 0)
                    <span class="text-[10px] bg-red-500 text-white px-2 py-1 rounded-lg font-black shadow-sm">{{ $unreadCount }} Baru</span>
                @endif
            </a>
            <a href="{{ route('dosen.notifications') ?? '#' }}" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span>Pemberitahuan</span>
                </div>
            </a>
            <a href="{{ route('dosen.profile') ?? '#' }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span>Profil Saya</span>
            </a>
        </nav>

        <div class="p-6 border-t border-slate-100 shrink-0">
            <a href="{{ route('logout.dosen') }}" class="w-full p-4 flex items-center justify-between text-red-600 font-bold bg-red-50 rounded-2xl hover:bg-red-100 transition-all border border-red-100">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Keluar</span>
                </div>
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full relative min-w-0 bg-[#f8fafc] overflow-y-auto custom-scrollbar">
        
        <header class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-4 md:px-8 py-4 sm:py-6 sticky top-0 z-30">
            <div class="max-w-7xl mx-auto flex items-center justify-between h-10 sm:h-14">
                <div class="flex items-center gap-3 sm:gap-4">
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-800 rounded-lg cursor-pointer">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div>
                        <h2 class="text-lg sm:text-2xl font-black text-slate-900 tracking-tight leading-none">Halo, Pak {{ explode(' ', Auth::guard('dosen')->user()->nama ?? 'Dosen')[0] }}</h2>
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $tanggalLengkap ?? now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>
                <div class="flex items-cen!ter gap-4">
                    <a href="{{ route('dosen.profile') }}" class="flex items-center gap-3 cursor-pointer group">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-black text-slate-900 group-hover:text-blue-600 transition-colors">{{ Auth::guard('dosen')->user()->nama ?? 'Dosen' }}</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">NIDN: {{ Auth::guard('dosen')->user()->nidn ?? '0000' }}</p>
                        </div>
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-slate-200 overflow-hidden border-2 border-white shadow-md">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('dosen')->user()->nama ?? 'Dosen') }}&background=0D8ABC&color=fff" alt="Profile" class="w-full h-full object-cover" />
                        </div>
                    </a>
                </div>
            </div>
        </header>

        <div class="p-4 sm:p-6 lg:p-10 max-w-7xl mx-auto w-full space-y-8 sm:space-y-10 mb-10">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                <div data-aos="fade-up" data-aos-delay="100" class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-all">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center font-black text-xl shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kelas Diampu</p>
                        <h3 class="text-2xl font-black text-slate-900">{{ $totalMatkul ?? 0 }} <span class="text-sm font-bold text-slate-500">Kelas</span></h3>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="200" class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-all">
                    <div class="w-14 h-14 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center font-black text-xl shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Mahasiswa</p>
                        <h3 class="text-2xl font-black text-slate-900">{{ $totalMahasiswa ?? 0 }} <span class="text-sm font-bold text-slate-500">Orang</span></h3>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="300" class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-all sm:col-span-2 md:col-span-1">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center font-black text-xl shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Perlu Dinilai</p>
                        <h3 class="text-2xl font-black text-slate-900">{{ $totalPenilaian ?? 0 }} <span class="text-sm font-bold text-slate-500">Tugas</span></h3>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 sm:gap-10">
                <div class="lg:col-span-2 flex flex-col gap-6">
                    <div class="flex justify-between items-center px-2" data-aos="fade-left" data-aos-delay="400">
                        <h3 class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-wide">Mata Kuliah Diampu</h3>
                        <a href="{{ route('dosen.courses') }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua</a>
                    </div>

                    <div class="flex flex-col gap-4">
                        @forelse($kelasDiampu ?? [] as $kelas)
                        @php
                            $colors = ['blue', 'purple', 'emerald', 'orange', 'pink'];
                            $color = $colors[$loop->index % count($colors)];
                            $delay = 400 + ($loop->index * 100); 
                        @endphp
                        
                        <a href="{{ route('dosen.course.manage', $kelas->id) }}" data-aos="fade-up" data-aos-delay="{{ $delay }}"
                             class="block group bg-white p-5 rounded-[1.5rem] border border-slate-200 shadow-sm hover:border-{{ $color }}-300 hover:shadow-md transition-all cursor-pointer">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6 justify-between">
                                <div class="flex items-center gap-4 sm:gap-5 w-full sm:w-auto">
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-{{ $color }}-100 text-{{ $color }}-600 rounded-2xl flex items-center justify-center shrink-0 font-black text-lg group-hover:bg-{{ $color }}-600 group-hover:text-white transition-all">
                                        {{ strtoupper(substr($kelas->mataKuliah->nama ?? 'MK', 0, 2)) }}
                                    </div>
                                    <div>
                                        <h4 class="text-sm sm:text-base font-black text-slate-900 group-hover:text-{{ $color }}-700 transition-colors">
                                            {{ $kelas->mataKuliah->nama ?? 'Mata Kuliah' }}
                                        </h4>
                                        <div class="flex flex-wrap gap-2 mt-1">
                                            <span class="px-2 py-0.5 bg-slate-100 rounded-md text-[9px] sm:text-[10px] font-bold uppercase tracking-widest text-slate-500">
                                                Kelas {{ $kelas->kode_kelas ?? '-' }}
                                            </span>
                                            <span class="px-2 py-0.5 bg-{{ $color }}-50 text-{{ $color }}-600 rounded-md text-[9px] sm:text-[10px] font-bold uppercase tracking-widest border border-{{ $color }}-100">
                                                {{ $kelas->sks ?? 3 }} SKS
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between w-full sm:w-auto gap-4 sm:gap-8 border-t sm:border-t-0 border-slate-100 pt-3 sm:pt-0">
                                    <div class="text-left sm:text-right">
                                        <p class="text-xs text-slate-500 font-medium flex items-center gap-2">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $kelas->hari ?? 'Senin' }}, {{ $kelas->jam_mulai ?? '08:00' }}
                                        </p>
                                    </div>

                                    <div class="flex items-center gap-3 sm:gap-4">
                                        <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 bg-slate-50 px-3 py-1 rounded-lg border border-slate-100">
                                            {{ $kelas->mahasiswa->count() ?? 0 }} Mhs
                                        </span>
                                        <div class="w-8 h-8 rounded-full border border-slate-200 flex items-center justify-center group-hover:bg-{{ $color }}-50 transition-all shrink-0 hidden sm:flex">
                                            <svg class="w-4 h-4 text-slate-400 group-hover:text-{{ $color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="p-8 text-center bg-white rounded-[2rem] border border-dashed border-slate-300">
                            <p class="text-slate-500 font-bold text-sm">Belum ada kelas yang diampu.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <div data-aos="fade-left" data-aos-delay="600" data-aos-duration="800">
                    <h3 class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-wide mb-4 sm:mb-6">Mengajar Hari Ini</h3>
                    
                    <div class="bg-white p-5 sm:p-6 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-6">
                        @forelse($jadwalHariIni ?? [] as $jadwal)
                        <div class="flex gap-4 relative">
                            <div class="flex flex-col items-center">
                                <div class="w-3 h-3 rounded-full {{ $jadwal['status'] == 'berlangsung' ? 'bg-blue-500 ring-4 ring-blue-100' : 'bg-slate-300' }}"></div>
                                @if(!$loop->last)
                                <div class="w-0.5 h-full bg-slate-100 my-1"></div>
                                @endif
                            </div>
                            <div class="pb-6">
                                <span class="text-[10px] sm:text-xs font-bold {{ $jadwal['status'] == 'berlangsung' ? 'text-blue-600' : 'text-slate-400' }}">
                                    {{ $jadwal['jam_mulai'] }} - {{ $jadwal['jam_selesai'] }}
                                </span>
                                <h4 class="font-bold text-xs sm:text-sm mt-1 {{ $jadwal['status'] == 'berlangsung' ? 'text-slate-900' : 'text-slate-500' }}">
                                    {{ $jadwal['mata_kuliah'] }} 
                                    <span class="font-normal text-slate-400">({{ $jadwal['kelas'] }})</span>
                                </h4>
                                <p class="text-[10px] sm:text-xs text-slate-500 mt-1">{{ $jadwal['ruangan'] ?? 'Online' }}</p>
                                @if($jadwal['status'] == 'berlangsung')
                                <span class="inline-block mt-2 px-2 py-1 bg-emerald-100 text-emerald-700 text-[9px] font-bold rounded uppercase tracking-wider">Sedang Berlangsung</span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <div class="w-14 h-14 sm:w-16 sm:h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-xs sm:text-sm font-bold text-slate-900">Tidak ada jadwal hari ini.</p>
                            <p class="text-[10px] sm:text-xs text-slate-400 mt-1">Istirahatlah sejenak, Pak!</p>
                        </div>
                        @endforelse
                    </div>

                    <div class="mt-6 bg-orange-50 p-5 sm:p-6 rounded-[2rem] border border-orange-100">
                        <div class="flex gap-3">
                            <div class="p-2 bg-white rounded-lg text-orange-500 shadow-sm h-fit shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-orange-800 text-xs sm:text-sm">Batas Waktu Penilaian</h4>
                                <p class="text-[10px] sm:text-xs text-orange-600 mt-1 leading-relaxed">Segera input nilai mahasiswa sebelum periode akademik berakhir minggu depan.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, easing: 'ease-out-cubic' });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('mobileBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }
    </script>
</body>
</html>