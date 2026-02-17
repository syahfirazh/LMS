<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Buat Tugas Baru | Portal Dosen</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
            rel="stylesheet"
        />
        <style>
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
        </style>
    </head>
    <body
        class="font-['Plus_Jakarta_Sans'] bg-[#f8fafc] text-slate-800 min-h-full flex flex-col border-box overflow-x-hidden"
    >
        <div
            class="bg-white/90 backdrop-blur-xl border-b border-slate-200 sticky top-0 z-40 px-4 md:px-6 py-4 shadow-sm transition-all"
        >
            <div class="max-w-5xl mx-auto flex items-center gap-4">
                <a
                    href="{{ route('dosen.course.assignments', $kelas->id) }}"
                    class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 border border-slate-200 flex items-center justify-center transition-all shrink-0 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 active:scale-95"
                >
                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2.5"
                            d="M15 19l-7-7 7-7"
                        ></path>
                    </svg>
                </a>

                <div class="overflow-hidden">
                    <h1
                        class="text-xl font-extrabold text-slate-900 tracking-tight leading-none truncate"
                    >
                        Buat Tugas Baru
                    </h1>
                    <p
                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 truncate"
                    >
                        {{ $kelas->mataKuliah->nama }} {{ $kelas->kode_kelas ?? '' }}
                    </p>
                </div>
            </div>
        </div>

        <main
            class="flex-1 max-w-5xl mx-auto p-4 md:p-6 lg:p-8 w-full space-y-8"
        ><form 
    action="{{ route('dosen.course.assignments.store', ['kelas' => $kelas->id]) }}" 
    method="POST"
    enctype="multipart/form-data"
    class="space-y-8"
>
    @csrf

    <div class="bg-white p-6 md:p-8 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-6">
        
        {{-- JUDUL --}}
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                Judul Tugas
            </label>
            <input
                type="text"
                name="judul"
                value="{{ old('judul') }}"
                placeholder="Contoh: Analisis Kompleksitas Algoritma"
                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all placeholder:font-medium placeholder:text-slate-400"
            />
            @error('judul')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- DESKRIPSI --}}
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                Instruksi / Deskripsi
            </label>
            <div class="w-full bg-slate-50 border border-slate-200 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 transition-all">
                
                <div class="bg-white border-b border-slate-200 px-3 py-2 flex gap-2 overflow-x-auto">
                    <!-- Toolbar tetap sama -->
                </div>

                <textarea
                    name="deskripsi"
                    class="w-full bg-transparent p-4 min-h-[150px] outline-none text-slate-700 font-medium resize-y"
                    placeholder="Tuliskan instruksi pengerjaan tugas di sini..."
                >{{ old('deskripsi') }}</textarea>

                @error('deskripsi')
                    <p class="text-xs text-red-500 mt-2 px-4 pb-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- FILE --}}
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                Lampiran File (Opsional)
            </label>
            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-blue-50 hover:border-blue-400 transition-all group">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <p class="mb-1 text-sm text-slate-500 font-medium">
                        Klik untuk upload atau drag & drop
                    </p>
                    <p class="text-xs text-slate-400">
                        PDF, DOCX, ZIP (Max. 10MB)
                    </p>
                </div>
                <input type="file" name="file" id="fileInput" class="hidden" />

<p id="fileName" class="text-xs text-blue-600 mt-2 hidden"></p>

            </label>

            @error('file')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- PENGATURAN --}}
    <div class="bg-white p-6 md:p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
        <h3 class="font-bold text-slate-800 text-lg mb-6 border-b border-slate-100 pb-4">
            Pengaturan Pengumpulan
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- TANGGAL --}}
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                    Tanggal Batas Waktu
                </label>
                <input
                    type="date"
                    name="deadline_tanggal"
                    value="{{ old('deadline_tanggal') }}"
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                @error('deadline_tanggal')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- JAM --}}
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                    Jam Batas Waktu
                </label>
                <input
                    type="time"
                    name="deadline_jam"
                    value="{{ old('deadline_jam', '23:59') }}"
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                @error('deadline_jam')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- POIN --}}
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                    Poin Maksimal
                </label>
                <div class="relative">
                    <input
                        type="number"
                        name="poin"
                        value="{{ old('poin', 100) }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-12 py-3 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">
                        PTS
                    </span>
                </div>
                @error('poin')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- TIPE --}}
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                    Tipe Pengumpulan
                </label>
                <select
                    name="tipe_pengumpulan"
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none"
                >
                    <option value="file" {{ old('tipe_pengumpulan') == 'file' ? 'selected' : '' }}>Upload File</option>
                    <option value="text" {{ old('tipe_pengumpulan') == 'text' ? 'selected' : '' }}>Teks Online</option>
                    <option value="both" {{ old('tipe_pengumpulan') == 'both' ? 'selected' : '' }}>File & Teks</option>
                </select>

                @error('tipe_pengumpulan')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- BUTTON --}}
    <div class="flex flex-col-reverse md:flex-row justify-end gap-4 pt-4 pb-12">

        <a
            href="{{ route('dosen.course.assignments', $kelas->id) }}"
            class="px-8 py-4 rounded-xl font-bold text-slate-500 hover:bg-slate-100 transition-all text-center"
        >
            Batal
        </a>

        <button
            type="submit"
            name="action"
            value="draft"
            class="px-8 py-4 bg-slate-800 text-white rounded-xl font-bold uppercase tracking-widest hover:bg-slate-900 transition-all flex items-center justify-center gap-2 shadow-lg"
        >
            Simpan Draft
        </button>

        <button
            type="submit"
            name="action"
            value="publish"
            class="px-10 py-4 bg-blue-600 text-white rounded-xl font-bold uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl shadow-blue-200 flex items-center justify-center gap-2"
        >
            Terbitkan Tugas
        </button>

    </div>
</form>

        </main>
        <script>
    const fileInput = document.getElementById('fileInput');
    const fileName = document.getElementById('fileName');

    fileInput.addEventListener('change', function () {
        if (this.files.length > 0) {
            fileName.textContent = "File dipilih: " + this.files[0].name;
            fileName.classList.remove('hidden');
        }
    });
</script>

    </body>
</html>
