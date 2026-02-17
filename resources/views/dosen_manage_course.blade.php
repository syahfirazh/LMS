<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Kelola Struktur Data | Portal Dosen</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
            rel="stylesheet"
        />
        <style>
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
            .scrollbar-hide {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>
    </head>
    <body
        class="font-['Plus_Jakarta_Sans'] bg-[#f8fafc] text-slate-800 min-h-full flex flex-col border-box overflow-x-hidden"
    >
        <div
            class="bg-white/90 backdrop-blur-xl border-b border-slate-200 sticky top-0 z-30 px-4 md:px-6 py-4 shadow-sm transition-all"
        >
            <div
                class="max-w-6xl mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-4 md:gap-6"
            >
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <a
                        href="{{ route('dosen.courses') }}"
                        class="w-10 h-10 rounded-full bg-slate-50 hover:bg-blue-50 text-slate-400 hover:text-blue-600 flex items-center justify-center transition-all border border-slate-200 shrink-0"
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
                            class="text-xl font-extrabold text-slate-900 tracking-tight leading-none truncate max-w-[250px] md:max-w-none mb-2"
                        >
                            {{ $kelas->mataKuliah->nama }}
                        </h1>
                        <div class="flex items-center gap-2 mt-1">
                            <span
                                class="text-[10px] font-bold text-blue-600 uppercase tracking-widest bg-blue-50 px-2 py-0.5 rounded"
                                >Kelas {{ $kelas->kode_kelas }}</span
                            >
                            <span
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest truncate"
                                >Dosen: {{ auth('dosen')->user()->nama }}</span
                            >
                        </div>
                    </div>
                </div>

                <div class="hidden md:block w-px h-8 bg-slate-200"></div>

                <nav
    class="w-full md:w-auto flex p-1 bg-slate-100 rounded-xl overflow-x-auto scrollbar-hide snap-x gap-1"
>
    {{-- Materi & Modul (halaman aktif / current page) --}}
    <a
        href="{{ route('dosen.course.manage', $kelas->id) }}"
        class="snap-start shrink-0 px-5 py-2 rounded-lg bg-white text-blue-700 font-bold text-[10px] uppercase tracking-widest shadow-sm border border-slate-200 whitespace-nowrap transition-all"
    >
        Materi & Modul
    </a>

    {{-- Absensi --}}
    <a
        href="{{ route('dosen.attendance.index', $kelas->id) }}"
        class="snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/50 flex items-center justify-center"
    >
        Absensi
    </a>

    {{-- Penugasan --}}
    <a
        href="{{ route('dosen.course.assignments', $kelas->id) }}"
        class="snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/50 flex items-center justify-center"
    >
        Penugasan
    </a>

    {{-- Peserta --}}
    <a
        href="{{ route('dosen.course.students', $kelas->id) }}"
        class="snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/50 flex items-center justify-center"
    >
        Peserta
    </a>

    {{-- Rekap Nilai --}}
    <a
        href="{{ route('dosen.grades.recap', $kelas->id) }}"
        class="snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/50 flex items-center justify-center"
    >
        Rekap Nilai
    </a>
</nav>


                <div class="hidden md:block w-10"></div>
            </div>
        </div>

        <main
            class="flex-1 max-w-6xl mx-auto p-4 md:p-6 lg:p-8 w-full space-y-8"
        >
           <div
    class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden flex flex-col md:flex-row"
>
    <form
        action="{{ route('dosen.course.updateDeskripsi', $kelas->id) }}"
        method="POST"
        enctype="multipart/form-data"
        class="flex flex-col md:flex-row w-full"
    >
        @csrf
        @method('PUT')

        <!-- SAMPUL -->
        <div
    class="w-full md:w-1/3 bg-slate-100 relative group cursor-pointer border-r border-slate-200 h-64 md:h-auto"
>
    <input
        type="file"
        name="sampul"
        class="absolute inset-0 opacity-0 cursor-pointer z-10"
        onchange="previewImage(this,'preview-header','placeholder-header')"
    />

    {{-- PLACEHOLDER --}}
    <div
        id="placeholder-header"
        class="absolute inset-0 flex flex-col items-center justify-center text-slate-400 p-8 text-center
        {{ $kelas->sampul ? 'hidden' : '' }}"
    >
        <span class="text-xs font-bold uppercase tracking-widest">
            Klik untuk upload sampul
        </span>
    </div>

    {{-- GAMBAR DARI DATABASE --}}
    <img
        id="preview-header"
        src="{{ $kelas->sampul ? asset('storage/' . $kelas->sampul) : '' }}"
        class="w-full h-full object-cover {{ $kelas->sampul ? '' : 'hidden' }}"
    />
</div>


        <!-- DESKRIPSI -->
        <div class="flex-1 p-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-black text-slate-900">
                    Deskripsi Mata Kuliah
                </h3>
                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-xl text-[10px] font-bold uppercase hover:bg-blue-700 transition-all"
                >
                    Simpan
                </button>
            </div>

            <textarea
                name="deskripsi"
                class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium text-slate-600 focus:ring-2 focus:ring-blue-500 h-40 resize-none leading-relaxed"
            >{{ old('deskripsi', $kelas->mataKuliah->deskripsi) }}</textarea>
        </div>
    </form>
</div>

            </div>

            <div class="space-y-4">
                <div class="flex justify-between items-center px-4">
                    <h3
                        class="font-black text-slate-400 uppercase tracking-widest text-[10px]"
                    >
                        Rencana Pertemuan
                    </h3>
                    <button
                        onclick="toggleModal('modalAddSession', true)"
                        class="px-5 py-2.5 bg-slate-900 text-white rounded-xl text-[10px] font-bold uppercase hover:bg-blue-600 transition-all"
                    >
                        + Tambah Pertemuan
                    </button>
                </div>

                <div
    class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm divide-y divide-slate-100"
>
    @forelse ($kelas->courseSessions as $session)

        <div
            class="p-6 flex flex-col sm:flex-row items-center justify-between gap-4 hover:bg-slate-50 transition-all"
        >
            <div class="flex items-center gap-6 w-full sm:w-auto">
                <div
                    class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center font-black text-lg shrink-0"
                >
                    {{ $loop->iteration }}
                </div>
                <div>
                    <h4 class="font-black text-slate-900">
                        {{ $session->judul }}
                    </h4>
                    <p
                        class="text-[10px] text-slate-400 font-bold uppercase tracking-widest"
                    >
                        {{ $session->materi_count ?? 0 }} Materi •
                        {{ $session->diskusi_count ?? 0 }} Forum Diskusi
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <a
                               href="{{ route('dosen.course.session.detail', [
    'kelas' => $kelas->id,
    'session' => $session->id
]) }}"

                                class="flex-1 sm:flex-none px-6 py-2.5 bg-blue-50 text-blue-600 rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-blue-600 hover:text-white transition-all text-center"
                                >Kelola Isi & Diskusi</a
                            >
            </div>
        </div>
    @empty
        <div class="p-10 text-center text-slate-400 text-sm font-bold">
            Belum ada pertemuan
        </div>
    @endforelse
