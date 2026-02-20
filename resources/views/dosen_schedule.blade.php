<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Jadwal Mengajar | LMS Inklusi UMMI</title>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
        
        <style>
            .custom-scrollbar::-webkit-scrollbar { width: 5px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .safe-fade-in {
                animation: fadeIn 0.5s ease-out forwards;
            }
        </style>
    </head>
    <body class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-full flex flex-col lg:flex-row overflow-hidden border-box text-slate-800">
        
        <div id="mobileBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden transition-opacity"></div>

        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-80 bg-white border-r border-slate-200 flex flex-col h-screen transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="p-8 border-b border-slate-100 flex items-center gap-4">
                <img src="{{ asset('images/logo-ummi.png') }}" class="w-10 h-10 object-contain" alt="Logo" />
                <div>
                    <h1 class="text-lg font-black text-slate-900 tracking-tight leading-none">LMS Inklusi</h1>
                    <p class="text-[9px] font-bold text-blue-600 uppercase tracking-widest mt-1">Portal Dosen</p>
                </div>
                <button onclick="toggleSidebar()" class="lg:hidden ml-auto text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <nav class="flex-1 p-6 space-y-3 overflow-y-auto custom-scrollbar">
                <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span>Beranda</span>
                </a>
                <a href="{{ route('dosen.courses') }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span>Mata Kuliah</span>
                </a>
                <a href="{{ route('dosen.schedule') }}" class="flex items-center gap-4 p-4 bg-blue-50 text-blue-700 rounded-2xl font-bold transition-all shadow-sm border border-blue-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Jadwal Mengajar</span>
                </a>
                <a href="{{ route('dosen.grading') }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <span>Input Nilai</span>
                </a>
                <a href="{{ route('dosen.exams') }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Kelola Ujian</span>
                </a>
                <a href="{{ route('dosen.messages') }}" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        <span>Pesan</span>
                    </div>
                    <span class="text-[10px] bg-red-100 text-red-600 px-2 py-1 rounded-lg font-black">3</span>
                </a>
                <a href="{{ route('dosen.notifications') }}" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span>Pemberitahuan</span>
                    </div>
                    <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                </a>
                <a href="{{ route('dosen.profile') }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>Profil Saya</span>
                </a>
            </nav>

            <div class="p-6 border-t border-slate-100">
                <a href="{{ route('logout') }}" class="w-full p-4 flex items-center justify-between text-red-600 font-bold bg-red-50 rounded-2xl hover:bg-red-100 transition-all border border-red-100">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Keluar</span>
                    </div>
                </a>
            </div>
        </aside>

        <main class="flex-1 h-screen overflow-y-auto flex flex-col relative lg:ml-80 transition-all duration-300 custom-scrollbar">
            
            <header class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-8 py-6 sticky top-0 z-30 flex items-center justify-between">
                <div class="flex items-center gap-4 h-14">
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Jadwal Mengajar</h2>
                        <p class="text-sm font-medium text-slate-500">{{ now()->translatedFormat('F Y') }}</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-4">
                    <button class="flex items-center gap-2 bg-slate-900 text-white px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Unduh PDF
                    </button>
                </div>
            </header>

            <div class="p-6 lg:p-8 w-full max-w-none pb-24">
                
                @php
                    $hariIniIndo = \Carbon\Carbon::now()->locale('id')->translatedFormat('l');
                @endphp

                @foreach ($jadwalPerHari as $hari => $kelasHariIni)
                    @php
                        $isToday = ($hariIniIndo === $hari);
                    @endphp
                    
                    <div class="flex flex-col md:flex-row gap-6 mb-8 group safe-fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s">
                        
                        <div class="w-full md:w-32 pt-0 md:pt-4 md:text-right shrink-0 flex flex-row md:flex-col items-center md:items-end justify-between md:justify-start">
                            <h3 class="uppercase tracking-widest text-sm {{ $isToday ? 'font-black text-blue-600' : 'font-bold text-slate-400' }}">
                                {{ $hari }}
                            </h3>
                            @if ($isToday)
                                <span class="text-[9px] font-bold bg-blue-100 text-blue-600 px-2 py-0.5 rounded inline-block md:mt-1 animate-pulse border border-blue-200">
                                    Hari Ini
                                </span>
                            @endif
                        </div>

                        <div class="flex-1 space-y-4 border-l-2 {{ $isToday ? 'border-blue-200' : 'border-slate-200' }} pl-6 pb-4 relative">
                            <div class="absolute -left-[5px] top-6 md:top-5 w-2.5 h-2.5 rounded-full {{ $isToday ? 'bg-blue-500 ring-4 ring-blue-100' : 'bg-slate-300 ring-4 ring-white' }}"></div>

                            @forelse ($kelasHariIni as $kelas)
                                {{-- PERUBAHAN UTAMA: Tag <div> diganti <a> dan ditambahkan href --}}
                                {{-- Pastikan 'dosen.courses.show' sesuai dengan nama route di web.php Anda --}}
                                <a href="{{ route('dosen.course.manage', $kelas->id) }}" class="block bg-white p-6 rounded-[2rem] border {{ $isToday ? 'border-blue-100 shadow-md ring-1 ring-blue-50' : 'border-slate-200 shadow-sm' }} hover:shadow-lg hover:border-blue-300 transition-all cursor-pointer group/card relative overflow-hidden">
                                    
                                    <div class="absolute top-0 right-0 w-20 h-20 bg-blue-50 rounded-bl-[4rem] -mr-10 -mt-10 transition-transform group-hover/card:scale-150"></div>

                                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative z-10">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="px-2 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-lg uppercase tracking-wide border border-slate-200">
                                                    {{ $kelas->jam_mulai }} - {{ $kelas->jam_selesai }}
                                                </span>
                                                @if($isToday)
                                                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">Aktif</span>
                                                @endif
                                            </div>

                                            <h4 class="text-lg font-black text-slate-900 group-hover/card:text-blue-700 transition-colors">
                                                {{ $kelas->mataKuliah->nama ?? 'Mata Kuliah' }}
                                            </h4>
                                            
                                            <div class="flex flex-wrap items-center gap-3 mt-2 text-sm text-slate-500 font-medium">
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                    Kelas {{ $kelas->kode_kelas }}
                                                </div>
                                                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                    {{ $kelas->ruangan }}
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-slate-50 text-slate-300 group-hover/card:bg-blue-600 group-hover/card:text-white transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </div>
                                    </div>
                                </a> {{-- Tutup tag <a> --}}
                            @empty
                                <div class="p-6 rounded-[2rem] border border-dashed border-slate-200 bg-slate-50/30 flex items-center gap-4">
                                    <div class="w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center text-slate-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                    </div>
                                    <p class="text-slate-400 font-bold text-sm italic">
                                        Tidak ada jadwal kuliah.
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach

            </div>
        </main>

        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const backdrop = document.getElementById('mobileBackdrop');
                sidebar.classList.toggle('-translate-x-full');
                backdrop.classList.toggle('hidden');
            }
        </script>
    </body>
</html>