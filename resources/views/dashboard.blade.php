<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Dashboard Mahasiswa | LMS Inklusi UMMI</title>

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
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                            ></path>
                        </svg>
                        <span>Beranda</span>
                    </div>
                    <span
                        class="text-[10px] bg-blue-200 text-blue-800 px-2 py-1 rounded-lg font-black"
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
                                stroke-width="2"
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
                                stroke-width="2"
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
                        class="text-[10px] bg-slate-100 text-slate-500 px-2 py-1 rounded-lg font-black"
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
            class="flex-1 h-screen overflow-y-auto flex flex-col relative lg:ml-80 transition-all duration-300 custom-scrollbar"
        >
            <div
                class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-blue-50 to-transparent -z-10"
            ></div>

            <header
                class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-8 py-6 sticky top-0 z-30"
            >
                <div
                    class="max-w-7xl mx-auto flex items-center justify-between h-14"
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
                                 Halo, {{ $mahasiswa->nama }}
                            </h2>
                            <p class="text-sm font-medium text-slate-500">
                                Siap untuk belajar hari ini?
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div
                            class="flex items-center gap-3 pr-4 border-r border-slate-200"
                        >
                            <button
                                onclick="navigasiKe(7)"
                                class="p-2 text-slate-400 hover:text-blue-600 transition-all relative cursor-pointer"
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

            <div class="p-6 lg:p-10 max-w-7xl mx-auto w-full space-y-10">
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"
                >
                    <div
                        onclick="navigasiKe(1)"
                        data-aos="fade-up"
                        data-aos-delay="100"
                        class="group bg-white p-8 rounded-[2.5rem] shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all border border-slate-100 cursor-pointer relative overflow-hidden h-full"
                    >
                        <div
                            class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-[100%] -mr-6 -mt-6 transition-transform group-hover:scale-110"
                        ></div>
                        <div
                            class="relative z-10 flex flex-col h-full justify-between"
                        >
                            <div
                                class="w-14 h-14 bg-blue-600 text-white rounded-2xl flex items-center justify-center mb-6 font-black text-xl shadow-lg shadow-blue-200"
                            >
                                1
                            </div>
                            <div>
                                <h3
                                    class="text-xl font-black text-slate-900 tracking-tight group-hover:text-blue-600 transition-colors leading-tight"
                                >
                                    Daftar Mata Kuliah
                                </h3>
                                <p
                                    class="text-sm text-slate-400 font-medium mt-2"
                                >
                                    Lihat semua.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        onclick="navigasiKe(2)"
                        data-aos="fade-up"
                        data-aos-delay="200"
                        class="group bg-white p-8 rounded-[2.5rem] shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all border border-slate-100 cursor-pointer relative overflow-hidden h-full"
                    >
                        <div
                            class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-[100%] -mr-6 -mt-6 transition-transform group-hover:scale-110"
                        ></div>
                        <div
                            class="relative z-10 flex flex-col h-full justify-between"
                        >
                            <div
                                class="w-14 h-14 bg-emerald-500 text-white rounded-2xl flex items-center justify-center mb-6 font-black text-xl shadow-lg shadow-emerald-200"
                            >
                                2
                            </div>
                            <div>
                                <h3
                                    class="text-xl font-black text-slate-900 tracking-tight group-hover:text-emerald-600 transition-colors leading-tight"
                                >
                                    Gabung Mata Kuliah
                                </h3>
                                <p
                                    class="text-sm text-slate-400 font-medium mt-2"
                                >
                                    Masukan kode.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        onclick="navigasiKe(3)"
                        data-aos="fade-up"
                        data-aos-delay="300"
                        class="group bg-white p-8 rounded-[2.5rem] shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all border border-slate-100 cursor-pointer relative overflow-hidden h-full"
                    >
                        <div
                            class="absolute top-0 right-0 w-24 h-24 bg-orange-50 rounded-bl-[100%] -mr-6 -mt-6 transition-transform group-hover:scale-110"
                        ></div>
                        <div
                            class="relative z-10 flex flex-col h-full justify-between"
                        >
                            <div
                                class="w-14 h-14 bg-orange-500 text-white rounded-2xl flex items-center justify-center mb-6 font-black text-xl shadow-lg shadow-orange-200"
                            >
                                3
                            </div>
                            <div>
                                <h3
                                    class="text-xl font-black text-slate-900 tracking-tight group-hover:text-orange-600 transition-colors leading-tight"
                                >
                                    Daftar Ujian
                                </h3>
                                <p
                                    class="text-sm text-slate-400 font-medium mt-2"
                                >
                                    Cek jadwal.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        onclick="navigasiKe(4)"
                        data-aos="fade-up"
                        data-aos-delay="400"
                        class="group bg-gradient-to-br from-indigo-600 to-purple-700 p-8 rounded-[2.5rem] shadow-xl shadow-indigo-200 hover:shadow-2xl hover:-translate-y-1 transition-all text-white cursor-pointer relative overflow-hidden h-full"
                    >
                        <div
                            class="relative z-10 flex flex-col h-full justify-between"
                        >
                            <div
                                class="w-14 h-14 bg-white/20 border border-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mb-6 font-black text-xl"
                            >
                                4
                            </div>
                            <div>
                                <h3
                                    class="text-xl font-black tracking-tight leading-tight"
                                >
                                    Gabung Ujian
                                </h3>
                                <p
                                    class="text-sm text-indigo-100 font-medium mt-2"
                                >
                                    Input token.
                                </p>
                            </div>
                        </div>
                        <div
                            class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"
                        ></div>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="500">
                    <div class="flex items-center justify-between mb-6 px-2">
                        <h3
                            class="text-sm font-black text-slate-900 uppercase tracking-widest"
                        >
                            Sedang Dipelajari
                        </h3>
                        <span
                            class="text-[10px] font-bold bg-slate-200 text-slate-600 px-3 py-1 rounded-full"
                            >Semester {{ $mahasiswa->semester }}</span
                        >
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
@foreach ($kelas as $index => $k)
    <div
        onclick="navigasiKe({{ 11 + $index }})"
        class="group bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-lg transition-all cursor-pointer flex items-center gap-6"
    >
        <div
            class="w-20 h-20 bg-blue-50 text-blue-600 rounded-3xl flex items-center justify-center font-black text-2xl"
        >
            {{ 11 + $index }}
        </div>

        <div class="flex-1">
            <h4 class="text-lg font-black text-slate-900">
                {{ $k->mataKuliah->nama }}
            </h4>

            <p class="text-xs font-bold text-slate-400 uppercase">
                {{ $k->dosen->nama }}
            </p>

            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden mt-2">
                <div
                    class="h-full bg-blue-500 rounded-full"
                    style="width: {{ $k->progress ?? 0 }}%"
                >
            </div>
            </div>
        </div>
    </div>
