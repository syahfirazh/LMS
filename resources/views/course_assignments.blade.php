<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Daftar Tugas - {{ $kelas->mataKuliah->nama }} | LMS Inklusi UMMI</title>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <style>
        html { scrollbar-gutter: stable; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-full flex flex-col border-box overflow-x-hidden text-slate-800">
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-[-10%] right-[-5%] w-[400px] h-[400px] bg-blue-100/40 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] bg-indigo-50/40 rounded-full blur-3xl opacity-50"></div>
    </div>

    <main class="flex-1 flex flex-col h-screen overflow-y-scroll custom-scrollbar relative">
        <div class="bg-white/90 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm transition-all w-full">
            <div class="max-w-7xl mx-auto flex flex-col lg:flex-row lg:items-center justify-between gap-4 lg:gap-6 relative">
                
                <div class="flex items-center gap-4 relative z-10 w-full lg:w-auto">
                    <button onclick="navigasiKe(0)" class="w-11 h-11 md:w-12 md:h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm shrink-0 group border border-slate-200 hover:border-blue-600 relative cursor-pointer active:scale-95">
                        <svg class="w-5 h-5 md:w-6 md:h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <span class="absolute -bottom-1 -right-1 bg-slate-800 text-white text-[9px] font-black px-1.5 py-0.5 rounded-md border border-white">0</span>
                    </button>

                    <div class="hidden sm:block text-left cursor-pointer group shrink-0" onclick="navigasiKe(0)">
                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest">Navigasi Suara</span>
                        <span class="block text-xs font-black text-slate-700 group-hover:text-blue-600 transition-colors">0 - Kembali</span>
                    </div>

                    <div class="hidden sm:block w-px h-10 bg-slate-200 mx-2"></div>

                    <div class="overflow-hidden flex-1">
                        <h1 class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight leading-none truncate max-w-[250px] md:max-w-none">
                            {{ $kelas->mataKuliah->nama }}
                        </h1>
                        <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1 truncate">
                            Dosen: {{ $kelas->dosen->nama ?? '-' }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                    <nav class="w-full lg:w-auto flex p-1.5 bg-slate-100/80 rounded-xl overflow-x-auto custom-scrollbar snap-x gap-1 border border-slate-200/50">
                        <button onclick="navigasiKe(1)" class="cursor-pointer active:scale-95 snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-white/50 font-bold text-[10px] uppercase tracking-widest border border-transparent whitespace-nowrap transition-all">
                            1. Pembelajaran
                        </button>
                        <button onclick="navigasiKe(2)" class="cursor-pointer active:scale-95 snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-white/50 font-bold text-[10px] uppercase tracking-widest border border-transparent whitespace-nowrap transition-all">
                            2. Presensi
                        </button>
                        <button onclick="navigasiKe(3)" class="cursor-pointer active:scale-95 snap-start shrink-0 px-5 py-2 rounded-lg bg-white text-blue-700 font-bold text-[10px] uppercase tracking-widest shadow-sm border border-slate-200 whitespace-nowrap transition-all">
                            3. Penugasan
                        </button>
                        <button onclick="navigasiKe(4)" class="cursor-pointer active:scale-95 snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-white/50 font-bold text-[10px] uppercase tracking-widest border border-transparent whitespace-nowrap transition-all">
                            4. Anggota
                        </button>
                    </nav>

                    <div class="hidden md:flex items-center gap-3 pl-4 border-l border-slate-200 relative z-10 justify-end shrink-0 w-32">
                        <div class="flex items-center gap-[2px] h-4 w-10 justify-center" id="wave-container">
                            <div class="wave-bar w-[2px] bg-blue-500 rounded-full h-1 transition-all"></div>
                            <div class="wave-bar w-[2px] bg-blue-400 rounded-full h-1 transition-all"></div>
                            <div class="wave-bar w-[2px] bg-blue-600 rounded-full h-1 transition-all"></div>
                        </div>
                        <span id="status-desc" class="text-[9px] font-black text-slate-400 uppercase tracking-widest w-full text-left">SIAP</span>
                    </div>
                </div>
            </div>
        </div>

        @php
            $mahasiswaId = Auth::guard('mahasiswa')->id();
            $jumlahSelesai = 0;
            $jumlahBelum = 0;

            foreach($assignments as $tugas) {
                $sub = \App\Models\Submission::where('assignment_id', $tugas->id)
                            ->where('mahasiswa_id', $mahasiswaId)
                            ->first();

                // Cek apakah mahasiswa punya record pengumpulan di tugas ini yang terisi
                $isBenarSelesai = $sub && ($sub->file_path || $sub->text_submission || $sub->voice_submission || $sub->voice_url || $sub->text_online);

                if ($isBenarSelesai) {
                    $jumlahSelesai++;
                } else {
                    $jumlahBelum++;
                }
            }
        @endphp

        <div class="max-w-6xl mx-auto w-full p-6 lg:p-8 space-y-8 pb-20">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div data-aos="fade-up" data-aos-duration="600" class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-slate-900 leading-none">{{ $assignments->count() }} Tugas</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Total Semester Ini</p>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-duration="600" data-aos-delay="100" class="bg-white p-6 rounded-[2rem] border border-orange-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-orange-600 leading-none">{{ $jumlahBelum }} Aktif</h3>
                        <p class="text-[10px] font-bold text-orange-400 uppercase tracking-widest mt-1">Perlu Dikerjakan</p>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div>
                    <div data-aos="fade-in" class="flex items-center justify-between mb-4 px-2">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Daftar Semua Tugas</h3>
                    </div>

                    <div data-aos="fade-up" data-aos-duration="600" class="bg-white rounded-[2.5rem] p-6 border border-slate-200 shadow-sm space-y-4">
                        
                        @forelse($assignments as $index => $tugas)
                            @php
                                $subData = \App\Models\Submission::where('assignment_id', $tugas->id)
                                    ->where('mahasiswa_id', Auth::guard('mahasiswa')->id())
                                    ->first();

                                $isSelesai = $subData && ($subData->file_path || $subData->text_submission || $subData->text_online || $subData->voice_submission || $subData->voice_url);
                                
                                $borderClass = $isSelesai ? 'border-emerald-200 hover:bg-emerald-50 bg-emerald-50/20' : 'border-slate-100 hover:border-orange-200 hover:bg-orange-50/30';
                                $lineClass = $isSelesai ? 'bg-emerald-400' : 'bg-orange-400';
                                $iconBg = $isSelesai ? 'bg-emerald-100 text-emerald-700' : 'bg-orange-100 text-orange-700';
                            @endphp

                            <a href="{{ route('mahasiswa.assignment.detail', ['kelas' => $kelas->id,'assignment' => $tugas->id]) }}" class="group flex flex-col md:flex-row items-start md:items-center gap-4 p-4 rounded-2xl border {{ $borderClass }} transition-all cursor-pointer relative overflow-hidden block">
                                <div class="absolute left-0 top-0 bottom-0 w-1 {{ $lineClass }} rounded-l-2xl"></div>
                                <div class="flex items-center gap-4 flex-1">
                                    <div class="w-12 h-12 rounded-xl {{ $iconBg }} flex items-center justify-center shrink-0 font-black text-sm shadow-sm group-hover:scale-105 transition-transform">
                                        {{ $index + 5 }} 
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-800">{{ $tugas->judul }}</h4>
                                        <div class="flex items-center gap-2 mt-1 text-xs font-medium {{ $isSelesai ? 'text-emerald-600' : 'text-orange-600' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <span>Tenggat: {{ \Carbon\Carbon::parse($tugas->deadline)->translatedFormat('d M Y, H:i') }} WIB</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col md:flex-row items-end md:items-center gap-3 shrink-0 mt-3 md:mt-0 w-full md:w-auto">
                                    @if($isSelesai)
                                        @if($subData->nilai !== null)
                                            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[9px] font-bold uppercase tracking-widest">Nilai: {{ $subData->nilai }}</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-[9px] font-bold uppercase tracking-widest">Menunggu Nilai</span>
                                        @endif
                                    @else
                                        <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-[9px] font-bold uppercase tracking-widest">Belum Dikumpulkan</span>
                                    @endif
                                    
                                    <span class="w-full text-center md:w-auto px-4 py-2 rounded-xl bg-white border-2 border-slate-100 text-slate-700 font-bold text-[10px] uppercase tracking-widest group-hover:bg-slate-800 group-hover:text-white group-hover:border-transparent transition-all">Buka</span>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-slate-400 font-bold text-sm">Belum ada tugas di kelas ini.</p>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, easing: "ease-out-cubic" });

        // Data Tugas Dinamis Untuk Navigasi Suara
        const tugasList = [
            @foreach($assignments as $index => $tugas)
                {
                    id: {{ $tugas->id }},
                    judul: "{{ addslashes($tugas->judul) }}",
                    voiceId: {{ $index + 5 }}
                },
            @endforeach
        ];

        const statusDesc = document.getElementById("status-desc");
        const waveBars = document.querySelectorAll(".wave-bar");
        const synth = window.speechSynthesis;
        const SpeechRec = window.webkitSpeechRecognition || window.SpeechRecognition;
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
                    bar.style.height = active ? `${Math.floor(Math.random() * 12) + 4}px` : "4px";
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

            if (nomor === 0 || nomor === 1) {
                tujuan = "{{ route('course.detail', $kelas->id) }}";
                teks = nomor === 0 ? "Kembali ke Beranda Kelas." : "Membuka halaman Pembelajaran.";
            } 
            else if (nomor === 2) {
                @if(isset($session) && $session)
                    tujuan = "{{ route('course.attendance', $session->id) }}";
                    teks = "Membuka halaman Presensi.";
                @else
                    tujuan = "#";
                    teks = "Halaman presensi belum tersedia di kelas ini karena belum ada sesi yang dibuat dosen.";
                @endif
            } 
            else if (nomor === 3) {
                tujuan = "#";
                teks = "Anda sudah berada di halaman Penugasan.";
            } 
            else if (nomor === 4) {
                tujuan = "{{ route('course.members', $kelas->id) }}";
                teks = "Membuka daftar Anggota kelas.";
            } 
            else if (nomor >= 5) {
                let tugasTujuan = tugasList.find(t => t.voiceId === nomor);
                if(tugasTujuan) {
                    // Penulisan aman link tugas
                    tujuan = "{{ url('/mata-kuliah') }}/{{ $kelas->id }}/penugasan/" + tugasTujuan.id;
                    teks = "Membuka Tugas " + tugasTujuan.judul + ".";
                } else {
                    teks = "Nomor tugas tidak ditemukan.";
                }
            }

            if (teks !== "") {
                bicara(teks);
                if (tujuan !== "" && tujuan !== "#") {
                    setTimeout(() => {
                        window.location.href = tujuan;
                    }, 1500);
                } else {
                    // Restart mic jika tujuannya '#'
                    setTimeout(() => { if(rec) rec.start(); }, 1500);
                }
            }
        }

        function mulaiMendengar() {
            if (!rec) return;
            try {
                rec.start();
                rec.onresult = (event) => {
                    const hasil = event.results[event.results.length - 1][0].transcript.toLowerCase().trim();
                    
                    const kataAngka = {
                        "nol": 0, "satu": 1, "dua": 2, "tiga": 3, "empat": 4, "lima": 5, 
                        "enam": 6, "tujuh": 7, "delapan": 8, "sembilan": 9, "sepuluh": 10,
                        "sebelas": 11, "dua belas": 12, "tiga belas": 13, "empat belas": 14, "lima belas": 15
                    };

                    let terdeteksiAngka = null;
                    const regexAngka = hasil.match(/\d+/);
                    
                    if (regexAngka) {
                        terdeteksiAngka = parseInt(regexAngka[0]);
                    } else {
                        for (let kata in kataAngka) {
                            if (hasil.includes(kata)) { terdeteksiAngka = kataAngka[kata]; break; }
                        }
                    }

                    if (terdeteksiAngka !== null) { 
                        navigasiKe(terdeteksiAngka); 
                    }
                    else if (hasil.includes("kembali") || hasil.includes("beranda")) { navigasiKe(0); }
                    else if (hasil.includes("pembelajaran") || hasil.includes("materi")) { navigasiKe(1); }
                    else if (hasil.includes("presensi") || hasil.includes("absen")) { navigasiKe(2); }
                    else if (hasil.includes("penugasan") || hasil.includes("tugas")) { navigasiKe(3); }
                    else if (hasil.includes("anggota") || hasil.includes("peserta")) { navigasiKe(4); }
                };
                
                rec.onend = () => { rec.start(); };
            } catch (e) { console.error("Error recognition:", e); }
        }

        window.onload = () => {
            let totalTugas = {{ $assignments->count() }};
            let orientasi = "";
            
            if (totalTugas > 0) {
                orientasi = "Anda berada di Halaman Daftar Tugas. Sebutkan angka lima ke atas untuk membuka tugas spesifik, atau sebutkan angka nol untuk kembali ke beranda kelas.";
            } else {
                orientasi = "Anda berada di Halaman Daftar Tugas. Saat ini belum ada tugas yang diberikan oleh dosen. Sebutkan angka nol untuk kembali.";
            }

            document.body.addEventListener("click", () => {}, { once: true });
            setTimeout(() => { bicara(orientasi, () => { mulaiMendengar(); }); }, 800);
        };
    </script>
</body>
</html>