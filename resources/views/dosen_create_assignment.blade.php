<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Buat Tugas Baru | Portal Dosen</title>
    
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
    
    {{-- NAVBAR --}}
    <div class="bg-white/90 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm w-full">
        <div class="max-w-7xl mx-auto flex items-center justify-between relative">
            
            <div class="flex items-center gap-4 relative z-10 md:w-auto w-full justify-start">
                <a href="{{ route('dosen.course.assignments', $kelas->id) }}" class="w-11 h-11 md:w-12 md:h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all shadow-sm shrink-0 border border-slate-200 hover:border-blue-600 group">
                    <svg class="w-5 h-5 md:w-6 md:h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </a>
            </div>
            
            <div class="text-center absolute left-1/2 transform -translate-x-1/2 w-full max-w-[60%] md:max-w-md hidden md:block z-0">
                <h1 class="text-lg md:text-xl font-black text-slate-900 truncate">Buat Tugas Baru</h1>
                <div class="flex items-center justify-center gap-2 mt-1">
                    <span class="text-[10px] font-bold text-blue-600 uppercase bg-blue-100 px-2 py-0.5 rounded-md">{{ $kelas->nama ?? 'Kelas' }}</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase truncate max-w-[200px]">{{ $kelas->kode_kelas ?? '' }}</span>
                </div>
            </div>
            
            <div class="w-11 md:w-12 hidden md:block relative z-10"></div>
        </div>
    </div>

    {{-- KONTEN BAWAH (Layout Split 8:4) --}}
    <main class="w-full max-w-7xl mx-auto p-4 md:p-6 pb-24 relative flex-1">
        
        <form action="{{ route('dosen.course.assignments.store', ['kelas' => $kelas->id]) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
            @csrf

            {{-- KOLOM KIRI (Area Utama 8/12) --}}
            <div class="lg:col-span-8 flex flex-col gap-6">
                
                {{-- KONTEN FORM --}}
                <div class="glass-card p-6 sm:p-8 rounded-[2rem] space-y-6 relative overflow-hidden" data-aos="fade-up" data-aos-duration="600">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-[100px] -z-0 opacity-50"></div>
                    
                    <div class="relative z-10">
                        <label class="block text-xs font-bold text-slate-700 mb-2 ml-1">
                            Judul Tugas <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3.5 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50/50 transition-all text-base placeholder-slate-400" placeholder="Contoh: Analisis Kompleksitas Algoritma" required />
                        @error('judul') <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="relative z-10">
                        <label class="block text-xs font-bold text-slate-700 mb-2 ml-1">
                            Instruksi / Deskripsi Detail <span class="text-red-500">*</span>
                        </label>
                        <textarea name="deskripsi" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-4 min-h-[200px] outline-none text-slate-700 font-medium leading-relaxed resize-y placeholder-slate-400 text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50/50 transition-all custom-scrollbar" placeholder="Tuliskan instruksi pengerjaan tugas di sini..." required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- KOLOM FILE LAMPIRAN --}}
                <div class="glass-card p-6 sm:p-8 rounded-[2rem] relative overflow-hidden" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                    <div class="mb-4">
                        <h3 class="text-base font-black text-slate-900">Lampiran File Tugas</h3>
                        <p class="text-xs font-medium text-slate-400 mt-1">Dokumen pendukung untuk mahasiswa (Opsional. Maks 10MB)</p>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 sm:p-5 relative">
                        
                        {{-- PREVIEW DIV (Hidden default) --}}
                        <div id="filePreviewContainer" class="hidden items-center justify-between p-3 sm:p-4 bg-white border border-blue-100 rounded-xl shadow-sm relative z-10 mb-4 transition-all">
                            <div class="flex items-center gap-3 sm:gap-4 overflow-hidden">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600 border border-emerald-100 shrink-0">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div class="overflow-hidden flex-1">
                                    <p id="fileName" class="text-xs sm:text-sm font-bold text-slate-800 truncate">namafile.pdf</p>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                                        <p class="text-[9px] sm:text-[10px] font-bold text-emerald-600 uppercase tracking-wider">File Siap Diupload</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-white hover:bg-blue-50/50 hover:border-blue-400 transition-all group/upload shadow-sm">
                            <div class="flex flex-col items-center justify-center gap-2 p-4 text-center">
                                <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 group-hover/upload:text-blue-600 group-hover/upload:bg-blue-100 transition-colors mb-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                </div>
                                <p class="text-sm text-slate-700 font-bold group-hover/upload:text-blue-600">Klik untuk Pilih File</p>
                                <p class="text-[10px] text-slate-400 font-medium">PDF, DOCX, ZIP</p>
                            </div>
                            <input type="file" name="file" id="fileInput" class="hidden" />
                        </label>
                        @error('file') <p class="text-xs text-red-500 mt-2 text-center">{{ $message }}</p> @enderror
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
                                <input type="date" name="deadline_tanggal" value="{{ old('deadline_tanggal') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all cursor-pointer text-sm" required />
                                @error('deadline_tanggal') <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Batas Waktu (Jam)</label>
                                <input type="time" name="deadline_jam" value="{{ old('deadline_jam', '23:59') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all cursor-pointer text-sm" required />
                                @error('deadline_jam') <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Poin Maksimal</label>
                                <div class="relative group">
                                    <input type="number" name="poin" value="{{ old('poin', 100) }}" min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-12 py-3 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all text-sm" placeholder="100" required />
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 uppercase tracking-widest group-focus-within:text-blue-500">PTS</span>
                                </div>
                                @error('poin') <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Tipe Penyerahan</label>
                                <div class="relative">
                                     <select name="tipe_pengumpulan" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-10 py-3 font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 appearance-none transition-all cursor-pointer text-sm" required>
                                        <option value="file" {{ old('tipe_pengumpulan') == 'file' ? 'selected' : '' }}>Upload File Saja</option>
                                        <option value="text" {{ old('tipe_pengumpulan') == 'text' ? 'selected' : '' }}>Teks Online Saja</option>
                                        <option value="both" {{ old('tipe_pengumpulan') == 'both' ? 'selected' : '' }}>File & Teks Online</option>
                                    </select>
                                     <svg class="w-4 h-4 text-slate-500 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                @error('tipe_pengumpulan') <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- TOMBOL ACTION --}}
                    <div class="flex flex-col gap-3">
                        <button type="submit" name="action" value="publish" class="w-full py-4 bg-blue-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all transform hover:-translate-y-0.5 shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            Terbitkan Tugas
                        </button>

                        <div class="grid grid-cols-2 gap-3">
                            <button type="submit" name="action" value="draft" class="w-full py-3.5 bg-slate-800 text-white rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-slate-900 transition-all shadow-md flex items-center justify-center">
                                Simpan Draft
                            </button>
                            <a href="{{ route('dosen.course.assignments', $kelas->id) }}" class="w-full py-3.5 bg-slate-100 text-slate-600 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-slate-200 hover:text-slate-800 transition-all text-center flex items-center justify-center">
                                Batal
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Init Animasi AOS
        AOS.init({ once: true, easing: 'ease-out-cubic', duration: 800, offset: 50 });

        // JS untuk merubah UI saat file dipilih
        const fileInput = document.getElementById('fileInput');
        const fileName = document.getElementById('fileName');
        const filePreviewContainer = document.getElementById('filePreviewContainer');

        if(fileInput) {
            fileInput.addEventListener('change', function () {
                if (this.files.length > 0) {
                    const file = this.files[0];
                    if(fileName) fileName.textContent = file.name;
                    if(filePreviewContainer) {
                        filePreviewContainer.classList.remove('hidden');
                        filePreviewContainer.classList.add('flex');
                    }
                } else {
                    if(filePreviewContainer) {
                        filePreviewContainer.classList.add('hidden');
                        filePreviewContainer.classList.remove('flex');
                    }
                }
            });
        }
    </script>
</body>
</html>