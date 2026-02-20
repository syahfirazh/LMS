<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Pengaturan Aksesibilitas | LMS Inklusi UMMI</title>

        <link
            href="https://unpkg.com/aos@2.3.1/dist/aos.css"
            rel="stylesheet"
        />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap"
            rel="stylesheet"
        />
        <style>
            input[type="range"]::-webkit-slider-thumb {
                -webkit-appearance: none;
                appearance: none;
                width: 28px;
                height: 28px;
                border-radius: 50%;
                background: #2563eb;
                cursor: pointer;
                box-shadow: 0 0 10px rgba(37, 99, 235, 0.5);
                transition: transform 0.2s;
            }
            input[type="range"]::-webkit-slider-thumb:hover {
                transform: scale(1.15);
            }
            .wave-bar {
                transition: height 0.1s ease;
            }
        </style>
    </head>
    <body
        class="font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-screen flex flex-col items-center justify-center p-6 text-slate-800 relative overflow-hidden"
    >
        <div
            id="permission-overlay"
            class="fixed inset-0 z-[100] bg-blue-950/95 backdrop-blur-xl flex flex-col items-center justify-center p-6 text-center cursor-pointer transition-opacity duration-700"
        >
            <div
                class="w-24 h-24 bg-white/10 rounded-[2.5rem] flex items-center justify-center mb-8 animate-pulse border border-white/20 text-white"
            >
                <svg
                    class="w-12 h-12"
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
            </div>
            <h2
                class="text-3xl font-black mb-4 uppercase tracking-tighter text-white animate-bounce"
            >
                Aktivasi Asisten Suara
            </h2>
            <p class="text-blue-200 text-lg">
                Ketuk layar di mana saja untuk memulai pengaturan
            </p>
        </div>

        <div
            class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"
        ></div>
        <div
            class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"
        ></div>

        <div
            id="main-card"
            class="hidden w-full max-w-lg bg-white/90 backdrop-blur-2xl rounded-[2.5rem] shadow-2xl border border-white/50 p-8 sm:p-12 relative z-10 flex-col items-center text-center"
        >
            <div
                data-aos="fade-down"
                data-aos-duration="800"
                id="voice-header"
                class="w-full mb-8"
            >
                <div
                    class="flex flex-row items-center justify-center gap-6 mb-4"
                >
                    <div
                        id="wave-container"
                        class="flex items-center gap-[2px] h-12"
                    >
                        <div
                            class="wave-bar w-[3px] bg-blue-500 rounded-full transition-all duration-150 h-1"
                        ></div>
                        <div
                            class="wave-bar w-[3px] bg-blue-400 rounded-full transition-all duration-150 h-1"
                        ></div>
                        <div
                            class="wave-bar w-[3px] bg-blue-600 rounded-full transition-all duration-150 h-1"
                        ></div>
                        <div
                            class="wave-bar w-[3px] bg-blue-400 rounded-full transition-all duration-150 h-1"
                        ></div>
                        <div
                            class="wave-bar w-[3px] bg-blue-500 rounded-full transition-all duration-150 h-1"
                        ></div>
                        <div
                            class="wave-bar w-[3px] bg-blue-600 rounded-full transition-all duration-150 h-1"
                        ></div>
                        <div
                            class="wave-bar w-[3px] bg-blue-400 rounded-full transition-all duration-150 h-1"
                        ></div>
                        <div
                            class="wave-bar w-[3px] bg-blue-500 rounded-full transition-all duration-150 h-1"
                        ></div>
                        <div
                            class="wave-bar w-[3px] bg-blue-600 rounded-full transition-all duration-150 h-1"
                        ></div>
                        <div
                            class="wave-bar w-[3px] bg-blue-400 rounded-full transition-all duration-150 h-1"
                        ></div>
                    </div>
                    <div class="flex flex-col text-left">
                        <span
                            class="text-[8px] font-black text-blue-600 uppercase tracking-[0.3em]"
                            >Status Sistem</span
                        >
                        <span
                            id="status-desc"
                            class="text-base font-bold text-slate-800 leading-none mt-1 uppercase"
                            >Menunggu</span
                        >
                    </div>
                </div>
                <hr class="border-slate-100 w-full" />
            </div>

            <h1
                data-aos="fade-up"
                data-aos-delay="300"
                class="text-3xl font-black text-slate-900 tracking-tight mb-2"
            >
                Atur Suara
            </h1>
            <p
                data-aos="fade-up"
                data-aos-delay="400"
                id="instruction-text"
                class="text-slate-500 font-medium mb-8 text-sm leading-relaxed"
            >
                Sebutkan atau geser angka
                <strong class="text-blue-600">1 sampai 100</strong> untuk
                mengatur kecepatan asisten suara.
            </p>

            <div
                data-aos="fade-up"
                data-aos-delay="500"
                class="bg-slate-50 p-6 rounded-3xl border border-slate-200 mb-8 w-full text-left"
            >
                <div class="flex justify-between items-end mb-4">
                    <label
                        class="text-sm font-bold text-slate-700 uppercase tracking-widest"
                        >Tingkat Kecepatan</label
                    >
                    <span
                        id="speedValue"
                        class="text-3xl font-black text-blue-600"
                        >50</span
                    >
                </div>

                <div class="relative w-full">
                    <input
                        type="range"
                        id="speedSlider"
                        min="1"
                        max="100"
                        value="50"
                        class="w-full h-3 bg-slate-200 rounded-lg appearance-none outline-none cursor-pointer focus:ring-2 focus:ring-blue-200"
                    />
                </div>

                <div
                    class="flex justify-between mt-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest"
                >
                    <span>1 (Lambat)</span>
                    <span>100 (Cepat)</span>
                </div>
            </div>

            <button
                data-aos="zoom-in"
                data-aos-delay="600"
                onclick="simpanDanLanjut()"
                class="w-full py-4 bg-blue-600 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-xl hover:-translate-y-0.5 transition-all cursor-pointer"
            >
                Lanjut Manual
            </button>
        </div>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

        <script>
            const slider = document.getElementById("speedSlider");
            const display = document.getElementById("speedValue");
            const instructionText = document.getElementById("instruction-text");

            // Voice & Mic Elements
            const statusDesc = document.getElementById("status-desc");
            const waveBars = document.querySelectorAll(".wave-bar");
            const synth = window.speechSynthesis;
            const SpeechRec =
                window.webkitSpeechRecognition || window.SpeechRecognition;
            let rec = null;
            let isRecActive = false;
            let currentStep = 1;

            if (SpeechRec) {
                rec = new SpeechRec();
                rec.lang = "id-ID";
                rec.continuous = true;
                rec.interimResults = false;
            }

            // --- ANIMASI WAVE ---
            let waveInterval;
            function setWave(active) {
                if (active) {
                    waveInterval = setInterval(() => {
                        waveBars.forEach((bar) => {
                            const h = Math.floor(Math.random() * 40) + 4;
                            bar.style.height = `${h}px`;
                        });
                    }, 100);
                } else {
                    clearInterval(waveInterval);
                    waveBars.forEach((bar) => (bar.style.height = "4px"));
                }
            }

            function hitungRate(val) {
                return 0.5 + (val - 1) * (1.5 / 99);
            }

            // --- EVENT SLIDER ---
            slider.addEventListener("input", function () {
                display.innerText = this.value;
            });

            slider.addEventListener("change", function () {
                const newRate = hitungRate(parseInt(this.value));
                currentStep = 2;
                instructionText.innerHTML =
                    "Sebutkan <strong class='text-blue-600'>Satu</strong> untuk Lanjut, atau <strong class='text-red-600'>Dua</strong> untuk Ulang.";

                bicara(
                    "Kecepatan diatur ke " +
                        this.value +
                        ". Sebutkan satu untuk lanjut, atau dua untuk ulang.",
                    newRate,
                    () => {
                        mulaiMendengar();
                    },
                );
            });

            // --- FUNGSI BICARA / TTS ---
            function bicara(teks, rateValue = null, callback = null) {
                synth.cancel();

                const utter = new SpeechSynthesisUtterance(teks);
                utter.lang = "id-ID";
                utter.rate = rateValue !== null ? rateValue : 1.0;

                utter.onstart = () => {
                    if (statusDesc) {
                        statusDesc.innerText = "SISTEM BERBICARA";
                        statusDesc.classList.replace(
                            "text-red-500",
                            "text-blue-600",
                        );
                        statusDesc.classList.replace(
                            "text-slate-800",
                            "text-blue-600",
                        );
                    }
                    if (isRecActive && rec) {
                        rec.stop();
                        isRecActive = false;
                    }
                    setWave(true);
                };

                utter.onend = () => {
                    setWave(false);
                    if (callback) callback();
                };

                synth.speak(utter);
            }

            // --- FUNGSI MENDENGARKAN (STT) ---
            function mulaiMendengar() {
                if (!rec) return;
                try {
                    if (statusDesc) {
                        statusDesc.innerText = "MENDENGARKAN";
                        statusDesc.classList.replace(
                            "text-black",
                            "text-black",
                        );
                        statusDesc.classList.replace(
                            "text-black",
                            "text-black",
                        );
                    }
                    rec.start();
                    isRecActive = true;

                    rec.onresult = (event) => {
                        const hasil = event.results[
                            event.results.length - 1
                        ][0].transcript
                            .toLowerCase()
                            .trim();
                        prosesJawaban(hasil);
                    };

                    rec.onend = () => {
                        if (isRecActive) rec.start();
                    };
                } catch (e) {
                    console.error(e);
                }
            }

            // --- LOGIKA PERCAKAPAN ---
            function prosesJawaban(hasil) {
                const kataKeAngka = {
                    satu: 1,
                    dua: 2,
                    tiga: 3,
                    empat: 4,
                    lima: 5,
                    enam: 6,
                    tujuh: 7,
                    delapan: 8,
                    sembilan: 9,
                    sepuluh: 10,
                    seratus: 100,
                };

                let angkaDeteksi = hasil.match(/\d+/);
                let nilaiAngka = angkaDeteksi
                    ? parseInt(angkaDeteksi[0])
                    : null;

                if (!nilaiAngka) {
                    for (let kata in kataKeAngka) {
                        if (hasil.includes(kata)) {
                            nilaiAngka = kataKeAngka[kata];
                            break;
                        }
                    }
                }

                if (currentStep === 1) {
                    if (
                        nilaiAngka !== null &&
                        nilaiAngka >= 1 &&
                        nilaiAngka <= 100
                    ) {
                        slider.value = nilaiAngka;
                        display.innerText = nilaiAngka;
                        const newRate = hitungRate(nilaiAngka);

                        instructionText.innerHTML =
                            "Sebutkan <strong class='text-blue-600'>Satu</strong> untuk Lanjut, atau <strong class='text-red-600'>Dua</strong> untuk Ulang.";
                        currentStep = 2;

                        const teksKonfirmasi =
                            "Kecepatan diatur ke " +
                            nilaiAngka +
                            ". Ini adalah contoh kecepatan suara Anda. Sebutkan SATU untuk melanjutkan ke halaman login, atau sebutkan DUA untuk mengatur ulang kecepatan.";
                        bicara(teksKonfirmasi, newRate, () => {
                            mulaiMendengar();
                        });
                    } else {
                        bicara(
                            "Maaf, sebutkan angka dari satu sampai seratus.",
                            1.0,
                            () => mulaiMendengar(),
                        );
                    }
                } else if (currentStep === 2) {
                    if (
                        nilaiAngka === 1 ||
                        hasil.includes("lanjut") ||
                        hasil.includes("satu")
                    ) {
                        bicara(
                            "Pengaturan disimpan. Mengalihkan ke halaman login.",
                            hitungRate(parseInt(slider.value)),
                            () => {
                                simpanDanLanjut();
                            },
                        );
                    } else if (
                        nilaiAngka === 2 ||
                        hasil.includes("ulang") ||
                        hasil.includes("dua")
                    ) {
                        currentStep = 1;
                        slider.value = 50;
                        display.innerText = "50";
                        instructionText.innerHTML =
                            "Sebutkan angka <strong class='text-blue-600'>1 sampai 100</strong> untuk mengatur kecepatan asisten suara.";
                        bicara(
                            "Silakan sebutkan kembali angka kecepatan dari satu sampai seratus.",
                            1.0,
                            () => mulaiMendengar(),
                        );
                    } else {
                        bicara(
                            "Maaf, sebutkan SATU untuk lanjut, atau DUA untuk mengulang.",
                            hitungRate(parseInt(slider.value)),
                            () => mulaiMendengar(),
                        );
                    }
                }
            }

            function simpanDanLanjut() {
                synth.cancel();
                const finalRate = hitungRate(parseInt(slider.value));
                localStorage.setItem("speechRate", finalRate);
                localStorage.setItem("speechSpeedDisplay", slider.value);
                window.location.href = "{{ route('login') }}";
            }

            // --- KUNCI ANIMASI MUNCUL: OVERLAY KLIK ---
            const overlay = document.getElementById("permission-overlay");
            const mainCard = document.getElementById("main-card");

            overlay.addEventListener("click", () => {
                overlay.classList.add("opacity-0", "pointer-events-none");

                // Tunggu hilangnya layar biru
                setTimeout(() => {
                    overlay.classList.add("hidden");

                    // 1. Tampilkan kotak utama
                    mainCard.classList.remove("hidden");
                    mainCard.classList.add("flex");

                    // 2. JALANKAN INISIALISASI AOS SEKARANG
                    AOS.init({ once: true, easing: "ease-out-cubic" });

                    // 3. Suara menyapa masuk setelah animasi
                    setTimeout(() => {
                        const introText =
                            "Selamat datang di LMS Inklusi UMMI. Silakan sebutkan angka dari satu sampai seratus untuk mengatur kecepatan suara.";
                        bicara(introText, 1.0, () => {
                            mulaiMendengar();
                        });
                    }, 1200);
                }, 700);
            });
        </script>
    </body>
</html>
