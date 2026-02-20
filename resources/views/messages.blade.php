<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Pesan | LMS Inklusi UMMI</title>

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
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
            .custom-scrollbar::-webkit-scrollbar {
                width: 4px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f1f5f9;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 4px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
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
            class="fixed inset-y-0 left-0 z-50 w-80 bg-white border-r border-slate-200 flex flex-col h-screen transform -translate-x-full lg:translate-x-0 lg:static transition-transform duration-300 ease-in-out shrink-0"
        >
            <div class="p-8 border-b border-slate-100 flex items-center gap-4">
                <img
                    src="{{ asset('images/logo-ummi.png') }}"
                    class="w-10 h-10 object-contain"
                    alt="Logo UMMI"
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
                        Portal Mahasiswa
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
                    href="{{ route('dashboard') ?? '#' }}"
                    onclick="navigasiKe(5)"
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
                                stroke-width="2.5"
                                d="M3 12l2-2m0 0l7-7m9 9l-2-2m0 0l-7-7m7 7v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                            ></path>
                        </svg>
                        <span>Beranda</span>
                    </div>
                    <span
                        class="text-[10px] bg-slate-100 text-slate-500 px-2 py-1 rounded-lg font-black"
                        >5</span
                    >
                </a>

                <a
                    href="{{ route('profile') ?? '#' }}"
                    onclick="navigasiKe(6)"
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
                                stroke-width="2.5"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                            ></path>
                        </svg>
                        <span>Profil Saya</span>
                    </div>
                    <span
                        class="text-[10px] bg-slate-100 text-slate-500 px-2 py-1 rounded-lg font-black"
                        >6</span
                    >
                </a>

                <a
                    href="{{ route('notifications') ?? '#' }}"
                    onclick="navigasiKe(7)"
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
                                stroke-width="2.5"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                            ></path>
                        </svg>
                        <span>Pemberitahuan</span>
                    </div>
                    <span
                        class="text-[10px] bg-slate-100 text-slate-500 px-2 py-1 rounded-lg font-black"
                        >7</span
                    >
                </a>

                <a
                    href="{{ route('messages') ?? '#' }}"
                    onclick="navigasiKe(8)"
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
                                stroke-width="2.5"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                            ></path>
                        </svg>
                        <span>Pesan</span>
                    </div>
                    <span
                        class="text-[10px] bg-blue-200 text-blue-800 px-2 py-1 rounded-lg font-black"
                        >8</span
                    >
                </a>

                <a
                    href="{{ route('help') ?? '#' }}"
                    onclick="navigasiKe(9)"
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
                                stroke-width="2.5"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                        <span>Bantuan</span>
                    </div>
                    <span
                        class="text-[10px] bg-slate-100 text-slate-500 px-2 py-1 rounded-lg font-black"
                        >9</span
                    >
                </a>
            </nav>

            <div class="p-6 border-t border-slate-100">
                <button
                    onclick="navigasiKe(0)"
                    class="w-full p-4 flex items-center justify-between text-red-600 font-bold bg-red-50 rounded-2xl hover:bg-red-100 transition-all border border-red-100 cursor-pointer"
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
                    <span
                        class="text-[10px] bg-red-200 text-red-800 px-2 py-1 rounded-lg font-black"
                        >0</span
                    >
                </button>
            </div>
        </aside>

        <main
            class="flex-1 h-screen overflow-hidden flex flex-col relative bg-slate-50 transition-all duration-300 w-full lg:ml-0"
        >
            <div
                class="absolute top-0 left-0 w-full h-80 bg-gradient-to-b from-blue-50 to-transparent -z-10"
            ></div>

            <header
                class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-8 py-6 sticky top-0 z-30 shrink-0"
            >
                <div
                    class="max-w-7xl mx-auto flex items-center justify-between h-14 w-full"
                >
                    <div class="flex items-center gap-4">
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
                                class="text-2xl font-extrabold text-slate-900 tracking-tight"
                            >
                                Pesan Masuk
                            </h2>
                            <p
                                class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1"
                            >
                                Komunikasi Akademik
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div
                            class="flex items-center gap-3 pr-4 border-r border-slate-200"
                        >
                            <button
                                onclick="navigasiKe(7)"
                                class="relative p-2 text-slate-400 hover:text-blue-600 transition-all cursor-pointer"
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
                            <button
                                onclick="navigasiKe(9)"
                                class="p-2 text-slate-400 hover:text-blue-600 transition-all cursor-pointer"
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
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    ></path>
                                </svg>
                            </button>
                        </div>

                        <div class="hidden md:flex items-center gap-3 pl-4">
                            <div
                                id="wave-container"
                                class="flex items-center gap-[2px] h-4 w-10 justify-center"
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
                                class="text-[9px] font-black text-slate-400 uppercase tracking-widest"
                                >Siap</span
                            >
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex-1 flex overflow-hidden w-full relative">
                <div
                    data-aos="fade-right"
                    data-aos-duration="600"
                    class="w-full md:w-80 bg-white border-r border-slate-200 flex flex-col z-10 hidden md:flex shrink-0 h-full"
                >
                    <div class="p-4 border-b border-slate-100 shrink-0">
                        <input
                            type="text"
                            placeholder="Cari..."
                            class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-slate-400"
                        />
                    </div>
                    <div
                        class="flex-1 overflow-y-auto p-2 space-y-1 custom-scrollbar"
                    >
                        <div
                            onclick="navigasiKe(10)"
                            class="p-3 bg-blue-50 rounded-xl flex gap-3 cursor-pointer border border-blue-100 relative group transition-all"
                        >
                            <div
                                class="w-10 h-10 rounded-xl bg-blue-200 shrink-0 overflow-hidden"
                            >
                                <img
                                    src="https://ui-avatars.com/api/?name=Aris+Martono&background=DBEAFE&color=2563EB"
                                    class="w-full h-full object-cover"
                                />
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <div
                                    class="flex justify-between items-center mb-0.5"
                                >
                                    <h4
                                        class="font-bold text-slate-900 text-xs truncate"
                                    >
                                        Dr. Aris Martono
                                    </h4>
                                    <span
                                        class="text-[9px] font-bold text-blue-600"
                                        >10:45</span
                                    >
                                </div>
                                <p
                                    class="text-[10px] text-slate-500 truncate font-medium"
                                >
                                    Tugas sudah saya terima, Ridwan...
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex-1 flex flex-col bg-[#f0f4f8] relative h-full">
                    <div
                        class="p-4 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between sticky top-0 z-10 shrink-0"
                    >
                        <div
                            class="flex items-center gap-3"
                            data-aos="fade-down"
                            data-aos-duration="500"
                        >
                            <div
                                class="w-10 h-10 rounded-xl bg-blue-100 overflow-hidden shadow-sm"
                            >
                                <img
                                    src="https://ui-avatars.com/api/?name=Aris+Martono&background=DBEAFE&color=2563EB"
                                    class="w-full h-full object-cover"
                                />
                            </div>
                            <div>
                                <h4
                                    class="font-black text-slate-900 text-sm leading-tight"
                                >
                                    Dr. Aris Martono
                                </h4>
                                <span
                                    class="inline-flex items-center text-[9px] font-bold text-emerald-600 uppercase tracking-widest mt-0.5"
                                >
                                    <span
                                        class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5 animate-pulse"
                                    ></span>
                                    Online
                                </span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex-1 p-6 overflow-y-auto space-y-6 custom-scrollbar"
                        id="chat-container"
                    >
                        <div
                            data-aos="fade-up"
                            data-aos-duration="400"
                            data-aos-delay="100"
                            class="flex flex-col items-start max-w-[80%]"
                        >
                            <div
                                class="bg-white p-4 rounded-2xl rounded-tl-none shadow-sm border border-slate-100"
                            >
                                <p
                                    class="text-sm text-slate-700 leading-relaxed font-medium"
                                >
                                    Ridwan, apakah ada kendala dalam pengerjaan
                                    tugas nomor 2?
                                </p>
                            </div>
                            <span
                                class="text-[9px] font-bold text-slate-400 mt-1 ml-1"
                                >10:40 AM</span
                            >
                        </div>

                        <div
                            data-aos="fade-up"
                            data-aos-duration="400"
                            data-aos-delay="200"
                            class="flex flex-col items-end ml-auto max-w-[80%]"
                        >
                            <div
                                class="bg-blue-600 p-4 rounded-2xl rounded-tr-none shadow-md shadow-blue-100"
                            >
                                <p
                                    class="text-sm text-white leading-relaxed font-medium"
                                >
                                    Belum ada pak, sedang saya kerjakan bagian
                                    logikanya. Nanti saya kabari lagi.
                                </p>
                            </div>
                            <span
                                class="text-[9px] font-bold text-slate-400 mt-1 mr-1"
                                >10:42 AM</span
                            >
                        </div>
                    </div>

                    <div
                        data-aos="fade-up"
                        data-aos-anchor="bottom"
                        class="p-4 bg-white border-t border-slate-200 shrink-0 z-20 relative"
                    >
                        <div
                            class="flex items-center gap-2 bg-slate-50 p-2 rounded-2xl border border-slate-200 focus-within:ring-2 focus-within:ring-blue-100 transition-all"
                        >
                            <button
                                onclick="navigasiKe(12)"
                                class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-white rounded-xl transition-all cursor-pointer"
                                title="Kirim Gambar (12)"
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
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    ></path>
                                </svg>
                            </button>

                            <input
                                onclick="navigasiKe(11)"
                                type="text"
                                id="chat-input"
                                placeholder="Ketik pesan... (11)"
                                class="flex-1 bg-transparent text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none px-2"
                            />

                            <button
                                onclick="navigasiKe(13)"
                                class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all cursor-pointer"
                                title="Voice Note (13)"
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
                                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"
                                    ></path>
                                </svg>
                            </button>

                            <button
                                onclick="navigasiKe(14)"
                                class="w-12 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center shadow-md hover:bg-blue-700 transition-all cursor-pointer"
                                title="Kirim (14)"
                            >
                                <svg
                                    class="w-5 h-5 transform rotate-90 ml-0.5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2.5"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
                                    ></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

        <script>
            // INIT ANIMASI AOS
            AOS.init({ once: true, easing: "ease-out-cubic" });

            // FUNGSI TOGGLE SIDEBAR MOBILE
            function toggleSidebar() {
                const sidebar = document.getElementById("sidebar");
                const backdrop = document.getElementById("mobileBackdrop");
                sidebar.classList.toggle("-translate-x-full");
                backdrop.classList.toggle("hidden");
            }

            // ==========================================
            // LOGIKA VOICE ASSISTANT
            // ==========================================
            const statusDesc = document.getElementById("status-desc");
            const waveBars = document.querySelectorAll(".wave-bar");
            const synth = window.speechSynthesis;

            const SpeechRec =
                window.webkitSpeechRecognition || window.SpeechRecognition;
            let rec = null;

            if (SpeechRec) {
                rec = new SpeechRec();
                rec.lang = "id-ID";
                rec.continuous = true;
            } else {
                console.warn("Browser tidak mendukung Web Speech API");
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

            let interval;

            // FUNGSI BICARA DENGAN PENGATURAN KECEPATAN DARI LOCAL STORAGE
            function bicara(teks, callback) {
                synth.cancel();

                const utter = new SpeechSynthesisUtterance(teks);
                utter.lang = "id-ID";

                // Ambil kecepatan suara dari pengaturan
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

            // FUNGSI NAVIGASI VOICE
            function navigasiKe(nomor) {
                let tujuan = "";
                let teks = "";

                // NAVIGASI SIDEBAR (5-0)
                if (nomor === 5) {
                    tujuan = "{{ route('dashboard') ?? '#' }}";
                    teks = "Kembali ke Beranda.";
                } else if (nomor === 6) {
                    tujuan = "{{ route('profile') ?? '#' }}";
                    teks = "Membuka Profil Saya.";
                } else if (nomor === 7) {
                    tujuan = "{{ route('notifications') ?? '#' }}";
                    teks = "Membuka Pemberitahuan.";
                } else if (nomor === 8) {
                    teks = "Anda sudah berada di Halaman Pesan.";
                } else if (nomor === 9) {
                    tujuan = "{{ route('help') ?? '#' }}";
                    teks = "Membuka Bantuan.";
                } else if (nomor === 0) {
                    tujuan = "{{ route('logout') ?? '#' }}";
                    teks = "Keluar akun. Sampai jumpa.";
                }

                // FITUR PESAN (10-14)
                else if (nomor === 10) {
                    teks = "Membuka obrolan dengan Dokter Aris Martono.";
                } else if (nomor === 11) {
                    document.getElementById("chat-input").focus();
                    teks = "Silakan ketik pesan Anda.";
                } else if (nomor === 12) {
                    teks = "Membuka galeri untuk mengirim gambar.";
                } else if (nomor === 13) {
                    teks = "Merekam pesan suara. Silakan bicara.";
                } else if (nomor === 14) {
                    if (
                        document.getElementById("chat-input").value.trim() !==
                        ""
                    ) {
                        teks = "Pesan berhasil dikirim.";
                        document.getElementById("chat-input").value = "";
                    } else {
                        teks = "Kotak pesan masih kosong.";
                    }
                }

                if (teks !== "") {
                    bicara(teks);
                    if (tujuan !== "" && tujuan !== "#") {
                        setTimeout(() => {
                            window.location.href = tujuan;
                        }, 2000);
                    }
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
                            hasil.includes("lima") ||
                            hasil.includes("beranda")
                        )
                            navigasiKe(5);
                        else if (
                            hasil.includes("enam") ||
                            hasil.includes("profil")
                        )
                            navigasiKe(6);
                        else if (
                            hasil.includes("tujuh") ||
                            hasil.includes("pemberitahuan")
                        )
                            navigasiKe(7);
                        else if (
                            hasil.includes("delapan") ||
                            hasil.includes("pesan")
                        )
                            navigasiKe(8);
                        else if (
                            hasil.includes("sembilan") ||
                            hasil.includes("bantuan")
                        )
                            navigasiKe(9);
                        else if (
                            hasil.includes("sebelas") ||
                            hasil.includes("ketik")
                        )
                            navigasiKe(11);
                        else if (
                            hasil.includes("dua belas") ||
                            hasil.includes("gambar")
                        )
                            navigasiKe(12);
                        else if (
                            hasil.includes("tiga belas") ||
                            hasil.includes("suara") ||
                            hasil.includes("voice")
                        )
                            navigasiKe(13);
                        else if (
                            hasil.includes("empat belas") ||
                            hasil.includes("kirim")
                        )
                            navigasiKe(14);
                        else if (
                            hasil.includes("nol") ||
                            hasil.includes("keluar")
                        )
                            navigasiKe(0);
                    };

                    rec.onend = () => {
                        rec.start();
                    };
                } catch (e) {
                    console.error("Error recognition:", e);
                }
            }

            // AUTO-START KETIKA HALAMAN DIMUAT
            window.onload = () => {
                // Teks Penjelasan Detail digabung menjadi instruksi panjang yang natural
                const orientasi =
                    "Halo Ridwan, ini adalah halaman Pesan Anda. Silakan sebutkan angka berikut untuk memilih menu di samping: lima untuk Beranda, enam untuk Profil, tujuh untuk Pemberitahuan, sembilan untuk Bantuan, dan nol untuk Keluar. Untuk membalas pesan ke Dr. Aris Martono, sebutkan: sebelas untuk mengetik, dua belas untuk mengirim gambar, tiga belas untuk merekam suara, dan empat belas untuk mengirim pesan. Apa yang ingin Anda lakukan?";

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
