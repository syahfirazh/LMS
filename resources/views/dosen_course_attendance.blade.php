<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Kelola Absensi | Portal Dosen</title>
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
                            class="text-xl font-extrabold text-slate-900 tracking-tight leading-none truncate max-w-[250px] md:max-w-none"
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
                                >Dosen: {{ auth()->guard('dosen')->user()->nama }}</span
                            >
                        </div>
                    </div>
                </div>

                <div class="hidden md:block w-px h-8 bg-slate-200"></div>

                <nav
                    class="w-full md:w-auto flex p-1 bg-slate-100 rounded-xl overflow-x-auto scrollbar-hide snap-x gap-1"
                >
                    <a
                        href="{{ route('dosen.course.manage', $kelas->id) }}"
                        class="snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/50 flex items-center justify-center"
                    >
                        Materi & Modul
                    </a>

                    <button
                        class="snap-start shrink-0 px-5 py-2 rounded-lg bg-white text-blue-700 font-bold text-[10px] uppercase tracking-widest shadow-sm border border-slate-200 whitespace-nowrap transition-all"
                    >
                        Absensi
                    </button>

                    <a
                        href="{{ route('dosen.course.assignments', $kelas->id) }}"
                        class="snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/50 flex items-center justify-center"
                    >
                        Penugasan
                    </a>

                    <a
                        href="{{ route('dosen.course.students', $kelas->id) }}"
                        class="snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/50 flex items-center justify-center"
                    >
                        Peserta 
                    </a>

                    <a
                        href="{{ route('dosen.grades.recap', $kelas->id) }}"
                        class="snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/50 flex items-center justify-center"
                    >
                        Rekap Nilai
                    </a>
                </nav>

                <div class="hidden md:flex items-center justify-end w-10"></div>
            </div>
        </div>

       <main
    class="flex-1 max-w-6xl mx-auto p-4 md:p-6 lg:p-8 w-full space-y-8"
>
    <div
        class="bg-blue-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-blue-200 relative overflow-hidden"
    >
        <div
            class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6"
        >
            <div class="text-center md:text-left">
                @if ($todaySession)
                    <span
                        class="inline-block px-3 py-1 bg-white/20 rounded-lg text-[10px] font-bold uppercase tracking-widest mb-2"
                    >
                        Pertemuan ke-{{ $todaySession->pertemuan }}:
                    </span>
                    <h2 class="text-2xl md:text-3xl font-black mb-1">
                        {{ $todaySession->judul }}
                    </h2>
                    <p class="text-blue-100 font-medium text-sm">
                        {{ optional($todaySession->tanggal)->translatedFormat('l, d M Y') ?? '-' }}
        • {{ $todaySession->jam_mulai }} - {{ $todaySession->jam_selesai }} WIB
                @else
                    <span
                        class="inline-block px-3 py-1 bg-white/20 rounded-lg text-[10px] font-bold uppercase tracking-widest mb-2"
                    >
                        Tidak Ada Pertemuan Hari Ini
                    </span>
                    <h2 class="text-2xl md:text-3xl font-black mb-1">—</h2>
                    <p class="text-blue-100 font-medium text-sm">
                        Silakan buat sesi pertemuan terlebih dahulu
                    </p>
                @endif
            </div>

            <div
                class="flex flex-wrap justify-center gap-3 w-full md:w-auto"
            >
                <button
                    class="bg-white text-blue-600 px-6 py-3 rounded-xl font-bold text-sm hover:bg-blue-50 transition-all flex items-center gap-2 shadow-lg w-full md:w-auto justify-center"
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
                            stroke-width="2"
                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"
                        ></path>
                    </svg>
                    Buka QR Code
                </button>
@if ($todaySession)
    <a
        href="{{ route('dosen.attendance.manual', $todaySession->id) }}"
        class="bg-blue-700 text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-blue-800 transition-all border border-blue-500 w-full md:w-auto flex items-center justify-center"
    >
        Input Manual
    </a>
@else
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 flex items-center gap-4 transition-all hover:bg-blue-100/50">
    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shrink-0 shadow-sm">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0116 0z"></path>
        </svg>
    </div>
    <div>
        <h4 class="text-sm font-bold text-slate-900">Sesi Absensi Belum Tersedia</h4>
        <p class="text-xs text-slate-500 font-medium leading-relaxed">
            Silakan buat sesi pertemuan baru di halaman Kelola Kursus terlebih dahulu.
        </p>
    </div>
</div>
@endif

            </div>
        </div>

        <div
            class="absolute -right-10 -bottom-20 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"
        ></div>
    </div>

    <div
        class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden"
    >
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <h3
                class="font-bold text-slate-700 uppercase tracking-widest text-xs"
            >
                Riwayat Pertemuan
            </h3>
        </div>

        @if ($riwayat->count())
    @foreach ($riwayat as $session)
        <a
            href="{{ route('dosen.attendance.history', $session->id) }}"
            class="block p-6 flex flex-col sm:flex-row items-center justify-between gap-4 hover:bg-slate-50 transition-colors group"
        >
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-black text-lg"
                >
                    {{ $session->urutan }}
                </div>

                <div>
                    <h4 class="font-bold text-slate-900 group-hover:text-blue-600">
                        {{ $session->judul }}
                    </h4>
                    <p class="text-xs text-slate-500">
                       {{ $session->tanggal?->translatedFormat('l, d M Y') ?? '-' }}
    • {{ $session->jam_mulai ?? '-' }} - {{ $session->jam_selesai ?? '-' }} WIB

                    </p>
                </div>
            </div>

            <div class="text-right">
                <span class="block text-lg font-black text-slate-900">
                    {{ $session->hadir }}
                    <span class="text-sm text-slate-400 font-bold">
                        /{{ $session->total }}
                    </span>
                </span>
                <span
                    class="text-[9px] font-bold text-slate-400 uppercase tracking-widest bg-slate-100 px-2 py-0.5 rounded"
                >
                    Hadir
                </span>
            </div>
        </a>
    @endforeach
@else
    <div class="p-6 text-sm text-slate-400 italic">
        Belum ada riwayat pertemuan
    </div>
@endif

    </div>
</main>

    </body>
</html>
