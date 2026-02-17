<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Dashboard Dosen | LMS Inklusi UMMI</title>
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
            class="hidden lg:flex w-80 bg-white border-r border-slate-200 flex-col h-screen sticky top-0 z-20"
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

        <main class="flex-1 h-screen overflow-y-auto flex flex-col relative">
            <div
                class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-blue-50 to-transparent -z-10"
            ></div>

            <header
                class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-8 py-6 sticky top-0 z-30"
            >
                <div
                    class="max-w-7xl mx-auto flex items-center justify-between"
                >
                    <div>
                        <h2
                            class="text-2xl font-black text-slate-900 tracking-tight"
                        >
                            Halo, Pak {{ $dosen->nama }}! 👨‍🏫
                        </h2>
                        <p class="text-sm font-medium text-slate-500">
                            {{ $hariIni }}
                        </p>
                    </div>

                    <div class="flex items-center gap-4">
                        <button
                            class="relative p-2 text-slate-400 hover:text-blue-600 transition-all"
                        >
                            <svg
                                class="w-6 h-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                                ></path>
                            </svg>
                            <span
                                class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"
                            ></span>
                        </button>

                        <div class="h-8 w-px bg-slate-200 mx-2"></div>

                        <a
                            href="{{ route('dosen.profile') }}"
                            class="flex items-center gap-3 cursor-pointer group"
                        >
                            <div class="text-right hidden md:block">
                                <p
                                    class="text-sm font-black text-slate-900 group-hover:text-blue-600 transition-colors"
                                >
                                    {{ $dosen->nama }}
                                </p>
                                <p
                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"
                                >
                                    NIDN : {{ $dosen->nidn }}
                                </p>
                            </div>
                            <div
                                class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden border-2 border-white shadow-md"
                            >
                                <img
                                    src="https://ui-avatars.com/api/?name={{ urlencode($dosen->nama) }}&background=0D8ABC&color=fff"
                                    alt="Profile"
                                    class="w-full h-full object-cover"
                                />
                            </div>
                        </a>
                    </div>
                </div>
            </header>

            <div class="p-6 lg:p-10 max-w-7xl mx-auto w-full space-y-10">
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    <div
                        class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-4"
                    >
                        <div
                            class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center font-black text-xl"
                        >
                            <svg
                                class="w-6 h-6"
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
                        </div>
                        <div>
                            <p
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"
                            >
                                Kelas Diampu
                            </p>
                            <h3 class="text-2xl font-black text-slate-900">
                                {{ $totalMatkul }}
                            </h3>
                        </div>
                    </div>

                    <div
                        class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-4"
                    >
                        <div
                            class="w-14 h-14 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center font-black text-xl"
                        >
                            <svg
                                class="w-6 h-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <p
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"
                            >
                                Total Mahasiswa
                            </p>
                            <h3 class="text-2xl font-black text-slate-900">
                                {{ $totalMahasiswa }}
                            </h3>
                        </div>
                    </div>

                    <div
                        class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-4"
                    >
                        <div
                            class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center font-black text-xl"
                        >
                            <svg
                                class="w-6 h-6"
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
                        </div>
                        <div>
                            <p
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"
                            >
                                Perlu Dinilai
                            </p>
                            <h3 class="text-2xl font-black text-slate-900">
                                {{ $totalPenilaian }}
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="flex justify-between items-center px-2">
                            <h3
                                class="text-lg font-black text-slate-900 uppercase tracking-wide"
                            >
                                Mata Kuliah Diampu
                            </h3>
                            <a
                                href="{{ route('dosen.courses') }}"
                                class="text-xs font-bold text-blue-600 hover:underline"
                                >Lihat Semua</a
                            >
                        </div>

                        @foreach ($kelasDiampu as $kelas)
<div
    class="group bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm hover:border-blue-300 hover:shadow-md transition-all cursor-pointer flex items-center gap-6"
