<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Persiapan Ujian | LMS Inklusi UMMI</title>
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
            }

            @keyframes wave-bounce {
                0%,
                100% {
                    height: 4px;
                }
                50% {
                    height: 16px;
                }
            }
            .wave-bar {
                transition: height 0.1s ease;
            }
        </style>
    </head>
    <body
        class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] text-slate-800 relative custom-scrollbar"
    >
        @php $mulai = \Carbon\Carbon::parse($exam->waktu_mulai); $selesai =
        \Carbon\Carbon::parse($exam->waktu_selesai); $durasiMenit =
        $mulai->diffInMinutes($selesai); $jumlahSoal = $exam->questions ?
        $exam->questions->count() : 0; $namaDosen = $exam->kelas->dosen->nama ??
        $exam->dosen->nama ?? 'Dosen Pengampu'; @endphp

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

        <div
            class="bg-white/90 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm w-full"
        >
            <div
                class="max-w-7xl mx-auto flex items-center justify-between relative h-12"
            >
                <div
                    class="flex items-center gap-4 relative z-10 w-1/3 justify-start shrink-0"
                >
                    <a
                        href="{{ route('exams') }}"
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
                    </a>
                    <a
                        href="{{ route('exams') }}"
                        class="hidden md:block text-left cursor-pointer group shrink-0 decoration-transparent"
                    >
                        <span
                            class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest"
                            >Navigasi Suara</span
                        >
                        <span
                            class="block text-xs font-black text-slate-700 group-hover:text-blue-600 transition-colors"
                            >0 - Kembali</span
                        >
                    </a>
                </div>

                <div
                    class="text-center absolute left-1/2 transform -translate-x-1/2 w-1/3 z-0 pointer-events-none"
                >
                    <h1
                        class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight leading-none truncate pointer-events-auto"
                    >
                        Persiapan Ujian
                    </h1>
                    <p
                        class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1 truncate pointer-events-auto"
                    >
                        Konfirmasi Data
                    </p>
                </div>

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
                        class="hidden md:block text-[9px] font-black text-slate-400 uppercase tracking-widest w-20 text-left"
                        >SIAP</span
                    >
                </div>
            </div>
        </div>

        <main
            class="flex-1 w-full max-w-4xl mx-auto p-4 md:p-6 lg:p-8 space-y-6 pb-12 mt-4 relative z-10"
        >
            <div
                class="bg-blue-600 rounded-[2.5rem] p-8 md:p-10 text-white shadow-xl shadow-blue-200/50 relative overflow-hidden flex flex-col items-center text-center text-balance"
            >
                <div class="relative z-10">
                    <span
                        class="inline-block px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-xl text-[10px] font-black uppercase tracking-widest mb-4 border border-white/20 shadow-sm"
                    >
                        {{ $exam->kategori ?? 'Ujian' }}
                    </span>
                    <h2
                        class="text-3xl md:text-4xl font-black tracking-tight mb-3 leading-tight"
                    >
                        {{ $exam->judul }}
                    </h2>
                    <p
                        class="text-blue-200 font-medium text-sm md:text-base flex items-center justify-center gap-2"
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
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                            ></path>
                        </svg>
                        Dosen: {{ $namaDosen }}
                    </p>
                </div>

                <div
                    class="absolute -right-10 -bottom-20 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"
                ></div>
                <div
                    class="absolute -left-10 -top-20 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"
                ></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                <div
                    class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center gap-4 hover:-translate-y-1 transition-transform"
                >
                    <div
                        class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shrink-0"
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
                        <p
                            class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5"
                        >
                            Durasi
                        </p>
                        <h3
                            class="text-lg font-black text-slate-900 leading-none"
                        >
                            {{ $durasiMenit }} Menit
                        </h3>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center gap-4 hover:-translate-y-1 transition-transform"
                >
                    <div
                        class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center shrink-0"
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
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            ></path>
                        </svg>
                    </div>
                    <div>
                        <p
                            class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5"
                        >
                            Soal
                        </p>
                        <h3
                            class="text-lg font-black text-slate-900 leading-none"
                        >
                            {{ $jumlahSoal }} Butir
                        </h3>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center gap-4 hover:-translate-y-1 transition-transform"
                >
                    <div
                        class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shrink-0"
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
                        <p
                            class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5"
                        >
                            Mata Kuliah
                        </p>
                        <h3
                            class="text-xs font-black text-slate-900 leading-tight line-clamp-2"
                        >
                            {{ $exam->kelas->mataKuliah->nama ?? '-' }}
                        </h3>
                    </div>
                </div>
            </div>

            <div
                class="bg-white p-6 md:p-8 rounded-[2rem] border border-slate-200 shadow-sm"
            >
                <h3
                    class="text-lg font-black text-slate-900 mb-6 flex items-center gap-3 border-b border-slate-100 pb-4"
                >
                    <span
                        class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500"
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
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                    </span>
                    Tata Tertib & Petunjuk
                </h3>
                <ul class="space-y-5">
                    <li class="flex gap-4 items-start">
                        <span
                            class="w-7 h-7 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-black shrink-0"
                            >1</span
                        >
                        <p
                            class="text-sm text-slate-600 font-medium leading-relaxed mt-1"
                        >
                            Berdoalah sebelum memulai ujian agar diberi
                            kemudahan dan kelancaran.
                        </p>
                    </li>
                    <li class="flex gap-4 items-start">
                        <span
                            class="w-7 h-7 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-black shrink-0"
                            >2</span
                        >
                        <p
                            class="text-sm text-slate-600 font-medium leading-relaxed mt-1"
                        >
                            Waktu akan otomatis berjalan mundur saat Anda
                            menekan tombol "Mulai Mengerjakan".
                        </p>
                    </li>
                    <li class="flex gap-4 items-start">
                        <span
                            class="w-7 h-7 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-black shrink-0"
                            >3</span
                        >
                        <p
                            class="text-sm text-slate-600 font-medium leading-relaxed mt-1"
                        >
                            Pastikan koneksi internet stabil. Jika terputus,
                            jawaban akan tersimpan secara otomatis di sistem.
                        </p>
                    </li>
                    <li class="flex gap-4 items-start">
                        <span
                            class="w-7 h-7 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-black shrink-0"
                            >4</span
                        >
                        <p
                            class="text-sm text-slate-600 font-medium leading-relaxed mt-1"
                        >
                            Dilarang keras membuka tab lain, aplikasi lain, atau
                            bekerja sama dengan peserta lain selama ujian
                            berlangsung.
                        </p>
                    </li>
                </ul>

                <div
                    class="mt-8 p-5 bg-orange-50 border border-orange-100 rounded-2xl flex flex-col sm:flex-row gap-4 items-center sm:items-start text-center sm:text-left"
                >
                    <div
                        class="w-10 h-10 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center shrink-0"
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
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                            ></path>
                        </svg>
                    </div>
                    <p
                        class="text-xs font-bold text-orange-800 leading-relaxed sm:mt-1"
                    >
                        Dengan menekan tombol mulai di bawah, Anda dianggap
                        telah membaca, memahami, dan menyetujui seluruh tata
                        tertib ujian di atas.
                    </p>
                </div>
            </div>

            {{-- BOX ACTION MULAI UJIAN --}}
            <div
                class="bg-white p-6 md:p-8 rounded-[2rem] border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6"
            >
                <div class="text-center md:text-left">
                    <p
                        class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1"
                    >
                        Token Ujian
                    </p>
                    <p
                        class="text-2xl font-mono font-black text-slate-900 tracking-wider"
                    >
                        {{ $exam->token }}
                    </p>
                </div>

                <form
                    action="{{ route('exam.start', $exam->id) }}"
                    method="POST"
                    class="w-full md:w-auto"
                    id="form-mulai-ujian"
                >
                    @csrf
                    <button
                        type="button"
                        onclick="navigasiKe(1)"
                        class="w-full md:w-auto bg-blue-600 text-white px-8 py-4 md:py-4 rounded-xl font-black text-sm uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 flex items-center justify-center gap-3 transform hover:-translate-y-0.5 active:scale-95"
                    >
                        <span
                            class="bg-white/20 text-white w-6 h-6 rounded flex items-center justify-center font-black text-[10px]"
                            >1</span
                        >
                        <span>Mulai Mengerjakan</span>
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
                                d="M14 5l7 7m0 0l-7 7m7-7H3"
                            ></path>
                        </svg>
                    </button>
                </form>
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

            function getPanduanUtama() {
                const durasi = {{ $durasiMenit }};
                let teks = `Halaman Persiapan Ujian. Waktu pengerjaan Anda adalah ${durasi} menit. `;
                teks += "Sebutkan angka satu untuk mulai mengerjakan. Atau sebutkan angka nol untuk batal dan kembali. ";
                teks += "Katakan Ulang, jika butuh mendengarkan panduan ini lagi.";

                return teks;
            }

            function navigasiKe(nomor) {
                let tujuan = "";
                let teks = "";

                if (nomor === 0) {
                    tujuan = "{{ route('exams') }}";
                    teks = "Membatalkan persiapan ujian. Kembali ke daftar ujian.";
                } else if (nomor === 1) {
                    tujuan = "SUBMIT_FORM";
                    teks = "Ujian dimulai. Waktu terus berjalan, semoga berhasil.";
                }

                if (teks !== "") {
                    bicara(teks, () => {
                        setTimeout(() => {
                            if (tujuan === "SUBMIT_FORM") {
                                document.getElementById("form-mulai-ujian").submit();
                            } else if (tujuan !== "") {
                                window.location.href = tujuan;
                            } else {
                                if (rec) rec.start();
                            }
                        }, 500);
                    });
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

                        if(hasil.includes("ulang") || hasil.includes("panduan") || hasil.includes("bantuan")) {
                            rec.stop();
                            bicara(getPanduanUtama(), () => { rec.start(); });
                            return;
                        }

                        if (
                            hasil.includes("satu") ||
                            hasil.includes("mulai") ||
                            hasil.includes("kerjakan")
                        ) {
                            rec.stop();
                            navigasiKe(1);
                        } else if (
                            hasil.includes("nol") ||
                            hasil.includes("batal") ||
                            hasil.includes("kembali")
                        ) {
                            rec.stop();
                            navigasiKe(0);
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
                document.body.addEventListener("click", () => {}, {
                    once: true,
                });

                setTimeout(() => {
                    bicara(getPanduanUtama(), () => {
                        mulaiMendengar();
                    });
                }, 800);
            };
        </script>
    </body>
</html>
