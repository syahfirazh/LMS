<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Input Nilai | Portal Dosen</title>

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

            /* Sembunyikan panah input number bawaan browser */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
            input[type="number"] {
                -moz-appearance: textfield;
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

            .modal-enter {
                animation: modalFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1)
                    forwards;
            }
            .modal-card-enter {
                animation: cardPopUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }
            @keyframes modalFadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }
            @keyframes cardPopUp {
                from {
                    opacity: 0;
                    transform: scale(0.95) translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: scale(1) translateY(0);
                }
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
                            Input Nilai Kelas
                        </h2>
                        <p class="text-sm font-medium text-slate-500">
                            Kelola entri nilai mahasiswa.
                        </p>
                    </div>
                </div>

                <div class="relative hidden md:block min-w-[250px]">
                    <select
                        class="appearance-none w-full bg-white border border-slate-300 rounded-xl px-5 py-3 font-bold text-sm outline-none focus:ring-2 focus:ring-blue-500 shadow-sm text-slate-700 cursor-pointer"
                    >
                        <option selected>PBO - 3A</option>
                        <option>Struktur Data - 3C</option>
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400"
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
                                d="M19 9l-7 7-7-7"
                            ></path>
                        </svg>
                    </div>
                </div>
            </header>

            <div class="p-6 lg:p-10 w-full pb-24">
                <form action="#" method="POST" id="mainGradingForm">
                    @csrf

                    <input
                        type="hidden"
                        id="inputBobotAbsen"
                        name="bobot_absen"
                        value="10"
                    />
                    <input
                        type="hidden"
                        id="inputBobotTugas"
                        name="bobot_tugas"
                        value="20"
                    />
                    <input
                        type="hidden"
                        id="inputBobotUts"
                        name="bobot_uts"
                        value="30"
                    />
                    <input
                        type="hidden"
                        id="inputBobotUas"
                        name="bobot_uas"
                        value="40"
                    />

                    <div
                        class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden safe-fade-in"
                    >
                        <div
                            class="p-6 border-b border-slate-100 flex flex-col xl:flex-row justify-between items-start xl:items-center bg-slate-50/50 gap-5"
                        >
                            <div>
                                <h3
                                    class="font-black text-slate-700 uppercase tracking-widest text-xs mb-2"
                                >
                                    Form Penilaian (3 Mahasiswa)
                                </h3>
                                <span
                                    id="badgeInfoBobot"
                                    class="inline-block text-[10px] font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-100"
                                >
                                    Bobot: Absen 10% | Tugas 20% | UTS 30% | UAS
                                    40%
                                </span>
                            </div>

                            <div class="flex flex-wrap gap-3 w-full xl:w-auto">
                                <button
                                    type="button"
                                    onclick="openModalBobot()"
                                    class="cursor-pointer flex-1 xl:flex-none bg-white border border-slate-200 px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all text-slate-600 shadow-sm flex items-center justify-center gap-2"
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
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                                        ></path>
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        ></path>
                                    </svg>
                                    Atur Bobot
                                </button>

                                <button
                                    type="button"
                                    class="cursor-pointer flex-1 xl:flex-none bg-white border border-slate-200 px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all text-slate-600 shadow-sm flex items-center justify-center gap-2"
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
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                                        ></path>
                                    </svg>
                                    Import Excel
                                </button>

                                <button
                                    type="submit"
                                    class="cursor-pointer flex-1 xl:flex-none bg-blue-600 text-white px-7 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all flex items-center justify-center gap-2 transform hover:-translate-y-0.5"
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
                                            d="M5 13l4 4L19 7"
                                        ></path>
                                    </svg>
                                    Simpan Nilai
                                </button>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead
                                    class="bg-slate-50 border-b border-slate-100 text-slate-500 uppercase tracking-widest text-[10px]"
                                >
                                    <tr>
                                        <th class="px-6 py-5 font-black w-10">
                                            #
                                        </th>
                                        <th
                                            class="px-4 py-5 font-black min-w-[200px]"
                                        >
                                            NIM & Nama
                                        </th>
                                        <th
                                            class="px-3 py-5 font-black text-center w-24"
                                        >
                                            Absen
                                        </th>
                                        <th
                                            class="px-3 py-5 font-black text-center w-24"
                                        >
                                            Tugas
                                        </th>
                                        <th
                                            class="px-3 py-5 font-black text-center w-24"
                                        >
                                            UTS
                                        </th>
                                        <th
                                            class="px-3 py-5 font-black text-center w-24"
                                        >
                                            UAS
                                        </th>
                                        <th
                                            class="px-6 py-5 font-black text-center w-28"
                                        >
                                            Total Akhir
                                        </th>
                                        <th
                                            class="px-4 py-5 font-black text-center w-24"
                                        >
                                            Huruf Mutu
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <tr
                                        class="hover:bg-blue-50/30 transition-colors group"
                                    >
                                        <td
                                            class="px-6 py-4 font-bold text-slate-400"
                                        >
                                            1
                                        </td>
                                        <td class="px-4 py-4">
                                            <div
                                                class="font-bold text-slate-800"
                                            >
                                                Muhammad Ridwan Firdaus
                                            </div>
                                            <div
                                                class="font-mono text-slate-500 font-bold text-[10px]"
                                            >
                                                2430511083
                                            </div>
                                        </td>
                                        <td class="px-3 py-4 text-center">
                                            <input
                                                type="text"
                                                pattern="\d*"
                                                maxlength="3"
                                                id="absen_1"
                                                value="100"
                                                class="w-14 bg-white border border-slate-200 rounded-lg p-2 text-center font-bold text-slate-700 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm"
                                                onkeypress="
                                                    return isNumberKey(event);
                                                "
                                                oninput="calculate(1)"
                                            />
                                        </td>
                                        <td class="px-3 py-4 text-center">
                                            <input
                                                type="text"
                                                pattern="\d*"
                                                maxlength="3"
                                                id="tugas_1"
                                                value="90"
                                                class="w-14 bg-white border border-slate-200 rounded-lg p-2 text-center font-bold text-slate-700 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm"
                                                onkeypress="
                                                    return isNumberKey(event);
                                                "
                                                oninput="calculate(1)"
                                            />
                                        </td>
                                        <td class="px-3 py-4 text-center">
                                            <input
                                                type="text"
                                                pattern="\d*"
                                                maxlength="3"
                                                id="uts_1"
                                                value="85"
                                                class="w-14 bg-white border border-slate-200 rounded-lg p-2 text-center font-bold text-slate-700 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm"
                                                onkeypress="
                                                    return isNumberKey(event);
                                                "
                                                oninput="calculate(1)"
                                            />
                                        </td>
                                        <td class="px-3 py-4 text-center">
                                            <input
                                                type="text"
                                                pattern="\d*"
                                                maxlength="3"
                                                id="uas_1"
                                                value="88"
                                                class="w-14 bg-white border border-slate-200 rounded-lg p-2 text-center font-bold text-slate-700 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm"
                                                onkeypress="
                                                    return isNumberKey(event);
                                                "
                                                oninput="calculate(1)"
                                            />
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <div
                                                id="total_1"
                                                class="font-black text-sm text-slate-400"
                                            >
                                                --
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <span
                                                id="huruf_1"
                                                class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase bg-slate-100 text-slate-400 border border-slate-200"
                                                >-</span
                                            >
                                        </td>
                                    </tr>

                                    <tr
                                        class="hover:bg-blue-50/30 transition-colors group"
                                    >
                                        <td
                                            class="px-6 py-4 font-bold text-slate-400"
                                        >
                                            2
                                        </td>
                                        <td class="px-4 py-4">
                                            <div
                                                class="font-bold text-slate-800"
                                            >
                                                Siti Aisyah Rahmawati
                                            </div>
                                            <div
                                                class="font-mono text-slate-500 font-bold text-[10px]"
                                            >
                                                2430511084
                                            </div>
                                        </td>
                                        <td class="px-3 py-4 text-center">
                                            <input
                                                type="text"
                                                pattern="\d*"
                                                maxlength="3"
                                                id="absen_2"
                                                value="80"
                                                class="w-14 bg-white border border-slate-200 rounded-lg p-2 text-center font-bold text-slate-700 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm"
                                                onkeypress="
                                                    return isNumberKey(event);
                                                "
                                                oninput="calculate(2)"
                                            />
                                        </td>
                                        <td class="px-3 py-4 text-center">
                                            <input
                                                type="text"
                                                pattern="\d*"
                                                maxlength="3"
                                                id="tugas_2"
                                                value="95"
                                                class="w-14 bg-white border border-slate-200 rounded-lg p-2 text-center font-bold text-slate-700 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm"
                                                onkeypress="
                                                    return isNumberKey(event);
                                                "
                                                oninput="calculate(2)"
                                            />
                                        </td>
                                        <td class="px-3 py-4 text-center">
                                            <input
                                                type="text"
                                                pattern="\d*"
                                                maxlength="3"
                                                id="uts_2"
                                                value="90"
                                                class="w-14 bg-white border border-slate-200 rounded-lg p-2 text-center font-bold text-slate-700 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm"
                                                onkeypress="
                                                    return isNumberKey(event);
                                                "
                                                oninput="calculate(2)"
                                            />
                                        </td>
                                        <td class="px-3 py-4 text-center">
                                            <input
                                                type="text"
                                                pattern="\d*"
                                                maxlength="3"
                                                id="uas_2"
                                                value="92"
                                                class="w-14 bg-white border border-slate-200 rounded-lg p-2 text-center font-bold text-slate-700 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm"
                                                onkeypress="
                                                    return isNumberKey(event);
                                                "
                                                oninput="calculate(2)"
                                            />
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <div
                                                id="total_2"
                                                class="font-black text-sm text-slate-400"
                                            >
                                                --
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <span
                                                id="huruf_2"
                                                class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase bg-slate-100 text-slate-400 border border-slate-200"
                                                >-</span
                                            >
                                        </td>
                                    </tr>

                                    <tr
                                        class="hover:bg-blue-50/30 transition-colors group"
                                    >
                                        <td
                                            class="px-6 py-4 font-bold text-slate-400"
                                        >
                                            3
                                        </td>
                                        <td class="px-4 py-4">
                                            <div
                                                class="font-bold text-slate-800"
                                            >
                                                Budi Santoso
                                            </div>
                                            <div
                                                class="font-mono text-slate-500 font-bold text-[10px]"
                                            >
                                                2430511085
                                            </div>
                                        </td>
                                        <td class="px-3 py-4 text-center">
                                            <input
                                                type="text"
                                                pattern="\d*"
                                                maxlength="3"
                                                id="absen_3"
                                                value="50"
                                                class="w-14 bg-white border border-slate-200 rounded-lg p-2 text-center font-bold text-slate-700 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm"
                                                onkeypress="
                                                    return isNumberKey(event);
                                                "
                                                oninput="calculate(3)"
                                            />
                                        </td>
                                        <td class="px-3 py-4 text-center">
                                            <input
                                                type="text"
                                                pattern="\d*"
                                                maxlength="3"
                                                id="tugas_3"
                                                value="45"
                                                class="w-14 bg-white border border-slate-200 rounded-lg p-2 text-center font-bold text-slate-700 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm"
                                                onkeypress="
                                                    return isNumberKey(event);
                                                "
                                                oninput="calculate(3)"
                                            />
                                        </td>
                                        <td class="px-3 py-4 text-center">
                                            <input
                                                type="text"
                                                pattern="\d*"
                                                maxlength="3"
                                                id="uts_3"
                                                value="55"
                                                class="w-14 bg-white border border-slate-200 rounded-lg p-2 text-center font-bold text-slate-700 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm"
                                                onkeypress="
                                                    return isNumberKey(event);
                                                "
                                                oninput="calculate(3)"
                                            />
                                        </td>
                                        <td class="px-3 py-4 text-center">
                                            <input
                                                type="text"
                                                pattern="\d*"
                                                maxlength="3"
                                                id="uas_3"
                                                placeholder="0"
                                                class="w-14 bg-white border border-slate-200 rounded-lg p-2 text-center font-bold text-slate-700 focus:ring-2 focus:ring-blue-400 outline-none shadow-sm"
                                                onkeypress="
                                                    return isNumberKey(event);
                                                "
                                                oninput="calculate(3)"
                                            />
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <div
                                                id="total_3"
                                                class="font-black text-sm text-slate-400"
                                            >
                                                --
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <span
                                                id="huruf_3"
                                                class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase bg-slate-100 text-slate-400 border border-slate-200"
                                                >-</span
                                            >
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </main>

        <div
            id="modalBobot"
            class="fixed inset-0 z-[60] hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity"
        >
            <div
                class="bg-white rounded-[2rem] w-full max-w-md shadow-2xl overflow-hidden modal-card-enter"
            >
                <div
                    class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50"
                >
                    <h3 class="font-black text-slate-800 text-lg">
                        Atur Bobot Penilaian
                    </h3>
                    <button
                        type="button"
                        onclick="closeModalBobot()"
                        class="cursor-pointer text-slate-400 hover:text-red-500 transition-colors"
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

                <div class="p-6 space-y-5">
                    <div
                        class="flex justify-between items-center bg-blue-50 p-3 rounded-xl border border-blue-100"
                    >
                        <span class="text-xs font-bold text-blue-800"
                            >Total Persentase:</span
                        >
                        <span
                            id="modalTotalBadge"
                            class="px-2 py-1 bg-blue-600 text-white text-xs font-black rounded-md"
                            >100%</span
                        >
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1.5"
                                >Absensi (%)</label
                            >
                            <input
                                type="text"
                                pattern="\d*"
                                maxlength="3"
                                id="modalAbsen"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 font-bold text-slate-700 focus:ring-2 focus:ring-blue-500 outline-none"
                                onkeypress="return isNumberKey(event);"
                                oninput="checkModalTotal()"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1.5"
                                >Tugas (%)</label
                            >
                            <input
                                type="text"
                                pattern="\d*"
                                maxlength="3"
                                id="modalTugas"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 font-bold text-slate-700 focus:ring-2 focus:ring-blue-500 outline-none"
                                onkeypress="return isNumberKey(event);"
                                oninput="checkModalTotal()"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1.5"
                                >UTS (%)</label
                            >
                            <input
                                type="text"
                                pattern="\d*"
                                maxlength="3"
                                id="modalUts"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 font-bold text-slate-700 focus:ring-2 focus:ring-blue-500 outline-none"
                                onkeypress="return isNumberKey(event);"
                                oninput="checkModalTotal()"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1.5"
                                >UAS (%)</label
                            >
                            <input
                                type="text"
                                pattern="\d*"
                                maxlength="3"
                                id="modalUas"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 font-bold text-slate-700 focus:ring-2 focus:ring-blue-500 outline-none"
                                onkeypress="return isNumberKey(event);"
                                oninput="checkModalTotal()"
                            />
                        </div>
                    </div>
                </div>

                <div
                    class="p-6 border-t border-slate-100 flex gap-3 bg-slate-50"
                >
                    <button
                        type="button"
                        onclick="closeModalBobot()"
                        class="cursor-pointer flex-1 px-4 py-3 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-100 transition-colors text-sm"
                    >
                        Batal
                    </button>
                    <button
                        type="button"
                        onclick="saveBobot()"
                        id="btnSaveBobot"
                        class="cursor-pointer flex-1 px-4 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors text-sm shadow-md"
                    >
                        Terapkan Bobot
                    </button>
                </div>
            </div>
        </div>

        <script>
            // Validasi Murni hanya angka (Tolak spasi, huruf, minus, titik, e)
            function isNumberKey(evt) {
                var charCode = evt.which ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57))
                    return false;
                return true;
            }

            document.addEventListener("DOMContentLoaded", () => calculateAll());

            function toggleSidebar() {
                document
                    .getElementById("sidebar")
                    .classList.toggle("-translate-x-full");
                document
                    .getElementById("mobileBackdrop")
                    .classList.toggle("hidden");
            }

            const modal = document.getElementById("modalBobot");

            function openModalBobot() {
                document.getElementById("modalAbsen").value =
                    document.getElementById("inputBobotAbsen").value;
                document.getElementById("modalTugas").value =
                    document.getElementById("inputBobotTugas").value;
                document.getElementById("modalUts").value =
                    document.getElementById("inputBobotUts").value;
                document.getElementById("modalUas").value =
                    document.getElementById("inputBobotUas").value;
                checkModalTotal();
                modal.classList.remove("hidden");
                modal.classList.add("modal-enter");
            }

            function closeModalBobot() {
                modal.classList.add("hidden");
                modal.classList.remove("modal-enter");
            }

            function checkModalTotal() {
                const a =
                    parseFloat(document.getElementById("modalAbsen").value) ||
                    0;
                const t =
                    parseFloat(document.getElementById("modalTugas").value) ||
                    0;
                const ut =
                    parseFloat(document.getElementById("modalUts").value) || 0;
                const ua =
                    parseFloat(document.getElementById("modalUas").value) || 0;
                const total = a + t + ut + ua;

                const badge = document.getElementById("modalTotalBadge");
                const btnSave = document.getElementById("btnSaveBobot");

                badge.innerText = total + "%";

                if (total === 100) {
                    badge.className =
                        "px-2 py-1 bg-emerald-500 text-white text-xs font-black rounded-md";
                    btnSave.disabled = false;
                    btnSave.classList.replace("bg-slate-400", "bg-blue-600");
                    btnSave.classList.replace(
                        "cursor-not-allowed",
                        "hover:bg-blue-700",
                    );
                } else {
                    badge.className =
                        "px-2 py-1 bg-red-500 text-white text-xs font-black rounded-md";
                    btnSave.disabled = true;
                    btnSave.classList.replace("bg-blue-600", "bg-slate-400");
                    btnSave.classList.replace(
                        "hover:bg-blue-700",
                        "cursor-not-allowed",
                    );
                }
            }

            function saveBobot() {
                const a = document.getElementById("modalAbsen").value;
                const t = document.getElementById("modalTugas").value;
                const ut = document.getElementById("modalUts").value;
                const ua = document.getElementById("modalUas").value;

                document.getElementById("inputBobotAbsen").value = a;
                document.getElementById("inputBobotTugas").value = t;
                document.getElementById("inputBobotUts").value = ut;
                document.getElementById("inputBobotUas").value = ua;

                document.getElementById("badgeInfoBobot").innerText =
                    `Bobot: Absen ${a}% | Tugas ${t}% | UTS ${ut}% | UAS ${ua}%`;

                closeModalBobot();
                calculateAll();
            }

            function calculateAll() {
                [1, 2, 3].forEach((id) => calculate(id));
            }

            function getHurufMutu(nilai) {
                if (nilai >= 85)
                    return {
                        huruf: "A",
                        class: "bg-emerald-100 text-emerald-700 border-emerald-200",
                    };
                if (nilai >= 70)
                    return {
                        huruf: "B",
                        class: "bg-blue-100 text-blue-700 border-blue-200",
                    };
                if (nilai >= 60)
                    return {
                        huruf: "C",
                        class: "bg-yellow-100 text-yellow-700 border-yellow-200",
                    };
                if (nilai >= 50)
                    return {
                        huruf: "D",
                        class: "bg-orange-100 text-orange-700 border-orange-200",
                    };
                return {
                    huruf: "E",
                    class: "bg-red-100 text-red-700 border-red-200",
                };
            }

            function calculate(id) {
                const bA =
                    (parseFloat(
                        document.getElementById("inputBobotAbsen").value,
                    ) || 0) / 100;
                const bT =
                    (parseFloat(
                        document.getElementById("inputBobotTugas").value,
                    ) || 0) / 100;
                const bUts =
                    (parseFloat(
                        document.getElementById("inputBobotUts").value,
                    ) || 0) / 100;
                const bUas =
                    (parseFloat(
                        document.getElementById("inputBobotUas").value,
                    ) || 0) / 100;

                let elA = document.getElementById(`absen_${id}`);
                let elT = document.getElementById(`tugas_${id}`);
                let elUts = document.getElementById(`uts_${id}`);
                let elUas = document.getElementById(`uas_${id}`);

                if (elA.value > 100) elA.value = 100;
                if (elT.value > 100) elT.value = 100;
                if (elUts.value > 100) elUts.value = 100;
                if (elUas.value > 100) elUas.value = 100;

                const a = parseFloat(elA.value) || 0;
                const t = parseFloat(elT.value) || 0;
                const uts = parseFloat(elUts.value) || 0;
                const uas = parseFloat(elUas.value) || 0;

                let total = a * bA + t * bT + uts * bUts + uas * bUas;

                const elTotal = document.getElementById(`total_${id}`);
                const elHuruf = document.getElementById(`huruf_${id}`);

                if (
                    elA.value === "" &&
                    elT.value === "" &&
                    elUts.value === "" &&
                    elUas.value === ""
                ) {
                    elTotal.innerText = "--";
                    elTotal.className = "font-black text-sm text-slate-400";
                    elHuruf.innerText = "-";
                    elHuruf.className =
                        "px-2.5 py-1 rounded-lg text-[10px] font-black uppercase bg-slate-100 text-slate-400 border border-slate-200";
                    return;
                }

                elTotal.innerText = total.toFixed(1);
                if (total >= 60)
                    elTotal.className = "font-black text-sm text-blue-600";
                else elTotal.className = "font-black text-sm text-red-600";

                const mutu = getHurufMutu(total);
                elHuruf.innerText = mutu.huruf;
                elHuruf.className = `px-2.5 py-1 rounded-lg text-[10px] font-black uppercase border ${mutu.class}`;
            }
        </script>
    </body>
</html>
