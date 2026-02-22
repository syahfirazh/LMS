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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
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
        
        <header class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-4 md:px-8 py-4 sm:py-6 sticky top-0 z-30 flex items-center justify-between">
            <div class="flex items-center gap-3 sm:gap-4 h-10 sm:h-14">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg cursor-pointer">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div>
                    <h2 class="text-lg sm:text-2xl font-black text-slate-900 tracking-tight">Kelola Ujian & Kuis</h2>
                    <p class="text-[9px] sm:text-sm font-medium text-slate-500">Bank Soal, UTS, UAS, dan Kuis Harian</p>
                </div>
            </div>
        </header>

        <div class="p-4 sm:p-6 lg:p-10 max-w-7xl mx-auto w-full space-y-8 pb-24">
            
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-bold text-sm safe-fade-in">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center justify-between safe-fade-in" style="animation-delay: 0.1s">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Ujian Aktif</p>
                        <h2 class="text-3xl font-black text-slate-900">{{ $aktif ?? 0 }}</h2>
                    </div>
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center justify-between safe-fade-in" style="animation-delay: 0.2s">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Terjadwal</p>
                        <h2 class="text-3xl font-black text-slate-900">{{ $terjadwal ?? 0 }}</h2>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center justify-between safe-fade-in" style="animation-delay: 0.3s">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Selesai</p>
                        <h2 class="text-3xl font-black text-slate-900">{{ $selesai ?? 0 }}</h2>
                    </div>
                    <div class="w-12 h-12 bg-slate-100 text-slate-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                
                {{-- FILTER TABS --}}
                <div class="flex gap-2 border-b border-slate-200 mb-6 safe-fade-in overflow-x-auto custom-scrollbar pb-2" style="animation-delay: 0.4s" id="filterTabs">
                    <button onclick="filterExams('Semua', this)" class="tab-btn px-6 py-3 border-b-2 border-slate-900 text-slate-900 font-bold text-sm whitespace-nowrap">Semua</button>
                    <button onclick="filterExams('UTS', this)" class="tab-btn px-6 py-3 border-b-2 border-transparent text-slate-400 font-bold text-sm hover:text-slate-800 transition-colors whitespace-nowrap">UTS</button>
                    <button onclick="filterExams('UAS', this)" class="tab-btn px-6 py-3 border-b-2 border-transparent text-slate-400 font-bold text-sm hover:text-slate-800 transition-colors whitespace-nowrap">UAS</button>
                    <button onclick="filterExams('Kuis', this)" class="tab-btn px-6 py-3 border-b-2 border-transparent text-slate-400 font-bold text-sm hover:text-slate-800 transition-colors whitespace-nowrap">Kuis</button>
                </div>

                {{-- Tombol Buat Ujian Baru --}}
                <div onclick="openModalExam()" class="bg-slate-50 border-2 border-dashed border-slate-300 rounded-[2.5rem] p-8 flex flex-col items-center justify-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all group min-h-[150px] safe-fade-in" style="animation-delay: 0.5s">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-sm">
                        <svg class="w-8 h-8 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <h3 class="text-lg font-black text-slate-400 group-hover:text-blue-600 transition-colors uppercase tracking-widest">Buat Ujian Baru</h3>
                </div>

                {{-- Looping Data Ujian --}}
                @forelse ($exams as $exam)
                    @php
                        $bgClass = 'bg-' . $exam->status_color . '-100';
                        $textClass = 'text-' . $exam->status_color . '-700';
                        $dateTextClass = 'text-' . $exam->status_color . '-600';
                    @endphp

                    {{-- Tambahkan atribut data-kategori untuk keperluan filtering Javascript --}}
                    <div class="exam-card group bg-white p-5 sm:p-6 rounded-[2.5rem] border border-slate-200 shadow-sm hover:shadow-lg transition-all flex flex-col md:flex-row items-center gap-6 {{ $exam->status_color == 'slate' ? 'opacity-60 hover:opacity-100' : '' }} safe-fade-in" data-kategori="{{ $exam->kategori }}" style="animation-delay: 0.6s">
                        
                        <div class="w-full md:w-20 h-20 {{ $bgClass }} {{ $dateTextClass }} rounded-3xl flex flex-col items-center justify-center shrink-0">
                            <span class="text-[9px] font-black bg-white/50 px-2 py-0.5 rounded-md mb-1">{{ $exam->kategori }}</span>
                            <span class="text-2xl font-black leading-none">{{ \Carbon\Carbon::parse($exam->waktu_mulai)->format('d') }}</span>
                            <span class="text-[10px] font-bold uppercase tracking-wider leading-none mt-1">{{ \Carbon\Carbon::parse($exam->waktu_mulai)->translatedFormat('M') }}</span>
                        </div>
                        
                        <div class="flex-1 w-full text-center md:text-left">
                            <div class="flex flex-col md:flex-row items-center gap-3 mb-1">
                                <h4 class="text-base sm:text-lg font-black text-slate-900 group-hover:text-blue-600 transition-colors">
                                    {{ $exam->judul }}
                                </h4>
                                <span class="px-3 py-1 {{ $bgClass }} {{ $textClass }} text-[9px] sm:text-[10px] font-bold rounded-full uppercase tracking-wide">
                                    {{ $exam->status_text }}
                                </span>
                            </div>
                            <p class="text-xs sm:text-sm text-slate-500 font-medium">
                                {{ $exam->kelas->mataKuliah->nama ?? 'Kelas' }} ({{ $exam->kelas->kode_kelas ?? '-' }}) • 
                                {{ \Carbon\Carbon::parse($exam->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($exam->waktu_selesai)->format('H:i') }} WIB
                            </p>
                        </div>
                        
                        <div class="flex items-center justify-between w-full md:w-auto gap-4 mt-2 md:mt-0">
                            @if($exam->status_text == 'Sedang Berlangsung')
                                <button class="px-6 py-3 bg-slate-900 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-blue-600 transition-all cursor-pointer shadow-sm hover:shadow-md">Pantau</button>
                            @elseif($exam->status_text == 'Terjadwal')
                                <button class="px-6 py-3 border border-slate-200 text-slate-500 rounded-xl font-bold text-xs uppercase tracking-widest hover:border-slate-400 hover:text-slate-800 transition-all cursor-pointer">Edit Soal</button>
                            @else
                                <button class="px-6 py-3 border border-slate-200 text-blue-600 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-blue-50 transition-all cursor-pointer">Lihat Hasil</button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 opacity-60 exam-empty">
                        <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <h4 class="text-lg font-bold text-slate-500">Belum ada ujian yang dibuat.</h4>
                    </div>
                @endforelse

                <div id="noDataFiltered" class="hidden text-center py-12 opacity-60">
                    <h4 class="text-lg font-bold text-slate-500">Tidak ada ujian di kategori ini.</h4>
                </div>

            </div>
        </div>
    </main>

    {{-- MODAL FORM BUAT UJIAN --}}
    <div id="modalExam" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm items-center justify-center p-4 transition-opacity">
        <div class="bg-white rounded-[2rem] w-full max-w-lg shadow-2xl overflow-hidden animate-pop relative max-h-[90vh] flex flex-col">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50 shrink-0">
                <h3 class="font-black text-slate-800 text-lg">Jadwalkan Ujian Baru</h3>
                <button type="button" onclick="closeModalExam()" class="text-slate-400 hover:text-red-500 transition-colors p-1"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            
            <form action="{{ route('dosen.exams.store') }}" method="POST" class="overflow-y-auto custom-scrollbar p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Mata Kuliah / Kelas</label>
                        <select name="kelas_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 font-bold text-slate-700 text-sm focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($listKelas as $kls)
                                <option value="{{ $kls->id }}">{{ $kls->mataKuliah->nama ?? 'Kelas' }} ({{ $kls->kode_kelas }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Judul Ujian</label>
                        <input type="text" name="judul" required placeholder="Contoh: UTS Pemrograman Web" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 font-bold text-slate-700 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Kategori</label>
                        <select name="kategori" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 font-bold text-slate-700 text-sm focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer">
                            <option value="Kuis">Kuis Harian</option>
                            <option value="UTS">Ujian Tengah Semester (UTS)</option>
                            <option value="UAS">Ujian Akhir Semester (UAS)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Waktu Mulai</label>
                            <input type="datetime-local" name="waktu_mulai" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 font-bold text-slate-700 text-xs focus:ring-2 focus:ring-blue-500 outline-none cursor-text">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Waktu Selesai</label>
                            <input type="datetime-local" name="waktu_selesai" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 font-bold text-slate-700 text-xs focus:ring-2 focus:ring-blue-500 outline-none cursor-text">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Deskripsi / Instruksi (Opsional)</label>
                        <textarea name="deskripsi" rows="3" placeholder="Kerjakan dengan jujur..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 font-medium text-slate-700 text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModalExam()" class="flex-1 px-4 py-3 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-100 transition-colors text-sm">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors text-sm shadow-md">Jadwalkan Ujian</button>
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
            // Ubah styling tab aktif
            const tabs = document.querySelectorAll('.tab-btn');
            tabs.forEach(tab => {
                tab.classList.remove('border-slate-900', 'text-slate-900');
                tab.classList.add('border-transparent', 'text-slate-400');
            });
            btnElement.classList.remove('border-transparent', 'text-slate-400');
            btnElement.classList.add('border-slate-900', 'text-slate-900');

            // Saring kartu ujian
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

            // Tampilkan pesan kosong jika tidak ada data
            const noDataMsg = document.getElementById('noDataFiltered');
            if (countVisible === 0 && cards.length > 0) {
                noDataMsg.classList.remove('hidden');
            } else {
                noDataMsg.classList.add('hidden');
            }
        }

        // --- Logika Modal Form Ujian ---
        const modalExam = document.getElementById('modalExam');
        function openModalExam() {
            modalExam.classList.add('modal-active');
        }
        function closeModalExam() {
            modalExam.classList.remove('modal-active');
        }
    </script>
</body>
</html>