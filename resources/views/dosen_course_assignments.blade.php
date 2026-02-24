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
    </style>
</head>
<body class="font-['Plus_Jakarta_Sans'] bg-[#f1f5f9] text-slate-800 min-h-full flex flex-col border-box overflow-x-hidden overflow-y-scroll selection:bg-blue-200">
    
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

    <main class="flex-1 max-w-7xl mx-auto p-4 md:p-8 w-full space-y-10 mb-20">
        
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
                    Rekap Nilai Tugas
                </a>

                <a href="{{ route('dosen.assignment.create', $kelas->id) }}" class="w-full sm:w-auto px-6 py-3.5 bg-blue-600 text-white rounded-xl font-black text-[11px] uppercase tracking-widest hover:bg-blue-700 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 shadow-lg shadow-blue-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat Tugas
                </a>
                
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            @forelse($assignments as $assignment)
            @php
                $isPublished = $assignment->status === 'published';
                
                // LOGIKA COUNT DIPERBARUI: Hanya menggunakan kolom yang benar-benar ada di database Anda
                $hadirCount = \App\Models\Submission::where('assignment_id', $assignment->id)
                                ->where(function($query) {
                                    $query->whereNotNull('file_path')
                                          ->orWhereNotNull('text_submission')
                                          ->orWhereNotNull('voice_submission');
                                })->count();
                                
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
                        <a href="{{ $isPublished ? route('dosen.assignment.grade', ['kelas' => $kelas->id, 'assignment' => $assignment->id]) : route('dosen.assignment.edit', [$kelas->id, $assignment->id]) }}" class="flex-1 sm:flex-none px-5 py-3 bg-blue-50 text-blue-700 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-600 hover:text-white transition-all text-center border border-blue-100">
                            {{ $isPublished ? 'Periksa' : 'Edit' }}
                        </a>

                        <form action="{{ route('dosen.assignment.destroy', [$kelas->id, $assignment->id]) }}" method="POST" onsubmit="return confirm('Hapus tugas ini?')" class="m-0">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-3 bg-slate-50 text-slate-400 hover:bg-red-500 hover:text-white rounded-xl transition-all border border-slate-100 hover:border-red-500 shadow-sm">
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
                <a href="{{ route('dosen.assignment.create', $kelas->id) }}" class="px-6 py-2.5 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all shadow-md inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Buat Tugas
                </a>
            </div>
            @endforelse

        </div>
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, easing: 'ease-out-cubic', duration: 800 });
    </script>
</body>
</html>