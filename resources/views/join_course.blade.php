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

        <main class="flex-1 flex flex-col h-screen overflow-y-auto">
            <div
                class="bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-30 px-6 py-4"
            >
                <div
                    class="max-w-6xl mx-auto flex items-center justify-between"
                >
                    <div class="flex items-center gap-4">
                        <button
                            onclick="navigasiKe(4)"
                            class="w-10 h-10 rounded-full bg-slate-50 hover:bg-blue-50 text-slate-400 hover:text-blue-600 flex items-center justify-center transition-all border border-slate-200 shrink-0"
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
                                    stroke-width="2.5"
                                    d="M15 19l-7-7 7-7"
                                ></path>
                            </svg>
                        </button>
                    </div>

                    <div
                        class="text-center absolute left-1/2 transform -translate-x-1/2"
                    >
                        <h1
                            class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight leading-none"
                        >
                            Gabung Kelas Baru
                        </h1>
                        <p
                            class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1"
                        >
                            Mahasiswa
                        </p>
                    </div>

                    <div
                        class="flex items-center gap-3 pl-6 border-l border-slate-200"
                    >
                        <div
                            id="wave-container"
                            class="flex items-center gap-[2px] h-4 w-10 justify-center"
                        >
                            <div
                                class="wave-bar w-[2px] bg-blue-500 rounded-full h-1"
                            ></div>
                            <div
                                class="wave-bar w-[2px] bg-blue-400 rounded-full h-1"
                            ></div>
                            <div
                                class="wave-bar w-[2px] bg-blue-600 rounded-full h-1"
                            ></div>
                        </div>
                        <span
                            id="status-desc"
                            class="hidden md:block text-[9px] font-black text-slate-400 uppercase tracking-widest"
                            >Listening</span
                        >
                    </div>
                </div>
            </div>

            <div
                class="max-w-4xl mx-auto w-full p-6 flex flex-col items-center justify-center min-h-[80vh]"
            >
                <div
                    class="bg-white rounded-[3rem] shadow-xl shadow-slate-100 border border-slate-200 p-8 md:p-12 w-full relative overflow-hidden"
                >
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-bl-[100%] -mr-10 -mt-10 -z-0"
                    ></div>

                    <div class="relative z-10 text-center space-y-8">
                        <div
                            class="flex items-center justify-center mx-auto shadow-inner mb-6"
                        ></div>

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
                            action="#"
                            method="POST"
                            class="max-w-md mx-auto space-y-6"
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
                                type="button"
                                onclick="navigasiKe(2)"
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
            const rec = new SpeechRec();
            rec.lang = "id-ID";
            rec.continuous = true;

            function setWave(active) {
                waveBars.forEach((bar) => {
                    bar.style.height = active
                        ? `${Math.floor(Math.random() * 12) + 4}px`
                        : "4px";
                });
            }

            let interval;
            function bicara(teks, callback) {
                synth.cancel();
                const utter = new SpeechSynthesisUtterance(teks);
                utter.lang = "id-ID";
                utter.onstart = () => {
                    if (statusDesc) statusDesc.innerText = "Speaking";
                    interval = setInterval(() => setWave(true), 150);
                };
                utter.onend = () => {
                    if (statusDesc) statusDesc.innerText = "Listening";
                    clearInterval(interval);
                    setWave(false);
                    if (callback) callback();
                };
                synth.speak(utter);
            }

            function navigasiKe(nomor) {
                let tujuan = "";
                let teks = "";

                if (nomor === 4) {
                    tujuan = "{{ route('dashboard') }}";
                    teks = "Kembali ke Beranda.";
                } else if (nomor === 1) {
                    // Fokus ke Input
                    document.getElementById("class-code").focus();
                    teks = "Silahkan ketik kode kelas.";
                } else if (nomor === 2) {
                    // Submit Form (Simulasi)
                    const code = document.getElementById("class-code").value;
                    if (code.length < 3) {
                        teks = "Kode kelas terlalu pendek.";
                    } else {
                        teks = "Memproses kode kelas " + code;
                        // Disini nanti form.submit() yang asli
                        setTimeout(
                            () => alert("Berhasil bergabung ke kelas!"),
                            2000,
                        );
                    }
                }

                if (teks !== "") {
                    bicara(teks);
                    if (tujuan !== "") {
                        setTimeout(() => {
                            window.location.href = tujuan;
                        }, 1500);
                    }
                }
            }

            function mulaiMendengar() {
                try {
                    rec.start();
                    rec.onresult = (event) => {
                        const hasil =
                            event.results[
                                event.results.length - 1
                            ][0].transcript.toLowerCase();
                        const angka = hasil.match(/\d+/);

                        if (angka) {
                            navigasiKe(parseInt(angka[0]));
                        } else if (
                            hasil.includes("satu") ||
                            hasil.includes("kode")
                        ) {
                            navigasiKe(1);
                        } else if (
                            hasil.includes("dua") ||
                            hasil.includes("gabung")
                        ) {
                            navigasiKe(2);
                        } else if (
                            hasil.includes("empat") ||
                            hasil.includes("kembali")
                        ) {
                            navigasiKe(4);
                        }
                    };
                } catch (e) {}
            }

            window.onload = () => {
                const orientasi =
                    "Halaman Gabung Kelas. Sebutkan Satu untuk isi kode, Dua untuk gabung, atau Empat untuk kembali.";

                setTimeout(() => {
                    bicara(orientasi, () => {
                        mulaiMendengar();
                    });
                }, 1000);
            };
        </script>
    </body>
</html>
