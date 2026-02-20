<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Pemberitahuan | Portal Dosen</title>

        <link
            href="https://unpkg.com/aos@2.3.1/dist/aos.css"
            rel="stylesheet"
        />
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
        </style>
    </head>
    <body
        class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-full flex overflow-hidden border-box text-slate-800"
    >
        <div
            id="mobileBackdrop"
            onclick="toggleSidebar()"
            class="fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden transition-opacity"
        ></div>

        <aside
            id="sidebar"
            class="fixed inset-y-0 left-0 z-50 w-80 bg-white border-r border-slate-200 flex flex-col h-screen transform -translate-x-full lg:translate-x-0 lg:static transition-transform duration-300 ease-in-out shrink-0"
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
                    class="lg:hidden ml-auto text-slate-400 hover:text-slate-600"
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
                    class="flex items-center justify-between p-4 bg-blue-50 text-blue-700 rounded-2xl font-bold transition-all shadow-sm border border-blue-100"
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
            class="flex-1 h-screen overflow-y-auto flex flex-col relative bg-slate-50 transition-all duration-300"
        >
            <div
                class="absolute top-0 left-0 w-full h-80 bg-gradient-to-b from-blue-50/50 to-transparent -z-10"
            ></div>

            <header
                class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-8 py-6 sticky top-0 z-20 shrink-0"
            >
                <div
                    class="max-w-7xl mx-auto flex items-center justify-between h-14"
                >
                    <div class="flex items-center gap-4">
                        <button
                            onclick="toggleSidebar()"
                            class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg transition-all focus:outline-none focus:ring-2 focus:ring-slate-200 cursor-pointer"
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
                                class="text-2xl font-black text-slate-900 tracking-tight leading-none"
                            >
                                Pemberitahuan
                            </h2>
                            <span
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5 block"
                                >Informasi Akademik</span
                            >
                        </div>
                    </div>
                </div>
            </header>

            <div class="p-6 lg:p-10 max-w-5xl mx-auto w-full space-y-6">
                <div
                    class="flex justify-between items-center mb-4"
                    data-aos="fade-in"
                    data-aos-duration="800"
                >
                    <h3
                        class="text-sm font-bold text-slate-500 uppercase tracking-widest"
                    >
                        Terbaru (2)
                    </h3>
                    <button
                        class="text-[10px] font-bold text-blue-600 uppercase tracking-widest hover:underline hover:text-blue-700 transition-all"
                    >
                        Tandai semua dibaca
                    </button>
                </div>

                <div class="space-y-4">
                    <div
                        data-aos="fade-up"
                        data-aos-delay="100"
                        class="bg-white p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] border-l-8 border-orange-500 shadow-sm hover:shadow-md transition-all flex flex-col md:flex-row items-start md:items-center gap-5 md:gap-6 cursor-pointer group"
                    >
                        <div
                            class="w-14 h-14 md:w-16 md:h-16 bg-orange-50 rounded-2xl md:rounded-3xl flex items-center justify-center text-orange-600 shrink-0 group-hover:scale-110 transition-transform"
                        >
                            <svg
                                class="w-7 h-7 md:w-8 md:h-8"
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
                        <div class="flex-1">
                            <div
                                class="flex flex-col md:flex-row justify-between items-start mb-2 gap-2"
                            >
                                <h4
                                    class="text-base md:text-lg font-bold text-slate-900 group-hover:text-orange-600 transition-colors"
                                >
                                    Batas Waktu Input Nilai
                                </h4>
                                <span
                                    class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50 px-2.5 py-1 rounded-lg border border-slate-100 whitespace-nowrap"
                                >
                                    6 Jam Lalu
                                </span>
                            </div>
                            <p
                                class="text-sm text-slate-500 leading-relaxed font-medium"
                            >
                                Pengisian nilai untuk mata kuliah
                                <span class="text-slate-800 font-bold"
                                    >Struktur Data (3C)</span
                                >
                                akan ditutup dalam
                                <span class="text-orange-600 font-bold"
                                    >24 jam</span
                                >. Mohon segera selesaikan penilaian di portal.
                            </p>
                        </div>
                    </div>

                    <div
                        data-aos="fade-up"
                        data-aos-delay="200"
                        class="bg-white p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] border-l-8 border-blue-500 shadow-sm hover:shadow-md transition-all flex flex-col md:flex-row items-start md:items-center gap-5 md:gap-6 cursor-pointer group"
                    >
                        <div
                            class="w-14 h-14 md:w-16 md:h-16 bg-blue-50 rounded-2xl md:rounded-3xl flex items-center justify-center text-blue-600 shrink-0 group-hover:scale-110 transition-transform"
                        >
                            <svg
                                class="w-7 h-7 md:w-8 md:h-8"
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
                        </div>
                        <div class="flex-1">
                            <div
                                class="flex flex-col md:flex-row justify-between items-start mb-2 gap-2"
                            >
                                <h4
                                    class="text-base md:text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors"
                                >
                                    Jadwal Ujian Telah Disetujui
                                </h4>
                                <span
                                    class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50 px-2.5 py-1 rounded-lg border border-slate-100 whitespace-nowrap"
                                >
                                    Kemarin
                                </span>
                            </div>
                            <p
                                class="text-sm text-slate-500 leading-relaxed font-medium"
                            >
                                Pengajuan jadwal UAS untuk mata kuliah
                                <span class="text-slate-800 font-bold"
                                    >Pemrograman Berorientasi Objek</span
                                >
                                telah disetujui oleh Bagian Akademik.
                            </p>
                        </div>
                    </div>

                    <div
                        data-aos="fade-up"
                        data-aos-delay="300"
                        class="bg-slate-50 p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] border-l-8 border-slate-300 flex flex-col md:flex-row items-start md:items-center gap-5 md:gap-6 opacity-75 hover:opacity-100 transition-all cursor-pointer"
                    >
                        <div
                            class="w-14 h-14 md:w-16 md:h-16 bg-white rounded-2xl md:rounded-3xl flex items-center justify-center text-slate-400 shrink-0 shadow-sm border border-slate-100"
                        >
                            <svg
                                class="w-7 h-7 md:w-8 md:h-8"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                                ></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div
                                class="flex flex-col md:flex-row justify-between items-start mb-2 gap-2"
                            >
                                <h4
                                    class="text-base md:text-lg font-bold text-slate-600"
                                >
                                    Undangan Rapat Dosen Informatika
                                </h4>
                                <span
                                    class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-white px-2.5 py-1 rounded-lg border border-slate-200 whitespace-nowrap"
                                >
                                    3 Hari Lalu
                                </span>
                            </div>
                            <p
                                class="text-sm text-slate-500 leading-relaxed font-medium"
                            >
                                Undangan rapat evaluasi kurikulum semester
                                ganjil di Ruang Rapat 1 pada hari Jumat, 7
                                Februari 2026. Kehadiran sangat diharapkan.
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="pt-8 text-center"
                    data-aos="fade-up"
                    data-aos-delay="400"
                >
                    <button
                        class="px-8 py-4 bg-white border border-slate-200 text-slate-500 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-blue-50 hover:text-blue-600 transition-all shadow-sm"
                    >
                        Lihat Pemberitahuan Lama
                    </button>
                </div>
            </div>
        </main>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Aktifkan Animasi
                AOS.init({
                    once: true,
                    easing: "ease-out-cubic",
                    offset: 50,
                });
            });

            function toggleSidebar() {
                const sidebar = document.getElementById("sidebar");
                const backdrop = document.getElementById("mobileBackdrop");
                sidebar.classList.toggle("-translate-x-full");
                backdrop.classList.toggle("hidden");
            }
        </script>
    </body>
</html>
