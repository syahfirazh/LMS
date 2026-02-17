<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Jadwal Mengajar | Portal Dosen</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
            rel="stylesheet"
        />
    </head>
    <body
        class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-full flex overflow-hidden border-box text-slate-800"
    >
        <aside
            class="hidden lg:flex w-80 bg-white border-r border-slate-200 flex-col h-screen sticky top-0 z-20 flex-shrink-0"
        >
            <div class="p-8 border-b border-slate-100 flex items-center gap-4">
                <img
                    src="{{ asset('images/logo-ummi.png') }}"
                    class="w-12 h-12 object-contain"
                    alt="Logo UMMI"
                />
                <div>
                    <h1
                        class="text-xl font-black text-slate-900 tracking-tight leading-none"
                    >
                        LMS Inklusi
                    </h1>
                    <p
                        class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1"
                    >
                        Portal Dosen
                    </p>
                </div>
            </div>

            <nav class="flex-1 p-6 space-y-3 overflow-y-auto">
                <a
                    href="{{ route('dosen.dashboard') }}"
                    class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all"
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
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                        ></path>
                    </svg>
                    <span>Beranda</span>
                </a>

                <a
                    href="{{ route('dosen.courses') }}"
                    class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all"
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
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                        ></path>
                    </svg>
                    <span>Mata Kuliah</span>
                </a>

                <a
                    href="{{ route('dosen.schedule') }}"
                    class="flex items-center gap-4 p-4 bg-blue-50 text-blue-700 rounded-2xl font-bold transition-all shadow-sm border border-blue-100"
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
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                        ></path>
                    </svg>
                    <span>Jadwal Mengajar</span>
                </a>

                <a
                    href="{{ route('dosen.grading') }}"
                    class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all"
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
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                        ></path>
                    </svg>
                    <span>Input Nilai</span>
                </a>

                <a
                    href="{{ route('dosen.exams') }}"
                    class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all"
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
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        ></path>
                    </svg>
                    <span>Kelola Ujian</span>
                </a>

                <a
                    href="{{ route('dosen.messages') }}"
                    class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all"
                >
                    <div class="flex items-center gap-4">
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
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                            ></path>
                        </svg>
                        <span>Pesan</span>
                    </div>
                    <span
                        class="text-[10px] bg-red-100 text-red-600 px-2 py-1 rounded-lg font-black"
                        >3</span
                    >
                </a>
                <a
                    href="{{ route('dosen.profile') }}"
                    class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all"
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
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                        ></path>
                    </svg>
                    <span>Profil Saya</span>
                </a>
            </nav>

            <div class="p-6 border-t border-slate-100">
                <a
                    href="{{ route('logout') }}"
                    class="w-full p-4 flex items-center justify-between text-red-600 font-bold bg-red-50 rounded-2xl hover:bg-red-100 transition-all border border-red-100"
                >
                    <div class="flex items-center gap-3">
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
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                            ></path>
                        </svg>
                        <span>Keluar</span>
                    </div>
                </a>
            </div>
        </aside>

        <main
            class="flex-1 h-screen overflow-y-auto flex flex-col relative bg-[#f8fafc]"
        >
            <header
                class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-8 py-6 sticky top-0 z-30 flex items-center justify-between"
            >
                <div>
                    <h2
                        class="text-2xl font-black text-slate-900 tracking-tight"
                    >
                        Jadwal Mengajar
                    </h2>
                    <p class="text-sm font-medium text-slate-500">
                        Minggu ke-4, Februari 2026
                    </p>
                </div>

                <div class="flex items-center gap-6">
                    <button
                        class="flex items-center gap-2 bg-slate-900 text-white px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-700 transition-all shadow-lg"
                    >
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                            ></path>
                        </svg>
                        Unduh PDF
                    </button>   
            </header>

            @foreach ($hariList as $hari)
