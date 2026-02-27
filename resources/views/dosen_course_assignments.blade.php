<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Kelola Penugasan | Portal Dosen</title>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        
        /* Modal Animation Classes */
        .modal-active { opacity: 1 !important; pointer-events: auto !important; }
        .modal-content-active { transform: scale(1) translateY(0) !important; opacity: 1 !important; }
    </style>
</head>
<body class="font-['Plus_Jakarta_Sans'] bg-[#f1f5f9] text-slate-800 min-h-full flex flex-col border-box overflow-x-hidden overflow-y-scroll selection:bg-blue-200 relative">
    
    {{-- NAVBAR UTAMA --}}
    <div class="w-full bg-white/80 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm transition-all">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-5">
            
            <div class="flex items-center gap-4 w-full md:w-auto">
                <a href="{{ route('dosen.courses') }}" class="w-12 h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all shadow-sm shrink-0 group">
                    <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="overflow-hidden">
                    <h1 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight leading-tight truncate">
                        {{ $kelas->mataKuliah->nama }}
                    </h1>
                    <div class="flex items-center gap-3 mt-1">
                        <span class="text-[10px] font-black text-blue-700 uppercase tracking-widest bg-blue-100 px-2.5 py-1 rounded-md">
                            Kelas {{ $kelas->kode_kelas }}
                        </span>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">
                            Dosen: {{ auth('dosen')->user()->nama }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="hidden md:block w-px h-10 bg-slate-200"></div>

            <nav class="w-full md:w-auto flex p-1.5 bg-slate-100/80 rounded-2xl overflow-x-auto scrollbar-hide snap-x gap-2 border border-slate-200/50">
                <a href="{{ route('dosen.course.manage', $kelas->id) }}" class="snap-start shrink-0 px-6 py-2.5 rounded-xl text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/60 flex items-center justify-center">
                    Materi & Modul
                </a>
                <a href="{{ route('dosen.attendance.index', $kelas->id) }}" class="snap-start shrink-0 px-6 py-2.5 rounded-xl text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/60 flex items-center justify-center">
                    Absensi
                </a>
                <a href="{{ route('dosen.course.assignments', $kelas->id) }}" class="snap-start shrink-0 px-6 py-2.5 rounded-xl bg-white text-blue-700 font-black text-[10px] uppercase tracking-widest shadow-sm border border-slate-200/60 whitespace-nowrap transition-all flex items-center justify-center">
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

    {{-- KONTEN UTAMA --}}
    <main class="flex-1 max-w-7xl mx-auto p-4 md:p-8 w-full space-y-10 mb-20 relative z-10">
        
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-emerald-100 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl relative flex items-center gap-3" role="alert">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                <span class="block sm:inline font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error') || $errors->any())
            <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative flex items-center gap-3" role="alert">
                <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                <span class="block sm:inline font-bold text-sm">{{ session('error') ?? 'Terdapat kesalahan pada input form Anda.' }}</span>
            </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-slate-200 pb-6" data-aos="fade-down">
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">Daftar Penugasan</h2>
                <p class="text-sm text-slate-500 font-medium mt-1">Kelola tugas, kuis, dan pantau pengumpulan mahasiswa.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
               <a href="{{ route('dosen.assignment.recap', $kelas->id) }}" class="w-full sm:w-auto px-6 py-3.5 bg-white border-2 border-slate-200 text-slate-600 rounded-xl font-black text-[11px] uppercase tracking-widest hover:bg-slate-50 hover:border-blue-300 hover:text-blue-600 transition-all flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v1a3 3 0 106 0v-1m-6 0a3 3 0 006 0v-1m-6 0h6m-6-5h6m-6-4h6M4 21h16a2 2 0 002-2V5a2 2 0 00-2-2H4a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Rekap Nilai
                </a>

                {{-- TOMBOL TRIGGER MODAL BUAT TUGAS --}}
                <button type="button" onclick="openCreateModal()" class="w-full sm:w-auto px-6 py-3.5 bg-blue-600 text-white rounded-xl font-black text-[11px] uppercase tracking-widest hover:bg-blue-700 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 shadow-lg shadow-blue-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat Tugas
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            @forelse($assignments as $assignment)
            @php
                $isPublished = $assignment->status === 'published';
                $hadirCount = $assignment->submissions_count ?? 0;
                $totalCount = $kelas->mahasiswa_count ?? 0;
            @endphp
            
            <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}" class="group bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm hover:shadow-xl hover:border-blue-300 transition-all duration-300 flex flex-col sm:flex-row items-center justify-between gap-5 relative overflow-hidden transform hover:-translate-y-1">
                
                <div class="absolute left-0 top-0 bottom-0 w-2 {{ $isPublished ? 'bg-blue-500' : 'bg-slate-300' }} transition-colors"></div>

                <div class="flex items-center gap-5 w-full sm:w-auto pl-2">
                    <div class="w-14 h-14 {{ $isPublished ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-slate-50 text-slate-400 border-slate-100' }} rounded-2xl flex items-center justify-center font-black text-xl shrink-0 border group-hover:scale-105 transition-transform">
                        T{{ $loop->iteration }}
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="font-black text-slate-900 text-lg mb-1 group-hover:text-blue-700 transition-colors truncate">
                            {{ $assignment->judul }}
                        </h4>
                        <div class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-widest">
                            @if($assignment->deadline)
                                <span class="text-orange-600 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                    Deadline: {{ \Carbon\Carbon::parse($assignment->deadline)->translatedFormat('d M Y') }}
                                </span>
                            @endif
                            <span class="{{ $isPublished ? 'text-emerald-600' : 'text-slate-400' }}">
                                • {{ $isPublished ? 'Published' : 'Draft' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4 w-full sm:w-auto">
                    @if($isPublished)
                    <div class="text-right hidden sm:block">
                        <span class="block text-xl font-black text-slate-900">{{ $hadirCount }}<span class="text-sm text-slate-400">/{{ $totalCount }}</span></span>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Submit</span>
                    </div>
                    @endif

                    <div class="flex items-center gap-2 flex-1 sm:flex-none">
                        @if($isPublished)
                            <a href="{{ route('dosen.assignment.grade', ['kelas' => $kelas->id, 'assignment' => $assignment->id]) }}" class="flex-1 sm:flex-none px-5 py-3 bg-blue-50 text-blue-700 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-600 hover:text-white transition-all text-center border border-blue-100">
                                Periksa
                            </a>
                        @else
                            {{-- TOMBOL TRIGGER MODAL EDIT TUGAS --}}
                            <button type="button" 
                                onclick="openEditModal('{{ $assignment->id }}', '{{ addslashes($assignment->judul) }}', '{{ addslashes($assignment->deskripsi) }}', '{{ \Carbon\Carbon::parse($assignment->deadline)->format('Y-m-d') }}', '{{ \Carbon\Carbon::parse($assignment->deadline)->format('H:i') }}', '{{ $assignment->poin }}', '{{ $assignment->tipe_pengumpulan }}')" 
                                class="flex-1 sm:flex-none px-5 py-3 bg-blue-50 text-blue-700 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-600 hover:text-white transition-all text-center border border-blue-100 cursor-pointer">
                                Edit
                            </button>
                        @endif

                        <form action="{{ route('dosen.assignment.destroy', [$kelas->id, $assignment->id]) }}" method="POST" onsubmit="return confirm('Hapus tugas ini?')" class="m-0">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-3 bg-slate-50 text-slate-400 hover:bg-red-500 hover:text-white rounded-xl transition-all border border-slate-100 hover:border-red-500 shadow-sm cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full p-20 text-center bg-white rounded-[2.5rem] border-2 border-dashed border-slate-200" data-aos="zoom-in">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <h3 class="font-black text-slate-800 text-lg mb-1">Belum ada penugasan</h3>
                <p class="text-sm font-medium text-slate-400 mb-6">Mulai buat tugas atau kuis pertama untuk mahasiswa Anda.</p>
                <button type="button" onclick="openCreateModal()" class="px-6 py-2.5 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all shadow-md inline-flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Buat Tugas
                </button>
            </div>
            @endforelse

        </div>
    </main>

    {{-- MODAL BACKDROP --}}
    <div id="modalBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] opacity-0 pointer-events-none transition-opacity duration-300" onclick="closeAllModals()"></div>
    
    {{-- ======================================================== --}}
    {{-- 1. MODAL BUAT TUGAS BARU (Lebih Lebar) --}}
    {{-- ======================================================== --}}
    <div id="createAssignmentModal" class="fixed inset-0 flex items-center justify-center z-[70] opacity-0 pointer-events-none transition-opacity duration-300 p-4 sm:p-6 overflow-hidden">
        {{-- Diubah menjadi w-[95vw] max-w-7xl agar melebar --}}
        <div class="bg-[#f8fafc] w-[95vw] max-w-7xl max-h-[95vh] rounded-[2rem] shadow-2xl transform scale-95 translate-y-4 transition-transform duration-300 flex flex-col border border-slate-200 overflow-hidden my-auto" id="modalContentCreate">
            
            <div class="bg-white px-6 py-4 border-b border-slate-200 flex justify-between items-center z-20 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-900">Buat Tugas Baru</h2>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $kelas->mataKuliah->nama }}</p>
                    </div>
                </div>
                <button type="button" onclick="closeCreateModal()" class="w-10 h-10 flex items-center justify-center bg-slate-100 hover:bg-red-100 text-slate-500 hover:text-red-600 rounded-full transition-all cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ route('dosen.course.assignments.store', ['kelas' => $kelas->id]) }}" method="POST" enctype="multipart/form-data" class="flex-1 overflow-y-auto custom-scrollbar p-6">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    
                    {{-- Form Kiri (Lebih lebar lg:col-span-8) --}}
                    <div class="lg:col-span-8 flex flex-col gap-6">
                        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Judul Tugas <span class="text-red-500">*</span></label>
                                <input type="text" name="judul" value="{{ old('judul') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50/50 transition-all placeholder-slate-400" placeholder="Contoh: Analisis Kompleksitas Algoritma" required />
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Instruksi / Deskripsi Detail <span class="text-red-500">*</span></label>
                                <textarea name="deskripsi" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 min-h-[140px] outline-none text-slate-700 font-medium leading-relaxed resize-y placeholder-slate-400 text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50/50 transition-all custom-scrollbar" placeholder="Tuliskan instruksi pengerjaan tugas di sini..." required>{{ old('deskripsi') }}</textarea>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-sm font-black text-slate-900 mb-1">Lampiran File Tugas</h3>
                                    <p class="text-[10px] font-medium text-slate-400">Opsional. Maks 10MB (PDF/DOCX/ZIP)</p>
                                </div>
                                <div class="flex-1">
                                    <label class="flex items-center justify-center w-full h-16 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-blue-50/50 hover:border-blue-400 transition-all group/upload shadow-sm relative overflow-hidden">
                                        <div class="flex items-center gap-3 px-4 z-10">
                                            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover/upload:text-blue-600 group-hover/upload:bg-blue-100 transition-colors shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                            </div>
                                            <p class="text-xs text-slate-700 font-bold group-hover/upload:text-blue-600">Pilih File Lampiran</p>
                                        </div>
                                        <input type="file" name="file" id="fileInputCreate" class="hidden" />
                                    </label>
                                </div>
                            </div>
                            
                            <div id="filePreviewContainerCreate" class="hidden items-center justify-between p-3 mt-4 bg-emerald-50 border border-emerald-100 rounded-xl shadow-sm transition-all">
                                <div class="flex items-center gap-3 overflow-hidden">
                                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-emerald-600 border border-emerald-200 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div class="overflow-hidden flex-1">
                                        <p id="fileNameCreate" class="text-xs font-bold text-slate-800 truncate">namafile.pdf</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Form Kanan --}}
                    <div class="lg:col-span-4 flex flex-col gap-5">
                        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex flex-col h-full">
                            <h3 class="font-black text-slate-900 text-sm pb-3 border-b border-slate-100 flex items-center gap-2 mb-4">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Pengaturan Tugas
                            </h3>

                            <div class="space-y-4 flex-1">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Batas Tanggal</label>
                                    <input type="date" name="deadline_tanggal" value="{{ old('deadline_tanggal') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all cursor-pointer text-sm" required />
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Batas Waktu (Jam)</label>
                                    <input type="time" name="deadline_jam" value="{{ old('deadline_jam', '23:59') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all cursor-pointer text-sm" required />
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Poin Maksimal</label>
                                    <div class="relative group">
                                        <input type="number" name="poin" value="{{ old('poin', 100) }}" min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-12 py-2.5 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all text-sm" placeholder="100" required />
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-500">PTS</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Tipe Penyerahan</label>
                                    <div class="relative">
                                         <select name="tipe_pengumpulan" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 appearance-none transition-all cursor-pointer text-sm" required>
                                            <option value="file" {{ old('tipe_pengumpulan') == 'file' ? 'selected' : '' }}>Upload File Saja</option>
                                            <option value="text" {{ old('tipe_pengumpulan') == 'text' ? 'selected' : '' }}>Teks Online Saja</option>
                                            <option value="both" {{ old('tipe_pengumpulan') == 'both' ? 'selected' : '' }}>File & Teks Online</option>
                                        </select>
                                         <svg class="w-4 h-4 text-slate-500 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 pt-5 border-t border-slate-100 space-y-3 shrink-0">
                                <button type="submit" name="action" value="publish" class="w-full py-3.5 bg-blue-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-md shadow-blue-500/30 flex items-center justify-center gap-2 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                    Terbitkan Tugas
                                </button>
                                <div class="flex gap-2">
                                    <button type="submit" name="action" value="draft" class="flex-1 py-2.5 bg-slate-800 text-white rounded-xl font-bold text-[10px] uppercase tracking-wider hover:bg-slate-900 transition-all shadow-sm cursor-pointer">
                                        Simpan Draft
                                    </button>
                                    <button type="button" onclick="closeCreateModal()" class="flex-1 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-bold text-[10px] uppercase tracking-wider hover:bg-slate-200 transition-all cursor-pointer">
                                        Batal
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    {{-- ======================================================== --}}
    {{-- 2. MODAL EDIT TUGAS (DIREVISI AGAR LEBARNYA SAMA) --}}
    {{-- ======================================================== --}}
    <div id="editAssignmentModal" class="fixed inset-0 flex items-center justify-center z-[70] opacity-0 pointer-events-none transition-opacity duration-300 p-4 sm:p-6 overflow-hidden">
        {{-- Diubah menjadi w-[95vw] max-w-7xl --}}
        <div class="bg-[#f8fafc] w-[95vw] max-w-7xl max-h-[95vh] rounded-[2rem] shadow-2xl transform scale-95 translate-y-4 transition-transform duration-300 flex flex-col border border-slate-200 overflow-hidden my-auto" id="modalContentEdit">
            
            <div class="bg-white px-6 py-4 border-b border-slate-200 flex justify-between items-center z-20 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-900">Perbarui Tugas</h2>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $kelas->mataKuliah->nama }}</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditModal()" class="w-10 h-10 flex items-center justify-center bg-slate-100 hover:bg-red-100 text-slate-500 hover:text-red-600 rounded-full transition-all cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form id="editFormElement" method="POST" enctype="multipart/form-data" class="flex-1 overflow-y-auto custom-scrollbar p-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    <div class="lg:col-span-8 flex flex-col gap-6">
                        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Judul Tugas <span class="text-red-500">*</span></label>
                                <input type="text" name="judul" id="edit_judul" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50/50 transition-all placeholder-slate-400" required />
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Instruksi / Deskripsi Detail <span class="text-red-500">*</span></label>
                                <textarea name="deskripsi" id="edit_deskripsi" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 min-h-[140px] outline-none text-slate-700 font-medium leading-relaxed resize-y placeholder-slate-400 text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50/50 transition-all custom-scrollbar" required></textarea>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-sm font-black text-slate-900 mb-1">Ganti File Tugas</h3>
                                    <p class="text-[10px] font-medium text-slate-400">Pilih file jika ingin menimpa file lama.</p>
                                </div>
                                <div class="flex-1">
                                    <label class="flex items-center justify-center w-full h-16 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-blue-50/50 hover:border-blue-400 transition-all group/upload shadow-sm relative overflow-hidden">
                                        <div class="flex items-center gap-3 px-4 z-10">
                                            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover/upload:text-blue-600 group-hover/upload:bg-blue-100 transition-colors shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                            </div>
                                            <p class="text-xs text-slate-700 font-bold group-hover/upload:text-blue-600">Pilih File Baru</p>
                                        </div>
                                        <input type="file" name="file" id="fileInputEdit" class="hidden" />
                                    </label>
                                </div>
                            </div>
                            
                            <div id="filePreviewContainerEdit" class="hidden items-center justify-between p-3 mt-4 bg-emerald-50 border border-emerald-100 rounded-xl shadow-sm transition-all">
                                <div class="flex items-center gap-3 overflow-hidden">
                                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-emerald-600 border border-emerald-200 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div class="overflow-hidden flex-1">
                                        <p id="fileNameEdit" class="text-xs font-bold text-slate-800 truncate">namafile.pdf</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-4 flex flex-col gap-5">
                        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex flex-col h-full">
                            <h3 class="font-black text-slate-900 text-sm pb-3 border-b border-slate-100 flex items-center gap-2 mb-4">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Pengaturan Tugas
                            </h3>

                            <div class="space-y-4 flex-1">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Batas Tanggal</label>
                                    <input type="date" name="deadline_tanggal" id="edit_deadline_tanggal" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all cursor-pointer text-sm" required />
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Batas Waktu (Jam)</label>
                                    <input type="time" name="deadline_jam" id="edit_deadline_jam" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all cursor-pointer text-sm" required />
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Poin Maksimal</label>
                                    <div class="relative group">
                                        <input type="number" name="poin" id="edit_poin" min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-12 py-2.5 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all text-sm" required />
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-500">PTS</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Tipe Penyerahan</label>
                                    <div class="relative">
                                         <select name="tipe_pengumpulan" id="edit_tipe_pengumpulan" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 appearance-none transition-all cursor-pointer text-sm" required>
                                            <option value="file">Upload File Saja</option>
                                            <option value="text">Teks Online Saja</option>
                                            <option value="both">File & Teks Online</option>
                                        </select>
                                         <svg class="w-4 h-4 text-slate-500 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 pt-5 border-t border-slate-100 space-y-3 shrink-0">
    {{-- Tombol Terbitkan Tugas --}}
    <button type="submit" name="action" value="publish" class="w-full py-3.5 bg-blue-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-md shadow-blue-500/30 flex items-center justify-center gap-2 cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
        Terbitkan Tugas
    </button>
    
    <div class="flex gap-2">
        {{-- Tombol Simpan Perubahan (sebagai Draft) --}}
        <button type="submit" name="action" value="draft" class="flex-1 py-2.5 bg-slate-800 text-white rounded-xl font-bold text-[10px] uppercase tracking-wider hover:bg-slate-900 transition-all shadow-sm cursor-pointer flex items-center justify-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Simpan Edit
        </button>
        
        {{-- Tombol Batal --}}
        <button type="button" onclick="closeEditModal()" class="flex-1 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-bold text-[10px] uppercase tracking-wider hover:bg-slate-200 transition-all cursor-pointer">
            Batal
        </button>
    </div>
