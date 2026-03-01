<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Mengerjakan Ujian | LMS Inklusi UMMI</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap"
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

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .safe-fade-in {
                animation: fadeIn 0.6s ease-out forwards;
                opacity: 0;
            }

            /* Voice Wave Animation */
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

            .nav-btn {
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .nav-btn.active {
                background-color: #2563eb;
                color: white;
                border-color: #2563eb;
                transform: scale(1.05);
                box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
            }
            .nav-btn.answered:not(.active) {
                background-color: #eff6ff; /* Biru sangat muda */
                color: #2563eb;
                border-color: #93c5fd;
            }

            .option-item {
                transition: all 0.2s ease;
            }
            .option-item:active {
                transform: scale(0.99);
            }
        </style>
    </head>
    <body
        class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] text-slate-800 border-box selection:bg-blue-200 relative custom-scrollbar flex flex-col h-screen overflow-hidden"
    >
        @php $mulai = \Carbon\Carbon::parse($exam->waktu_mulai); $selesai =
        \Carbon\Carbon::parse($exam->waktu_selesai); $durasiMenit =
        $mulai->diffInMinutes($selesai); $jumlahSoal = $exam->questions ?
        $exam->questions->count() : 0; $namaDosen = $exam->kelas->dosen->nama ??
        $exam->dosen->nama ?? 'Dosen Pengampu'; @endphp

        {{-- BACKGROUND DEKORASI --}}
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

        {{-- NAVBAR BARU --}}
        <header
            class="bg-white/90 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm w-full shrink-0"
        >
            <div
                class="w-full mx-auto flex items-center justify-between relative h-12"
            >
                {{-- Kiri: Tombol Back + Angka 0 --}}
                <div
                    class="flex items-center gap-4 relative z-10 w-1/3 justify-start shrink-0"
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
                        class="hidden md:block text-left cursor-pointer group shrink-0"
                        onclick="navigasiKe(0)"
                    >
                        <span
                            class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest"
                            >Navigasi Suara</span
                        >
                        <span
                            class="block text-xs font-black text-slate-700 group-hover:text-blue-600 transition-colors"
                            >0 - Keluar Ujian</span
                        >
                    </div>
                </div>

                {{-- Tengah: Judul & Timer --}}
                <div
                    class="text-center absolute left-1/2 transform -translate-x-1/2 w-1/3 z-0 pointer-events-none flex flex-col items-center justify-center"
                >
                    <h1
                        class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight leading-none truncate pointer-events-auto w-full"
                    >
                        {{ $exam->judul }}
                    </h1>
                    <div
                        class="mt-1.5 pointer-events-auto flex items-center justify-center gap-2"
                    >
                        <div
                            class="flex items-center gap-1.5 bg-red-50 px-2 py-0.5 rounded-md border border-red-100 shadow-sm"
                        >
                            <svg
                                class="w-3 h-3 text-red-500 animate-pulse"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2.5"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                            <span
                                id="timerDisplay"
                                class="text-[10px] font-black text-red-600 font-mono tracking-widest"
                                >00:00:00</span
                            >
                        </div>
                        <span
                            class="text-[9px] font-black text-blue-700 uppercase tracking-widest bg-blue-100 px-2 py-1 rounded-md border border-blue-200 shadow-sm"
                        >
                            No. Soal: <span id="lblSoalNoTop">1</span>
                        </span>
                    </div>
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
                        class="hidden md:block text-[9px] font-black text-slate-400 uppercase tracking-widest w-20 text-left"
                        >MEMUAT...</span
                    >
                </div>
            </div>
        </header>

        {{-- AREA UTAMA --}}
        <main class="flex-1 flex overflow-hidden w-full relative">
            {{-- AREA KIRI: Konten Soal + Footer Navigasi --}}
            <div class="flex-1 flex flex-col h-full bg-slate-50/50 relative">
                <div
                    class="flex-1 overflow-y-auto custom-scrollbar p-4 md:p-8 lg:p-12"
                >
                    <div class="w-full max-w-5xl mx-auto space-y-8">
                        <div
                            class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden relative min-h-[500px] flex flex-col transition-all duration-500"
                        >
                            {{-- Loader --}}
                            <div
                                id="loader"
                                class="absolute inset-0 bg-white/95 backdrop-blur-md z-50 flex flex-col items-center justify-center transition-all"
                            >
                                <div
                                    class="w-12 h-12 border-4 border-slate-100 border-t-blue-600 rounded-full animate-spin mb-4"
                                ></div>
                                <span
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]"
                                    >Memproses Soal...</span
                                >
                            </div>

                            <div class="p-8 md:p-12 flex-1 flex flex-col">
                                <div
                                    class="flex justify-between items-center mb-8 pb-6 border-b border-slate-100"
                                >
                                    <h3
                                        class="text-xl font-black text-slate-900 tracking-tight flex items-center gap-3"
                                    >
                                        <span
                                            class="w-12 h-12 bg-blue-600 text-white rounded-xl flex items-center justify-center text-xl shadow-md shadow-blue-200"
                                            id="lblSoalNoLarge"
                                            >1</span
                                        >
                                        Pertanyaan
                                    </h3>
                                    <span
                                        id="lblTipeSoal"
                                        class="px-4 py-2 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-black uppercase tracking-widest border border-slate-200"
                                        >Pilihan Ganda</span
                                    >
                                </div>

                                <div
                                    id="teksSoal"
                                    class="text-xl md:text-2xl font-bold text-slate-800 leading-relaxed mb-12"
                                >
                                    {{-- Konten Soal Di-render Disini --}}
                                </div>

                                <div
                                    id="opsiContainer"
                                    class="grid grid-cols-1 gap-4 mt-auto"
                                >
                                    {{-- Opsi Jawaban Di-render Disini --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FOOTER NAV (Fixed di bawah area soal) --}}
                <footer
                    class="bg-white/90 backdrop-blur-md border-t border-slate-200 p-4 shrink-0 shadow-[0_-4px_20px_rgba(0,0,0,0.02)] z-30"
                >
                    <div
                        class="w-full max-w-5xl mx-auto flex items-center justify-between gap-4"
                    >
                        <button
                            onclick="navPrev()"
                            id="btnPrev"
                            class="flex-1 md:flex-none px-8 py-4 bg-slate-100 text-slate-600 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-all disabled:opacity-40 disabled:cursor-not-allowed active:scale-95"
                        >
                            Sebelumnya
                        </button>

                        <button
                            onclick="openMobileNav()"
                            class="lg:hidden p-4 bg-blue-50 text-blue-600 rounded-2xl border border-blue-100 hover:bg-blue-100 transition-colors active:scale-95 relative"
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
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                                ></path>
                            </svg>
                        </button>

                        <button
                            onclick="navNext()"
                            id="btnNext"
                            class="flex-1 md:flex-none px-8 py-4 bg-blue-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-blue-600/30 hover:bg-blue-700 transition-all active:scale-95"
                        >
                            <span id="txtBtnNext">Selanjutnya</span>
                        </button>
                    </div>
                </footer>
            </div>

            {{-- AREA KANAN: Peta Soal FULL MENTOK KANAN (Desktop) --}}
            <aside
                class="hidden lg:flex w-[340px] xl:w-[380px] flex-col h-full bg-white border-l border-slate-200 shadow-[-10px_0_30px_rgba(0,0,0,0.03)] shrink-0 z-10"
            >
                <div
                    class="p-8 border-b border-slate-100 bg-slate-50/50 shrink-0"
                >
                    <div class="flex items-center justify-between mb-6">
                        <h3
                            class="text-lg font-black text-slate-900 tracking-tight uppercase"
                        >
                            Peta Soal
                        </h3>
                        <span
                            class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-[10px] font-black"
                            ><span id="lblTerjawab">0</span
                            >/{{ count($exam->questions ?? []) }}</span
                        >
                    </div>
                    <div class="flex gap-4">
                        <div
                            class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider"
                        >
                            <span
                                class="w-3 h-3 rounded-full bg-blue-500 shadow-sm"
                            ></span>
                            Terjawab
                        </div>
                        <div
                            class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider"
                        >
                            <span
                                class="w-3 h-3 rounded-full bg-white border-2 border-slate-200"
                            ></span>
                            Belum
                        </div>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto custom-scrollbar p-8">
                    <div id="gridNavigasi" class="grid grid-cols-5 gap-3">
                        {{-- Grid Tombol Peta Soal --}}
                    </div>
                </div>

                <div
                    class="p-8 border-t border-slate-100 bg-slate-50/30 shrink-0"
                >
                    <button
                        onclick="konfirmasiSelesai()"
                        class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] shadow-lg shadow-slate-900/20 hover:bg-blue-600 hover:shadow-blue-600/30 transition-all transform hover:-translate-y-1 active:scale-95"
                    >
                        Kumpulkan Ujian
                    </button>
                </div>
            </aside>
        </main>

        {{-- MODAL MOBILE NAV (MODERN BOTTOM SHEET) --}}
        <div id="mobileNavOverlay" class="fixed inset-0 z-[100] hidden">
            <div
                class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0 duration-300"
                id="mobileNavBackdrop"
                onclick="closeMobileNav()"
            ></div>

            <div
                id="mobileNavContent"
                class="absolute bottom-0 left-0 w-full bg-white rounded-t-[2rem] shadow-[0_-10px_40px_rgba(0,0,0,0.1)] transform translate-y-full transition-transform duration-300 ease-out flex flex-col max-h-[85vh]"
            >
                <div
                    class="pt-4 pb-2 flex flex-col items-center border-b border-slate-100 shrink-0 bg-white rounded-t-[2rem]"
                >
                    <div
                        class="w-12 h-1.5 bg-slate-200 rounded-full mb-4"
                    ></div>
                    <div
                        class="w-full px-6 flex justify-between items-center mb-2"
                    >
                        <div>
                            <h3
                                class="font-black text-slate-900 uppercase tracking-widest text-sm"
                            >
                                Peta Soal
                            </h3>
                            <p
                                class="text-[10px] text-slate-400 font-bold mt-1"
                            >
                                <span
                                    class="text-blue-600"
                                    id="lblTerjawabMobile"
                                    >0</span
                                >
                                Terjawab /
                                {{ count($exam->questions ?? []) }} Total
                            </p>
                        </div>
                        <button
                            onclick="closeMobileNav()"
                            class="w-8 h-8 bg-slate-100 text-slate-500 rounded-full flex items-center justify-center font-bold hover:bg-slate-200 transition-colors active:scale-95"
                        >
                            ✕
                        </button>
                    </div>
                </div>

                <div
                    class="flex-1 overflow-y-auto p-6 custom-scrollbar bg-slate-50/50"
                >
                    <div
                        id="gridNavigasiMobile"
                        class="grid grid-cols-5 sm:grid-cols-6 gap-3"
                    ></div>
                </div>

                <div class="p-6 bg-white border-t border-slate-100 shrink-0">
                    <button
                        onclick="konfirmasiSelesai()"
                        class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] shadow-lg hover:bg-blue-600 transition-colors active:scale-95"
                    >
                        Kumpulkan Ujian
                    </button>
                </div>
            </div>
        </div>

        {{-- FORM SUBMIT HIDDEN --}}
        <form
            id="submitUjianForm"
            action="{{ route('exam.submit', $exam->id ?? 1) }}"
            method="POST"
            class="hidden"
        >
            @csrf
            <input type="hidden" name="jawaban_data" id="jawabanDataInput" />
        </form>

        <script>
            const examData = @json($exam);
            const questions = examData.questions || [];
            let answers = {};
            let currentIndex = 0;
            let waktuDurasi = {{ $exam->durasi ?? 90 }} * 60;

            const statusDesc = document.getElementById("status-desc");
            const waveBars = document.querySelectorAll(".wave-bar");
            const synth = window.speechSynthesis;
            const SpeechRec = window.webkitSpeechRecognition || window.SpeechRecognition;
            let rec = null;
            let isVoiceActive = true;
            let waveInterval;

            window.onload = () => {
                document.getElementById('lblTerjawab').innerText = "0";
                if(questions.length === 0) {
                    alert("Soal belum tersedia.");
                    window.location.href = "/exams";
                    return;
                }
                renderNavigasi();
                muatSoal(0);
                mulaiTimer();

                document.body.addEventListener("click", () => {}, { once: true });

                setTimeout(() => {
                    document.getElementById('loader').classList.add('opacity-0');
                    setTimeout(() => document.getElementById('loader').classList.add('hidden'), 500);
                    bacaSoalAktif();
                }, 800);
            };

            /* --- FUNGSI MODAL BOTTOM SHEET MOBILE --- */
            function openMobileNav() {
                const overlay = document.getElementById('mobileNavOverlay');
                const backdrop = document.getElementById('mobileNavBackdrop');
                const content = document.getElementById('mobileNavContent');

                overlay.classList.remove('hidden');
                // Sedikit delay agar class transisi membaca display block
                setTimeout(() => {
                    backdrop.classList.remove('opacity-0');
                    content.classList.remove('translate-y-full');
                }, 10);
            }

            function closeMobileNav() {
                const backdrop = document.getElementById('mobileNavBackdrop');
                const content = document.getElementById('mobileNavContent');

                backdrop.classList.add('opacity-0');
                content.classList.add('translate-y-full');

                setTimeout(() => {
                    document.getElementById('mobileNavOverlay').classList.add('hidden');
                }, 300); // durasi sama dengan CSS transition duration
            }

            function renderNavigasi() {
                const gridDesktop = document.getElementById('gridNavigasi');
                const gridMobile = document.getElementById('gridNavigasiMobile');
                let html = '';
                let countTerjawab = 0;

                questions.forEach((q, idx) => {
                    const isDijawab = answers[q.id] !== undefined && answers[q.id] !== '';
                    if(isDijawab) countTerjawab++;
                    const isActive = idx === currentIndex;

                    let cls = "nav-btn w-full aspect-square rounded-xl flex items-center justify-center font-black text-xs border-2 focus:outline-none focus:ring-2 focus:ring-blue-300 ";

                    if (isActive) cls += "active";
                    else if (isDijawab) cls += "answered";
                    else cls += "border-slate-200 bg-white text-slate-500 hover:border-blue-400";

                    html += `<button onclick="pindahSoalManual(${idx})" class="${cls}">${idx + 1}</button>`;
                });

                if(gridDesktop) gridDesktop.innerHTML = html;
                if(gridMobile) gridMobile.innerHTML = html;

                document.getElementById('lblTerjawab').innerText = countTerjawab;
                document.getElementById('lblTerjawabMobile').innerText = countTerjawab;
            }

            function muatSoal(index) {
                currentIndex = index;
                const q = questions[currentIndex];

                document.getElementById('lblSoalNoTop').innerText = currentIndex + 1;
                document.getElementById('lblSoalNoLarge').innerText = currentIndex + 1;
                document.getElementById('lblTipeSoal').innerText = q.tipe === 'PG' ? 'Pilihan Ganda' : 'Esai';
                document.getElementById('teksSoal').innerHTML = q.teks_soal;

                const container = document.getElementById('opsiContainer');
                container.innerHTML = '';

                if (q.tipe === 'PG') {
                    q.options.forEach((opt, idx) => {
                        const isSelected = answers[q.id] === opt.id;
                        const letter = ['A', 'B', 'C', 'D', 'E'][idx];

                        const div = document.createElement('div');
                        div.className = `option-item p-4 sm:p-5 rounded-2xl border-2 cursor-pointer flex items-center gap-4 transition-all relative overflow-hidden ${isSelected ? 'border-blue-600 bg-blue-50 z-10' : 'border-slate-200 hover:border-blue-300 bg-white hover:bg-slate-50'}`;
                        div.onclick = () => pilihJawaban(opt.id, idx);

                        div.innerHTML = `
                            ${isSelected ? '<div class="absolute left-0 top-0 bottom-0 w-1.5 bg-blue-600"></div>' : ''}
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black transition-colors ${isSelected ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-500'}">${letter}</div>
                            <div class="flex-1 font-bold text-base sm:text-lg ${isSelected ? 'text-blue-900' : 'text-slate-700'}">${opt.teks_opsi}</div>
                        `;
                        container.appendChild(div);
                    });
                } else {
                    const txt = document.createElement('textarea');
                    txt.className = "w-full p-6 bg-slate-50 border-2 border-slate-200 rounded-[2rem] h-64 font-bold text-slate-700 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 focus:bg-white transition-all resize-y";
                    txt.placeholder = "Tulis jawaban esai Anda di sini...";
                    txt.value = answers[q.id] || '';
                    txt.oninput = (e) => { answers[q.id] = e.target.value; renderNavigasi(); };
                    container.appendChild(txt);
                }

                document.getElementById('btnPrev').disabled = (currentIndex === 0);

                const btnNext = document.getElementById('btnNext');
                const txtBtnNext = document.getElementById('txtBtnNext');

                if (currentIndex === questions.length - 1) {
                    btnNext.className = "flex-1 md:flex-none px-8 py-4 bg-emerald-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-emerald-600/30 hover:bg-emerald-700 transition-all active:scale-95";
                    txtBtnNext.innerText = "Kumpulkan";
                    btnNext.onclick = konfirmasiSelesai;
                } else {
                    btnNext.className = "flex-1 md:flex-none px-8 py-4 bg-blue-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-blue-600/30 hover:bg-blue-700 transition-all active:scale-95";
                    txtBtnNext.innerText = "Selanjutnya";
                    btnNext.onclick = navNext;
                }

                renderNavigasi();
            }

            // --- Logika Suara ---
            function setWave(active) {
                if (waveBars.length > 0) {
                    waveBars.forEach((bar) => {
                        bar.style.height = active ? `${Math.floor(Math.random() * 12) + 4}px` : "4px";
                    });
                }
            }

            function bicara(teks, cb) {
                if(!isVoiceActive) return;
                synth.cancel();

                const utter = new SpeechSynthesisUtterance(teks);
                utter.lang = "id-ID";
                const savedRate = localStorage.getItem("speechRate");
                utter.rate = savedRate ? parseFloat(savedRate) : 1.0;

                utter.onstart = () => {
                    if (statusDesc) {
                        statusDesc.innerText = "BERBICARA...";
                        statusDesc.className = "hidden md:block text-[9px] font-black text-blue-600 uppercase tracking-widest w-20 text-left";
                    }
                    waveInterval = setInterval(() => setWave(true), 150);
                };

                utter.onend = () => {
                    if (statusDesc) {
                        statusDesc.innerText = "MENDENGARKAN...";
                        statusDesc.className = "hidden md:block text-[9px] font-black text-blue-600 uppercase tracking-widest w-20 text-left animate-pulse";
                    }
                    clearInterval(waveInterval);
                    setWave(false);
                    if (cb) cb();
                };
                synth.speak(utter);
            }

            function bacaSoalAktif(isUlang = false) {
                const q = questions[currentIndex];
                let t = `Soal nomor ${currentIndex+1}. ${q.teks_soal}. `;

                if(q.tipe === 'PG') {
                    q.options.forEach((o, i) => t += `Pilihan ${['A','B','C','D','E'][i]}, ${o.teks_opsi}. `);
                    t += "Sebutkan huruf pilihan jawaban Anda.";
                } else {
                    t += "Ini adalah soal esai. Silakan ketik jawaban Anda di kolom yang tersedia, lalu bilang lanjut.";
                }

                if (isUlang) {
                    t += " Anda bisa bilang Lanjut ke soal berikutnya, Kembali ke soal sebelumnya, atau Kumpulkan untuk mengakhiri.";
                } else {
                    t += " Katakan Ulang, jika Anda ingin soal ini dibacakan lagi.";
                }

                bicara(t, mulaiMendengar);
            }

            function mulaiMendengar() {
                if(!SpeechRec) return;
                if(rec) rec.stop();

                rec = new SpeechRec();
                rec.lang = 'id-ID';

                rec.onresult = (e) => {
                    const msg = e.results[0][0].transcript.toLowerCase().trim();

                    if(msg.includes("ulang") || msg.includes("panduan") || msg.includes("bantuan")) {
                        rec.stop();
                        bacaSoalAktif(true);
                        return;
                    }

                    if(msg.includes("lanjut") || msg.includes("selanjutnya")) { rec.stop(); navNext(); }
                    else if(msg.includes("kembali") && !msg.includes("nol")) { rec.stop(); navPrev(); }
                    else if(msg.includes("kumpulkan") || msg.includes("selesai")) { rec.stop(); konfirmasiSelesai(); }
                    else if(msg.includes("nol") || msg.includes("batal")) { rec.stop(); navigasiKe(0); }
                    else if(questions[currentIndex].tipe === 'PG') {
                        // Deteksi spesifik untuk pilihan A B C D E
                        const isA = msg === 'a' || msg.endsWith(' a') || msg.includes('pilih a') || msg.includes('jawaban a') || msg === 'ah';
                        const isB = msg === 'b' || msg === 'be' || msg.endsWith(' b') || msg.includes('pilih b') || msg.includes('jawaban b');
                        const isC = msg === 'c' || msg === 'ce' || msg.endsWith(' c') || msg.includes('pilih c') || msg.includes('jawaban c');
                        const isD = msg === 'd' || msg === 'de' || msg.endsWith(' d') || msg.includes('pilih d') || msg.includes('jawaban d');
                        const isE = msg === 'e' || msg === 'eh' || msg.endsWith(' e') || msg.includes('pilih e') || msg.includes('jawaban e');

                        if (isA && questions[currentIndex].options[0]) { rec.stop(); pilihJawaban(questions[currentIndex].options[0].id, 0); }
                        else if (isB && questions[currentIndex].options[1]) { rec.stop(); pilihJawaban(questions[currentIndex].options[1].id, 1); }
                        else if (isC && questions[currentIndex].options[2]) { rec.stop(); pilihJawaban(questions[currentIndex].options[2].id, 2); }
                        else if (isD && questions[currentIndex].options[3]) { rec.stop(); pilihJawaban(questions[currentIndex].options[3].id, 3); }
                        else if (isE && questions[currentIndex].options[4]) { rec.stop(); pilihJawaban(questions[currentIndex].options[4].id, 4); }
                    }
                };

                rec.onend = () => { rec.start(); };
                rec.start();
            }

            function pilihJawaban(optId, idx) {
                answers[questions[currentIndex].id] = optId;
                muatSoal(currentIndex); // Update UI

                const feedback = "Anda memilih jawaban " + ['A', 'B', 'C', 'D', 'E'][idx];

                if (currentIndex < questions.length - 1) {
                    bicara(feedback + ". Melanjutkan ke soal berikutnya.", () => {
                        navNext();
                    });
                } else {
                    bicara(feedback + ". Ini adalah soal terakhir. Katakan kumpulkan untuk menyelesaikan ujian.", mulaiMendengar);
                }
            }

            function navNext() {
                if(currentIndex < questions.length - 1) {
                    synth.cancel();
                    closeMobileNav(); // Tutup modal nav mobile jika terbuka
                    muatSoal(currentIndex + 1);
                    if(isVoiceActive) setTimeout(() => bacaSoalAktif(), 300);
                } else {
                    bicara("Ini sudah soal terakhir. Katakan kumpulkan untuk mengakhiri ujian.", mulaiMendengar);
                }
            }

            function navPrev() {
                if(currentIndex > 0) {
                    synth.cancel();
                    closeMobileNav(); // Tutup modal nav mobile jika terbuka
                    muatSoal(currentIndex - 1);
                    if(isVoiceActive) setTimeout(() => bacaSoalAktif(), 300);
                } else {
                    bicara("Ini sudah soal pertama.", mulaiMendengar);
                }
            }

            function pindahSoalManual(i) {
                synth.cancel();
                closeMobileNav();
                muatSoal(i);
                if(isVoiceActive) setTimeout(bacaSoalAktif, 300);
            }

            function mulaiTimer() {
                const timerContainer = document.querySelector('.bg-red-50');
                const timer = setInterval(() => {
                    if(waktuDurasi <= 0) { clearInterval(timer); submitUjian(); return; }
                    waktuDurasi--;
                    const h = Math.floor(waktuDurasi / 3600).toString().padStart(2, '0');
                    const m = Math.floor((waktuDurasi % 3600) / 60).toString().padStart(2, '0');
                    const s = (waktuDurasi % 60).toString().padStart(2, '0');
                    document.getElementById('timerDisplay').innerText = `${h}:${m}:${s}`;

                    if(waktuDurasi === 300) {
                        timerContainer.classList.add('bg-red-100', 'border-red-300');
                        bicara("Perhatian, waktu tersisa lima menit.", mulaiMendengar);
                    }
                }, 1000);
            }

            function konfirmasiSelesai() {
                synth.cancel();
                if(confirm("Apakah Anda yakin ingin mengumpulkan ujian? Pastikan semua soal telah terjawab.")) submitUjian();
                else bicara("Pengumpulan dibatalkan. Silakan lanjutkan.", mulaiMendengar);
            }

            function submitUjian() {
                isVoiceActive = false; // matikan suara
                if(rec) rec.stop();
                document.getElementById('loader').classList.remove('hidden');
                setTimeout(() => { document.getElementById('loader').classList.remove('opacity-0'); }, 10);
                document.querySelector('#loader span').innerText = "Mengirim Jawaban...";

                document.getElementById('jawabanDataInput').value = JSON.stringify(answers);
                document.getElementById('submitUjianForm').submit();
            }

            function navigasiKe(v) {
                if(v === 0) {
                    synth.cancel();
                    if(confirm("Yakin ingin keluar ujian? Jawaban Anda mungkin tidak tersimpan jika belum di kumpulkan.")){
                        bicara("Membatalkan ujian. Kembali ke halaman sebelumnya.", () => {
                            setTimeout(() => { window.location.href="/exams"; }, 500);
                        });
                    }
                }
            }
        </script>
    </body>
</html>
