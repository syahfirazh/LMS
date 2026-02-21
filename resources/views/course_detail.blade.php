<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Pembelajaran - Struktur Data 3C | LMS Inklusi UMMI</title>

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
                scrollbar-gutter: stable; /* Mengunci ruang scrollbar agar tidak geser */
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
                                {{ $kelas->mataKuliah->nama }}
                            </h1>
                            <p
                                class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1 truncate"
                            >
                                Dosen: {{ $kelas->dosen->nama }}
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
                                class="cursor-pointer active:scale-95 snap-start shrink-0 px-5 py-2 rounded-lg bg-white text-blue-700 font-bold text-[10px] uppercase tracking-widest shadow-sm border border-slate-200 whitespace-nowrap transition-all"
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
                                class="cursor-pointer active:scale-95 snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-white/50 font-bold text-[10px] uppercase tracking-widest border border-transparent whitespace-nowrap transition-all"
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

            <div
                class="max-w-6xl mx-auto w-full p-4 md:p-6 lg:p-8 space-y-6 pb-20"
            >
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <div
                            data-aos="fade-up"
                            data-aos-duration="600"
                            class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex flex-col md:flex-row gap-6 items-start"
                        >
                            <div
                                class="w-full md:w-1/3 h-48 md:h-40 rounded-2xl overflow-hidden relative group shrink-0"
                            >
                                <img
                                    src="{{
                                        asset('images/course-banner.jpg')
                                    }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                    alt="Thumbnail"
                                />
                                <div
                                    class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest text-slate-900"
                                >
                                    Semester 3
                                </div>
                            </div>
                            <div class="flex-1 space-y-3">
                                <h2
                                    class="text-lg font-black text-slate-900 leading-tight"
                                >
                                   {{ $kelas->mataKuliah->nama }}
                                </h2>
                                <p
                                    class="text-sm font-medium text-slate-500 leading-relaxed line-clamp-3"
                                >
                                    {{ $kelas->mataKuliah->deskripsi }}
                                </p>
                                <div class="pt-2 flex gap-2">
                                    <span
                                        class="px-3 py-1 bg-blue-50 text-blue-700 text-[9px] font-bold uppercase tracking-wider rounded-lg"
                                        >{{ $kelas->mataKuliah->sks }} SKS</span
                                    >
                                    <span
                                        class="px-3 py-1 bg-purple-50 text-purple-700 text-[9px] font-bold uppercase tracking-wider rounded-lg"
                                        >Wajib</span
                                    >
                                </div>
                            </div>
                        </div>

                        <div
                            data-aos="fade-up"
                            data-aos-duration="600"
                            data-aos-delay="100"
                            class="bg-blue-600 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-lg shadow-blue-200/50"
                        >
                            <div
                                class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4"
                            >
                                <div>
                                    <p
                                        class="text-blue-200 text-[10px] font-bold uppercase tracking-widest mb-1"
                                    >
                                        Progres Belajar Anda
                                    </p>
                                    <h3 class="text-3xl font-black tracking-tight">
    {{ $progress }}% Selesai
</h3>

<p class="text-[10px] text-blue-200 font-bold">
    {{ $completedSession }} dari {{ $totalSession }} pertemuan
</p>
                                </div>
                                @php
    $current = $kelas->courseSessions
        ->first(fn ($s) => !$s->is_done)
        ?? $kelas->courseSessions->last();
@endphp

@if ($current)
<button
   onclick="bukaSession({{ $current->id }})"
    class="cursor-pointer active:scale-95 bg-white text-blue-600 px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-50 transition-all shadow-md w-full md:w-auto"
>
    Lanjut Materi ({{ $current->pertemuan_ke }})
