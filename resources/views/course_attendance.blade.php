<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Presensi - Struktur Data 3C | LMS Inklusi UMMI</title>

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
                        <a href="{{ route('course.detail', $currentSession?->kelas->id ?? 0) }}"
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
                        <a href="{{ route('course.detail', $currentSession?->kelas->id ?? 0) }}"
                            class="hidden sm:block text-left cursor-pointer group shrink-0 decoration-transparent"
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
                        <div
                            class="hidden sm:block w-px h-10 bg-slate-200 mx-2"
                        ></div>
                        <div class="overflow-hidden flex-1">
                            <h1
                                class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight leading-none truncate max-w-[250px] md:max-w-none"
                            >
                                {{ $session->kelas->mataKuliah->nama ?? 'Mata Kuliah' }}
                            </h1>
                            <p
                                class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1 truncate"
                            >
                                {{ $session->kelas->dosen->nama ?? '-' }}
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
                                class="cursor-pointer active:scale-95 snap-start shrink-0 px-5 py-2 rounded-lg bg-white text-blue-700 font-bold text-[10px] uppercase tracking-widest shadow-sm border border-slate-200 whitespace-nowrap transition-all"
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

            <div class="max-w-6xl mx-auto w-full p-6 lg:p-8 space-y-8 pb-20">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div
                        data-aos="fade-up"
                        data-aos-duration="600"
                        class="bg-blue-600 text-white p-6 rounded-[2rem] shadow-lg shadow-blue-200/50 flex flex-col justify-between h-32 relative overflow-hidden group"
                    >
                        <div class="relative z-10">
                            <h3 class="text-4xl font-black tracking-tighter">
                                @php
                                $total = $stats['hadir'] + $stats['izin'] + $stats['sakit'] + $stats['alpha'];
                                $persen = $total > 0 ? round(($stats['hadir'] / $total) * 100) : 0;
                                @endphp
                                {{ $persen }}%
                            </h3>
                            <p
                                class="text-[9px] font-bold text-blue-200 uppercase tracking-widest mt-1"
                            >
                                Total Kehadiran
                            </p>
                        </div>
                        <div
                            class="absolute -right-4 -bottom-4 opacity-20 group-hover:scale-110 transition-transform"
                        >
                            <svg
                                class="w-24 h-24"
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
                    </div>

                    <div
                        data-aos="fade-up"
                        data-aos-duration="600"
                        data-aos-delay="100"
                        class="bg-white p-6 rounded-[2rem] border border-emerald-100 shadow-sm flex flex-col justify-center items-center text-center"
                    >
                        <div
                            class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mb-2"
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
                                    stroke-width="3"
                                    d="M5 13l4 4L19 7"
                                ></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-black text-slate-900"
                            >{{ $stats['hadir'] }}</span
                        >
                        <span
                            class="text-[9px] font-bold text-slate-400 uppercase tracking-widest"
                            >Hadir</span
                        >
                    </div>

                    <div
                        data-aos="fade-up"
                        data-aos-duration="600"
                        data-aos-delay="200"
                        class="bg-white p-6 rounded-[2rem] border border-orange-100 shadow-sm flex flex-col justify-center items-center text-center"
                    >
                        <div
                            class="w-10 h-10 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center mb-2"
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
                                    stroke-width="3"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-black text-slate-900"
                            >{{ $stats['izin'] + $stats['sakit'] }}</span
                        >
                        <span
                            class="text-[9px] font-bold text-slate-400 uppercase tracking-widest"
                            >Izin/Sakit</span
                        >
                    </div>

                    <div
                        data-aos="fade-up"
                        data-aos-duration="600"
                        data-aos-delay="300"
                        class="bg-white p-6 rounded-[2rem] border border-red-100 shadow-sm flex flex-col justify-center items-center text-center"
                    >
                        <div
                            class="w-10 h-10 rounded-full bg-red-50 text-red-600 flex items-center justify-center mb-2"
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
                                    stroke-width="3"
                                    d="M6 18L18 6M6 6l12 12"
                                ></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-black text-slate-900"
                            >{{ $stats['alpha'] }}</span
                        >
                        <span
                            class="text-[9px] font-bold text-slate-400 uppercase tracking-widest"
                            >Alpha</span
                        >
                    </div>
                </div>

                <div class="space-y-4">
                    <h3
                        data-aos="fade-in"
                        class="text-sm font-black text-slate-900 uppercase tracking-widest px-2"
                    >
                        Riwayat Pertemuan
                    </h3>

                    {{-- 🔵 PERTEMUAN SEDANG BERLANGSUNG --}}
                    @if ($currentSession)
                        <div
                            data-aos="fade-up"
                            data-aos-duration="600"
                            class="group bg-white rounded-[2.5rem] p-1 border-2 border-blue-500 shadow-lg shadow-blue-100 relative overflow-hidden transition-transform hover:scale-[1.01]"
                        >
                            <div
                                class="absolute top-0 right-0 bg-blue-500 text-white text-[9px] font-black px-4 py-1 rounded-bl-xl uppercase tracking-widest"
                            >
                                Sedang Berlangsung
                            </div>

                            <div class="p-6">
                                <div class="flex flex-col md:flex-row items-center gap-6 mb-6">
                                    <div
                                        class="w-20 h-20 rounded-2xl bg-blue-50 text-blue-600 flex flex-col items-center justify-center shrink-0 border border-blue-100"
                                    >
                                       <span class="text-[10px] font-black uppercase tracking-widest text-blue-400">
                                            {{ \Carbon\Carbon::parse($currentSession->created_at)->translatedFormat('M') }}
                                        </span>
                                        <span class="text-3xl font-black">
                                            {{ \Carbon\Carbon::parse($currentSession->created_at)->translatedFormat('d') }}
                                        </span>
                                    </div>

                                    <div class="flex-1 text-center md:text-left">
                                        <h4 class="text-lg font-black text-slate-900">
                                            Pertemuan {{ $currentSession->urutan }}: {{ $currentSession->judul }}
                                        </h4>
                                        <p class="text-xs font-medium text-slate-500 mt-1">
                                            Silahkan isi kehadiran sesuai jam pembelajaran mata kuliah.
                                        </p>

                                        <div class="mt-3 inline-flex items-center gap-2 bg-blue-50 px-3 py-1 rounded-lg">
                                            <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                                            <span class="text-[9px] font-bold text-blue-600 uppercase tracking-widest">
                                                Presensi Dibuka
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- BUTTON PRESENSI --}}
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-slate-100">
                                    <button
                                        onclick="navigasiKe(5)"
                                        class="cursor-pointer active:scale-95 flex items-center justify-center gap-3 w-full bg-emerald-500 text-white px-6 py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-lg hover:bg-emerald-600 hover:-translate-y-1 transition-all"
                                    >
                                        <span class="bg-white/20 w-6 h-6 rounded-full flex items-center justify-center text-xs">5</span>
                                        Hadir
                                    </button>
                                    <button
                                        onclick="navigasiKe(6)"
                                        class="cursor-pointer active:scale-95 flex items-center justify-center gap-3 w-full bg-orange-500 text-white px-6 py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-lg hover:bg-orange-600 hover:-translate-y-1 transition-all"
                                    >
                                        <span class="bg-white/20 w-6 h-6 rounded-full flex items-center justify-center text-xs">6</span>
                                        Sakit
                                    </button>
                                    <button
                                        onclick="navigasiKe(7)"
                                        class="cursor-pointer active:scale-95 flex items-center justify-center gap-3 w-full bg-blue-500 text-white px-6 py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-lg hover:bg-blue-600 hover:-translate-y-1 transition-all"
                                    >
                                        <span class="bg-white/20 w-6 h-6 rounded-full flex items-center justify-center text-xs">7</span>
                                        Izin
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- ⚪ RIWAYAT PERTEMUAN SEBELUMNYA --}}
                    @foreach ($sessions->where('id','!=', optional($currentSession)->id) as $session)
                        @php
                            $attendance = $myAttendances[$session->id] ?? null;
                        @endphp

                        <div
                            data-aos="fade-up"
                            data-aos-duration="600"
                            class="bg-white rounded-[2.5rem] p-6 border border-slate-200 shadow-sm
                                   flex flex-col md:flex-row items-center gap-6
                                   {{ $attendance ? '' : 'opacity-60' }}"
                        >
                            {{-- TANGGAL --}}
                            <div class="w-16 h-16 rounded-2xl bg-slate-50 text-slate-400 flex flex-col items-center justify-center shrink-0">
                                <span class="text-[8px] font-black uppercase tracking-widest">
                                    {{ \Carbon\Carbon::parse($session->tanggal)->translatedFormat('M') }}
                                </span>
                                <span class="text-2xl font-black">
                                    {{ \Carbon\Carbon::parse($session->tanggal)->translatedFormat('d') }}
                                </span>
                            </div>

                            {{-- INFO SESI --}}
                            <div class="flex-1 text-center md:text-left">
                                <h4 class="text-base font-bold text-slate-700">
                                    Pertemuan {{ $session->urutan }}: {{ $session->judul }}
                                </h4>
                                <p class="text-[10px] font-medium text-slate-400 mt-1">
                                    {{ $session->jam_mulai }} - {{ $session->jam_selesai }} WIB
                                </p>
                            </div>

                            {{-- STATUS / BUTTON --}}
                            @if ($attendance)
                                <button
                                    disabled
                                    class="px-6 py-2 rounded-xl font-black text-[10px] uppercase tracking-widest border flex items-center gap-2 cursor-not-allowed
                                    {{ $attendance->status === 'hadir' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' :
                                       ($attendance->status === 'izin' ? 'bg-blue-50 text-blue-600 border-blue-100' :
                                       'bg-orange-50 text-orange-600 border-orange-100') }}"
                                >
                                    ✔ {{ ucfirst($attendance->status) }}
                                </button>
                            @else
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    Belum Absen
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </main>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({ once: true, easing: "ease-out-cubic" });

            const statusDesc = document.getElementById("status-desc");
            const waveBars = document.querySelectorAll(".wave-bar");
            const synth = window.speechSynthesis;

            // 🔐 SESSION ID AMAN (sinkron Blade)
            const CURRENT_SESSION_ID = @json(optional($currentSession)->id);
            
            // Variabel Data Statistik untuk Suara
            const namaMatkul = "{{ $kelas->mataKuliah->nama ?? 'Mata Kuliah' }}";
            const totalKehadiran = "{{ $persen }}";
            const hadir = "{{ $stats['hadir'] }}";
            const izinSakit = "{{ $stats['izin'] + $stats['sakit'] }}";
            const alpha = "{{ $stats['alpha'] }}";
            const hasActiveSession = {{ $currentSession ? 'true' : 'false' }};
            const activeUrutan = "{{ $currentSession->urutan ?? '' }}";

            let rec = null;
            let interval;

            // ==============================
            // SAFE SpeechRecognition
            // ==============================
            if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
                const SpeechRec = window.webkitSpeechRecognition || window.SpeechRecognition;
                rec = new SpeechRec();
                rec.lang = "id-ID";
                rec.continuous = true;
            }

            function setWave(active) {
                if (!waveBars.length) return;
                waveBars.forEach((bar) => {
                    bar.style.height = active
                        ? `${Math.floor(Math.random() * 12) + 4}px`
                        : "4px";
                });
            }

            // ==============================
            // TEXT TO SPEECH
            // ==============================
            function bicara(teks, callback) {
                synth.cancel();
                const utter = new SpeechSynthesisUtterance(teks);
                utter.lang = "id-ID";
                utter.rate = parseFloat(localStorage.getItem("speechRate")) || 1.0;

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

            // FUNGSI PANDUAN SUARA DINAMIS
            function getPanduanSuara() {
                let teks = `Halaman Presensi kelas ${namaMatkul}. `;
                teks += `Statistik kehadiran Anda: Kehadiran ${totalKehadiran} persen. Hadir ${hadir} kali, Izin atau Sakit ${izinSakit} kali, Alpha ${alpha} kali. `;
                
                if (hasActiveSession) {
                    teks += `Saat ini Pertemuan ${activeUrutan} sedang berlangsung. Silakan sebutkan angka lima untuk Hadir, enam untuk Sakit, atau tujuh untuk Izin. `;
                } else {
                    teks += `Saat ini belum ada pertemuan yang membuka absensi. `;
                }

                teks += "Untuk navigasi menu: Sebutkan satu untuk Pembelajaran, dua untuk tetap di Presensi, tiga untuk Penugasan, empat untuk Anggota kelas, atau nol untuk kembali. Katakan Ulang, jika Anda ingin mendengar panduan ini dari awal.";
                
                return teks;
            }

            // ==============================
            // PRESENSI FUNCTION
            // ==============================
            function kirimPresensi(status) {
                if (!CURRENT_SESSION_ID) {
                    alert("Tidak ada sesi aktif.");
                    return;
                }

                document.getElementById('status-desc').innerText = "MEMPROSES...";

                fetch("{{ url('presensi') }}/" + CURRENT_SESSION_ID + "/" + status, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Presensi gagal atau Anda sudah absen sebelumnya.");
                    }
                    return response.json();
                })
                .then(data => {
                    bicara("Presensi " + status + " Anda berhasil dicatat.", () => {
                        location.reload();
                    });
                })
                .catch(error => {
                    console.error(error);
                    bicara("Presensi gagal atau Anda sudah mengisi absen sebelumnya.", () => {
                        mulaiMendengar();
                    });
                });
            }

            // ==============================
            // NAVIGASI + VOICE COMMAND
            // ==============================
            function navigasiKe(nomor) {
                let tujuan = "";
                let teks = "";

                if (nomor === 0) {
                    tujuan = "{{ route('dashboard') ?? '#' }}";
                    teks = "Kembali ke Beranda.";
                }
                else if (nomor === 1) {
                    tujuan = "{{ route('course.detail', $currentSession?->kelas->id ?? 0) }}";
                    teks = "Membuka Menu Pembelajaran.";
                }
                else if (nomor === 2) {
                    teks = "Anda sudah berada di Halaman Presensi.";
                }
                else if (nomor === 3) {
                    tujuan = "{{ route('course.assignments', $currentSession?->kelas->id ?? 0) }}";
                    teks = "Membuka Menu Penugasan.";
                }
                else if (nomor === 4) {
                    tujuan = "{{ route('course.members', $currentSession?->kelas->id ?? 0) }}";
                    teks = "Membuka Menu Anggota Kelas.";
                }
                // ===== PRESENSI =====
                else if (nomor === 5) {
                    if(!hasActiveSession) { bicara("Belum ada absensi yang dibuka saat ini.", () => mulaiMendengar()); return; }
                    kirimPresensi("hadir");
                    return;
                }
                else if (nomor === 6) {
                    if(!hasActiveSession) { bicara("Belum ada absensi yang dibuka saat ini.", () => mulaiMendengar()); return; }
                    kirimPresensi("sakit");
                    return;
                }
                else if (nomor === 7) {
                    if(!hasActiveSession) { bicara("Belum ada absensi yang dibuka saat ini.", () => mulaiMendengar()); return; }
                    kirimPresensi("izin");
                    return;
                }

                if (teks !== "") {
                    bicara(teks, () => {
                        if (tujuan && tujuan !== "#") {
                            window.location.href = tujuan;
                        } else {
                            mulaiMendengar();
                        }
                    });
                } else if (tujuan && tujuan !== "#") {
                    window.location.href = tujuan;
                }
            }

            // ==============================
            // VOICE RECOGNITION
            // ==============================
            function mulaiMendengar() {
                if (!rec) return;

                try {
                    rec.start();

                    rec.onresult = (event) => {
                        const hasil = event.results[event.results.length - 1][0].transcript.toLowerCase().trim();

                        if(hasil.includes("ulang") || hasil.includes("panduan") || hasil.includes("bantuan")) {
                            bicara(getPanduanSuara(), () => { mulaiMendengar(); });
                            return;
                        }

                        const angka = hasil.match(/\d+/);

                        if (angka) navigasiKe(parseInt(angka[0]));
                        else if (hasil.includes("nol") || hasil.includes("kembali")) navigasiKe(0);
                        else if (hasil.includes("satu") || hasil.includes("pembelajaran")) navigasiKe(1);
                        else if (hasil.includes("dua") || hasil.includes("presensi")) navigasiKe(2);
                        else if (hasil.includes("tiga") || hasil.includes("penugasan")) navigasiKe(3);
                        else if (hasil.includes("empat") || hasil.includes("anggota")) navigasiKe(4);
                        else if (hasil.includes("lima") || hasil.includes("hadir")) navigasiKe(5);
                        else if (hasil.includes("enam") || hasil.includes("sakit")) navigasiKe(6);
                        else if (hasil.includes("tujuh") || hasil.includes("izin")) navigasiKe(7);
                    };

                    rec.onend = () => rec.start();

                } catch (e) {
                    console.error("Speech recognition error:", e);
                }
            }

            // ==============================
            // INIT
            // ==============================
            window.onload = () => {
                document.body.addEventListener("click", () => {}, { once: true });
                
                setTimeout(() => {
                    bicara(getPanduanSuara(), () => {
                        mulaiMendengar();
                    });
                }, 800);
            };
        </script>
    </body>
</html>