<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Daftar Tugas - Struktur Data 3C | LMS Inklusi UMMI</title>

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
            html {
                scrollbar-gutter: stable;
            }
            .custom-scrollbar::-webkit-scrollbar {
                width: 5px;
                height: 5px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background-color: #cbd5e1;
                border-radius: 20px;
            }
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
        class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-full flex flex-col border-box overflow-x-hidden text-slate-800"
    >
        <div
            class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none"
        >
            <div
                class="absolute top-[-10%] right-[-5%] w-[400px] h-[400px] bg-blue-100/40 rounded-full blur-3xl opacity-50"
            ></div>
            <div
                class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] bg-indigo-50/40 rounded-full blur-3xl opacity-50"
            ></div>
        </div>

        <main
            class="flex-1 flex flex-col h-screen overflow-y-scroll custom-scrollbar relative"
        >
            <div
                class="bg-white/90 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm transition-all w-full"
            >
                <div
                    class="max-w-7xl mx-auto flex flex-col lg:flex-row lg:items-center justify-between gap-4 lg:gap-6 relative"
                >
                    <div
                        class="flex items-center gap-4 relative z-10 w-full lg:w-auto"
                    >
                        <button
                            onclick="navigasiKe(0)"
                            class="w-11 h-11 md:w-12 md:h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm shrink-0 group border border-slate-200 hover:border-blue-600 relative cursor-pointer active:scale-95"
                        >
                            <svg
                                class="w-5 h-5 md:w-6 md:h-6 transform group-hover:-translate-x-1 transition-transform"
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
                            <span
                                class="absolute -bottom-1 -right-1 bg-slate-800 text-white text-[9px] font-black px-1.5 py-0.5 rounded-md border border-white"
                                >0</span
                            >
                        </button>

                        <div
                            class="hidden sm:block text-left cursor-pointer group shrink-0"
                            onclick="navigasiKe(0)"
                        >
                            <span
                                class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest"
                                >Navigasi Suara</span
                            >
                            <span
                                class="block text-xs font-black text-slate-700 group-hover:text-blue-600 transition-colors"
                                >0 - Kembali</span
                            >
                        </div>

                        <div
                            class="hidden sm:block w-px h-10 bg-slate-200 mx-2"
                        ></div>

                        <div class="overflow-hidden flex-1">
                            <h1
                                class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight leading-none truncate max-w-[250px] md:max-w-none"
                            >
                                Struktur Data 3C
                            </h1>
                            <p
                                class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1 truncate"
                            >
                                Dosen: Asril Adi Sunarto
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto"
                    >
                        <nav
                            class="w-full lg:w-auto flex p-1.5 bg-slate-100/80 rounded-xl overflow-x-auto custom-scrollbar snap-x gap-1 border border-slate-200/50"
                        >
                            <button
                                onclick="navigasiKe(1)"
                                class="cursor-pointer active:scale-95 snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-white/50 font-bold text-[10px] uppercase tracking-widest border border-transparent whitespace-nowrap transition-all"
                            >
                                1. Pembelajaran
                            </button>
                            <button
                                onclick="navigasiKe(2)"
                                class="cursor-pointer active:scale-95 snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-white/50 font-bold text-[10px] uppercase tracking-widest border border-transparent whitespace-nowrap transition-all"
                            >
                                2. Presensi
                            </button>
                            <button
                                onclick="navigasiKe(3)"
                                class="cursor-pointer active:scale-95 snap-start shrink-0 px-5 py-2 rounded-lg bg-white text-blue-700 font-bold text-[10px] uppercase tracking-widest shadow-sm border border-slate-200 whitespace-nowrap transition-all"
                            >
                                3. Penugasan
                            </button>
                            <button
                                onclick="navigasiKe(4)"
                                class="cursor-pointer active:scale-95 snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-white/50 font-bold text-[10px] uppercase tracking-widest border border-transparent whitespace-nowrap transition-all"
                            >
                                4. Anggota
                            </button>
                        </nav>

                        <div
                            class="hidden md:flex items-center gap-3 pl-4 border-l border-slate-200 relative z-10 justify-end shrink-0 w-32"
                        >
                            <div
                                class="flex items-center gap-[2px] h-4 w-10 justify-center"
                                id="wave-container"
                            >
                                <div
                                    class="wave-bar w-[2px] bg-blue-500 rounded-full h-1 transition-all"
                                ></div>
                                <div
                                    class="wave-bar w-[2px] bg-blue-400 rounded-full h-1 transition-all"
                                ></div>
                                <div
                                    class="wave-bar w-[2px] bg-blue-600 rounded-full h-1 transition-all"
                                ></div>
                            </div>
                            <span
                                id="status-desc"
                                class="text-[9px] font-black text-slate-400 uppercase tracking-widest w-full text-left"
                                >SIAP</span
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-6xl mx-auto w-full p-6 lg:p-8 space-y-8 pb-20">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div
                        data-aos="fade-up"
                        data-aos-duration="600"
                        class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow"
                    >
                        <div
                            class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0"
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
                            <h3
                                class="text-2xl font-black text-slate-900 leading-none"
                            >
                                4 Tugas
                            </h3>
                            <p
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1"
                            >
                                Total Semester Ini
                            </p>
                        </div>
                    </div>

                    <div
                        data-aos="fade-up"
                        data-aos-duration="600"
                        data-aos-delay="100"
                        class="bg-white p-6 rounded-[2rem] border border-orange-200 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow relative overflow-hidden"
                    >
                        <div
                            class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center shrink-0"
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
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <h3
                                class="text-2xl font-black text-orange-600 leading-none"
                            >
                                2 Aktif
                            </h3>
                            <p
                                class="text-[10px] font-bold text-orange-400 uppercase tracking-widest mt-1"
                            >
                                Perlu Dikerjakan
                            </p>
                        </div>
                    </div>

                    <div
                        data-aos="fade-up"
                        data-aos-duration="600"
                        data-aos-delay="200"
                        class="bg-white p-6 rounded-[2rem] border border-emerald-200 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow"
                    >
                        <div
                            class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0"
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
                        <div>
                            <h3
                                class="text-2xl font-black text-emerald-600 leading-none"
                            >
                                2 Selesai
                            </h3>
                            <p
                                class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mt-1"
                            >
                                Sudah Dinilai
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <div>
                        <div
                            data-aos="fade-in"
                            class="flex items-center justify-between mb-4 px-2"
                        >
                            <h3
                                class="text-sm font-black text-slate-900 uppercase tracking-widest"
                            >
                                Perlu Dikerjakan
                            </h3>
                        </div>

                        <div
                            data-aos="fade-up"
                            data-aos-duration="600"
                            class="bg-white rounded-[2.5rem] p-6 border border-slate-200 shadow-sm space-y-4"
                        >
                            <div
                                onclick="navigasiKe(5)"
                                class="group flex flex-col md:flex-row items-start md:items-center gap-4 p-4 rounded-2xl border border-slate-100 hover:border-orange-200 hover:bg-orange-50/30 transition-all cursor-pointer active:scale-[0.98] relative overflow-hidden"
                            >
                                <div
                                    class="absolute left-0 top-0 bottom-0 w-1 bg-orange-400 rounded-l-2xl"
                                ></div>
                                <div class="flex items-center gap-4 flex-1">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-orange-100 text-orange-700 flex items-center justify-center shrink-0 font-black text-sm shadow-sm group-hover:scale-105 transition-transform"
                                    >
                                        5
                                    </div>
                                    <div>
                                        <h4
                                            class="text-sm font-bold text-slate-800 group-hover:text-orange-800 transition-colors"
                                        >
                                            Laporan Praktikum Modul 2: Array
                                        </h4>
                                        <div
                                            class="flex items-center gap-2 mt-1 text-xs font-medium text-orange-600"
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
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                ></path>
                                            </svg>
                                            <span
                                                >Tenggat: Besok, 23:59 WIB</span
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="flex flex-col md:flex-row items-end md:items-center gap-3 shrink-0 mt-3 md:mt-0 w-full md:w-auto"
                                >
                                    <span
                                        class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-[9px] font-bold uppercase tracking-widest"
                                        >Belum Dikumpulkan</span
                                    >
                                    <button
                                        class="w-full md:w-auto px-4 py-2 rounded-xl bg-white border-2 border-orange-100 text-orange-700 font-bold text-[10px] uppercase tracking-widest hover:bg-orange-600 hover:text-white hover:border-transparent transition-all pointer-events-none"
                                    >
                                        Buka
                                    </button>
                                </div>
                            </div>

                            <div
                                onclick="navigasiKe(6)"
                                class="group flex flex-col md:flex-row items-start md:items-center gap-4 p-4 rounded-2xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50/30 transition-all cursor-pointer active:scale-[0.98] relative overflow-hidden"
                            >
                                <div
                                    class="absolute left-0 top-0 bottom-0 w-1 bg-blue-400 rounded-l-2xl"
                                ></div>
                                <div class="flex items-center gap-4 flex-1">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0 font-black text-sm shadow-sm group-hover:scale-105 transition-transform"
                                    >
                                        6
                                    </div>
                                    <div>
                                        <h4
                                            class="text-sm font-bold text-slate-800 group-hover:text-blue-800 transition-colors"
                                        >
                                            Tugas Analisis Linked List
                                        </h4>
                                        <div
                                            class="flex items-center gap-2 mt-1 text-xs font-medium text-slate-500"
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
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                ></path>
                                            </svg>
                                            <span
                                                >Tenggat: 25 Okt, 23:59
                                                WIB</span
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="flex flex-col md:flex-row items-end md:items-center gap-3 shrink-0 mt-3 md:mt-0 w-full md:w-auto"
                                >
                                    <span
                                        class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[9px] font-bold uppercase tracking-widest"
                                        >Baru Dibuka</span
                                    >
                                    <button
                                        class="w-full md:w-auto px-4 py-2 rounded-xl bg-white border-2 border-blue-100 text-blue-700 font-bold text-[10px] uppercase tracking-widest hover:bg-blue-600 hover:text-white hover:border-transparent transition-all pointer-events-none"
                                    >
                                        Buka
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="opacity-90">
                        <div
                            data-aos="fade-in"
                            class="flex items-center justify-between mb-4 px-2"
                        >
                            <h3
                                class="text-sm font-black text-slate-900 uppercase tracking-widest"
                            >
                                Riwayat Selesai
                            </h3>
                        </div>

                        <div
                            data-aos="fade-up"
                            data-aos-duration="600"
                            data-aos-delay="100"
                            class="bg-white rounded-[2.5rem] p-6 border border-slate-200 shadow-sm space-y-4"
                        >
                            <div
                                onclick="navigasiKe(7)"
                                class="group flex flex-col md:flex-row items-start md:items-center gap-4 p-4 rounded-2xl border border-slate-100 bg-emerald-50/20 hover:border-emerald-200 hover:bg-emerald-50 transition-all cursor-pointer active:scale-[0.98] relative overflow-hidden"
                            >
                                <div
                                    class="absolute left-0 top-0 bottom-0 w-1 bg-emerald-400 rounded-l-2xl"
                                ></div>
                                <div class="flex items-center gap-4 flex-1">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 font-black text-sm shadow-sm"
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
                                                stroke-width="3"
                                                d="M5 13l4 4L19 7"
                                            ></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="bg-emerald-600 text-white text-[8px] font-black px-1.5 py-0.5 rounded"
                                                >7</span
                                            >
                                            <h4
                                                class="text-sm font-bold text-slate-800"
                                            >
                                                Laporan Praktikum Modul 1
                                            </h4>
                                        </div>
                                        <p
                                            class="text-xs font-medium text-emerald-600 mt-1"
                                        >
                                            Diserahkan: 17 Okt 2025
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="flex flex-col items-end justify-center"
                                >
                                    <span
                                        class="text-2xl font-black text-emerald-600"
                                        >100</span
                                    >
                                    <span
                                        class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest"
                                        >Nilai (A)</span
                                    >
                                </div>
                            </div>

                            <div
                                onclick="navigasiKe(8)"
                                class="group flex flex-col md:flex-row items-start md:items-center gap-4 p-4 rounded-2xl border border-slate-100 bg-emerald-50/20 hover:border-emerald-200 hover:bg-emerald-50 transition-all cursor-pointer active:scale-[0.98] relative overflow-hidden"
                            >
                                <div
                                    class="absolute left-0 top-0 bottom-0 w-1 bg-emerald-400 rounded-l-2xl"
                                ></div>
                                <div class="flex items-center gap-4 flex-1">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 font-black text-sm shadow-sm"
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
                                                stroke-width="3"
                                                d="M5 13l4 4L19 7"
                                            ></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="bg-emerald-600 text-white text-[8px] font-black px-1.5 py-0.5 rounded"
                                                >8</span
                                            >
                                            <h4
                                                class="text-sm font-bold text-slate-800"
                                            >
                                                Quiz Pre-Test Logika
                                            </h4>
                                        </div>
                                        <p
                                            class="text-xs font-medium text-emerald-600 mt-1"
                                        >
                                            Diserahkan: 10 Okt 2025
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="flex flex-col items-end justify-center"
                                >
                                    <span
                                        class="text-2xl font-black text-emerald-600"
                                        >85</span
                                    >
                                    <span
                                        class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest"
                                        >Nilai (B)</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

        <script>
            // INIT ANIMASI SCROLL
            AOS.init({ once: true, easing: "ease-out-cubic" });

            // LOGIKA VOICE ASSISTANT
            const statusDesc = document.getElementById("status-desc");
            const waveBars = document.querySelectorAll(".wave-bar");
            const synth = window.speechSynthesis;
            const SpeechRec =
                window.webkitSpeechRecognition || window.SpeechRecognition;
            let rec = null;
            let interval;

            if (SpeechRec) {
                rec = new SpeechRec();
                rec.lang = "id-ID";
                rec.continuous = true;
            }

            function setWave(active) {
                if (waveBars.length > 0) {
                    waveBars.forEach((bar) => {
                        bar.style.height = active
                            ? `${Math.floor(Math.random() * 12) + 4}px`
                            : "4px";
                    });
                }
            }

            function bicara(teks, callback) {
                synth.cancel();
                const utter = new SpeechSynthesisUtterance(teks);
                utter.lang = "id-ID";

                const savedRate = localStorage.getItem("speechRate");
                utter.rate = savedRate ? parseFloat(savedRate) : 1.0;

                utter.onstart = () => {
                    if (statusDesc) statusDesc.innerText = "BERBICARA...";
                    interval = setInterval(() => setWave(true), 150);
                };
                utter.onend = () => {
                    if (statusDesc) statusDesc.innerText = "MENDENGARKAN...";
                    clearInterval(interval);
                    setWave(false);
                    if (callback) callback();
                };
                synth.speak(utter);
            }

            function navigasiKe(nomor) {
                let tujuan = "";
                let teks = "";

                if (nomor === 0) {
                    tujuan = "{{ route('dashboard') ?? '#' }}";
                    teks = "Kembali ke Daftar Mata Kuliah.";
                } else if (nomor === 1) {
                    tujuan = "{{ route('course.detail', $session->kelas->id) }}";
                    teks = "Membuka halaman Pembelajaran.";
                } else if (nomor === 2) {
                    tujuan = "{{ route('course.attendance', $session->kelas->id) ?? '#' }}";
                    teks = "Membuka halaman Presensi.";
                } else if (nomor === 3) {
                    teks = "Anda sudah di halaman Penugasan.";
                } else if (nomor === 4) {
                    tujuan = "{{ route('course.members', $session->kelas->id) ?? '#' }}";
                    teks = "Membuka daftar Anggota.";
                }
                // TUGAS NAV
                else if (nomor === 5) {
                    tujuan = "{{ route('assignment.detail') ?? '#' }}";
                    teks = "Membuka tugas Laporan Modul Dua.";
                } else if (nomor === 6) {
                    tujuan = "{{ route('assignment.detail') ?? '#' }}";
                    teks = "Membuka Tugas Analisis Linked List.";
                } else if (nomor === 7) {
                    tujuan = "{{ route('assignment.detail') ?? '#' }}";
                    teks = "Membuka riwayat Laporan Modul Satu.";
                } else if (nomor === 8) {
                    tujuan = "{{ route('assignment.detail') ?? '#' }}";
                    teks = "Membuka riwayat Quiz Pre-Test.";
                }

                if (teks !== "") {
                    bicara(teks);
                    setTimeout(() => {
                        if (tujuan !== "" && tujuan !== "#")
                            window.location.href = tujuan;
                    }, 1500);
                }
            }

            function mulaiMendengar() {
                if (!rec) return;
                try {
                    rec.start();
                    rec.onresult = (event) => {
                        const hasil = event.results[
                            event.results.length - 1
                        ][0].transcript
                            .toLowerCase()
                            .trim();
                        const angka = hasil.match(/\d+/);

                        if (angka) navigasiKe(parseInt(angka[0]));
                        else if (
                            hasil.includes("nol") ||
                            hasil.includes("kembali") ||
                            hasil.includes("daftar")
                        )
                            navigasiKe(0);
                        else if (
                            hasil.includes("satu") ||
                            hasil.includes("pembelajaran")
                        )
                            navigasiKe(1);
                        else if (
                            hasil.includes("dua") ||
                            hasil.includes("presensi")
                        )
                            navigasiKe(2);
                        else if (
                            hasil.includes("tiga") ||
                            hasil.includes("penugasan") ||
                            hasil.includes("tugas")
                        )
                            navigasiKe(3);
                        else if (
                            hasil.includes("empat") ||
                            hasil.includes("anggota")
                        )
                            navigasiKe(4);
                        else if (
                            hasil.includes("lima") ||
                            hasil.includes("modul dua")
                        )
                            navigasiKe(5);
                        else if (
                            hasil.includes("enam") ||
                            hasil.includes("analisis")
                        )
                            navigasiKe(6);
                        else if (
                            hasil.includes("tujuh") ||
                            hasil.includes("modul satu")
                        )
                            navigasiKe(7);
                        else if (
                            hasil.includes("delapan") ||
                            hasil.includes("kuis")
                        )
                            navigasiKe(8);
                    };
                    rec.onend = () => {
                        rec.start();
                    };
                } catch (e) {
                    console.error("Error recognition:", e);
                }
            }

            window.onload = () => {
                const orientasi =
                    "Daftar Tugas. 5 dan 6 Tugas Aktif. 7 dan 8 Tugas Selesai. Sebutkan nomor untuk membuka tugas yang diinginkan.";

                document.body.addEventListener("click", () => {}, {
                    once: true,
                });

                setTimeout(() => {
                    bicara(orientasi, () => {
                        mulaiMendengar();
                    });
                }, 800);
            };
        </script>
    </body>
</html>