@endforeach
</div>
                    </div>
                </div>
            </div>
        </main>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
/* ==========================================
   DATA KELAS REAL-TIME DARI DATABASE
========================================== */
const kelasData = {!! json_encode(
    $kelas->values()->map(function ($k, $i) {
        return [
            'nomor' => 11 + $i,
            'nama'  => $k->mataKuliah->nama,
            'url' => route('course.detail', ['kelas' => $k->id]),
        ];
    })->toArray()
) !!};

/* ==========================================
   INIT ANIMASI
========================================== */
AOS.init({ once: true, easing: "ease-out-cubic" });

function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("-translate-x-full");
    document.getElementById("mobileBackdrop").classList.toggle("hidden");
}

/* ==========================================
   VOICE ASSISTANT CORE
========================================== */
const statusDesc = document.getElementById("status-desc");
const waveBars = document.querySelectorAll(".wave-bar");
const synth = window.speechSynthesis;

const SpeechRec =
    window.webkitSpeechRecognition || window.SpeechRecognition;
let rec = SpeechRec ? new SpeechRec() : null;

if (rec) {
    rec.lang = "id-ID";
    rec.continuous = true;
}

function setWave(active) {
    waveBars.forEach(bar => {
        bar.style.height = active
            ? `${Math.floor(Math.random() * 12) + 4}px`
            : "4px";
    });
}

let interval;

