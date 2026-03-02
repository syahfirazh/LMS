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
    <title>Kelola Ujian | Portal Dosen</title>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .safe-fade-in { animation: fadeIn 0.6s ease-out forwards; opacity: 0; }
        
        /* Animasi Modal */
        .modal-active { display: flex !important; }
        @keyframes popUp { from { opacity: 0; transform: scale(0.95) translateY(10px); } to { opacity: 1; transform: scale(1) translateY(0); } }
        .animate-pop { animation: popUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
</head>
<body class="m-0 font-['Plus_Jakarta_Sans'] bg-slate-50 text-slate-800 antialiased h-screen flex overflow-hidden">
    
    <div id="mobileBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden transition-opacity"></div>

    {{-- SIDEBAR --}}
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
            <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
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
            {{-- Tombol Aktif Kelola Ujian --}}
            <a href="{{ route('dosen.exams') ?? '#' }}" class="flex items-center gap-4 p-4 bg-blue-50 text-blue-700 rounded-2xl font-bold transition-all shadow-sm border border-blue-100">
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
            <a href="{{ route('logout') }}" class="w-full p-4 flex items-center justify-between text-red-600 font-bold bg-red-50 rounded-2xl hover:bg-red-100 transition-all border border-red-100">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Keluar</span>
                </div>
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full relative min-w-0 bg-[#f8fafc] overflow-y-auto custom-scrollbar">
        
        {{-- BACKGROUND DEKORASI (Nuansa Biru) --}}
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute top-[-10%] right-[-5%] w-[400px] h-[400px] bg-blue-100/40 rounded-full blur-3xl opacity-50"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] bg-indigo-50/40 rounded-full blur-3xl opacity-50"></div>
        </div>

        <header class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-4 md:px-8 py-4 sm:py-6 sticky top-0 z-30 flex items-center justify-between">
            <div class="flex items-center gap-3 sm:gap-4 h-10 sm:h-14">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg cursor-pointer">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div>
                    <h2 class="text-lg sm:text-2xl font-black text-slate-900 tracking-tight">Kelola Ujian & Kuis</h2>
                    <p class="text-[10px] sm:text-sm font-medium text-slate-500 mt-0.5">Draft, Bank Soal, UTS, UAS, dan Kuis</p>
                </div>
            </div>
        </header>

        <div class="p-4 sm:p-6 lg:p-10 max-w-7xl mx-auto w-full space-y-8 pb-24 relative">
            
            {{-- Pesan Sukses / Error --}}
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-bold text-sm safe-fade-in flex items-center gap-3 shadow-sm">
                    <div class="p-1.5 bg-emerald-100 rounded-lg">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl font-bold text-sm safe-fade-in mb-6 shadow-sm">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Gagal memproses permintaan:</span>
                    </div>
                    <ul class="list-disc pl-8 font-medium text-xs space-y-1 text-red-600/80">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- KARTU STATISTIK --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-emerald-50 to-white p-6 rounded-[2rem] border border-emerald-100 shadow-sm flex items-center justify-between safe-fade-in hover:-translate-y-1 transition-transform" style="animation-delay: 0.1s">
                    <div>
                        <p class="text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-1">Berlangsung</p>
                        <h2 class="text-4xl font-black text-emerald-900">{{ $aktif ?? 0 }}</h2>
                    </div>
                    <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-white p-6 rounded-[2rem] border border-blue-100 shadow-sm flex items-center justify-between safe-fade-in hover:-translate-y-1 transition-transform" style="animation-delay: 0.2s">
                    <div>
                        <p class="text-[10px] font-black text-blue-600/70 uppercase tracking-widest mb-1">Terjadwal</p>
                        <h2 class="text-4xl font-black text-blue-900">{{ $terjadwal ?? 0 }}</h2>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-slate-100 to-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center justify-between safe-fade-in hover:-translate-y-1 transition-transform" style="animation-delay: 0.3s">
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Draft & Selesai</p>
                        <h2 class="text-4xl font-black text-slate-800">{{ $selesai ?? 0 }}</h2>
                    </div>
                    <div class="w-14 h-14 bg-slate-200 text-slate-600 rounded-2xl flex items-center justify-center shadow-inner">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                
                {{-- FILTER TABS --}}
                <div class="flex gap-2 border-b border-slate-200 mb-6 safe-fade-in overflow-x-auto custom-scrollbar pb-2" style="animation-delay: 0.4s" id="filterTabs">
                    <button onclick="filterExams('Semua', this)" class="tab-btn px-6 py-3 border-b-2 border-blue-600 text-blue-600 font-bold text-sm whitespace-nowrap transition-colors">Semua</button>
                    <button onclick="filterExams('UTS', this)" class="tab-btn px-6 py-3 border-b-2 border-transparent text-slate-400 font-bold text-sm hover:text-slate-800 transition-colors whitespace-nowrap">UTS</button>
                    <button onclick="filterExams('UAS', this)" class="tab-btn px-6 py-3 border-b-2 border-transparent text-slate-400 font-bold text-sm hover:text-slate-800 transition-colors whitespace-nowrap">UAS</button>
                    <button onclick="filterExams('Kuis', this)" class="tab-btn px-6 py-3 border-b-2 border-transparent text-slate-400 font-bold text-sm hover:text-slate-800 transition-colors whitespace-nowrap">Kuis</button>
                </div>

                {{-- TOMBOL BUAT UJIAN BARU --}}
                <div onclick="openModalExam()" class="bg-blue-50/30 border-2 border-dashed border-blue-200 hover:border-blue-400 hover:bg-blue-50 rounded-[2rem] p-6 flex flex-col items-center justify-center cursor-pointer transition-all duration-300 group min-h-[120px] safe-fade-in" style="animation-delay: 0.5s">
                    <div class="w-12 h-12 bg-white text-blue-500 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 group-hover:shadow-md transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <h3 class="text-sm font-black text-blue-600/80 group-hover:text-blue-700 transition-colors uppercase tracking-widest">Buat Ujian Baru</h3>
                </div>

                {{-- GRID UJIAN --}}
                <div class="grid grid-cols-1 gap-5">
                    @forelse ($exams as $exam)
                        @php
                            // Logika Pewarnaan Berdasarkan Status
                            if($exam->status_text == 'Draft') {
                                $bgClass = 'bg-amber-50'; $textClass = 'text-amber-700'; $dateTextClass = 'text-amber-600'; $borderClass = 'border-amber-200';
                            } elseif($exam->status_text == 'Terjadwal' || $exam->status_text == 'Belum Dimulai') {
                                $bgClass = 'bg-blue-50'; $textClass = 'text-blue-700'; $dateTextClass = 'text-blue-600'; $borderClass = 'border-blue-200';
                            } elseif($exam->status_text == 'Sedang Berlangsung') {
                                $bgClass = 'bg-emerald-50'; $textClass = 'text-emerald-700'; $dateTextClass = 'text-emerald-600'; $borderClass = 'border-emerald-200';
                            } else {
                                $bgClass = 'bg-slate-100'; $textClass = 'text-slate-700'; $dateTextClass = 'text-slate-600'; $borderClass = 'border-slate-200';
                            }
                        @endphp

                        <div class="exam-card group bg-white p-5 rounded-[2rem] border {{ $exam->status_text == 'Draft' ? 'border-dashed border-2 '.$borderClass : 'border border-slate-200' }} shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col lg:flex-row items-center gap-6 {{ $exam->status_text == 'Selesai' ? 'opacity-70 hover:opacity-100' : '' }} safe-fade-in" data-kategori="{{ $exam->kategori }}" style="animation-delay: 0.6s">
                            
                            {{-- Tanggal Box --}}
                            <div class="w-full lg:w-24 h-24 {{ $bgClass }} {{ $dateTextClass }} rounded-[1.5rem] flex flex-col items-center justify-center shrink-0 border {{ $borderClass }}">
                                <span class="text-[10px] font-black bg-white/60 px-2 py-0.5 rounded-md mb-1 shadow-sm">{{ $exam->kategori }}</span>
                                <span class="text-3xl font-black leading-none">{{ \Carbon\Carbon::parse($exam->waktu_mulai)->format('d') }}</span>
                                <span class="text-[10px] font-bold uppercase tracking-wider leading-none mt-1">{{ \Carbon\Carbon::parse($exam->waktu_mulai)->translatedFormat('M Y') }}</span>
                            </div>
                            
                            {{-- Info Box --}}
                            <div class="flex-1 w-full text-center lg:text-left pr-0">
                                <div class="flex flex-col lg:flex-row items-center gap-3 mb-2">
                                    <h4 class="text-lg sm:text-xl font-black text-slate-900 group-hover:text-blue-600 transition-colors">
                                        {{ $exam->judul }}
                                    </h4>
                                    <span class="px-3 py-1 {{ $bgClass }} {{ $textClass }} text-[10px] font-bold rounded-full uppercase tracking-wide border {{ $borderClass }}">
                                        {{ $exam->status_text }}
                                    </span>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-xs sm:text-sm text-slate-500 font-medium justify-center lg:justify-start">
                                    <span class="flex items-center gap-1.5 justify-center lg:justify-start">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        {{ $exam->kelas->mataKuliah->nama ?? 'Kelas' }} <span class="text-slate-400/70">({{ $exam->kelas->kode_kelas ?? '-' }})</span>
                                    </span>
                                    <span class="hidden sm:inline text-slate-300">•</span>
                                    <span class="flex items-center gap-1.5 justify-center lg:justify-start">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ \Carbon\Carbon::parse($exam->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($exam->waktu_selesai)->format('H:i') }} WIB
                                    </span>
                                </div>
                            </div>
                            
                            {{-- Tombol Aksi Utama --}}
                            <div class="flex flex-wrap items-center justify-center lg:justify-end w-full lg:w-auto gap-2.5 mt-4 lg:mt-0">
                                
                                {{-- JIKA DRAFT --}}
                                @if($exam->status_text == 'Draft')
                                    <a href="{{ route('dosen.exams.questions', $exam->id) }}" class="px-4 py-2 bg-amber-50 text-amber-700 border border-amber-200 rounded-xl font-bold text-xs hover:bg-amber-100 transition-all flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Lengkapi Soal
                                    </a>
                                    
                                    @php
                                        $jumlahSoal = $exam->questions()->count();
                                    @endphp

                                    @if($jumlahSoal > 0)
                                        <form action="{{ route('dosen.exams.publish', $exam->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menerbitkan ujian ini? Mahasiswa akan dapat melihat jadwalnya.')">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl font-bold text-xs hover:bg-blue-700 transition-all shadow-md flex items-center gap-2 h-full">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Terbitkan
                                            </button>
                                        </form>
                                    @else
                                        <div class="px-3 py-2 bg-red-50 border border-red-200 rounded-xl flex items-center gap-2 shadow-sm cursor-help" title="Soal ujian masih kosong. Lengkapi soal terlebih dahulu agar ujian bisa diterbitkan.">
                                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            <span class="text-[10px] font-bold text-red-600 uppercase tracking-wide leading-none pt-0.5">Belum Bisa Diterbitkan</span>
                                        </div>
                                    @endif

                                {{-- JIKA TERJADWAL --}}
                                @elseif($exam->status_text == 'Terjadwal' || $exam->status_text == 'Belum Dimulai')
                                    <a href="{{ route('dosen.exams.questions', $exam->id) }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold text-xs hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        Edit Soal
                                    </a>
                                
                                {{-- JIKA SEDANG BERLANGSUNG --}}
                                @elseif($exam->status_text == 'Sedang Berlangsung')
                                    {{-- INI SUDAH DISAMBUNGKAN KE ROUTE MONITOR --}}
                                    <a href="{{ route('dosen.exams.monitor', $exam->id) }}" class="px-4 py-2 bg-emerald-500 text-white rounded-xl font-bold text-xs hover:bg-emerald-600 transition-all shadow-md shadow-emerald-200 flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                                        Pantau
                                    </a>
                                    <form action="{{ route('dosen.exams.stop', $exam->id) }}" method="POST" onsubmit="return confirm('PERINGATAN! Anda yakin ingin menghentikan ujian ini sekarang? Waktu mahasiswa akan habis seketika.')">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-xl font-bold text-xs hover:bg-red-700 transition-all shadow-md shadow-red-200 flex items-center gap-2 h-full">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10h6v4H9z"></path></svg>
                                            Hentikan
                                        </button>
                                    </form>
                                
                                {{-- JIKA SELESAI / DIHENTIKAN --}}
                                @else
                                    {{-- INI SUDAH DISAMBUNGKAN KE ROUTE RESULTS --}}
                                    <a href="{{ route('dosen.exams.results', $exam->id) }}" class="px-4 py-2 bg-blue-50 text-blue-600 border border-blue-200 rounded-xl font-bold text-xs hover:bg-blue-100 transition-all flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                        Hasil
                                    </a>
                                    <a href="{{ route('dosen.exams.questions', $exam->id) }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold text-xs hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Tinjau
                                    </a>
                                @endif

                                {{-- TOMBOL HAPUS --}}
                                @if($exam->status_text != 'Sedang Berlangsung')
                                    <form action="{{ route('dosen.exams.destroy', $exam->id) }}" method="POST" onsubmit="return confirm('PERINGATAN! Menghapus ujian akan menghapus seluruh soal dan nilai mahasiswa yang terkait. Anda yakin?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-white border border-red-200 text-red-500 rounded-xl font-bold text-xs hover:bg-red-50 transition-all flex items-center gap-2 shadow-sm h-full" title="Hapus Ujian">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            <span class="hidden sm:inline">Hapus</span>
                                        </button>
                                    </form>
                                @endif

                            </div>

                        </div>
                    @empty
                        <div class="text-center py-20 bg-white rounded-[2rem] border border-slate-200 shadow-sm exam-empty">
                            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-5">
                                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h4 class="text-xl font-black text-slate-700">Belum ada ujian yang dibuat.</h4>
                            <p class="text-sm font-medium text-slate-500 mt-2">Klik tombol di atas untuk membuat draft ujian pertama Anda.</p>
                        </div>
                    @endforelse

                    <div id="noDataFiltered" class="hidden text-center py-20 bg-white rounded-[2rem] border border-slate-200 shadow-sm">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-600">Tidak ada ujian di kategori ini.</h4>
                    </div>

                </div>
            </div>
        </div>
    </main>

    {{-- MODAL FORM BUAT DRAFT UJIAN --}}
    <div id="modalExam" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm items-center justify-center p-4 transition-opacity">
        <div class="bg-white rounded-[2rem] w-full max-w-4xl shadow-2xl overflow-hidden animate-pop relative max-h-[90vh] flex flex-col border border-slate-100">
            <div class="p-6 md:px-8 border-b border-slate-100 flex justify-between items-center bg-slate-50 shrink-0">
                <div>
                    <h3 class="font-black text-slate-900 text-xl leading-tight">Buat Draft Ujian</h3>
                    <p class="text-[10px] font-bold text-slate-500 mt-1.5 uppercase tracking-wider">Ujian tidak akan diterbitkan sebelum soal lengkap</p>
                </div>
                <button type="button" onclick="closeModalExam()" class="text-slate-400 hover:text-red-500 transition-colors p-2.5 bg-white rounded-xl shadow-sm border border-slate-200 hover:border-red-200"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            
            <form action="{{ route('dosen.exams.store') }}" method="POST" class="overflow-y-auto custom-scrollbar p-6 md:px-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Judul Ujian</label>
                        <input type="text" name="judul" required placeholder="Contoh: UTS Pemrograman Web" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 font-bold text-slate-800 text-sm focus:ring-2 focus:ring-blue-500 outline-none hover:border-blue-300 transition-colors shadow-sm placeholder:text-slate-400 placeholder:font-medium">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Mata Kuliah / Kelas</label>
                        <select name="kelas_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 font-bold text-slate-800 text-sm focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer hover:border-blue-300 transition-colors shadow-sm">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($listKelas ?? [] as $kls)
                                <option value="{{ $kls->id }}">{{ $kls->mataKuliah->nama ?? 'Kelas' }} ({{ $kls->kode_kelas }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Kategori</label>
                        <select name="kategori" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 font-bold text-slate-800 text-sm focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer hover:border-blue-300 transition-colors shadow-sm">
                            <option value="Kuis">Kuis Harian</option>
                            <option value="UTS">Ujian Tengah Semester (UTS)</option>
                            <option value="UAS">Ujian Akhir Semester (UAS)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Waktu Mulai</label>
                        <input type="datetime-local" name="waktu_mulai" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 font-bold text-slate-800 text-sm focus:ring-2 focus:ring-blue-500 outline-none cursor-text hover:border-blue-300 transition-colors shadow-sm">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Waktu Selesai</label>
                            <input type="datetime-local" name="waktu_selesai" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 font-bold text-slate-800 text-sm focus:ring-2 focus:ring-blue-500 outline-none cursor-text hover:border-blue-300 transition-colors shadow-sm">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 flex items-center justify-between">
                            Token Ujian
                            <span class="text-blue-500 normal-case tracking-normal bg-blue-50 px-2 py-0.5 rounded-md font-bold text-[9px]">otomatis / manual</span>
                        </label>
                        <input type="text" name="token" required placeholder="Contoh: UTS-WEB-2026" class="w-full bg-blue-50/50 border border-blue-200 rounded-xl p-3.5 font-mono font-black text-blue-700 text-sm focus:ring-2 focus:ring-blue-500 outline-none uppercase placeholder:text-blue-300 shadow-inner">
                    </div>
                </div>

                <div class="mt-8 flex flex-col md:flex-row gap-3 md:justify-end">
                    <button type="button" onclick="closeModalExam()" class="w-full md:w-auto px-6 py-3.5 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-colors text-sm shadow-sm">Batal</button>
                    <button type="submit" class="w-full md:w-auto px-6 py-3.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all shadow-md shadow-blue-200 text-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Draft
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("-translate-x-full");
            document.getElementById("mobileBackdrop").classList.toggle("hidden");
        }

        // --- Logika Filter Tabs ---
        function filterExams(kategori, btnElement) {
            const tabs = document.querySelectorAll('.tab-btn');
            tabs.forEach(tab => {
                tab.classList.remove('border-blue-600', 'text-blue-600');
                tab.classList.add('border-transparent', 'text-slate-400');
            });
            btnElement.classList.remove('border-transparent', 'text-slate-400');
            btnElement.classList.add('border-blue-600', 'text-blue-600');

            const cards = document.querySelectorAll('.exam-card');
            let countVisible = 0;

            cards.forEach(card => {
                if (kategori === 'Semua' || card.getAttribute('data-kategori') === kategori) {
                    card.style.display = 'flex';
                    countVisible++;
                } else {
                    card.style.display = 'none';
                }
            });

            const noDataMsg = document.getElementById('noDataFiltered');
            if (countVisible === 0 && cards.length > 0) {
                noDataMsg.classList.remove('hidden');
            } else {
                noDataMsg.classList.add('hidden');
            }
        }

        const modalExam = document.getElementById('modalExam');
        function openModalExam() { modalExam.classList.add('modal-active'); }
        function closeModalExam() { modalExam.classList.remove('modal-active'); }
    </script>
</body>
</html>