<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Edit Tugas | Portal Dosen</title>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        
        body { background-color: #f8fafc; }
        
        .glass-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }
    </style>
</head>
<body class="font-['Plus_Jakarta_Sans'] text-slate-800 min-h-screen flex flex-col border-box overflow-x-hidden selection:bg-blue-100 selection:text-blue-900">
    
    {{-- NAVBAR (Sama Persis Seperti Detail Sesi) --}}
    <div class="bg-white/90 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm w-full">
        <div class="max-w-7xl mx-auto flex items-center justify-between relative">
            <div class="flex items-center gap-4 relative z-10 md:w-auto w-full justify-start">
                <a href="{{ route('dosen.course.assignments', $kelas->id) }}" class="w-11 h-11 md:w-12 md:h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all shadow-sm shrink-0 border border-slate-200">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </a>
            </div>
            <div class="text-center absolute left-1/2 transform -translate-x-1/2 w-full max-w-[60%] md:max-w-md hidden md:block z-0">
                <h1 class="text-lg md:text-xl font-black text-slate-900 truncate">Edit Tugas</h1>
                <div class="flex items-center justify-center gap-2 mt-1">
                    <span class="text-[10px] font-bold text-blue-600 uppercase bg-blue-100 px-2 py-0.5 rounded-md">{{ $kelas->nama ?? 'Kelas' }}</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase truncate max-w-[200px]">{{ $assignment->judul ?? 'Detail Tugas' }}</span>
                </div>
            </div>
            <div class="w-11 md:w-12 hidden md:block relative z-10"></div>
        </div>
    </div>

    {{-- KONTEN BAWAH (Layout Split 8:4) --}}
    <main class="w-full max-w-7xl mx-auto p-4 md:p-6 pb-24 relative flex-1">
        
        <form action="{{ route('dosen.assignment.update', [$kelas->id, $assignment->id]) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
            @csrf
            @method('PUT')

            {{-- KOLOM KIRI (Area Utama 8/12) --}}
            <div class="lg:col-span-8 flex flex-col gap-6" data-aos="fade-up" data-aos-duration="600">
                
                <div class="glass-card p-6 sm:p-8 rounded-[2rem] space-y-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-[100px] -z-0 opacity-50"></div>
                    
                    <div class="relative z-10">
                        <label class="block text-xs font-bold text-slate-700 mb-2 ml-1">
                            Judul Tugas <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul', $assignment->judul) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3.5 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50/50 transition-all text-base" placeholder="Contoh: Implementasi Linked List" required />
                    </div>

                    <div class="relative z-10">
                        <label class="block text-xs font-bold text-slate-700 mb-2 ml-1">
                            Instruksi / Deskripsi Detail <span class="text-red-500">*</span>
                        </label>
                        <textarea name="deskripsi" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-4 min-h-[250px] outline-none text-slate-700 font-medium leading-relaxed resize-y placeholder-slate-400 text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50/50 transition-all custom-scrollbar" placeholder="Jelaskan instruksi tugas secara rinci di sini..." required>{{ old('deskripsi', $assignment->deskripsi) }}</textarea>
                    </div>
                </div>

                {{-- KOLOM FILE LAMPIRAN --}}
                <div class="glass-card p-6 sm:p-8 rounded-[2rem] relative overflow-hidden" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                    <div class="mb-4">
                        <h3 class="text-base font-black text-slate-900">Lampiran File Tugas</h3>
                        <p class="text-xs font-medium text-slate-400 mt-1">Dokumen pendukung untuk mahasiswa (Maks 10MB)</p>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 sm:p-5 relative">
                        @if($assignment->file_path)
                            <div id="currentFilePreview" class="flex items-center justify-between p-3 sm:p-4 bg-white border border-blue-100 rounded-xl shadow-sm relative z-10 mb-4 group hover:border-blue-300 transition-all">
                                <div class="flex items-center gap-3 sm:gap-4 overflow-hidden">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 border border-blue-100 group-hover:bg-blue-600 group-hover:text-white transition-colors shrink-0">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div class="overflow-hidden flex-1">
                                        <p id="fileName" class="text-xs sm:text-sm font-bold text-slate-800 truncate">{{ basename($assignment->file_path) }}</p>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                                            <p id="fileStatus" class="text-[9px] sm:text-[10px] font-bold text-slate-500 uppercase tracking-wider">Tersimpan di Server</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/'.$assignment->file_path) }}" id="fileLink" target="_blank" class="px-3 sm:px-4 py-2 bg-slate-50 text-blue-600 rounded-lg text-[10px] sm:text-xs font-bold hover:bg-blue-600 hover:text-white transition-colors shrink-0 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    <span class="hidden sm:inline">Buka File</span>
                                </a>
                            </div>
                        @endif

                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-white hover:bg-blue-50/50 hover:border-blue-400 transition-all group/upload shadow-sm">
                            <div class="flex flex-col items-center justify-center gap-2 p-4 text-center">
                                <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 group-hover/upload:text-blue-600 group-hover/upload:bg-blue-100 transition-colors mb-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                </div>
                                <p class="text-sm text-slate-700 font-bold group-hover/upload:text-blue-600">Pilih File Baru</p>
                                <p class="text-[10px] text-slate-400 font-medium">Opsional. Mengganti file sebelumnya.</p>
                            </div>
                            <input type="file" name="file" class="hidden" id="fileInput" />
                        </label>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN (Pengaturan - Sticky 4/12) --}}
            <div class="lg:col-span-4 flex flex-col gap-6" data-aos="fade-left" data-aos-duration="600" data-aos-delay="200">
                <div class="lg:sticky lg:top-[100px] flex flex-col gap-6">
                    
                    {{-- PENGATURAN TUGAS --}}
                    <div class="glass-card p-6 sm:p-7 rounded-[2rem]">
                        <h3 class="font-black text-slate-900 text-sm pb-4 border-b border-slate-100 flex items-center gap-2 mb-5">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Pengaturan Pengumpulan
                        </h3>

                        <div class="space-y-5">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Batas Tanggal</label>
                                <input type="date" name="deadline_tanggal" value="{{ old('deadline_tanggal', \Carbon\Carbon::parse($assignment->deadline)->format('Y-m-d')) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all cursor-pointer text-sm" required />
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Batas Waktu (Jam)</label>
                                <input type="time" name="deadline_jam" value="{{ old('deadline_jam', \Carbon\Carbon::parse($assignment->deadline)->format('H:i')) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all cursor-pointer text-sm" required />
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Poin Maksimal</label>
                                <div class="relative group">
                                    <input type="number" name="poin" value="{{ old('poin', $assignment->poin) }}" min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-12 py-3 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all text-sm" placeholder="100" required />
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-500">PTS</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Tipe Penyerahan</label>
                                <div class="relative">
                                     <select name="tipe_pengumpulan" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-10 py-3 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 appearance-none transition-all cursor-pointer text-sm" required>
                                        <option value="file" {{ $assignment->tipe_pengumpulan == 'file' ? 'selected' : '' }}>Upload File Saja</option>
                                        <option value="text" {{ $assignment->tipe_pengumpulan == 'text' ? 'selected' : '' }}>Teks Online Saja</option>
                                        <option value="both" {{ $assignment->tipe_pengumpulan == 'both' ? 'selected' : '' }}>File & Teks Online</option>
                                    </select>
                                     <svg class="w-4 h-4 text-slate-500 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TOMBOL SUBMIT --}}
                    <div class="glass-card p-4 rounded-[1.5rem] flex flex-col sm:flex-row items-center gap-3">
                        <button type="submit" class="w-full py-3.5 bg-blue-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all transform hover:-translate-y-0.5 shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Tugas
                        </button>
                    </div>

                </div>
            </div>
        </form>

        {{-- ZONA BAHAYA (Hapus Tugas & Terbitkan) --}}
        <div class="mt-8 border-t border-slate-200/60 pt-8 flex flex-col sm:flex-row items-center justify-between gap-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
            <div class="w-full sm:w-auto">
                <form action="{{ route('dosen.assignment.destroy', [$kelas->id, $assignment->id]) }}" method="POST" onsubmit="return confirm('PERINGATAN!\nMenghapus tugas ini akan menghapus semua file dan nilai mahasiswa.\nYakin ingin melanjutkan?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full sm:w-auto px-5 py-3 rounded-xl font-bold text-red-500 bg-white border border-red-200 hover:bg-red-50 hover:border-red-300 transition-all text-xs flex items-center justify-center gap-2 shadow-sm group">
                        <svg class="w-4 h-4 text-red-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Hapus Tugas
                    </button>
                </form>
            </div>

            @if($assignment->status === 'draft')
                <div class="w-full sm:w-auto">
                    <form action="{{ route('dosen.assignment.publish', [$kelas->id, $assignment->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 rounded-xl font-bold text-white bg-emerald-500 hover:bg-emerald-600 transition-all text-xs flex items-center justify-center gap-2 shadow-md shadow-emerald-500/25 hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Terbitkan Tugas
                        </button>
                    </form>
                </div>
            @endif
        </div>

    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, easing: 'ease-out-cubic', duration: 800, offset: 50 });

        // Script Preview Nama File Upload
        const fileInput = document.getElementById('fileInput');
        const fileName = document.getElementById('fileName');
        const fileLink = document.getElementById('fileLink');
        const fileStatus = document.getElementById('fileStatus');
        const currentFilePreview = document.getElementById('currentFilePreview');

        if(fileInput) {
            fileInput.addEventListener('change', function () {
                if (this.files.length > 0) {
                    const file = this.files[0];

                    if(fileName) fileName.textContent = file.name;

                    if(fileStatus) {
                        fileStatus.innerHTML = '<span class="text-amber-500 tracking-normal capitalize">File Baru Dipilih</span>';
                        const statusDot = fileStatus.previousElementSibling;
                        if(statusDot) {
                             statusDot.classList.remove('bg-emerald-500', 'animate-pulse');
                             statusDot.classList.add('bg-amber-500');
                        }
                    }

                    if(fileLink) {
                        const fileURL = URL.createObjectURL(file);
                        fileLink.href = fileURL;
                        fileLink.innerHTML = '<span class="hidden sm:inline">Pratinjau</span>';
                    }
                    
                    if(currentFilePreview && currentFilePreview.classList.contains('hidden')) {
                        currentFilePreview.classList.remove('hidden');
                        currentFilePreview.classList.add('flex');
                    }
                }
            });
        }
    </script>
</body>
</html>