</div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, easing: 'ease-out-cubic', duration: 800 });

        function closeAllModals() {
            closeCreateModal();
            closeEditModal();
        }

        // ==========================================
        // JS MODAL BUAT TUGAS
        // ==========================================
        function openCreateModal() {
            const backdrop = document.getElementById('modalBackdrop');
            const modal = document.getElementById('createAssignmentModal');
            const content = document.getElementById('modalContentCreate');
            
            backdrop.classList.add('modal-active');
            modal.classList.add('modal-active');
            document.body.style.overflow = 'hidden'; 
            
            setTimeout(() => { content.classList.add('modal-content-active'); }, 10);
        }

        function closeCreateModal() {
            const backdrop = document.getElementById('modalBackdrop');
            const modal = document.getElementById('createAssignmentModal');
            const content = document.getElementById('modalContentCreate');
            
            content.classList.remove('modal-content-active');
            
            setTimeout(() => {
                backdrop.classList.remove('modal-active');
                modal.classList.remove('modal-active');
                document.body.style.overflow = 'auto'; 
            }, 300);
        }

        // ==========================================
        // JS MODAL EDIT TUGAS (MENGISI DATA OTOMATIS)
        // ==========================================
        function openEditModal(id, judul, deskripsi, tgl, jam, poin, tipe) {
            const backdrop = document.getElementById('modalBackdrop');
            const modal = document.getElementById('editAssignmentModal');
            const content = document.getElementById('modalContentEdit');
            const form = document.getElementById('editFormElement');

            // [PERBAIKAN ERROR PUT METHOD - MENGGUNAKAN ROUTE MATA-KULIAH]
            form.action = `/dosen/mata-kuliah/{{ $kelas->id }}/penugasan/${id}`;

            // Isi input value
            document.getElementById('edit_judul').value = judul;
            document.getElementById('edit_deskripsi').value = deskripsi;
            document.getElementById('edit_deadline_tanggal').value = tgl;
            document.getElementById('edit_deadline_jam').value = jam;
            document.getElementById('edit_poin').value = poin;
            document.getElementById('edit_tipe_pengumpulan').value = tipe;
            
            // Tampilkan Modal
            backdrop.classList.add('modal-active');
            modal.classList.add('modal-active');
            document.body.style.overflow = 'hidden'; 
            
            setTimeout(() => { content.classList.add('modal-content-active'); }, 10);
        }

        function closeEditModal() {
            const backdrop = document.getElementById('modalBackdrop');
            const modal = document.getElementById('editAssignmentModal');
            const content = document.getElementById('modalContentEdit');
            
            content.classList.remove('modal-content-active');
            
            setTimeout(() => {
                backdrop.classList.remove('modal-active');
                modal.classList.remove('modal-active');
                document.body.style.overflow = 'auto'; 
            }, 300);
        }

        // Jika terjadi error pada form Create
        @if($errors->any() && !old('_method'))
            document.addEventListener('DOMContentLoaded', () => { openCreateModal(); });
        @endif

        // File Input Script (Create & Edit)
        function handleFilePreview(inputId, nameId, containerId) {
            const input = document.getElementById(inputId);
            const nameLabel = document.getElementById(nameId);
            const container = document.getElementById(containerId);

            if(input) {
                input.addEventListener('change', function () {
                    if (this.files.length > 0) {
                        const file = this.files[0];
                        if(nameLabel) nameLabel.textContent = file.name;
                        if(container) {
                            container.classList.remove('hidden');
                            container.classList.add('flex');
                        }
                    } else {
                        if(container) {
                            container.classList.add('hidden');
                            container.classList.remove('flex');
                        }
                    }
                });
            }
        }

        handleFilePreview('fileInputCreate', 'fileNameCreate', 'filePreviewContainerCreate');
        handleFilePreview('fileInputEdit', 'fileNameEdit', 'filePreviewContainerEdit');

    </script>
</body>
</html>