</div>

        </main>

        <div id="modalAddSession" class="fixed inset-0 z-50 hidden">
            <div
                class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
                onclick="toggleModal('modalAddSession', false)"
            ></div>
            <div class="absolute inset-0 flex items-center justify-center p-4">
                <div
                    class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg p-8"
                >
                    <form
    action="{{ route('dosen.course.session.store', $kelas->id) }}"
    method="POST"
>
    @csrf

    <h3 class="text-2xl font-black text-slate-900 mb-6">
        Pertemuan Baru
    </h3>

    <input
        type="text"
        name="judul"
        placeholder="Judul Pertemuan..."
        required
        class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:border-blue-500 mb-6"
    />

    <div class="flex gap-4">
        <button
            type="button"
            onclick="toggleModal('modalAddSession', false)"
            class="flex-1 py-3 bg-slate-100 text-slate-500 rounded-xl font-bold text-xs uppercase"
        >
            Batal
        </button>

        <button
            type="submit"
            class="flex-1 py-3 bg-blue-600 text-white rounded-xl font-bold text-xs uppercase shadow-lg"
        >
            Buat Sesi
        </button>
    </div>
</form>

                    </div>
                </div>
            </div>
        </div>

        <script>
            function toggleModal(modalID, show) {
                const modal = document.getElementById(modalID);
                if (show) modal.classList.remove("hidden");
                else modal.classList.add("hidden");
            }

            function previewImage(input, previewId, placeholderId) {
                const preview = document.getElementById(previewId);
                const placeholder = document.getElementById(placeholderId);
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.classList.remove("hidden");
                        placeholder.classList.add("hidden");
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    </body>
</html>
