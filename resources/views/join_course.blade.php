<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Gabung Kelas | LMS Inklusi UMMI</title>
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
        class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-full flex flex-col border-box overflow-x-hidden text-slate-800"
    >
        <div
            class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none"
        >
            <div
                class="absolute top-[-10%] right-[-5%] w-[400px] h-[400px] bg-emerald-100/40 rounded-full blur-3xl opacity-50"
            ></div>
            <div
                class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] bg-blue-50/40 rounded-full blur-3xl opacity-50"
            ></div>
        </div>

        <main
            class="flex-1 flex flex-col h-screen overflow-y-auto custom-scrollbar relative"
        >
            {{-- NAVBAR SEPERTI DAFTAR MATA KULIAH --}}
            <div
                class="bg-white/90 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm transition-all w-full"
            >
                <div
                    class="max-w-7xl mx-auto flex items-center justify-between relative"
                >
                    <div
                        class="flex items-center gap-4 relative z-10 md:w-auto w-full justify-start"
                    >
                        <button
                            onclick="navigasiKe(0)"
                            class="w-11 h-11 md:w-12 md:h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm shrink-0 group border border-slate-200 hover:border-blue-600 relative cursor-pointer"
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
                            class="hidden sm:block text-left cursor-pointer group"
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

                    <div
                        class="text-center absolute left-1/2 transform -translate-x-1/2 w-full max-w-[60%] md:max-w-md mt-2 md:mt-0"
                    >
                        <h1
                            class="text-lg md:text-2xl font-black text-slate-900 tracking-tight leading-tight truncate"
                        >
                            Gabung Kelas Baru
                        </h1>
                        <div
                            class="flex items-center justify-center gap-2 mt-1"
                        >
                            <span
                                class="text-[9px] md:text-[10px] font-bold text-blue-600 uppercase tracking-widest bg-blue-100 px-2 py-0.5 rounded-md"
                            >
                                Mahasiswa
                            </span>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-3 pl-6 border-l border-slate-200 relative z-10 justify-end"
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
                            class="hidden md:block text-[9px] font-black text-slate-400 uppercase tracking-widest"
                            >Siap</span
                        >
                    </div>
                </div>
            </div>

            {{-- KONTEN UTAMA --}}
            <div
                class="max-w-4xl mx-auto w-full p-6 flex flex-col items-center justify-center min-h-[80vh] pb-20"
            >
                <div
                    class="bg-white rounded-[3rem] shadow-xl shadow-slate-100 border border-slate-200 p-8 md:p-12 w-full relative overflow-hidden"
                >
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-bl-[100%] -mr-10 -mt-10 -z-0"
                    ></div>

                    <div class="relative z-10 text-center space-y-8">
                        <div class="space-y-2">
                            <h2
                                class="text-3xl font-black text-slate-900 tracking-tight"
                            >
                                Punya Kode Kelas?
                            </h2>
                            <p class="text-slate-500 font-medium">
                                Masukkan kode yang diberikan dosen untuk
                                bergabung.
                            </p>
                        </div>

                        <form
                            action="{{ route('mahasiswa.join.kelas') }}"
                            method="POST"
                            class="max-w-md mx-auto space-y-6"
                            id="join-form"
                        >
                            @csrf
                            <div
                                onclick="navigasiKe(1)"
                                class="group cursor-text"
                            >
                                <label
                                    class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3"
                                    >Kode Akses (1)</label
                                >
                                <input
                                    type="text"
                                    id="class-code"
                                    name="code"
                                    placeholder="Contoh: X7Y-99"
                                    class="w-full text-center text-3xl font-black uppercase tracking-[0.2em] py-5 border-b-4 border-slate-200 bg-transparent text-slate-800 placeholder-slate-300 focus:outline-none focus:border-emerald-500 transition-all font-mono"
                                    maxlength="8"
                                />
                            </div>

                            <button
                                type="submit"
                                onclick="
                                    navigasiKe(2);
                                    return false;
                                "
                                class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold text-sm uppercase tracking-widest hover:bg-emerald-600 hover:shadow-lg hover:shadow-emerald-200 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3"
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
                                class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 font-bold text-xs"
                            >
                                i
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                <span class="font-bold text-slate-700"
                                    >Tips:</span
                                >
                                Pastikan kode kelas yang dimasukkan sudah benar
                                (6-8 karakter). Jika bermasalah, hubungi dosen
                                yang bersangkutan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script>
            const statusDesc = document.getElementById("status-desc");
            const waveBars = document.querySelectorAll(".wave-bar");
            const synth = window.speechSynthesis;
            const SpeechRec =
                window.webkitSpeechRecognition || window.SpeechRecognition;
            let rec = null;
            let interval;

            // Variabel untuk melacak status konfirmasi
            let isConfirming = false;

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
                    tujuan = "{{ route('dashboard') }}";
                    teks = "Kembali ke Beranda.";
                } else if (nomor === 1) {
                    // Reset input & status konfirmasi
                    isConfirming = false;
                    document.getElementById("class-code").value = "";
                    document.getElementById("class-code").focus();
                    teks = "Silakan sebutkan ulang kode kelas Anda.";
                } else if (nomor === 2) {
                    const code = document
                        .getElementById("class-code")
                        .value.trim();
                    if (code.length < 3) {
                        isConfirming = false;
                        teks =
                            "Kode kelas kosong atau terlalu pendek. Silakan sebutkan ulang kode kelas Anda.";
                    } else {
                        teks = "Memproses kode kelas. Mohon tunggu.";
                        bicara(teks, () => {
                            document.getElementById("join-form").submit();
                        });
                        return;
                    }
                }

                if (teks !== "") {
                    bicara(teks, () => {
                        if (tujuan !== "") {
                            setTimeout(() => {
                                window.location.href = tujuan;
                            }, 1000);
                        } else {
                            if (rec) rec.start();
                        }
                    });
                }
            }

            function prosesKode(transcript) {
                // Hilangkan spasi dan jadikan kapital semua
                let kode = transcript.replace(/\s+/g, "").toUpperCase();

                // Hapus kata-kata perintah navigasi jika tidak sengaja terbawa
                kode = kode.replace(/(SATU|DUA|NOL|KEMBALI|GABUNG|ULANG)/g, "");

                if (kode.length > 0) {
                    // Masukkan ke input teks
                    document.getElementById("class-code").value = kode;
                    isConfirming = true; // Set mode konfirmasi aktif

                    // Buat ejaan dengan spasi agar diucapkan pelan dan jelas oleh sistem
                    let ejaan = kode.split("").join(" ");

                    let teksConfirm = `Kode yang Anda sebutkan adalah, ${ejaan}. Sebut dua untuk gabung, atau sebut satu untuk mengulang.`;

                    bicara(teksConfirm, () => {
                        rec.start();
                    });
                } else {
                    bicara(
                        "Suara tidak terdengar jelas. Silakan sebutkan ulang kode kelas Anda.",
                        () => {
                            rec.start();
                        },
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

                        // JIKA SEDANG DALAM MODE KONFIRMASI (Sistem nunggu jawaban 1 atau 2)
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
                            } else if (
                                hasil.includes("nol") ||
                                hasil.includes("kembali")
                            ) {
                                rec.stop();
                                navigasiKe(0);
                            } else {
                                rec.stop();
                                bicara(
                                    "Maaf, perintah tidak dikenali. Sebut dua untuk gabung, atau satu untuk mengulang.",
                                    () => {
                                        rec.start();
                                    },
                                );
                            }
                        }
                        // JIKA SEDANG MODE MENDENGARKAN KODE (Awal)
                        else {
                            if (
                                hasil === "nol" ||
                                hasil === "kembali" ||
                                hasil === "beranda"
                            ) {
                                rec.stop();
                                navigasiKe(0);
                            } else if (hasil === "satu" || hasil === "ulang") {
                                rec.stop();
                                navigasiKe(1);
                            } else if (hasil === "dua" || hasil === "gabung") {
                                rec.stop();
                                navigasiKe(2);
                            } else {
                                // Asumsikan yang diucapkan adalah kode kelas
                                rec.stop();
                                prosesKode(hasil);
                            }
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
                    "Halaman Gabung Kelas. Silakan sebutkan kode kelas Anda secara perlahan. Atau sebutkan nol untuk kembali.";

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
