<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Kelola {{ $kelas->mataKuliah->nama }} | Portal Dosen</title>
        
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
        
        <style>
            .scrollbar-hide::-webkit-scrollbar { display: none; }
            .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        </style>
    </head>
    <body class="font-['Plus_Jakarta_Sans'] bg-[#f1f5f9] text-slate-800 min-h-full flex flex-col border-box overflow-x-hidden selection:bg-blue-200">
        
        <div class="bg-white/80 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm transition-all">
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
                    <a href="{{ route('dosen.course.manage', $kelas->id) }}" class="snap-start shrink-0 px-6 py-2.5 rounded-xl bg-white text-blue-700 font-black text-[10px] uppercase tracking-widest shadow-sm border border-slate-200/60 whitespace-nowrap transition-all">
                        Materi & Modul
                    </a>
                    <a href="{{ route('dosen.attendance.index', $kelas->id) }}" class="snap-start shrink-0 px-6 py-2.5 rounded-xl text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/60 flex items-center justify-center">
                        Absensi
                    </a>
                    <a href="{{ route('dosen.course.assignments', $kelas->id) }}" class="snap-start shrink-0 px-6 py-2.5 rounded-xl text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/60 flex items-center justify-center">
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
            
            <div data-aos="fade-up" data-aos-duration="800" class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden flex flex-col md:flex-row group">
                
                <div class="w-full md:w-2/5 bg-slate-100 relative h-64 md:h-auto overflow-hidden border-b md:border-b-0 md:border-r border-slate-200">
                    @if($kelas->sampul)
                        <img src="{{ asset('storage/' . $kelas->sampul) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="Sampul Kelas">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-700 flex flex-col items-center justify-center p-8 text-white text-center relative overflow-hidden">
                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-black/10 rounded-full blur-2xl"></div>
                            
                            <svg class="w-16 h-16 mb-4 text-white/80 drop-shadow-md transform group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white/80">Mata Kuliah</span>
                            <h3 class="text-xl font-black mt-1 text-white drop-shadow-sm">{{ $kelas->mataKuliah->nama }}</h3>
                        </div>
                    @endif
                </div>

                <div class="flex-1 p-8 lg:p-10 bg-white">
                    <form action="{{ route('dosen.course.updateDeskripsi', $kelas->id) }}" method="POST" class="h-full flex flex-col">
                        @csrf 
                        @method('PUT')
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                                Deskripsi Kelas
                            </h3>
                            <button type="submit" class="px-5 py-2.5 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 transition-colors shadow-md">
                                Simpan
                            </button>
                        </div>
                        <textarea name="deskripsi" class="flex-1 w-full bg-slate-50 border border-slate-200 rounded-[1.5rem] p-6 text-sm font-medium text-slate-600 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all h-48 md:h-full resize-none leading-relaxed placeholder:text-slate-400" placeholder="Tuliskan deskripsi ringkas tentang mata kuliah ini... ">{{ old('deskripsi', $kelas->mataKuliah->deskripsi) }}</textarea>
                    </form>
                </div>
            </div>

            <div class="space-y-6 pt-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 px-2" data-aos="fade-right">
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">Rencana Pertemuan</h3>
                        <p class="text-xs font-bold text-slate-400 mt-1">Kelola silabus dan pertemuan pembelajaran kelas.</p>
                    </div>
                    <button onclick="toggleModal('modalAddSession', true)" class="px-6 py-3 bg-blue-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 transition-transform transform hover:-translate-y-1 shadow-lg shadow-blue-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Pertemuan
                    </button>
                </div>

                <div class="space-y-4">
                    @forelse ($kelas->courseSessions as $session)
                        <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}" class="group bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-xl hover:border-blue-300 transition-all duration-300 flex flex-col sm:flex-row items-center justify-between gap-5 relative overflow-hidden transform hover:-translate-y-1">
                            
                            <div class="absolute left-0 top-0 bottom-0 w-2 bg-slate-100 group-hover:bg-blue-500 transition-colors duration-300"></div>

                            <div class="flex items-center gap-5 w-full sm:w-auto pl-2">
                                <div class="w-14 h-14 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center font-black text-xl shrink-0 group-hover:bg-blue-100 group-hover:text-blue-600 transition-colors border border-slate-100 group-hover:border-blue-200">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <h4 class="font-black text-slate-900 text-lg mb-1 group-hover:text-blue-700 transition-colors">
                                        {{ $session->judul }}
                                    </h4>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest flex items-center gap-2">
                                        <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> {{ $session->materi_count ?? 0 }} Materi</span>
                                        <span class="text-slate-300">•</span>
                                        <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg> {{ $session->diskusi_count ?? 0 }} Diskusi</span>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 w-full sm:w-auto">
                                <a href="{{ route('dosen.course.session.detail', ['kelas' => $kelas->id, 'session' => $session->id]) }}" class="flex-1 sm:flex-none px-6 py-3.5 bg-blue-50 text-blue-700 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-600 hover:text-white transition-all text-center border border-blue-100">
                                    Kelola Materi
                                </a>
                                
                                <form action="{{ route('dosen.course.session.destroy', ['kelas' => $kelas->id, 'session' => $session->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertemuan ini? Semua materi di dalamnya akan ikut terhapus.')" class="shrink-0">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="p-3.5 bg-slate-50 text-slate-400 hover:bg-red-500 hover:text-white rounded-xl transition-all border border-slate-100 hover:border-red-500 shadow-sm" title="Hapus Pertemuan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-16 text-center bg-white rounded-[2.5rem] border-2 border-dashed border-slate-200" data-aos="zoom-in">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                            <h3 class="font-black text-slate-800 text-lg mb-1">Belum ada pertemuan</h3>
                            <p class="text-sm font-medium text-slate-400 mb-6">Mulai tambahkan pertemuan pertama untuk kelas ini.</p>
                            <button onclick="toggleModal('modalAddSession', true)" class="px-6 py-2.5 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all shadow-md inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Tambah Pertemuan
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>

        <div id="modalAddSession" class="fixed inset-0 z-[100] hidden overflow-hidden">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity opacity-0" id="modalBackdrop"></div>
            <div class="absolute inset-0 flex items-center justify-center p-4">
                <div id="modalContent" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg p-8 md:p-10 transform scale-95 opacity-0 transition-all duration-300">
                    <form action="{{ route('dosen.course.session.store', $kelas->id) }}" method="POST">
                        @csrf
                        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 mb-2 tracking-tight">Pertemuan Baru</h3>
                        <p class="text-sm text-slate-500 font-medium mb-8">Tentukan judul atau topik bahasan untuk pertemuan ini.</p>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.1em] mb-2 block">Judul Pertemuan / Topik</label>
                                <input type="text" name="judul" placeholder="Contoh: Pengenalan Array & Linked List" required class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 font-bold text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white transition-all shadow-sm" />
                            </div>
                            
                            <div class="flex gap-4 pt-4 mt-2">
                                <button type="button" onclick="toggleModal('modalAddSession', false)" class="flex-1 py-4 bg-slate-100 text-slate-500 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-200 hover:text-slate-700 transition-all">
                                    Batal
                                </button>
                                <button type="submit" class="flex-1 py-4 bg-blue-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-blue-200 hover:bg-blue-700 transition-transform transform hover:-translate-y-1">
                                    Simpan Pertemuan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            // Inisialisasi AOS (Animasi Scroll)
            AOS.init({ once: true, easing: 'ease-out-cubic', duration: 800 });

            // Fungsi Toggle Sidebar Khusus Mobile
            function toggleSidebar() {
                // Berhubung Sidebar sudah dihapus, fungsi ini bisa dikosongkan atau diarahkan ke link kembali
                window.location.href = "{{ route('dosen.courses') }}";
            }

            // Fungsi Toggle Modal dengan Animasi Transisi Halus
            function toggleModal(id, show) {
                const modal = document.getElementById(id);
                const backdrop = document.getElementById('modalBackdrop');
                const content = document.getElementById('modalContent');
                
                if (show) {
                    modal.classList.remove('hidden');
                    // Timeout sedikit agar transisi class CSS jalan
                    setTimeout(() => {
                        backdrop.classList.remove('opacity-0');
                        backdrop.classList.add('opacity-100');
                        content.classList.remove('scale-95', 'opacity-0');
                        content.classList.add('scale-100', 'opacity-100');
                    }, 10);
                } else {
                    backdrop.classList.remove('opacity-100');
                    backdrop.classList.add('opacity-0');
                    content.classList.remove('scale-100', 'opacity-100');
                    content.classList.add('scale-95', 'opacity-0');
                    
                    // Sembunyikan elemen setelah animasi selesai
                    setTimeout(() => {
                        modal.classList.add('hidden');
                    }, 300);
                }
            }
        </script>
    </body>
</html>