>
    <div
        class="w-20 h-20 bg-blue-100 text-blue-600 rounded-3xl flex items-center justify-center shrink-0 font-black text-2xl group-hover:bg-blue-600 group-hover:text-white transition-all"
    >
        {{ strtoupper(substr($kelas->mataKuliah->nama ?? 'MK', 0, 2)) }}
    </div>

    <div class="flex-1">
        <div class="flex justify-between items-start">
            <h4
                class="text-lg font-black text-slate-900 group-hover:text-blue-700 transition-colors"
            >
                {{ $kelas->mataKuliah->nama ?? '-' }}
            </h4>

            <span
                class="px-3 py-1 bg-slate-100 rounded-lg text-[10px] font-bold uppercase tracking-widest text-slate-500"
            >
                {{ $kelas->kode_kelas }}
            </span>
        </div>

        <p class="text-sm text-slate-500 mt-1 mb-3">
            {{ $kelas->hari }},
            {{ $kelas->jam_mulai }} - {{ $kelas->jam_selesai }}
            • {{ $kelas->ruangan }}
        </p>

        <div class="flex gap-2">
            <span
                class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-bold rounded-lg border border-emerald-100"
            >
                {{ $kelas->mahasiswa->count() }} Mahasiswa
            </span>

            <span
                class="px-3 py-1 bg-orange-50 text-orange-600 text-[10px] font-bold rounded-lg border border-orange-100"
            >
                0 Tugas Aktif
            </span>
        </div>
    </div>

    <div
        class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center group-hover:bg-blue-50 transition-all"
    >
        <svg
            class="w-4 h-4 text-slate-400 group-hover:text-blue-600"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 5l7 7-7 7"
            ></path>
        </svg>
    </div>
</div>
@endforeach

                    <div>
                        <h3
                            class="text-lg font-black text-slate-900 uppercase tracking-wide mb-6"
                        >
                            Mengajar Hari Ini
                        </h3>
                        <div
                            class="bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-6"
                        >
                            @foreach ($jadwalHariIni as $jadwal)
<div class="flex gap-4 relative">
    <div class="flex flex-col items-center">
        <div class="w-3 h-3 
            {{ $jadwal['status'] === 'berlangsung' ? 'bg-blue-500 ring-4 ring-blue-100' : 'bg-slate-300' }}
            rounded-full">
        </div>

        @if (!$loop->last)
        <div class="w-0.5 h-full bg-slate-100 my-1"></div>
        @endif
    </div>

    <div class="pb-6">
        <span class="text-xs font-bold 
            {{ $jadwal['status'] === 'berlangsung' ? 'text-blue-600' : 'text-slate-400' }}">
            {{ $jadwal['jam_mulai'] }} - {{ $jadwal['jam_selesai'] }}
        </span>

        <h4 class="font-bold text-sm mt-1
            {{ $jadwal['status'] === 'berlangsung' ? 'text-slate-900' : 'text-slate-500' }}">
            {{ $jadwal['mata_kuliah'] }}
            @if($jadwal['kelas'])
                ({{ $jadwal['kelas'] }})
            @endif
        </h4>

        <p class="text-xs text-slate-500">
            {{ $jadwal['ruangan'] }}
        </p>

        @if ($jadwal['status'] === 'berlangsung')
            <span
                class="inline-block mt-2 px-2 py-1 bg-emerald-100 text-emerald-700 text-[9px] font-bold rounded uppercase">
                Sedang Berlangsung
            </span>
        @endif
    </div>
</div>
@endforeach


                        <div
                            class="mt-6 bg-orange-50 p-6 rounded-[2rem] border border-orange-100"
                        >
                            <div class="flex gap-3">
                                <div
                                    class="p-2 bg-white rounded-lg text-orange-500 shadow-sm"
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
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                        ></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4
                                        class="font-bold text-orange-800 text-sm"
                                    >
                                        Batas Waktu Penilaian
                                    </h4>
                                    <p
                                        class="text-xs text-orange-600 mt-1 leading-relaxed"
                                    >
                                        Input nilai UTS Struktur Data berakhir
                                        <strong>besok pukul 23:59</strong>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
