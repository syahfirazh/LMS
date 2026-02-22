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
    <title>Profil Saya | Portal Dosen</title>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
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
            <a href="{{ route('dosen.schedule') }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
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
                @if($unreadCount > 0)
                    <span class="text-[10px] bg-red-500 text-white px-2 py-1 rounded-lg font-black shadow-sm">{{ $unreadCount }} Baru</span>
                @endif
            </a>
            <a href="{{ route('dosen.notifications') }}" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span>Pemberitahuan</span>
                </div>
            </a>
            <a href="{{ route('dosen.profile') }}" class="flex items-center gap-4 p-4 bg-blue-50 text-blue-700 rounded-2xl font-bold transition-all shadow-sm border border-blue-100">
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
        <div class="absolute top-0 left-0 w-full h-80 bg-gradient-to-b from-blue-50/80 to-transparent -z-10"></div>

        <header class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-4 md:px-8 py-4 sm:py-6 sticky top-0 z-20 shrink-0">
            <div class="max-w-7xl mx-auto flex items-center justify-between h-10 sm:h-14">
                <div class="flex items-center gap-3 sm:gap-4">
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div>
                        <h2 class="text-lg sm:text-2xl font-black text-slate-900 tracking-tight leading-none">Identitas Diri</h2>
                        <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 block">Informasi akademik dan personal</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="p-4 sm:p-6 lg:p-10 max-w-6xl mx-auto w-full space-y-6 sm:space-y-8 mb-10">
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-bold text-sm safe-fade-in">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl font-bold text-sm safe-fade-in">
                    <ul class="list-disc list-inside">@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
                {{-- Kiri: Foto & Nama --}}
                <div data-aos="fade-up" class="bg-white p-6 sm:p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col items-center text-center relative overflow-hidden">
                    <div class="w-32 h-32 sm:w-40 sm:h-40 rounded-[2rem] border-4 border-blue-50 p-1 mb-6 relative z-10 shadow-sm">
                        <img src="{{ $dosen->foto ? asset('storage/'.$dosen->foto) : 'https://ui-avatars.com/api/?name='.urlencode($dosen->nama).'&background=0D8ABC&color=fff' }}" class="w-full h-full object-cover rounded-[1.8rem]" />
                    </div>
                    <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight relative z-10">{{ $dosen->nama }}</h2>
                    <p class="text-xs sm:text-sm font-bold text-slate-400 mt-1 relative z-10">NIDN: {{ $dosen->nidn ?? '-' }}</p>
                    <div class="mt-6 flex flex-wrap justify-center gap-2 relative z-10">
                        <span class="px-3 sm:px-4 py-1.5 sm:py-2 bg-emerald-50 text-emerald-600 rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest border border-emerald-100">Dosen Aktif</span>
                        <span class="px-3 sm:px-4 py-1.5 sm:py-2 bg-blue-50 text-blue-600 rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest border border-blue-100">{{ $dosen->jabatan }}</span>
                    </div>
                </div>

                {{-- Kanan: Detail Info --}}
                <div data-aos="fade-up" data-aos-delay="100" class="lg:col-span-2 bg-white p-6 sm:p-8 rounded-[2.5rem] shadow-sm border border-slate-100 relative overflow-hidden">
                    <div class="relative z-10 space-y-6 sm:space-y-8">
                        <div>
                            <h3 class="text-base sm:text-lg font-black text-slate-900 mb-4 flex items-center gap-3">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Informasi Akun & Akademik
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                <div class="bg-slate-50 p-3 sm:p-4 rounded-2xl border border-slate-100">
                                    <label class="text-[8px] sm:text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Email / Google Link</label>
                                    <p class="font-bold text-blue-600 text-xs sm:text-sm truncate">{{ $dosen->email }}</p>
                                </div>
                                <div class="bg-slate-50 p-3 sm:p-4 rounded-2xl border border-slate-100">
                                    <label class="text-[8px] sm:text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Nomor WhatsApp</label>
                                    <p class="font-bold text-slate-800 text-xs sm:text-sm">{{ $dosen->no_hp ?? '-' }}</p>
                                </div>
                                <div class="bg-slate-50 p-3 sm:p-4 rounded-2xl border border-slate-100">
                                    <label class="text-[8px] sm:text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Homebase / Prodi</label>
                                    <p class="font-bold text-slate-800 text-xs sm:text-sm">{{ $dosen->homebase }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <button onclick="openModal('editModal')" type="button" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-bold text-[10px] sm:text-[11px] uppercase tracking-widest hover:bg-blue-700 transition-all shadow-md cursor-pointer">Edit Identitas & Email</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Keamanan --}}
            <div data-aos="fade-up" data-aos-delay="200" class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-[2.5rem] p-6 sm:p-8 shadow-xl text-white flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-md shrink-0 text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black tracking-tight">Keamanan Akun</h3>
                        <p class="text-slate-300 text-xs sm:text-sm">Ganti kata sandi secara berkala untuk perlindungan.</p>
                    </div>
                </div>
                <button onclick="openModal('passwordModal')" type="button" class="px-8 py-3.5 bg-white text-slate-900 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-100 transition-all shadow-md cursor-pointer">Ganti Password</button>
            </div>
        </div>
    </main>

    {{-- MODAL EDIT PROFIL --}}
    <div id="editModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm items-center justify-center p-4 transition-opacity">
        <div class="bg-white rounded-[2rem] w-full max-w-2xl shadow-2xl overflow-hidden animate-pop relative max-h-[90vh] flex flex-col">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50 shrink-0">
                <h2 class="text-lg font-black text-slate-900">Edit Identitas & Email</h2>
                <button onclick="closeModal('editModal')" class="text-slate-400 hover:text-red-500 p-1 transition-all cursor-pointer"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <div class="p-6 overflow-y-auto custom-scrollbar">
                <form action="{{ route('dosen.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf @method('PUT')
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4">
                        <div class="w-20 h-20 rounded-[1.2rem] border-2 border-slate-100 overflow-hidden shrink-0">
                            <img src="{{ $dosen->foto ? asset('storage/'.$dosen->foto) : 'https://ui-avatars.com/api/?name='.urlencode($dosen->nama) }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 w-full">
                            <label class="block text-xs font-bold text-slate-700 mb-2">Ganti Foto Profil</label>
                            <input type="file" name="foto" accept="image/*" class="w-full text-xs text-slate-500 cursor-pointer border border-dashed border-slate-200 p-1.5 rounded-xl bg-slate-50">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Nama Lengkap & Gelar</label>
                            <input type="text" name="nama" value="{{ $dosen->nama }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none font-medium text-sm" required>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Email Institusi</label>
                            <input type="email" name="email" value="{{ $dosen->email }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none font-medium text-sm" required>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-1">No. WhatsApp</label>
                            <input type="text" name="no_hp" value="{{ $dosen->no_hp }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none font-medium text-sm">
                        </div>
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                        <button type="button" onclick="closeModal('editModal')" class="px-6 py-3 text-slate-500 font-bold text-[10px] uppercase bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">Batal</button>
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold text-[10px] uppercase hover:bg-blue-700 rounded-xl shadow-md transition-all">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL GANTI PASSWORD --}}
    <div id="passwordModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm items-center justify-center p-4 transition-opacity">
        <div class="bg-white rounded-[2rem] w-full max-w-md shadow-2xl overflow-hidden animate-pop relative">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <h2 class="text-lg font-black text-slate-900">Ganti Password</h2>
                <button type="button" onclick="closeModal('passwordModal')" class="text-slate-400 hover:text-red-500 p-1 transition-all cursor-pointer"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <div class="p-6">
                <form action="{{ route('dosen.profile.password') }}" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Password Lama</label>
                        <input type="password" name="current_password" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-sm" required>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Password Baru</label>
                        <input type="password" name="password" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-sm" required minlength="8">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-sm" required minlength="8">
                    </div>
                    <div class="pt-4 flex gap-3 border-t border-slate-100">
                        <button type="button" onclick="closeModal('passwordModal')" class="flex-1 py-3 text-slate-500 font-bold text-[10px] uppercase bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">Batal</button>
                        <button type="submit" class="flex-1 py-3 bg-slate-900 text-white font-bold text-[10px] uppercase hover:bg-black rounded-xl shadow-md transition-all">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() { AOS.init({ once: true, easing: 'ease-out-cubic', offset: 50 }); });
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('mobileBackdrop').classList.toggle('hidden');
        }
        function openModal(id) { document.getElementById(id).classList.add('modal-active'); }
        function closeModal(id) { document.getElementById(id).classList.remove('modal-active'); }
    </script>
</body>
</html>