</button>
@endif
                            </div>
                            <div
                                class="absolute -right-6 -bottom-10 opacity-20 pointer-events-none"
                            >
                                <svg
                                    class="w-40 h-40"
                                    viewBox="0 0 200 200"
                                    fill="currentColor"
                                >
                                    <path
                                        d="M45,-75.4C58.9,-69.3,71.4,-59.1,79.9,-46.3C88.4,-33.5,92.9,-18.1,89.6,-3.3C86.3,11.5,75.2,25.7,64.2,38.2C53.2,50.7,42.3,61.5,29.9,67.3C17.5,73.1,3.6,73.9,-9.4,72.1C-22.4,70.3,-34.5,65.9,-45.6,58.8C-56.7,51.7,-66.8,41.9,-73.4,30.1C-80,18.3,-83.1,4.5,-79.8,-7.8C-76.5,-20.1,-66.8,-30.9,-56.3,-39.7C-45.8,-48.5,-34.5,-55.3,-22.8,-62.8C-11.1,-70.3,1,-78.5,14.3,-80.8L27.6,-83.1Z"
                                        transform="translate(100 100)"
                                    />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        data-aos="fade-up"
                        data-aos-duration="600"
                        data-aos-delay="200"
                        class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm h-fit"
                    >
                        <div class="flex items-center justify-between mb-6">
                            <h3
                                class="text-sm font-black text-slate-900 uppercase tracking-widest"
                            >
                                Alur Belajar
                            </h3>
                            <span
                                class="text-[9px] font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded-md"
                                >{{ $kelas->courseSessions->count() }} Topik</span
                            >
                        </div>

                        <div class="relative space-y-0 pl-2">
    <div
        class="absolute top-4 left-[19px] bottom-4 w-[2px] bg-slate-100"
    ></div>

    @foreach ($kelas->courseSessions as $index => $session)
        <div
        @if (!$session->is_locked)
            onclick="bukaSession({{ $session->id }})"
            @endif
            class="relative pl-10 py-3 group cursor-pointer active:scale-[0.98] transition-transform
                {{ $session->is_locked ? 'opacity-60 hover:opacity-100' : '' }}"
        >
            <div
                class="absolute left-[10px] top-5 w-5 h-5 rounded-full border-4 border-white shadow-sm z-10 flex items-center justify-center
                {{ $session->is_done
                    ? 'bg-emerald-500'
                    : ($session->is_active
                        ? 'bg-blue-600 animate-pulse'
                        : 'bg-slate-200') }}"
            >
                @if ($session->is_done)
                    <svg
                        class="w-2.5 h-2.5 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="4"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
                @elseif ($session->is_locked)
                    <svg
                        class="w-2.5 h-2.5 text-slate-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="3"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"
                        />
                    </svg>
                @endif
            </div>

            <div
                class="{{ $session->is_active
                    ? 'bg-white border border-blue-200 shadow-md shadow-blue-100 transform group-hover:scale-[1.02]'
                    : 'bg-slate-50 group-hover:bg-blue-50 border border-transparent group-hover:border-blue-100' }}
                p-4 rounded-2xl transition-all"
            >
                <div class="flex justify-between items-start">
                    <span
                        class="text-[9px] font-black uppercase tracking-wider mb-1 block
                        {{ $session->is_done
                            ? 'text-emerald-600'
                            : ($session->is_active
                                ? 'text-blue-600'
                                : 'text-slate-400') }}"
                    >
                        Pertemuan {{ $session->urutan }}
                    </span>
                    <span class="text-[9px] font-bold text-slate-300">
                        #{{ 11 + $index }}
                    </span>
                </div>

                <h4
                    class="text-xs font-bold uppercase
                    {{ $session->is_locked ? 'text-slate-600' : 'text-slate-800' }}"
                >
                    {{ $session->judul }}
                </h4>

                @if ($session->is_active)
                    <p class="text-[9px] text-slate-400 mt-1 font-medium">
                        Sedang dipelajari
                    </p>
                @endif
            </div>
        </div>
    @endforeach
</div>

                        <button
                            class="cursor-pointer active:scale-95 w-full mt-6 py-2 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest hover:text-blue-600 transition-all"
                        >
                            Lihat Semua
                        </button>
                    </div>
                </div>
            </div>
        </main>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({ once: true, easing: "ease-out-cubic" });

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
                    tujuan = "{{ route('courses') ?? '#' }}";
                    teks = "Kembali ke Daftar Mata Kuliah.";
                } else if (nomor === 1) {
                    teks = "Anda sudah berada di halaman Pembelajaran.";
                } else if (nomor === 2) {
                    tujuan = "{{ route('course.attendance', [
    'slug' => $kelas->slug,
    'session' => $session->id
]) }}";
                    teks = "Membuka halaman Presensi.";
                } else if (nomor === 3) {
                    tujuan = "{{ route('course.assignments') ?? '#' }}";
                    teks = "Membuka halaman Penugasan.";
                } else if (nomor === 4) {
                    tujuan = "{{ route('course.members') ?? '#' }}";
                    teks = "Membuka daftar Anggota kelas.";
                } else if (nomor === 11) {
                    teks = "Membuka topik Kontrak Kuliah.";
                } else if (nomor === 12) {
                    tujuan = "{{ route('topic.detail', ['kelas' => $kelas->id]) }}";
                    teks = "Melanjutkan materi Array dan Memori.";
                } else if (nomor === 13) {
                    teks = "Materi Linked List saat ini masih terkunci.";
                }

                if (teks !== "") {
                    bicara(teks);
                    if (tujuan !== "" && tujuan !== "#")
                        setTimeout(() => {
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

                        if (angka) {
                            navigasiKe(parseInt(angka[0]));
                        } else if (
                            hasil.includes("nol") ||
                            hasil.includes("kembali") ||
                            hasil.includes("daftar")
                        ) {
                            navigasiKe(0);
                        } else if (
                            hasil.includes("satu") ||
                            hasil.includes("pembelajaran")
                        ) {
                            navigasiKe(1);
                        } else if (
                            hasil.includes("dua") ||
                            hasil.includes("presensi")
                        ) {
                            navigasiKe(2);
                        } else if (
                            hasil.includes("tiga") ||
                            hasil.includes("penugasan")
                        ) {
                            navigasiKe(3);
                        } else if (
                            hasil.includes("empat") ||
                            hasil.includes("anggota")
                        ) {
                            navigasiKe(4);
                        } else if (
                            hasil.includes("sebelas") ||
                            hasil.includes("kontrak")
                        ) {
                            navigasiKe(11);
                        } else if (
                            hasil.includes("dua belas") ||
                            hasil.includes("array") ||
                            hasil.includes("lanjut")
                        ) {
                            navigasiKe(12);
                        } else if (
                            hasil.includes("tiga belas") ||
                            hasil.includes("linked list")
                        ) {
                            navigasiKe(13);
                        }
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
                    "Anda berada di kelas Struktur Data. Sebutkan angka satu untuk Pembelajaran, dua untuk Presensi, atau angka sebelas dan dua belas untuk memilih topik. Sebutkan angka nol untuk kembali.";
                document.body.addEventListener("click", () => {}, {
                    once: true,
                });
                setTimeout(() => {
                    bicara(orientasi, () => {
                        mulaiMendengar();
                    });
                }, 800);
            };

            function bukaSession(sessionId) {
        const url = "{{ route('topic.detail', ['kelas' => $kelas->id]) }}".replace(':id', sessionId);
        window.location.href = url;
    }
        </script>
    </body>
</html>