/* ==========================================
   FUNGSI BICARA
========================================== */
function bicara(teks, callback) {
    synth.cancel();

    const utter = new SpeechSynthesisUtterance(teks);
    utter.lang = "id-ID";
    utter.rate = parseFloat(localStorage.getItem("speechRate")) || 1.0;

    utter.onstart = () => {
        statusDesc.innerText = "BERBICARA...";
        interval = setInterval(() => setWave(true), 150);
    };

    utter.onend = () => {
        statusDesc.innerText = "MENDENGARKAN...";
        clearInterval(interval);
        setWave(false);
        if (callback) callback();
    };

    synth.speak(utter);
}

/* ==========================================
   NAVIGASI BERDASARKAN ANGKA
========================================== */
function navigasiKe(nomor) {
    let tujuan = "";
    let teks = "";

    if (nomor === 1) {
        tujuan = "{{ route('courses.index') }}";
        teks = "Membuka Daftar Semua Mata Kuliah.";
    } else if (nomor === 2) {
        tujuan = "{{ route('courses.join') }}";
        teks = "Membuka halaman Gabung Mata Kuliah.";
    } else if (nomor === 3) {
        tujuan = "{{ route('exams') }}";
        teks = "Membuka Daftar Ujian.";
    } else if (nomor === 4) {
        tujuan = "{{ route('join.exam') }}";
        teks = "Membuka halaman Gabung Ujian.";
    } else if (nomor === 5) {
        teks = "Anda sudah berada di Beranda.";
    } else if (nomor === 6) {
        tujuan = "{{ route('profile') }}";
        teks = "Membuka Profil Saya.";
    } else if (nomor === 7) {
        tujuan = "{{ route('notifications') }}";
        teks = "Membuka Pemberitahuan.";
    } else if (nomor === 8) {
        tujuan = "{{ route('messages') }}";
        teks = "Membuka Pesan.";
    } else if (nomor === 9) {
        tujuan = "{{ route('help') }}";
        teks = "Membuka Bantuan.";
    } else if (nomor === 0) {
        tujuan = "{{ route('logout') }}";
        teks = "Keluar dari aplikasi. Sampai jumpa.";
    } else {
        const kelas = kelasData.find(k => k.nomor === nomor);
        if (kelas) {
            tujuan = kelas.url;
            teks = "Membuka mata kuliah " + kelas.nama;
        }
    }

    if (teks) {
        bicara(teks);
        if (tujuan) {
            setTimeout(() => window.location.href = tujuan, 2000);
        }
    }
}

/* ==========================================
   SPEECH RECOGNITION
========================================== */
function mulaiMendengar() {
    if (!rec) return;

    rec.start();

    rec.onresult = (event) => {
        const hasil = event.results[event.results.length - 1][0]
            .transcript.toLowerCase().trim();

        const angka = hasil.match(/\d+/);
        if (angka) {
            navigasiKe(parseInt(angka[0]));
            return;
        }

        const mapKata = {
            satu: 1, dua: 2, tiga: 3, empat: 4,
            lima: 5, enam: 6, tujuh: 7,
            delapan: 8, sembilan: 9, nol: 0
        };

        for (const kata in mapKata) {
            if (hasil.includes(kata)) {
                navigasiKe(mapKata[kata]);
                return;
            }
        }

        // Deteksi nama kelas langsung (DINAMIS)
        kelasData.forEach(k => {
            if (hasil.includes(k.nama.toLowerCase())) {
                navigasiKe(k.nomor);
            }
        });
    };

    rec.onend = () => rec.start();
}

/* ==========================================
   AUTO START + ORIENTASI DINAMIS
========================================== */
window.onload = () => {
    const daftarKelasVoice = kelasData
        .map(k => `${k.nomor} untuk kelas ${k.nama}`)
        .join(", ");

    const orientasi =
        "Halo {{ $mahasiswa->nama }}, selamat datang di Dashboard Mahasiswa. " +
        "Silakan sebutkan angka berikut: " +
        "satu untuk Daftar Mata Kuliah, dua untuk Gabung Mata Kuliah, " +
        "tiga untuk Daftar Ujian, empat untuk Gabung Ujian, " +
        "enam untuk Profil Saya, tujuh untuk Pemberitahuan, " +
        "delapan untuk Pesan, sembilan untuk Bantuan, " +
        daftarKelasVoice +
        ", dan nol untuk Keluar. Menu apa yang ingin Anda buka?";

    setTimeout(() => {
        bicara(orientasi, mulaiMendengar);
    }, 800);
};
</script>
    </body>
</html>
