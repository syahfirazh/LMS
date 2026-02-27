<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Gabung Ujian | LMS Inklusi UMMI</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
            rel="stylesheet"
        />
        <style>
            html {
                scroll-behavior: smooth;
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
            body {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                overflow-x: hidden;
            }
        </style>
    </head>
    <body
        class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] text-slate-800 relative custom-scrollbar flex flex-col h-screen"
    >
        {{-- BACKGROUND DEKORASI --}}
        <div
            class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none"
        >
            <div
                class="absolute top-[-10%] right-[-5%] w-[400px] h-[400px] bg-indigo-100/40 rounded-full blur-3xl opacity-50"
            ></div>
            <div
                class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] bg-purple-50/40 rounded-full blur-3xl opacity-50"
            ></div>
        </div>

        {{-- NAVBAR & VOICE STATUS --}}
        <header
            class="bg-white/90 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm w-full shrink-0"
        >
            <div
                class="max-w-7xl mx-auto flex items-center justify-between relative h-12"
            >
                {{-- Kiri: Tombol 0 (Kembali) --}}
                <div
                    class="flex items-center gap-4 relative z-10 w-1/3 justify-start shrink-0"
                >
                    <button
                        onclick="navigasiKe(0)"
                        class="flex w-11 h-11 md:w-12 md:h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white items-center justify-center transition-all duration-300 shadow-sm shrink-0 group border border-slate-200 hover:border-blue-600 relative cursor-pointer active:scale-95"
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
                            class="absolute -bottom-1 -right-1 bg-black text-white text-[9px] font-black px-1.5 py-0.5 rounded-md border border-white"
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
                </div>

                {{-- Tengah: Judul (Center Absolute) --}}
                <div
                    class="text-center absolute left-1/2 transform -translate-x-1/2 w-1/3 z-0 pointer-events-none flex flex-col items-center justify-center"
                >
                    <h1
                        class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight leading-none truncate pointer-events-auto"
                    >
                        Gabung Ujian
                    </h1>
                    <p
                        class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1 truncate pointer-events-auto"
                    >
                        Mahasiswa
                    </p>
                </div>

                {{-- Kanan: Indikator Voice --}}
                <div
                    class="flex items-center justify-end gap-3 relative z-10 w-1/3 shrink-0"
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
                        class="hidden sm:block text-[9px] font-black text-slate-400 uppercase tracking-widest w-20 text-left"
                        >SIAP</span
                    >
                </div>
            </div>
        </header>

        {{-- KONTEN UTAMA --}}
        <main
            class="flex-1 flex flex-col justify-center items-center p-4 md:p-6 pb-20 relative z-10 w-full overflow-y-auto"
        >
            <div
                class="w-full max-w-lg bg-white rounded-[3rem] p-8 md:p-12 shadow-2xl shadow-indigo-100/50 border border-slate-200 relative overflow-hidden text-center mt-4"
            >
                <div
                    class="absolute top-0 right-0 w-48 h-48 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-bl-[100%] -mr-10 -mt-10 -z-0"
                ></div>

                <div class="relative z-10">
                    <h1
                        class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight mb-2"
                    >
                        Punya Token Ujian?
                    </h1>
                    <p
                        class="text-slate-500 font-medium text-sm mb-10 leading-relaxed"
                    >
                        Masukkan token yang diberikan oleh dosen pengawas untuk
                        memulai ujian Anda.
                    </p>

                    <form
                        action="{{ route('exam.verify') }}"
                        method="POST"
                        id="join-form"
                    >
                        @csrf
                        <div
                            class="mb-8 relative group cursor-text"
                            onclick="navigasiKe(1)"
                        >
                            <label
                                class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2"
                                >Token Ujian (Sebutkan Langsung / 1)</label
                            >
                            <input
                                type="text"
                                id="token-input"
                                name="token"
                                placeholder="Contoh: X7Y-99"
                                class="w-full bg-slate-50 border-2 border-slate-200 rounded-2xl px-6 py-5 text-center text-2xl md:text-3xl font-black text-slate-800 tracking-[0.2em] focus:outline-none focus:border-indigo-500 focus:bg-white transition-all uppercase placeholder:tracking-normal placeholder:font-bold placeholder:text-slate-300 font-mono"
                                maxlength="10"
                            />
                            <div
                                class="absolute right-4 top-[42px] text-slate-300 group-hover:text-indigo-500 transition-colors pointer-events-none"
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
                                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V4.5a3 3 0 116 0v6a3 3 0 01-3 3z"
                                    />
                                </svg>
                            </div>
                        </div>

                        <button
                            type="button"
                            onclick="navigasiKe(2)"
                            class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all transform hover:-translate-y-1 flex justify-center items-center gap-3"
                        >
                            <span>Gabung Sekarang (2)</span>
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
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"
                                ></path>
                            </svg>
                        </button>
                    </form>

                    <div
                        class="bg-slate-50 rounded-2xl p-4 flex items-start gap-4 text-left border border-slate-100 mt-8"
                    >
                        <div
                            class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0 font-bold text-xs"
                        >
                            i
                        </div>
                        <p
                            class="text-[11px] md:text-xs text-slate-500 leading-relaxed"
                        >
                            <span class="font-bold text-slate-700">Tips:</span>
                            Pastikan token ujian sudah benar. Sebutkan token
                            Anda setelah asisten selesai bicara.
                        </p>
                    </div>
                </div>
            </div>
        </main>

        <script>
            const statusDesc = document.getElementById("status-desc");
            const waveBars = document.querySelectorAll(".wave-bar");
            const tokenInput = document.getElementById("token-input");
            const synth = window.speechSynthesis;
            const SpeechRec =
                window.webkitSpeechRecognition || window.SpeechRecognition;
            let rec = null;
            let interval;
            let isConfirming = false;

            if (SpeechRec) {
                rec = new SpeechRec();
                rec.lang = "id-ID";
                rec.continuous = true;
            }

            function setWave(active) {
                waveBars.forEach((bar) => {
                    bar.style.height = active
                        ? `${Math.floor(Math.random() * 12) + 4}px`
                        : "4px";
                });
            }

            function bicara(teks, callback) {
                synth.cancel();
                const utter = new SpeechSynthesisUtterance(teks);
                utter.lang = "id-ID";
                utter.rate =
                    parseFloat(localStorage.getItem("speechRate")) || 1.0;
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
                if (nomor === 0) {
                    bicara("Kembali ke daftar ujian.", () => {
                        window.location.href = "{{ route('exams') }}";
                    });
                } else if (nomor === 1) {
                    isConfirming = false;
                    tokenInput.value = "";
                    tokenInput.focus();
                    bicara(
                        "Silakan sebutkan token ujian Anda secara perlahan.",
                    );
                } else if (nomor === 2) {
                    const code = tokenInput.value.trim();
                    if (code.length < 3) {
                        isConfirming = false;
                        bicara(
                            "Token ujian kosong atau terlalu pendek. Silakan sebutkan ulang token Anda.",
                        );
                    } else {
                        bicara(
                            "Memproses token ujian. Masuk ke ruang ujian.",
                            () => {
                                document.getElementById("join-form").submit();
                            },
                        );
                    }
                }
            }

            function prosesEjaanToken(transcript) {
                let kode = transcript.replace(/\s+/g, "").toUpperCase();
                kode = kode.replace(/(NOL|SATU|DUA|KEMBALI|ULANG|GABUNG)/g, "");

                if (kode.length > 0) {
                    tokenInput.value = kode;
                    isConfirming = true;
                    let ejaan = kode.split("").join(" ");
                    bicara(
                        `Token yang terdeteksi adalah ${ejaan}. Sebut angka dua untuk gabung, atau satu untuk mengulang.`,
                    );
                } else {
                    bicara(
                        "Token tidak jelas. Silakan sebutkan ulang token Anda.",
                    );
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

                        if (
                            hasil.includes("nol") ||
                            hasil.includes("kembali")
                        ) {
                            rec.stop();
                            navigasiKe(0);
                            return;
                        }

                        if (isConfirming) {
                            if (
                                hasil.includes("dua") ||
                                hasil.includes("gabung")
                            ) {
                                rec.stop();
                                navigasiKe(2);
                            } else if (
                                hasil.includes("satu") ||
                                hasil.includes("ulang")
                            ) {
                                rec.stop();
                                navigasiKe(1);
                            }
                        } else {
                            if (hasil.includes("satu")) {
                                rec.stop();
                                navigasiKe(1);
                            } else if (hasil.includes("dua")) {
                                rec.stop();
                                navigasiKe(2);
                            } else {
                                rec.stop();
                                prosesEjaanToken(hasil);
                            }
                        }
                    };
                    rec.onend = () => {
                        rec.start();
                    };
                } catch (e) {}
            }

            window.onload = () => {
                const orientasi =
                    "Halaman Gabung Ujian. Silakan sebutkan token ujian Anda secara langsung. Ucapkan nol untuk kembali, satu untuk mengulang input, dan dua untuk bergabung.";
                setTimeout(() => {
                    bicara(orientasi, mulaiMendengar);
                }, 800);
            };
        </script>
    </body>
</html>
