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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mata Kuliah | Portal Dosen</title>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
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
            <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span>Beranda</span>
            </a>
            <a href="{{ route('dosen.courses') }}" class="flex items-center gap-4 p-4 bg-blue-50 text-blue-700 rounded-2xl font-bold transition-all shadow-sm border border-blue-100">
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
            <a href="{{ route('logout') }}" class="w-full p-4 flex items-center justify-between text-red-600 font-bold bg-red-50 rounded-2xl hover:bg-red-100 transition-all border border-red-100">
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
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all focus:outline-none cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div>
                        <h2 class="text-lg sm:text-2xl font-black text-slate-900 tracking-tight leading-none">Mata Kuliah Diampu</h2>
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Semester Ganjil 2025/2026</p>
                    </div>
                </div>
            </div>
        </header>

        <div class="p-4 sm:p-6 lg:p-10 w-full max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-10">
            
            <div data-aos="fade-up" data-aos-duration="800"
                 onclick="toggleModal('modalKelas', true)"
                 class="bg-slate-50 border-2 border-dashed border-slate-300 rounded-[2.5rem] p-8 flex flex-col items-center justify-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all group min-h-[300px]">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-sm">
                    <svg class="w-8 h-8 text-slate-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-black text-slate-400 group-hover:text-blue-600 transition-colors uppercase tracking-widest text-center">
                    Buat Kelas Baru
                </h3>
            </div>

            @forelse ($kelasDiampu ?? [] as $kelas)
                <a href="{{ route('dosen.course.manage', $kelas->id) }}" data-aos="fade-up" data-aos-duration="800" data-aos-delay="{{ 100 + ($loop->index * 100) }}"
                     class="block bg-white rounded-[2.5rem] border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all group relative overflow-hidden flex flex-col min-h-[300px] cursor-pointer">
                    
                    <div class="h-32 w-full bg-slate-100 relative overflow-hidden">
                        @if($kelas->sampul)
                            <img src="{{ asset('storage/' . $kelas->sampul) }}" class="w-full h-full object-cover" alt="Sampul">
                        @else
                            <div class="w-full h-full bg-gradient-to-r from-{{ $kelas->warna ?? 'blue' }}-100 to-{{ $kelas->warna ?? 'blue' }}-200"></div>
                        @endif
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg shadow-sm">
                            <span class="text-xs font-black text-slate-700 uppercase tracking-widest">{{ $kelas->kode_kelas }}</span>
                        </div>
                    </div>

                    <div class="p-8 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-black text-slate-900 mb-1 group-hover:text-blue-600 transition-colors line-clamp-2">
                                    {{ $kelas->mataKuliah->nama ?? 'Nama Mata Kuliah' }}
                                </h3>
                                <p class="text-sm text-slate-500 font-medium flex items-center gap-2 mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $kelas->hari }}, {{ $kelas->jam_mulai }} - {{ $kelas->jam_selesai }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-auto pt-6 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-widest">
                                {{ $kelas->mahasiswa->count() ?? 0 }} Mahasiswa
                            </span>

                            <div class="flex items-center gap-1 sm:gap-2">
                                <button type="button" onclick="event.preventDefault(); event.stopPropagation(); openEditModal({{ json_encode($kelas) }})" class="p-2 rounded-lg text-slate-300 hover:bg-blue-50 hover:text-blue-500 transition-all cursor-pointer" title="Edit Kelas">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>

                                <form action="{{ route('dosen.kelas.destroy', $kelas->id) }}" method="POST" onsubmit="return confirm('Hapus kelas ini?')" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="event.stopPropagation();" class="p-2 rounded-lg text-slate-300 hover:bg-red-50 hover:text-red-500 transition-all cursor-pointer" title="Hapus Kelas">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>

                                <span class="ml-1 sm:ml-2 px-3 sm:px-4 py-2 bg-blue-50 text-blue-600 rounded-lg text-[10px] sm:text-xs font-bold group-hover:bg-blue-600 group-hover:text-white transition-all cursor-pointer">
                                    Kelola
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
            @endforelse
        </div>
    </main>

    <div id="modalKelas" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="toggleModal('modalKelas', false)"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-2xl transform scale-100 transition-transform relative overflow-hidden max-h-[90vh] overflow-y-auto custom-scrollbar">
                <form action="{{ route('dosen.kelas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <input type="hidden" id="input_kode_kelas" name="kode_kelas" value="" />

                    <div class="px-6 py-4 sm:px-8 sm:py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 sticky top-0 z-10">
                        <h3 class="text-base sm:text-lg font-black text-slate-800">Buat Kelas Baru</h3>
                        <button type="button" onclick="toggleModal('modalKelas', false)" class="text-slate-400 hover:text-red-500 transition-colors cursor-pointer bg-white p-1 rounded-full shadow-sm border border-slate-100">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Nama Mata Kuliah</label>
                            <input type="text" name="nama_mata_kuliah" placeholder="Contoh: Algoritma" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 font-bold text-slate-700 text-sm focus:ring-2 focus:ring-blue-500 outline-none" />
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">SKS</label>
                                <input type="number" name="sks" min="1" max="6" value="3" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 font-bold text-slate-700 text-sm outline-none" />
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Hari</label>
                                <select name="hari" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 font-bold text-slate-700 text-sm focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer">
                                    <option value="Senin">Senin</option><option value="Selasa">Selasa</option><option value="Rabu">Rabu</option><option value="Kamis">Kamis</option><option value="Jumat">Jumat</option><option value="Sabtu">Sabtu</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div><label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Mulai</label><input type="time" name="jam_mulai" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 font-bold text-slate-700 text-sm outline-none cursor-pointer" /></div>
                            <div><label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Selesai</label><input type="time" name="jam_selesai" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 font-bold text-slate-700 text-sm outline-none cursor-pointer" /></div>
                            <div><label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Ruang</label><input type="text" name="ruangan" placeholder="R-101" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 font-bold text-slate-700 text-sm outline-none" /></div>
                        </div>
                        <div class="flex items-center gap-4 bg-slate-50 p-3 rounded-xl border border-dashed border-slate-300">
                            <div class="shrink-0 bg-white p-2 rounded-lg text-slate-400 shadow-sm">
                                <img id="preview_create" class="w-10 h-10 object-cover rounded-lg hidden" />
                                <svg id="icon_create" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="flex-1"><label class="block text-xs font-bold text-blue-600 uppercase tracking-widest cursor-pointer hover:underline">Upload Sampul (Opsional)<input type="file" name="sampul" class="hidden" accept="image/*" onchange="previewImage(this, 'preview_create', 'icon_create')" /></label></div>
                        </div>
                    </div>

                    <div class="px-6 py-4 sm:px-8 sm:py-5 bg-slate-50 flex justify-end gap-3 rounded-b-[2rem] sticky bottom-0 border-t border-slate-200">
                        <button type="button" onclick="toggleModal('modalKelas', false)" class="px-5 py-2 rounded-lg text-sm font-bold text-slate-500 hover:bg-white hover:shadow-sm transition-all cursor-pointer">Batal</button>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 shadow-md transition-all cursor-pointer">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

   <div id="modalEditKelas" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="toggleModal('modalEditKelas', false)"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-xl transform scale-100 transition-transform relative overflow-hidden max-h-[90vh] overflow-y-auto custom-scrollbar">
            <form id="formEditKelas" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') 
                
                <input type="hidden" id="edit_kode" name="kode_kelas" value="" />

                <div class="px-6 py-4 sm:px-8 sm:py-5 border-b border-slate-100 flex justify-between items-center bg-yellow-50/50 sticky top-0 z-10">
                    <h3 class="text-base sm:text-lg font-black text-slate-800">Edit Kelas</h3>
                    <button type="button" onclick="toggleModal('modalEditKelas', false)" class="text-slate-400 hover:text-red-500 transition-colors cursor-pointer bg-white p-1 rounded-full shadow-sm border border-slate-100">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Nama Mata Kuliah</label>
                        <input type="text" id="edit_nama" name="nama_mata_kuliah" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 font-bold text-slate-700 text-sm outline-none" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">SKS</label>
                            <input type="number" name="sks" value="3" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2 font-bold text-slate-500 text-sm outline-none cursor-not-allowed" readonly />
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Hari</label>
                            <select id="edit_hari" name="hari" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 font-bold text-slate-700 text-sm outline-none cursor-pointer">
                                <option value="Senin">Senin</option><option value="Selasa">Selasa</option><option value="Rabu">Rabu</option><option value="Kamis">Kamis</option><option value="Jumat">Jumat</option><option value="Sabtu">Sabtu</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div><label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Mulai</label><input type="time" id="edit_mulai" name="jam_mulai" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 font-bold text-slate-700 text-sm outline-none cursor-pointer" /></div>
                        <div><label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Selesai</label><input type="time" id="edit_selesai" name="jam_selesai" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 font-bold text-slate-700 text-sm outline-none cursor-pointer" /></div>
                        <div><label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block">Ruang</label><input type="text" id="edit_ruang" name="ruangan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 font-bold text-slate-700 text-sm outline-none" /></div>
                    </div>

                    <div class="flex items-center gap-4 bg-slate-50 p-3 rounded-xl border border-dashed border-slate-300">
                        <div class="shrink-0 bg-white p-2 rounded-lg text-slate-400 shadow-sm">
                            <img id="preview_edit" class="w-10 h-10 object-cover rounded-lg hidden" />
                            <svg id="icon_edit" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-blue-600 uppercase tracking-widest cursor-pointer hover:underline">
                                Ganti Sampul (Opsional)
                                <input type="file" name="sampul" class="hidden" accept="image/*" onchange="previewImage(this, 'preview_edit', 'icon_edit')" />
                            </label>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 sm:px-8 sm:py-5 bg-slate-50 flex justify-end gap-3 rounded-b-[2rem] sticky bottom-0 border-t border-slate-200">
                    <button type="button" onclick="toggleModal('modalEditKelas', false)" class="px-5 py-2 rounded-lg text-sm font-bold text-slate-500 hover:bg-white transition-all cursor-pointer">Batal</button>
                    <button type="submit" class="px-6 py-2 bg-yellow-500 text-white rounded-lg text-sm font-bold hover:bg-yellow-600 shadow-md transition-all cursor-pointer">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('mobileBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        // FUNGSI UNTUK GENERATE KODE KELAS OTOMATIS
        function generateKodeKelas() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let result = '';
            for (let i = 0; i < 6; i++) {
                result += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return result;
        }

        function toggleModal(modalID, show) {
            const modal = document.getElementById(modalID);
            if (show) {
                // Generate otomatis akan diisi ke input hidden yang tidak terlihat
                if(modalID === 'modalKelas') {
                    document.getElementById('input_kode_kelas').value = generateKodeKelas();
                }

                modal.classList.remove("hidden");
                setTimeout(() => {
                    modal.querySelector('div[class*="transform"]').classList.remove("scale-95", "opacity-0");
                    modal.querySelector('div[class*="transform"]').classList.add("scale-100", "opacity-100");
                }, 10);
            } else {
                modal.querySelector('div[class*="transform"]').classList.remove("scale-100", "opacity-100");
                modal.querySelector('div[class*="transform"]').classList.add("scale-95", "opacity-0");
                setTimeout(() => { modal.classList.add("hidden"); }, 200);
            }
        }

        function openEditModal(kelas) {
            document.getElementById('edit_nama').value = kelas.mata_kuliah ? kelas.mata_kuliah.nama : 'Mata Kuliah';
            document.getElementById('edit_kode').value = kelas.kode_kelas; // Ini mengisi ke input hidden
            document.getElementById('edit_hari').value = kelas.hari;
            document.getElementById('edit_mulai').value = kelas.jam_mulai.substring(0, 5);
            document.getElementById('edit_selesai').value = kelas.jam_selesai.substring(0, 5);
            document.getElementById('edit_ruang').value = kelas.ruangan;
            document.getElementById('formEditKelas').action = `/dosen/kelas/${kelas.id}`;
            toggleModal('modalEditKelas', true);
        }

        function previewImage(input, imgId, iconId) {
            const img = document.getElementById(imgId);
            const icon = document.getElementById(iconId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    icon.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>