<div class="flex gap-6 mb-2">

    <div class="w-24 pt-4 text-right shrink-0">
        <h3
            class="font-black uppercase tracking-widest text-sm
            {{ now()->translatedFormat('l') === $hari ? 'text-blue-600' : 'text-slate-400' }}">
            {{ $hari }}
        </h3>

        @if (now()->translatedFormat('l') === $hari)
            <span
                class="text-[10px] font-bold bg-blue-100 text-blue-600 px-2 py-0.5 rounded inline-block mt-1">
                Hari Ini
            </span>
        @endif
    </div>

    {{-- AREA KONTEN (TIDAK BERUBAH STRUKTUR) --}}
    <div class="flex-1 space-y-4">

        @forelse ($jadwal[$hari] ?? [] as $kelas)
        <div
            class="bg-white p-6 rounded-[2rem] border border-slate-200 border-l-8 border-l-blue-500 shadow-sm hover:shadow-md transition-all group"
        >
            <div class="flex justify-between items-start">
                <div>
                    <span
                        class="text-xs font-bold text-blue-600 mb-1 block">
                        {{ $kelas->jam_mulai }} - {{ $kelas->jam_selesai }} WIB
                    </span>

                    <h4
                        class="text-lg font-black text-slate-900 group-hover:text-blue-600 transition-colors">
                        {{ $kelas->mataKuliah->nama ?? '-' }}
                        ({{ $kelas->kode_kelas }})
                    </h4>

                    <p
                        class="text-sm text-slate-500 flex items-center gap-2 mt-1">
                        {{ $kelas->ruangan }}
                    </p>
                </div>
            </div>
        </div>
        @empty

        {{-- BLOK KOSONG (SAMA PERSIS SEPERTI UI AWAL) --}}
        <div
            class="bg-white p-6 rounded-[2rem] border border-slate-100 border-l-4 border-l-slate-300"
        >
            <p class="text-slate-400 font-bold text-sm italic">
                Tidak ada jadwal mengajar.
            </p>
        </div>

        @endforelse
    </div>
</div>
@endforeach

                {{-- @foreach ($hariList as $hari)
<div class="flex gap-6">
    <div class="w-24 pt-4 text-right shrink-0">
        <h3
            class="font-black uppercase tracking-widest text-sm
            {{ now()->translatedFormat('l') === $hari ? 'text-blue-600' : 'text-slate-400' }}">
            {{ $hari }}
        </h3>

        @if (now()->translatedFormat('l') === $hari)
            <span
                class="text-[10px] font-bold bg-blue-100 text-blue-600 px-2 py-0.5 rounded inline-block mt-1">
                Hari Ini
            </span>
        @endif
    </div>

    <div class="flex-1 space-y-4">
        @forelse ($jadwal[$hari] ?? [] as $kelas)
            <div
                class="bg-white p-6 rounded-[2rem] border border-slate-200 border-l-8 border-l-blue-500 shadow-sm hover:shadow-md transition-all group"
            >
                <div class="flex justify-between items-start">
                    <div>
                        <span
                            class="text-xs font-bold text-blue-600 mb-1 block">
                            {{ $kelas->jam_mulai }} - {{ $kelas->jam_selesai }} WIB
                        </span>

                        <h4
                            class="text-lg font-black text-slate-900 group-hover:text-blue-600 transition-colors">
                            {{ $kelas->mataKuliah->nama_mk }} ({{ $kelas->kode_kelas }})
                        </h4>

                        <p
                            class="text-sm text-slate-500 flex items-center gap-2 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $kelas->ruangan }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div
                class="bg-white p-6 rounded-[2rem] border border-slate-100 border-l-4 border-l-slate-300">
                <p class="text-slate-400 font-bold text-sm italic">
                    Tidak ada jadwal mengajar.
                </p>
            </div>
        @endforelse
    </div>
</div>
@endforeach --}}

            </div>
        </main>
    </body>
</html>
