<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Login | LMS Inklusi UMMI</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
            rel="stylesheet"
        />
    </head>
    <body
        class="m-0 p-4 font-['Plus_Jakarta_Sans'] bg-slate-50 min-h-full flex items-center justify-center overflow-x-hidden"
    >
        <div
            id="permission-overlay"
            class="fixed inset-0 z-[100] bg-blue-950/95 backdrop-blur-xl flex items-center justify-center p-6 text-center cursor-pointer transition-all duration-700"
        >
            <div class="pointer-events-none text-white max-w-sm text-center">
                <div
                    class="w-20 h-20 md:w-24 md:h-24 bg-white/10 rounded-[2.5rem] flex items-center justify-center mx-auto mb-8 animate-pulse border border-white/20"
                >
                    <svg
                        class="w-10 h-10 md:w-12 md:h-12"
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
                    class="text-2xl md:text-3xl font-black mb-4 uppercase italic tracking-tighter"
                >
                    Aktivasi Asisten Suara
                </h2>
                <p class="text-blue-200 text-base md:text-lg">
                    Ketuk di mana saja untuk memulai
                </p>
            </div>
        </div>

        <div
            class="w-full max-w-6xl bg-white rounded-[2rem] md:rounded-[3.5rem] shadow-2xl overflow-hidden border border-slate-100 grid grid-cols-1 lg:grid-cols-2 h-auto lg:h-[85vh] lg:max-h-[700px]"
        >
            <div
                class="hidden lg:block bg-cover bg-center shadow-inner"
                style="background-image: url('{{
                    asset('images/login.png')
                }}');"
            ></div>

            <div
                class="p-6 md:p-10 lg:p-6 flex flex-col justify-center bg-white items-center"
            >
                <div class="w-full max-w-md lg:max-w-[400px] mx-auto">
                    <div
                        id="voice-header"
                        class="mb-10 opacity-0 transition-opacity duration-500"
                    >
                        <div class="flex items-center gap-6 mb-4">
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
                            <div class="flex flex-col">
                                <span
                                    class="text-[8px] font-black text-blue-600 uppercase tracking-[0.3em]"
                                    >Status Sistem</span
                                >
                                <span
                                    id="status-desc"
                                    class="text-base font-bold text-slate-800 leading-none mt-1 italic uppercase"
                                    >Siap</span
                                >
                            </div>
                        </div>
                        <hr class="border-slate-100 w-full" />
                    </div>

                    <div class="mb-8">
                        <h2
                            class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tighter uppercase italic leading-none"
                        >
                            Masuk Akun
                        </h2>
                        <p
                            class="text-slate-400 text-[10px] font-bold mt-2 uppercase tracking-widest leading-loose"
                        >
                            Pusat Pembelajaran Disabilitas
                        </p>
                    </div>

                    <div class="space-y-4">
                        <div
                            id="field-nim"
                            class="p-4 rounded-2xl bg-slate-50 border-2 border-transparent transition-all duration-300"
                        >
                            <label
                                class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1"
                                >NIM Mahasiswa</label
                            >
                            <input
                                type="text"
                                id="input-nim"
                                readonly
                                class="w-full bg-transparent text-lg font-bold text-blue-900 outline-none"
                                placeholder="---"
                            />
                        </div>

                        <div
                            id="field-pass"
                            class="p-4 rounded-2xl bg-slate-50 border-2 border-transparent transition-all duration-300 opacity-20"
                        >
                            <label
                                class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1"
                                >Kata Sandi</label
                            >
                            <input
                            type="password"
                            id="input-pass"
                            readonly
                            autocomplete="off"
                            inputmode="none"
                            class="w-full bg-transparent text-lg font-bold text-blue-900 outline-none"
                        />

                        </div>

                        <div class="pt-4 space-y-3">
                            <button
                                class="w-full py-4 bg-blue-800 text-white rounded-xl font-black text-[10px] tracking-widest uppercase shadow-lg shadow-blue-100"
                            >
                                Login Sekarang
                            </button>
                            <button
                                class="w-full py-4 bg-white border border-slate-200 rounded-xl flex items-center justify-center gap-3"
                            >
                                <img
                                    src="{{ asset('images/gogle.svg') }}"
                                    class="w-4 h-4"
                                    alt="Google"
                                />
                                <span
                                    class="text-[9px] font-black text-slate-600 tracking-widest uppercase italic"
                                    >Login with Google</span
                                >
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const overlay = document.getElementById("permission-overlay");
            const voiceHeader = document.getElementById("voice-header");
            const statusDesc = document.getElementById("status-desc");
            const waveBars = document.querySelectorAll(".wave-bar");
            const inputNim = document.getElementById("input-nim");
            const inputPass = document.getElementById("input-pass");

            const synth = window.speechSynthesis;
            const SpeechRec =
                window.webkitSpeechRecognition || window.SpeechRecognition;
            const rec = new SpeechRec();
            rec.lang = "id-ID";

            // const dataMahasiswa = { 202601: "sandi123", 202602: "ummi2026" };

            let waveInterval;
            function setWave(active) {
                if (active) {
                    waveInterval = setInterval(() => {
                        waveBars.forEach((bar) => {
                            // Animasi naik-turun dari tengah (Mirip referensi gambar)
                            const h = Math.floor(Math.random() * 40) + 4;
                            bar.style.height = `${h}px`;
                        });
                    }, 100);
                } else {
                    clearInterval(waveInterval);
                    waveBars.forEach((bar) => (bar.style.height = "4px"));
                }
            }

            function bicara(teks, callback) {
                const utter = new SpeechSynthesisUtterance(teks);
                utter.lang = "id-ID";
                utter.onstart = () => {
                    voiceHeader.classList.remove("opacity-0");
                    statusDesc.innerText = "SISTEM BERBICARA";
                    setWave(true);
                };
                utter.onend = () => {
                    setWave(false);
                    if (callback) callback();
                };
                synth.speak(utter);
            }

            function dengar(onResult) {
    statusDesc.innerText = "MENDENGARKAN...";
    setWave(true);

    try {
        rec.abort(); // ⬅️ HENTIKAN SESI SEBELUMNYA (INI KUNCINYA)
    } catch (e) {}

    rec.start();

    rec.onresult = (e) => {
        setWave(false);
        rec.stop();
        onResult(e.results[0][0].transcript);
    };

    rec.onerror = () => {
        setWave(false);
        rec.stop();
        setTimeout(() => dengar(onResult), 500);
    };
}


            overlay.addEventListener("click", () => {
                overlay.classList.add("opacity-0");
                setTimeout(() => {
                    overlay.classList.add("hidden");
                    startFlow();
                }, 700);
            });

            function startFlow() {
                const fNim = document.getElementById("field-nim");
                fNim.classList.add("border-blue-600", "bg-white", "shadow-md");

                bicara("Selamat datang. Sebutkan NIM anda.", () => {
                    dengar((hasil) => {
                        const nimFix = hasil.replace(/[^0-9]/g, "");
                        inputNim.value = nimFix;
                        bicara(
                            `NIM anda adalah ${nimFix.split("").join(" ")}. Apakah sudah benar?`,
                            () => {
                                dengar((konf) => {
                                    if (
                                        konf.toLowerCase().includes("benar") ||
                                        konf.toLowerCase().includes("ya")
                                    ) {
                                        flowPassword();
                                    } else {
                                        inputNim.value = "";
                                        bicara("Mari ulangi NIM.", startFlow);
                                    }
                                });
                            },
                        );
                    });
                });
            }

             function kataKeAngka(teks) {
    if (!teks) return "";

    const map = {
        "nol": "0",
        "kosong": "0",
        "satu": "1",
        "dua": "2",
        "tiga": "3",
        "empat": "4",
        "lima": "5",
        "enam": "6",
        "tujuh": "7",
        "delapan": "8",
        "sembilan": "9"
    };

    // 1️⃣ Normalisasi
    let hasil = teks.toLowerCase();

    // 2️⃣ Ambil angka langsung (kalau user bilang "1 2 3" atau "123")
    const angkaLangsung = hasil.match(/\d+/g);
    if (angkaLangsung) {
        return angkaLangsung.join("");
    }

    // 3️⃣ Konversi kata → angka
    return hasil
        .replace(/[^a-z\s]/g, " ")
        .split(/\s+/)
        .map(k => map[k] || "")
        .join("");
}

           function flowPassword() {
    const fNim = document.getElementById("field-nim");
    const fPass = document.getElementById("field-pass");

    fNim.classList.remove("border-blue-600", "bg-white", "shadow-md");
    fPass.classList.remove("opacity-20");
    fPass.classList.add("border-blue-600", "bg-white", "shadow-md");

    bicara("Sebutkan kata sandi anda.", () => {
        dengar((hasil) => {

            // 🔑 KONVERSI KATA → ANGKA
            const passFix = kataKeAngka(hasil);

            // ❌ JIKA TIDAK TERBACA
            if (!passFix || passFix.length === 0) {
                inputPass.value = "";
                bicara(
                    "Kata sandi tidak terbaca. Silakan sebutkan ulang satu per satu.",
                    flowPassword
                );
                return;
            }

            // ✅ SIMPAN PASSWORD
            inputPass.value = passFix;

            const passSpoken = passFix.split("").join(" ");

            bicara(
                `Kata sandi anda adalah ${passSpoken}. Apakah sudah benar?`,
                () => {
                    dengar((konf) => {
                        const jawab = konf.toLowerCase();

                        if (jawab.includes("benar") || jawab.includes("ya")) {
                            validasiAkhir();
                        } else {
                            inputPass.value = "";
                            bicara("Mari ulangi kata sandi.", flowPassword);
                        }
                    });
                }
            );
        });
    });
}


            function validasiAkhir() {
    const nim = inputNim.value;
    const pass = inputPass.value;

    bicara("Sedang memeriksa data anda.", () => {
        fetch("{{ route('login.mahasiswa.post') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                nim: nim,
                password: pass
            })
        })
        .then(async res => {
    let data = {};
    try {
        data = await res.json();
    } catch (e) {}

    if (res.ok && data.success) {
        bicara("Akses diterima. Membuka dashboard mahasiswa.", () => {
            window.location.href = data.redirect;
        });
    } else {
        bicara(
            data.message || "Login gagal. Silakan ulangi kata sandi.",
            () => {
                inputPass.value = "";
                flowPassword();
            }
        );
    }
})


        .catch(() => {
            bicara("Terjadi kesalahan sistem. Silakan coba kembali.");
        });
    });
}

        </script>
    </body>
</html>
