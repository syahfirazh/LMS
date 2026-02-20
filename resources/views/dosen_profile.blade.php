<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Profil Saya | Portal Dosen</title>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        /* Animasi transisi modal */
        .modal-enter { opacity: 0; transform: scale(0.95); }
        .modal-enter-active { opacity: 1; transform: scale(1); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .modal-leave { opacity: 1; transform: scale(1); }
        .modal-leave-active { opacity: 0; transform: scale(0.95); transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-full flex flex-col lg:flex-row overflow-hidden border-box text-slate-800">
    
    <div id="mobileBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden transition-opacity"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-80 bg-white border-r border-slate-200 flex flex-col h-screen transform -translate-x-full lg:translate-x-0 lg:static transition-transform duration-300 ease-in-out shrink-0">
        <div class="p-8 border-b border-slate-100 flex items-center gap-4">
            <img src="{{ asset('images/logo-ummi.png') }}" class="w-10 h-10 object-contain" alt="Logo" onerror="this.src='https://via.placeholder.com/40'" />
            <div>
                <h1 class="text-lg font-black text-slate-900 tracking-tight leading-none">LMS Inklusi</h1>
                <p class="text-[9px] font-bold text-blue-600 uppercase tracking-widest mt-1">Portal Dosen</p>
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden ml-auto text-slate-400 hover:text-slate-600 cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <nav class="flex-1 p-6 space-y-3 overflow-y-auto custom-scrollbar">

            <a href="{{ route('dosen.dashboard') }}"
               class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                <span>Beranda</span>
            </a>

            <a href="{{ route('dosen.courses') }}"
               class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <span>Mata Kuliah</span>
            </a>

            <a href="{{ route('dosen.schedule') }}"
               class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>Jadwal Mengajar</span>
            </a>

            <a href="{{ route('dosen.grading') }}"
               class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <span>Input Nilai</span>
            </a>

            <a href="{{ route('dosen.exams') }}"
               class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Kelola Ujian</span>
            </a>

            <a href="{{ route('dosen.messages') }}"
               class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                    <span>Pesan</span>
                </div>
                <span class="text-[10px] bg-red-100 text-red-600 px-2 py-1 rounded-lg font-black">3</span>
            </a>

            <a href="{{ route('dosen.notifications') }}"
               class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span>Pemberitahuan</span>
                </div>
                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
            </a>

            <a href="{{ route('dosen.profile') }}"
               class="flex items-center gap-4 p-4 bg-blue-50 text-blue-700 rounded-2xl font-bold transition-all shadow-sm border border-blue-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>Profil Saya</span>
            </a>

        </nav>

        <div class="p-6 border-t border-slate-100">
            <a href="{{ route('logout') }}" class="w-full p-4 flex items-center justify-between text-red-600 font-bold bg-red-50 rounded-2xl hover:bg-red-100 transition-all border border-red-100 text-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Keluar</span>
                </div>
            </a>
        </div>
    </aside>

    <main class="flex-1 h-screen overflow-y-auto flex flex-col relative bg-slate-50 transition-all duration-300 lg:ml-0 custom-scrollbar">
        
        <div class="absolute top-0 left-0 w-full h-80 bg-gradient-to-b from-blue-50/80 to-transparent -z-10"></div>

        <header class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-8 py-6 sticky top-0 z-20 shrink-0">
            <div class="max-w-7xl mx-auto flex items-center justify-between h-14">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg transition-all focus:outline-none focus:ring-2 focus:ring-slate-200 cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight leading-none">Identitas Diri</h2>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5 block">Informasi akademik dan personal</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="p-6 lg:p-10 max-w-6xl mx-auto w-full space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div data-aos="fade-up" class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col items-center text-center relative overflow-hidden">
                    <div class="w-40 h-40 rounded-[2rem] border-4 border-blue-50 p-1 mb-6 relative z-10 shadow-sm">
                        <img 
                            src="{{ $dosen->foto ? asset('storage/'.$dosen->foto) : 'https://ui-avatars.com/api/?name='.urlencode($dosen->nama ?? 'Dosen') }}" 
                            class="w-full h-full object-cover rounded-[1.8rem]" 
                            alt="Foto Profil" 
                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($dosen->nama ?? 'Dosen') }}'"
                        />
                    </div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight relative z-10">
                        {{ $dosen->nama ?? 'Nama Dosen' }}
                    </h2>
                    <p class="text-sm font-bold text-slate-400 mt-1 relative z-10">
                        NIDN: {{ $dosen->nidn ?? '-' }}
                    </p>
                    <div class="mt-6 flex flex-wrap justify-center gap-2 relative z-10">
                        <span class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-100">
                            Dosen Aktif
                        </span>
                        <span class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-blue-100">
                            {{ $dosen->jabatan ?? 'Tenaga Pengajar' }}
                        </span>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="100" class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 relative overflow-hidden">
                    
                    <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full blur-3xl opacity-60 -mr-16 -mt-16 pointer-events-none"></div>
                    
                    <div class="relative z-10 space-y-8">
                        <div>
                            <h3 class="text-lg font-black text-slate-900 mb-6 flex items-center gap-3">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                </svg>
                                Data Akademik Institusi
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Homebase / Program Studi</label>
                                    <p class="font-bold text-slate-800">{{ $dosen->homebase ?? 'Teknik Informatika' }}</p>
                                </div>
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Bidang Keahlian Utama</label>
                                    <p class="font-bold text-slate-800">
                                        @if(is_array($dosen->bidang_keahlian))
                                            {{ implode(', ', $dosen->bidang_keahlian) }}
                                        @else
                                            {{ $dosen->bidang_keahlian ?? 'Rekayasa Perangkat Lunak' }}
                                        @endif
                                    </p>
                                </div>
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Email Institusi (UMMI)</label>
                                    <p class="font-bold text-blue-600 text-sm truncate">{{ $dosen->email ?? '-' }}</p>
                                </div>
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Status Kepegawaian</label>
                                    <p class="font-bold text-slate-800">Dosen Tetap Yayasan</p>
                                </div>
                            </div>
                        </div>

                        <hr class="border-slate-100" />

                        <div>
                            <h3 class="text-lg font-black text-slate-900 mb-6 flex items-center gap-3">
                                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 12.284 3 6V5z"></path>
                                </svg>
                                Kontak & Pengaturan
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Nomor Handphone (WhatsApp)</label>
                                    <p class="font-bold text-slate-800">{{ $dosen->no_hp ?? '-' }}</p>
                                </div>
                                <div class="flex items-center justify-end md:justify-start gap-4">
                                    <button onclick="toggleEditModal()" type="button" class="px-6 py-3.5 bg-blue-50 text-blue-600 rounded-xl font-bold text-[11px] uppercase tracking-widest hover:bg-blue-600 hover:text-white transition-all w-full text-center cursor-pointer active:scale-95 active:cursor-wait">
                                        Edit Profil
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="200" class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-[2.5rem] p-8 shadow-xl text-white flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-md shrink-0">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black tracking-tight">Keamanan Akun</h3>
                        <p class="text-slate-300 text-sm font-medium mt-1">Ubah kata sandi secara berkala untuk perlindungan ekstra.</p>
                    </div>
                </div>
                <button type="button" class="px-8 py-3.5 bg-white text-slate-900 rounded-xl font-black text-[11px] uppercase tracking-widest hover:bg-slate-100 transition-all text-center w-full md:w-auto shrink-0 cursor-pointer active:scale-95 active:cursor-wait">
                    Ganti Password
                </button>
            </div>
        </div>
    </main>

    <div id="editModal" class="fixed inset-0 z-[100] hidden items-center justify-center px-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity cursor-pointer" onclick="toggleEditModal()"></div>
        
        <div class="bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl relative z-10 flex flex-col max-h-[90vh] modal-enter overflow-hidden" id="editModalContent">
            
            <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-white shrink-0">
                <h2 class="text-xl font-black text-slate-900">Edit Profil Anda</h2>
                <button onclick="toggleEditModal()" class="text-slate-400 hover:text-red-500 hover:bg-red-50 p-2 rounded-xl transition-all cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-8 overflow-y-auto custom-scrollbar">
                <form action="{{ route('dosen.profile.update') ?? '#' }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 rounded-[1.2rem] border-2 border-slate-100 overflow-hidden shrink-0">
                            <img src="{{ $dosen->foto ? asset('storage/'.$dosen->foto) : 'https://ui-avatars.com/api/?name='.urlencode($dosen->nama ?? 'Dosen') }}" class="w-full h-full object-cover" alt="Preview Foto">
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-slate-700 mb-2">Ganti Foto Profil</label>
                            <input type="file" name="foto" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer">
                            <p class="text-[10px] text-slate-400 mt-2">Format JPG, PNG, atau JPEG. Maksimal 2MB.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Nama Lengkap & Gelar</label>
                            <input type="text" name="nama" value="{{ $dosen->nama ?? '' }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-medium text-slate-800" required>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">No. Handphone / WA</label>
                            <input type="text" name="no_hp" value="{{ $dosen->no_hp ?? '' }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-medium text-slate-800">
                        </div>

                        <div class="space-y-2 md:col-span-2">
                            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Bidang Keahlian</label>
                            <input type="text" name="bidang_keahlian" value="{{ is_array($dosen->bidang_keahlian ?? '') ? implode(', ', $dosen->bidang_keahlian) : ($dosen->bidang_keahlian ?? '') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-medium text-slate-800" placeholder="Misal: Rekayasa Perangkat Lunak, Data Science">
                            <p class="text-[10px] text-slate-400">Gunakan tanda koma (,) jika lebih dari satu bidang.</p>
                        </div>
                        
                        <div class="md:col-span-2 bg-blue-50/50 p-4 rounded-2xl border border-blue-100 flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-xs text-slate-600 font-medium leading-relaxed">Untuk perubahan data <strong>NIDN, Email Institusi, Homebase,</strong> atau <strong>Jabatan</strong>, harap menghubungi pihak Administrasi Kepegawaian Kampus atau Bagian IT.</p>
                        </div>
                    </div>

                    <div class="pt-6 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" onclick="toggleEditModal()" class="px-6 py-3 text-slate-500 font-bold text-[11px] uppercase tracking-widest hover:bg-slate-100 rounded-xl transition-all cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold text-[11px] uppercase tracking-widest hover:bg-blue-700 rounded-xl shadow-lg shadow-blue-500/30 transition-all cursor-pointer active:scale-95 active:cursor-wait">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            AOS.init({ 
                once: true, 
                easing: 'ease-out-cubic',
                offset: 50
            });
        });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('mobileBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        // Script untuk mengatur Modal Edit
        function toggleEditModal() {
            const modal = document.getElementById('editModal');
            const modalContent = document.getElementById('editModalContent');
            
            if (modal.classList.contains('hidden')) {
                // Open modal
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    modalContent.classList.remove('modal-enter');
                    modalContent.classList.add('modal-enter-active');
                }, 10);
            } else {
                // Close modal
                modalContent.classList.remove('modal-enter-active');
                modalContent.classList.add('modal-leave-active');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    modalContent.classList.remove('modal-leave-active');
                    modalContent.classList.add('modal-enter');
                }, 200);
            }
        }
    </script>
</body>
</html>