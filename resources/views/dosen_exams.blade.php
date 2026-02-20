<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Kelola Ujian | Portal Dosen</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
            rel="stylesheet"
        />

        <style>
            .custom-scrollbar::-webkit-scrollbar {
                width: 5px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background-color: #cbd5e1;
                border-radius: 20px;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .safe-fade-in {
                animation: fadeIn 0.6s ease-out forwards;
                opacity: 0;
            }
        </style>
    </head>
    <body
        class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-full flex flex-col lg:flex-row overflow-hidden border-box text-slate-800"
    >
        <div
            id="mobileBackdrop"
            onclick="toggleSidebar()"
            class="fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden transition-opacity"
        ></div>

        <aside
            id="sidebar"
            class="fixed inset-y-0 left-0 z-50 w-80 bg-white border-r border-slate-200 flex flex-col h-screen transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out"
        >
            <div class="p-8 border-b border-slate-100 flex items-center gap-4">
                <img
                    src="{{ asset('images/logo-ummi.png') }}"
                    class="w-10 h-10 object-contain"
                    alt="Logo"
                    onerror="this.src = 'https://via.placeholder.com/40'"
                />
                <div>
                    <h1
                        class="text-lg font-black text-slate-900 tracking-tight leading-none"
                    >
                        LMS Inklusi
                    </h1>
                    <p
                        class="text-[9px] font-bold text-blue-600 uppercase tracking-widest mt-1"
                    >
                        Portal Dosen
                    </p>
                </div>
                <button
                    onclick="toggleSidebar()"
                    class="lg:hidden ml-auto text-slate-400 hover:text-slate-600 cursor-pointer"
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
                            d="M6 18L18 6M6 6l12 12"
                        ></path>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 p-6 space-y-3 overflow-y-auto custom-scrollbar">
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
                    href="{{ route('dosen.notifications') }}"
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
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                            ></path>
                        </svg>
                        <span>Pemberitahuan</span>
                    </div>
                    <span class="w-2 h-2 bg-red-500 rounded-full"></span>
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
            class="flex-1 h-screen overflow-y-auto flex flex-col relative bg-[#f8fafc] lg:ml-80 transition-all duration-300 custom-scrollbar"
        >
            <header
                class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-8 py-6 sticky top-0 z-30 flex items-center justify-between"
            >
                <div class="flex items-center gap-4 h-14">
                    <button
                        onclick="toggleSidebar()"
                        class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg cursor-pointer"
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
                                d="M4 6h16M4 12h16M4 18h16"
                            ></path>
                        </svg>
                    </button>
                    <div>
                        <h2
                            class="text-2xl font-black text-slate-900 tracking-tight"
                        >
                            Kelola Ujian & Kuis
                        </h2>
                        <p class="text-sm font-medium text-slate-500">
                            Bank Soal, UTS, UAS, dan Kuis Harian
                        </p>
                    </div>
                </div>
            </header>

            <div class="p-6 lg:p-10 max-w-7xl mx-auto w-full space-y-8 pb-24">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div
                        class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center justify-between safe-fade-in"
                        style="animation-delay: 0.1s"
                    >
                        <div>
                            <p
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1"
                            >
                                Ujian Aktif
                            </p>
                            <h2 class="text-3xl font-black text-slate-900">
                                2
                            </h2>
                        </div>
                        <div
                            class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center"
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
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                        </div>
                    </div>

                    <div
                        class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center justify-between safe-fade-in"
                        style="animation-delay: 0.2s"
                    >
                        <div>
                            <p
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1"
                            >
                                Terjadwal
                            </p>
                            <h2 class="text-3xl font-black text-slate-900">
                                1
                            </h2>
                        </div>
                        <div
                            class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center"
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
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                ></path>
                            </svg>
                        </div>
                    </div>

                    <div
                        class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center justify-between safe-fade-in"
                        style="animation-delay: 0.3s"
                    >
                        <div>
                            <p
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1"
                            >
                                Selesai
                            </p>
                            <h2 class="text-3xl font-black text-slate-900">
                                5
                            </h2>
                        </div>
                        <div
                            class="w-12 h-12 bg-slate-100 text-slate-600 rounded-2xl flex items-center justify-center"
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
                                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
                                ></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div
                        class="flex gap-2 border-b border-slate-200 mb-6 safe-fade-in"
                        style="animation-delay: 0.4s"
                    >
                        <button
                            class="px-6 py-3 border-b-2 border-slate-900 text-slate-900 font-bold text-sm"
                        >
                            Semua
                        </button>
                        <button
                            class="px-6 py-3 border-b-2 border-transparent text-slate-400 font-bold text-sm hover:text-slate-800 transition-colors"
                        >
                            UTS
                        </button>
                        <button
                            class="px-6 py-3 border-b-2 border-transparent text-slate-400 font-bold text-sm hover:text-slate-800 transition-colors"
                        >
                            UAS
                        </button>
                        <button
                            class="px-6 py-3 border-b-2 border-transparent text-slate-400 font-bold text-sm hover:text-slate-800 transition-colors"
                        >
                            Kuis
                        </button>
                    </div>

                    <div
                        onclick="alert('Buka Modal Buat Ujian')"
                        class="bg-slate-50 border-2 border-dashed border-slate-300 rounded-[2.5rem] p-8 flex flex-col items-center justify-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all group min-h-[150px] safe-fade-in"
                        style="animation-delay: 0.5s"
                    >
                        <div
                            class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-sm"
                        >
                            <svg
                                class="w-8 h-8 text-slate-400 group-hover:text-blue-500 transition-colors"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 4v16m8-8H4"
                                ></path>
                            </svg>
                        </div>
                        <h3
                            class="text-lg font-black text-slate-400 group-hover:text-blue-600 transition-colors uppercase tracking-widest"
                        >
                            Buat Ujian Baru
                        </h3>
                    </div>

                    <div
                        class="group bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm hover:shadow-lg transition-all flex flex-col md:flex-row items-center gap-6 safe-fade-in"
                        style="animation-delay: 0.6s"
                    >
                        <div
                            class="w-full md:w-20 h-20 bg-orange-100 text-orange-600 rounded-3xl flex flex-col items-center justify-center shrink-0"
                        >
                            <span
                                class="text-xs font-bold uppercase tracking-wider"
                                >FEB</span
                            >
                            <span class="text-2xl font-black">04</span>
                        </div>
                        <div class="flex-1 w-full text-center md:text-left">
                            <div
                                class="flex flex-col md:flex-row items-center gap-3 mb-1"
                            >
                                <h4
                                    class="text-lg font-black text-slate-900 group-hover:text-blue-600 transition-colors"
                                >
                                    UTS: Algoritma & Pemrograman
                                </h4>
                                <span
                                    class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-full uppercase tracking-wide"
                                    >Sedang Berlangsung</span
                                >
                            </div>
                            <p class="text-sm text-slate-500 font-medium">
                                Struktur Data (3C) • 08:00 - 10:00 WIB
                            </p>
                        </div>
                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <div class="text-right hidden md:block">
                                <span
                                    class="block text-xl font-black text-slate-900"
                                    >32<span
                                        class="text-sm text-slate-400 font-bold"
                                        >/35</span
                                    ></span
                                >
                                <span
                                    class="text-[9px] font-bold text-slate-400 uppercase tracking-widest"
                                    >Submit</span
                                >
                            </div>
                            <button
                                class="flex-1 md:flex-none px-6 py-3 bg-slate-900 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-blue-600 transition-all cursor-pointer"
                            >
                                Pantau
                            </button>
                        </div>
                    </div>

                    <div
                        class="group bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm hover:shadow-lg transition-all flex flex-col md:flex-row items-center gap-6 opacity-75 hover:opacity-100 safe-fade-in"
                        style="animation-delay: 0.7s"
                    >
                        <div
                            class="w-full md:w-20 h-20 bg-blue-50 text-blue-600 rounded-3xl flex flex-col items-center justify-center shrink-0"
                        >
                            <span
                                class="text-xs font-bold uppercase tracking-wider"
                                >FEB</span
                            >
                            <span class="text-2xl font-black">10</span>
                        </div>
                        <div class="flex-1 w-full text-center md:text-left">
                            <div
                                class="flex flex-col md:flex-row items-center gap-3 mb-1"
                            >
                                <h4
                                    class="text-lg font-black text-slate-900 group-hover:text-blue-600 transition-colors"
                                >
                                    Kuis 2: Konsep OOP
                                </h4>
                                <span
                                    class="px-3 py-1 bg-blue-100 text-blue-700 text-[10px] font-bold rounded-full uppercase tracking-wide"
                                    >Terjadwal</span
                                >
                            </div>
                            <p class="text-sm text-slate-500 font-medium">
                                Pemrograman Objek (3A) • 13:00 - 14:00 WIB
                            </p>
                        </div>
                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <button
                                class="flex-1 md:flex-none px-6 py-3 border border-slate-200 text-slate-500 rounded-xl font-bold text-xs uppercase tracking-widest hover:border-slate-400 hover:text-slate-800 transition-all cursor-pointer"
                            >
                                Edit Soal
                            </button>
                        </div>
                    </div>

                    <div
                        class="group bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm hover:shadow-lg transition-all flex flex-col md:flex-row items-center gap-6 opacity-60 hover:opacity-100 safe-fade-in"
                        style="animation-delay: 0.8s"
                    >
                        <div
                            class="w-full md:w-20 h-20 bg-slate-100 text-slate-500 rounded-3xl flex flex-col items-center justify-center shrink-0"
                        >
                            <span
                                class="text-xs font-bold uppercase tracking-wider"
                                >JAN</span
                            >
                            <span class="text-2xl font-black">28</span>
                        </div>
                        <div class="flex-1 w-full text-center md:text-left">
                            <div
                                class="flex flex-col md:flex-row items-center gap-3 mb-1"
                            >
                                <h4 class="text-lg font-black text-slate-900">
                                    Kuis 1: Pengantar Struktur Data
                                </h4>
                                <span
                                    class="px-3 py-1 bg-slate-200 text-slate-600 text-[10px] font-bold rounded-full uppercase tracking-wide"
                                    >Selesai</span
                                >
                            </div>
                            <p class="text-sm text-slate-500 font-medium">
                                Struktur Data (3C) • 35 Peserta
                            </p>
                        </div>
                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <button
                                class="flex-1 md:flex-none px-6 py-3 border border-slate-200 text-blue-600 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-blue-50 transition-all cursor-pointer"
                            >
                                Lihat Hasil
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script>
            function toggleSidebar() {
                document
                    .getElementById("sidebar")
                    .classList.toggle("-translate-x-full");
                document
                    .getElementById("mobileBackdrop")
                    .classList.toggle("hidden");
            }
        </script>
    </body>
</html>
