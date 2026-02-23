<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Anggota - Struktur Data 3C | LMS Inklusi UMMI</title>

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
                               {{ $mataKuliah->nama }}
                            </h1>
                            <p
                                class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1 truncate"
                            >
                                {{ $dosen->nama }}
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
                                class="cursor-pointer active:scale-95 snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-white/50 font-bold text-[10px] uppercase tracking-widest border border-transparent whitespace-nowrap transition-all"
                            >
                                3. Penugasan
                            </button>
                            <button
                                onclick="navigasiKe(4)"
                                class="cursor-pointer active:scale-95 snap-start shrink-0 px-5 py-2 rounded-lg bg-white text-blue-700 font-bold text-[10px] uppercase tracking-widest shadow-sm border border-slate-200 whitespace-nowrap transition-all"
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
                <div
                    data-aos="fade-up"
                    data-aos-duration="600"
                    onclick="navigasiKe(5)"
                    class="group bg-gradient-to-br from-blue-600 to-blue-800 rounded-[2rem] p-8 text-white shadow-xl shadow-blue-200/50 cursor-pointer relative overflow-hidden transition-transform hover:scale-[1.01] active:scale-[0.98]"
                >
                    <div
                        class="relative z-10 flex flex-col md:flex-row items-center gap-6"
                    >
                        <div
                            class="w-20 h-20 rounded-full bg-white/20 border-4 border-white/10 flex items-center justify-center text-2xl font-black shadow-inner"
                        >
                            {{ strtoupper(substr($dosen->nama, 0, 2)) }}
                        </div>
                        <div class="flex-1 text-center md:text-left space-y-1">
                            <span
                                class="bg-blue-500/50 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border border-white/10"
                            >
                                Dosen Pengampu
                            </span>
                            <h2 class="text-2xl font-black tracking-tight">
                                {{ $dosen->nama }}
                            </h2>
                            <p
                                class="text-xs font-medium text-blue-100 flex items-center justify-center md:justify-start gap-2"
                            >
                                <span
                                    class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"
                                ></span>
                                {{ $dosen->nidn }}
                            </p>
                        </div>
                        <button
                            class="bg-white text-blue-700 px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-50 transition-all shadow-lg pointer-events-none"
                        >
                            <span class="mr-2 opacity-50">5</span> Hubungi
                        </button>
                    </div>
                    <div
                        class="absolute right-0 top-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"
                    ></div>
                </div>

                <div class="space-y-6">
                    <div
                        data-aos="fade-in"
                        class="flex flex-col md:flex-row items-center justify-between gap-4"
                    >
                        <h3
                            class="text-sm font-black text-slate-900 uppercase tracking-widest px-2 flex items-center gap-2"
                        >
                            Mahasiswa
                            <span
                                class="bg-slate-200 text-slate-600 px-2 py-0.5 rounded-md text-[9px]"
                                >{{ $totalMembers }} Orang</span
                            >
                        </h3>

                        <div
                            onclick="navigasiKe(6)"
                            class="w-full md:w-auto bg-white px-4 py-2 rounded-xl border border-slate-200 flex items-center gap-3 shadow-sm cursor-pointer hover:border-blue-300 transition-all group active:scale-95"
                        >
                            <svg
                                class="w-4 h-4 text-slate-400 group-hover:text-blue-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                ></path>
                            </svg>
                            <span
                                class="text-xs font-bold text-slate-400 group-hover:text-blue-500"
                            >
                                Cari Teman
                                <span class="opacity-50">(6)</span>...
                            </span>
                        </div>
                    </div>

                    <div
    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
>
    @foreach ($members as $index => $mhs)
        <div
            data-aos="fade-up"
            data-aos-duration="600"
            data-aos-delay="{{ 100 + ($index * 50) }}"
            class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all flex items-center gap-4 cursor-pointer hover:-translate-y-1 active:scale-[0.98]"
        >
            <div
                class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-sm border border-indigo-100"
            >
                {{ strtoupper(substr($mhs->nama, 0, 2)) }}
            </div>

            <div class="flex-1 min-w-0">
                <h4
                    class="text-sm font-bold text-slate-800 truncate"
                >
                    {{ $mhs->nama }}
                </h4>
                <p
                    class="text-[10px] text-slate-400 font-medium"
                >
                    {{ $mhs->nim }}
                </p>
            </div>

            <div
                class="w-2 h-2 {{ $mhs->is_online ? 'bg-emerald-500' : 'bg-slate-300' }} rounded-full"
                title="{{ $mhs->is_online ? 'Online' : 'Offline' }}"
            ></div>
        </div>
    @endforeach
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
                    teks = "Kembali ke Beranda.";
                } else if (nomor === 1) {
                    tujuan = "{{ route('course.detail', $session->kelas->id) ?? '#' }}";
                    teks = "Membuka Menu Pembelajaran.";
                } else if (nomor === 2) {
                    tujuan = "{{ route('course.attendance', $session->kelas->id) ?? '#' }}";
                    teks = "Membuka halaman Presensi.";
                } else if (nomor === 3) {
                    tujuan = "{{ route('course.assignments', $session->kelas->id    ) ?? '#' }}";
                    teks = "Membuka halaman Penugasan.";
                } else if (nomor === 4) {
                    teks = "Anda sudah di Halaman Anggota.";
                }
                // KONTEN ANGGOTA
                else if (nomor === 5) {
                    teks = "Membuka chat dengan Dosen Asril.";
                    bicara(teks, () => {
                        setTimeout(
                            () => alert("Fitur Chat Dosen Terbuka"),
                            500,
                        );
                    });
                    return; // Mencegah reload halaman
                } else if (nomor === 6) {
                    teks = "Mengaktifkan pencarian teman.";
                    bicara(teks, () => {
                        setTimeout(() => alert("Ketik nama teman..."), 500);
                    });
                    return; // Mencegah reload halaman
                }

                if (teks !== "") bicara(teks);
                if (tujuan !== "" && tujuan !== "#") {
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

                        if (angka) navigasiKe(parseInt(angka[0]));
                        else if (
                            hasil.includes("nol") ||
                            hasil.includes("kembali")
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
                            hasil.includes("penugasan")
                        )
                            navigasiKe(3);
                        else if (
                            hasil.includes("empat") ||
                            hasil.includes("anggota")
                        )
                            navigasiKe(4);
                        else if (
                            hasil.includes("lima") ||
                            hasil.includes("dosen") ||
                            hasil.includes("hubungi")
                        )
                            navigasiKe(5);
                        else if (
                            hasil.includes("enam") ||
                            hasil.includes("cari") ||
                            hasil.includes("teman")
                        )
                            navigasiKe(6);
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
                    "Anda berada di menu Anggota. Sebutkan nomor Lima untuk menghubungi dosen, atau Enam untuk mencari teman.";

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
