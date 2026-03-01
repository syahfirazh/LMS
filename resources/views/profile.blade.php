<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Profil Saya | LMS Inklusi UMMI</title>

        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

        <style>
            .custom-scrollbar::-webkit-scrollbar { width: 5px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
            @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
            .safe-fade-in { animation: fadeIn 0.4s ease-out forwards; }
        </style>
    </head>

    <body class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-screen flex flex-col lg:flex-row border-box text-slate-800">
        @php
            if (!isset($mahasiswa)) {
                abort(403, 'Profil harus diakses melalui controller MahasiswaProfileController');
            }
        @endphp
        
        <div id="mobileBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden transition-opacity"></div>

        {{-- SIDEBAR --}}
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-80 bg-white border-r border-slate-200 flex flex-col h-screen transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="p-8 border-b border-slate-100 flex items-center gap-4">
                <img src="{{ asset('images/logo-ummi.png') }}" class="w-10 h-10 object-contain" alt="Logo" onerror="this.src = 'https://via.placeholder.com/40'" />
                <div>
                    <h1 class="text-lg font-black text-slate-900 tracking-tight leading-none">LMS Inklusi</h1>
                    <p class="text-[9px] font-bold text-blue-600 uppercase tracking-widest mt-1">Portal Mahasiswa</p>
                </div>
                <button onclick="toggleSidebar()" class="lg:hidden ml-auto text-slate-400 hover:text-slate-600 cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <nav class="flex-1 p-6 space-y-3 overflow-y-auto custom-scrollbar">
                <a href="{{ url('/dashboard') }}" onclick="navigasiKe(5); return false;" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span>Beranda</span>
                    </div>
                    <span class="text-[10px] bg-black text-white px-2 py-1 rounded-lg font-black shadow-sm">5</span>
                </a>

                <a href="{{ url('/mahasiswa/profile') }}" onclick="navigasiKe(6); return false;" class="flex items-center justify-between p-4 bg-blue-50 text-blue-700 rounded-2xl font-bold transition-all shadow-sm border border-blue-100">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>Profil Saya</span>
                    </div>
                    <span class="text-[10px] bg-black text-white px-2 py-1 rounded-lg font-black shadow-sm">6</span>
                </a>

                <a href="{{ url('/pemberitahuan') }}" onclick="navigasiKe(7); return false;" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span>Pemberitahuan</span>
                    </div>
                    <span class="text-[10px] bg-black text-white px-2 py-1 rounded-lg font-black shadow-sm">7</span>
                </a>

                <a href="{{ url('/pesan') }}" onclick="navigasiKe(8); return false;" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        <span>Pesan</span>
                    </div>
                    <span class="text-[10px] bg-black text-white px-2 py-1 rounded-lg font-black shadow-sm">8</span>
                </a>

                <a href="{{ url('/bantuan') }}" onclick="navigasiKe(9); return false;" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Bantuan</span>
                    </div>
                    <span class="text-[10px] bg-black text-white px-2 py-1 rounded-lg font-black shadow-sm">9</span>
                </a>
            </nav>

            <div class="p-6 border-t border-slate-100">
                <button onclick="navigasiKe(0)" class="w-full p-4 flex items-center justify-between text-red-600 font-bold bg-red-50 rounded-2xl hover:bg-red-100 transition-all border border-red-100 cursor-pointer">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Keluar</span>
                    </div>
                    <span class="text-[10px] bg-black text-white px-2 py-1 rounded-lg font-black shadow-sm">0</span>
                </button>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 min-h-screen flex flex-col relative lg:ml-80 transition-all duration-300 custom-scrollbar">
            <div class="absolute top-0 left-0 w-full h-80 bg-gradient-to-b from-blue-50 to-transparent -z-10"></div>

            <header class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-8 py-6 sticky top-0 z-30">
                <div class="max-w-7xl mx-auto flex items-center justify-between h-14">
                    <div class="flex items-center gap-4">
                        <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg cursor-pointer">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                        <div>
                            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Identitas Diri</h2>
                            <p class="text-sm font-medium text-slate-500">Informasi akademik dan personal.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-3 pr-4 border-r border-slate-200">
                            <button onclick="navigasiKe(7)" class="relative p-2 text-slate-400 hover:text-blue-600 transition-all cursor-pointer">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            </button>
                            <button onclick="navigasiKe(9)" class="p-2 text-slate-400 hover:text-blue-600 transition-all cursor-pointer">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </button>
                        </div>
                        <div class="hidden md:flex items-center gap-3 pl-4">
                            <div id="wave-container" class="flex items-center gap-[2px] h-4 w-10 justify-center">
                                <div class="wave-bar w-[2px] bg-blue-500 rounded-full h-1 transition-all"></div>
                                <div class="wave-bar w-[2px] bg-blue-400 rounded-full h-1 transition-all"></div>
                                <div class="wave-bar w-[2px] bg-blue-600 rounded-full h-1 transition-all"></div>
                            </div>
                            <span id="status-desc" class="text-[9px] font-black text-slate-400 uppercase tracking-widest w-16">Siap</span>
                        </div>
                    </div>
                </div>
            </header>

            <div class="p-6 lg:p-10 max-w-6xl mx-auto w-full space-y-8">
                
                {{-- Session Notification (Jika Berhasil Update) --}}
                @if(session('success'))
                    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-bold text-sm safe-fade-in flex items-center gap-3 shadow-sm">
                        <div class="p-1.5 bg-emerald-100 rounded-lg">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Error Notif --}}
                @if($errors->any())
                    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl font-bold text-sm safe-fade-in flex flex-col gap-2 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="p-1.5 bg-red-100 rounded-lg">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </div>
                            Ada kesalahan pada inputan Anda:
                        </div>
                        <ul class="list-disc list-inside pl-10 text-xs font-medium">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Kartu Foto & Status --}}
                    <div data-aos="fade-up" class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col items-center text-center relative overflow-hidden">
                        <div class="w-40 h-40 rounded-[2rem] border-4 border-blue-50 p-1 mb-6 relative group">
                            @php
                                $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($mahasiswa->nama) . '&background=0D8ABC&color=fff';
                                $foto = $mahasiswa->foto ? asset('storage/'.$mahasiswa->foto) : $avatarUrl;
                            @endphp
                            <img src="{{ $foto }}" onerror="this.onerror=null; this.src='{{ $avatarUrl }}';" class="w-full h-full object-cover rounded-[1.8rem]" />
                        </div>
                        
                        <h2 class="text-xl font-black text-slate-900 tracking-tight">{{ $mahasiswa->nama }}</h2>
                        <p class="text-sm font-bold text-slate-400 mt-1">{{ $mahasiswa->nim }}</p>
                        
                        <div class="mt-6 flex flex-wrap justify-center gap-2">
                            <span class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-100">
                                {{ $mahasiswa->status ?? 'Aktif' }}
                            </span>
                            <span class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-blue-100">
                                Semester {{ $mahasiswa->semester ?? '-' }}
                            </span>
                        </div>
                    </div>

                    {{-- Detail Akademik & Kontak --}}
                    <div data-aos="fade-up" data-aos-delay="100" class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full blur-3xl opacity-50 -mr-16 -mt-16 pointer-events-none"></div>

                        <div class="relative z-10 space-y-8">
                            {{-- Section Akademik --}}
                            <div>
                                <h3 class="text-lg font-black text-slate-900 mb-6 flex items-center gap-3">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                    Data Akademik
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Program Studi</label>
                                        <p class="font-bold text-slate-800">{{ $mahasiswa->prodi ?? '-' }}</p>
                                    </div>
                                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Fakultas</label>
                                        <p class="font-bold text-slate-800">{{ $mahasiswa->fakultas ?? '-' }}</p>
                                    </div>
                                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Tahun Masuk</label>
                                        <p class="font-bold text-slate-800">{{ $mahasiswa->tahun_masuk ?? '-' }}</p>
                                    </div>
                                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Email Kampus</label>
                                        <p class="font-bold text-blue-600 text-sm truncate">{{ $mahasiswa->email_kampus ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-slate-100" />

                            {{-- Section Kontak Pribadi --}}
                            <div>
                                <div class="flex justify-between items-center mb-6">
                                    <h3 class="text-lg font-black text-slate-900 flex items-center gap-3">
                                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 12.284 3 6V5z"></path></svg>
                                        Kontak Pribadi
                                    </h3>
                                    <button onclick="bukaModalEdit()" class="text-[10px] bg-slate-100 hover:bg-blue-100 text-blue-600 font-bold px-3 py-1.5 rounded-lg uppercase tracking-widest transition-colors">
                                        <span class="bg-blue-600 text-white px-1.5 py-0.5 rounded mr-1">1</span> Edit
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Nomor Handphone</label>
                                        <p class="font-bold text-slate-800">{{ $mahasiswa->no_hp ?? '-' }}</p>
                                    </div>
                                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Email Pribadi</label>
                                        <p class="font-bold text-slate-800 text-sm truncate">{{ $mahasiswa->email_pribadi ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Banner Ganti Password --}}
                <div data-aos="fade-up" data-aos-delay="200" class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-[2.5rem] p-8 shadow-xl text-white flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-6">
                        <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-md">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black tracking-tight">Keamanan Akun</h3>
                            <p class="text-slate-300 text-sm font-medium">Ubah kata sandi secara berkala untuk perlindungan ekstra.</p>
                        </div>
                    </div>
                    <button onclick="bukaModalPassword()" class="px-8 py-4 bg-white text-slate-900 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-50 transition-all cursor-pointer flex items-center gap-2">
                        <span class="bg-slate-200 text-slate-800 px-1.5 py-0.5 rounded">2</span> Ganti Password
                    </button>
                </div>
            </div>
        </main>

        {{-- MODAL EDIT PROFIL --}}
        <div id="modalEdit" class="fixed inset-0 z-50 hidden items-center justify-center">
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="tutupModalEdit()"></div>
            <div class="bg-white rounded-[2rem] w-full max-w-md p-8 relative z-10 shadow-2xl safe-fade-in mx-4">
                <button onclick="tutupModalEdit()" class="absolute top-4 right-4 w-8 h-8 bg-slate-100 text-slate-500 rounded-full flex items-center justify-center font-bold hover:bg-slate-200 transition-colors">✕</button>
                <h3 class="text-2xl font-black text-slate-900 mb-2">Edit Kontak</h3>
                <p class="text-sm text-slate-500 mb-6">Perbarui informasi kontak pribadi Anda.</p>
                
                {{-- Gunakan Route /mahasiswa/profile/update seperti yg biasa dipakai Laravel --}}
                <form action="{{ url('/mahasiswa/profile/update') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Nomor Handphone</label>
                        <input type="text" name="no_hp" value="{{ $mahasiswa->no_hp }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all" placeholder="08xxxxxxxx">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Email Pribadi</label>
                        <input type="email" name="email_pribadi" value="{{ $mahasiswa->email_pribadi }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all" placeholder="email@gmail.com">
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white font-black py-4 rounded-xl text-xs uppercase tracking-widest hover:bg-blue-700 transition-all mt-4">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        {{-- MODAL GANTI PASSWORD --}}
        <div id="modalPassword" class="fixed inset-0 z-50 hidden items-center justify-center">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="tutupModalPassword()"></div>
            <div class="bg-white rounded-[2rem] w-full max-w-md p-8 relative z-10 shadow-2xl safe-fade-in mx-4">
                <button onclick="tutupModalPassword()" class="absolute top-4 right-4 w-8 h-8 bg-slate-100 text-slate-500 rounded-full flex items-center justify-center font-bold hover:bg-slate-200 transition-colors">✕</button>
                <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3 class="text-2xl font-black text-slate-900 mb-2">Ganti Password</h3>
                <p class="text-sm text-slate-500 mb-6">Silakan masukkan password lama dan password baru Anda.</p>
                
                {{-- Gunakan Route /mahasiswa/profile/password --}}
                <form action="{{ url('/mahasiswa/profile/password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Password Lama</label>
                        <input type="password" name="old_password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Password Baru</label>
                        <input type="password" name="new_password" required minlength="8" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" required minlength="8" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition-all">
                    </div>
                    <button type="submit" class="w-full bg-slate-900 text-white font-black py-4 rounded-xl text-xs uppercase tracking-widest hover:bg-orange-600 transition-all mt-4">
                        Update Password
                    </button>
                </form>
            </div>
        </div>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({ once: true, easing: "ease-out-cubic" });

            function toggleSidebar() {
                document.getElementById("sidebar").classList.toggle("-translate-x-full");
                document.getElementById("mobileBackdrop").classList.toggle("hidden");
            }

            function bukaModalEdit() {
                document.getElementById('modalEdit').classList.remove('hidden');
                document.getElementById('modalEdit').classList.add('flex');
            }
            function tutupModalEdit() {
                document.getElementById('modalEdit').classList.add('hidden');
                document.getElementById('modalEdit').classList.remove('flex');
            }

            function bukaModalPassword() {
                document.getElementById('modalPassword').classList.remove('hidden');
                document.getElementById('modalPassword').classList.add('flex');
            }
            function tutupModalPassword() {
                document.getElementById('modalPassword').classList.add('hidden');
                document.getElementById('modalPassword').classList.remove('flex');
            }

            // ==========================================
            // LOGIKA VOICE ASSISTANT
            // ==========================================
            const statusDesc = document.getElementById("status-desc");
            const waveBars = document.querySelectorAll(".wave-bar");
            const synth = window.speechSynthesis;
            const SpeechRec = window.webkitSpeechRecognition || window.SpeechRecognition;
            let rec = null;
            let interval;

            if (SpeechRec) {
                rec = new SpeechRec();
                rec.lang = "id-ID";
                rec.continuous = true;
            }

            function setWave(active) {
                if (waveBars.length > 0) {
                    waveBars.forEach((bar) => {
                        bar.style.height = active ? `${Math.floor(Math.random() * 12) + 4}px` : "4px";
                    });
                }
            }

            function bicara(teks, callback) {
                synth.cancel();
                const utter = new SpeechSynthesisUtterance(teks);
                utter.lang = "id-ID";
                utter.rate = localStorage.getItem("speechRate") ? parseFloat(localStorage.getItem("speechRate")) : 1.0;

                utter.onstart = () => {
                    if (statusDesc) statusDesc.innerText = "BERBICARA...";
                    interval = setInterval(() => setWave(true), 150);
                };

                utter.onend = () => {
                    if (statusDesc) statusDesc.innerText = "MENDENGARKAN...";
                    clearInterval(interval);
                    setWave(false);
                    if (callback) callback();
                };

                synth.speak(utter);
            }

            function getPanduanUtama(isInitial = false) {
                let teks = "";
                if(isInitial && "{{ session('success') }}") {
                    teks += "Pembaruan berhasil disimpan. ";
                }
                teks += "Halo {{ $mahasiswa->nama }}, ini adalah halaman Profil Anda. ";
                teks += "Sebutkan angka satu untuk Mengedit Kontak Pribadi. Sebutkan angka dua untuk Mengganti Password. ";
                teks += "Atau sebutkan menu lain seperti lima untuk Beranda, tujuh untuk Pemberitahuan, delapan untuk Pesan, dan nol untuk Keluar. ";
                teks += "Katakan Ulang jika butuh panduan lagi.";
                
                return teks;
            }

            function navigasiKe(nomor) {
                let tujuan = "";
                let teks = "";

                if (nomor === 1) {
                    teks = "Membuka formulir edit kontak. Silakan ketik data baru Anda menggunakan keyboard.";
                    bicara(teks, () => { bukaModalEdit(); if(rec) rec.start(); });
                    return;
                } else if (nomor === 2) {
                    teks = "Membuka formulir ganti password. Gunakan keyboard untuk mengetik.";
                    bicara(teks, () => { bukaModalPassword(); if(rec) rec.start(); });
                    return;
                } else if (nomor === 5) {
                    tujuan = "{{ url('/dashboard') }}";
                    teks = "Kembali ke Beranda.";
                } else if (nomor === 6) {
                    teks = "Anda sudah berada di Halaman Profil.";
                } else if (nomor === 7) {
                    tujuan = "{{ url('/pemberitahuan') }}";
                    teks = "Membuka Pemberitahuan.";
                } else if (nomor === 8) {
                    tujuan = "{{ url('/pesan') }}";
                    teks = "Membuka Pesan.";
                } else if (nomor === 9) {
                    tujuan = "{{ url('/bantuan') }}";
                    teks = "Membuka Bantuan.";
                } else if (nomor === 0) {
                    tujuan = "{{ url('/logout') }}";
                    teks = "Keluar akun. Sampai jumpa.";
                }

                if (teks !== "") {
                    bicara(teks, () => {
                        if (tujuan !== "" && tujuan !== "#") {
                            setTimeout(() => { window.location.href = tujuan; }, 1500);
                        } else {
                            try { rec.start(); } catch(e) {}
                        }
                    });
                }
            }

            function mulaiMendengar() {
                if (!rec) return;
                try {
                    rec.start();
                    rec.onresult = (event) => {
                        const hasil = event.results[event.results.length - 1][0].transcript.toLowerCase().trim();
                        
                        if(hasil.includes("ulang") || hasil.includes("panduan") || hasil.includes("bantuan")) {
                            rec.stop();
                            bicara(getPanduanUtama(false), () => { rec.start(); });
                            return;
                        }

                        const angka = hasil.match(/\d+/);

                        if (angka) navigasiKe(parseInt(angka[0]));
                        else if (hasil.includes("satu") || hasil.includes("edit")) { rec.stop(); navigasiKe(1); }
                        else if (hasil.includes("dua") || hasil.includes("password") || hasil.includes("sandi")) { rec.stop(); navigasiKe(2); }
                        else if (hasil.includes("lima") || hasil.includes("beranda")) { rec.stop(); navigasiKe(5); }
                        else if (hasil.includes("enam") || hasil.includes("profil")) { rec.stop(); navigasiKe(6); }
                        else if (hasil.includes("tujuh") || hasil.includes("pemberitahuan")) { rec.stop(); navigasiKe(7); }
                        else if (hasil.includes("delapan") || hasil.includes("pesan")) { rec.stop(); navigasiKe(8); }
                        else if (hasil.includes("sembilan")) { rec.stop(); navigasiKe(9); }
                        else if (hasil.includes("nol") || hasil.includes("keluar") || hasil.includes("kembali")) { rec.stop(); navigasiKe(0); }
                    };

                    rec.onend = () => { rec.start(); };
                } catch (e) {
                    console.error("Error recognition:", e);
                }
            }

            window.onload = () => {
                document.body.addEventListener("click", () => {}, { once: true });
                setTimeout(() => {
                    bicara(getPanduanUtama(true), () => {
                        mulaiMendengar();
                    });
                }, 800);
            };
        </script>
    </body>
</html>