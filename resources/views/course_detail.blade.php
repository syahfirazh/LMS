<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Pembelajaran - {{ $kelas->mataKuliah->nama }} | LMS Inklusi UMMI</title>

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
                        <a href="{{ route('courses.index') }}" class="w-11 h-11 md:w-12 md:h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm shrink-0 group border border-slate-200 hover:border-blue-600 relative cursor-pointer active:scale-95">
                            <svg class="w-5 h-5 md:w-6 md:h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            <span class="absolute -bottom-1 -right-1 bg-slate-800 text-white text-[9px] font-black px-1.5 py-0.5 rounded-md border border-white">0</span>
                        </a>
                        
                        <a href="{{ route('courses.index') }}" class="hidden sm:block text-left cursor-pointer group shrink-0 decoration-transparent">
                            <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest">Navigasi Suara</span>
                            <span class="block text-xs font-black text-slate-700 group-hover:text-blue-600 transition-colors">0 - Kembali</span>
                        </a>
                        
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
                            <button onclick="navigasiKe(1)" class="cursor-pointer active:scale-95 snap-start shrink-0 px-5 py-2 rounded-lg bg-white text-blue-700 font-bold text-[10px] uppercase tracking-widest shadow-sm border border-slate-200 whitespace-nowrap transition-all">
                                1. Pembelajaran
                            </button>
                            <button onclick="navigasiKe(2)" class="cursor-pointer active:scale-95 snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-white/50 font-bold text-[10px] uppercase tracking-widest border border-transparent whitespace-nowrap transition-all">
                                2. Presensi
                            </button>
                            <button onclick="navigasiKe(3)" class="cursor-pointer active:scale-95 snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-white/50 font-bold text-[10px] uppercase tracking-widest border border-transparent whitespace-nowrap transition-all">
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

            <div class="max-w-6xl mx-auto w-full p-4 md:p-6 lg:p-8 space-y-6 pb-20">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <div class="lg:col-span-2 space-y-6">
                        <div data-aos="fade-up" data-aos-duration="600" class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex flex-col md:flex-row gap-6 items-start">
                            <div class="w-full md:w-1/3 h-48 md:h-40 rounded-2xl overflow-hidden relative group shrink-0">
                                <img src="{{ $kelas->sampul ? asset('storage/'.$kelas->sampul) : asset('images/course-banner.jpg') }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="Thumbnail" />
                                <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest text-slate-900">
                                    {{ $kelas->mataKuliah->kode }}
                                </div>
                            </div>
                            
                            <div class="flex-1 space-y-3">
                                <h2 class="text-lg font-black text-slate-900 leading-tight">
                                    {{ $kelas->mataKuliah->nama }}
                                </h2>
                                <p id="deskripsi-matkul" class="text-sm font-medium text-slate-500 leading-relaxed line-clamp-3">
                                    {{ $kelas->mataKuliah->deskripsi }}
                                </p>
                                <div class="pt-2 flex gap-2">
                                    <span class="px-3 py-1 bg-blue-50 text-blue-700 text-[9px] font-bold uppercase tracking-wider rounded-lg">{{ $kelas->mataKuliah->sks }} SKS</span>
                                </div>
                            </div>
                        </div>

                        <div data-aos="fade-up" data-aos-duration="600" data-aos-delay="100" class="bg-blue-600 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-lg shadow-blue-200/50">
                            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
                                <div>
                                    <p class="text-blue-200 text-[10px] font-bold uppercase tracking-widest mb-1">Progres Belajar Anda</p>
                                    
                                    @php
                                        // LOGIKA BARU PROGRES 50% & 100%
                                        $totalSesi = $kelas->courseSessions->count();
                                        $sesiSelesai = 0;
                                        
                                        if($totalSesi > 0) {
                                            foreach($kelas->courseSessions as $idx => $ss) {
                                                $adaMateri = $ss->materis && $ss->materis->count() > 0;
                                                $adaDiskusi = $ss->discussions && $ss->discussions->count() > 0;
                                                
                                                if($adaMateri && $adaDiskusi) {
                                                    $sesiSelesai += 1; // 100% Selesai untuk sesi ini
                                                } else {
                                                    $sesiSelesai += 0.5; // 50% Baru terbuka (semua otomatis terbuka)
                                                }
                                            }
                                        }
                                        $persenProgres = $totalSesi > 0 ? min(100, round(($sesiSelesai / $totalSesi) * 100)) : 0;
                                    @endphp

                                    <h3 class="text-3xl font-black tracking-tight">{{ $persenProgres }}% Selesai</h3>
                                    <p class="text-[10px] text-blue-200 font-bold">{{ floor($sesiSelesai) }} dari {{ $totalSesi }} pertemuan penuh</p>
                                </div>
                                
                                @php
                                    $currentSession = $kelas->courseSessions->first(function($s) {
                                        return true; 
                                    }) ?? $kelas->courseSessions->last();
                                @endphp

                                @if ($currentSession)
                                    <button onclick="bukaSession({{ $currentSession->id }})" class="cursor-pointer active:scale-95 bg-white text-blue-600 px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-50 transition-all shadow-md w-full md:w-auto">
                                        Lanjut Materi (Pertemuan {{ $currentSession->urutan }})
                                    </button>
                                @endif
                            </div>
                            
                            <div class="absolute -right-6 -bottom-10 opacity-20 pointer-events-none">
                                <svg class="w-40 h-40" viewBox="0 0 200 200" fill="currentColor">
                                    <path d="M45,-75.4C58.9,-69.3,71.4,-59.1,79.9,-46.3C88.4,-33.5,92.9,-18.1,89.6,-3.3C86.3,11.5,75.2,25.7,64.2,38.2C53.2,50.7,42.3,61.5,29.9,67.3C17.5,73.1,3.6,73.9,-9.4,72.1C-22.4,70.3,-34.5,65.9,-45.6,58.8C-56.7,51.7,-66.8,41.9,-73.4,30.1C-80,18.3,-83.1,4.5,-79.8,-7.8C-76.5,-20.1,-66.8,-30.9,-56.3,-39.7C-45.8,-48.5,-34.5,-55.3,-22.8,-62.8C-11.1,-70.3,1,-78.5,14.3,-80.8L27.6,-83.1Z" transform="translate(100 100)" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div data-aos="fade-up" data-aos-duration="600" data-aos-delay="200" class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm h-fit">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Alur Belajar</h3>
                            <span class="text-[9px] font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded-md">{{ $totalSesi }} Pertemuan</span>
                        </div>

                        <div class="relative space-y-0 pl-2">
                            <div class="absolute top-4 left-[19px] bottom-4 w-[2px] bg-slate-100"></div>

                            @php $voiceId = 5; @endphp 
                            @forelse ($kelas->courseSessions as $index => $sess)
                                @php
                                    $adaMateri = $sess->materis && $sess->materis->count() > 0;
                                    $adaDiskusi = $sess->discussions && $sess->discussions->count() > 0;
                                    
                                    $isSelesai = $adaMateri && $adaDiskusi; 
                                @endphp

                                <div onclick="bukaSession({{ $sess->id }})" class="relative pl-10 py-3 group cursor-pointer active:scale-[0.98] transition-transform">
                                    
                                    <div class="absolute left-[10px] top-5 w-5 h-5 rounded-full border-4 border-white shadow-sm z-10 flex items-center justify-center 
                                        {{ $isSelesai ? 'bg-emerald-500' : 'bg-blue-600 animate-pulse' }}">
                                        
                                        @if ($isSelesai)
                                            <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7" /></svg>
                                        @endif
                                    </div>

                                    <div class="bg-white border border-blue-200 shadow-md shadow-blue-100 transform group-hover:scale-[1.02] p-4 rounded-2xl transition-all">
                                        <div class="flex justify-between items-start">
                                            <span class="text-[9px] font-black uppercase tracking-wider mb-1 block {{ $isSelesai ? 'text-emerald-600' : 'text-blue-600' }}">
                                                Pertemuan {{ $sess->urutan }}
                                            </span>
                                            <span class="text-[9px] font-bold text-slate-400 bg-white px-1.5 rounded border border-slate-200 shadow-sm">#{{ $voiceId }}</span>
                                        </div>
                                        <h4 class="text-xs font-bold uppercase text-slate-800">
                                            {{ $sess->judul ?? 'Materi Belum Diatur' }}
                                        </h4>
                                        @if ($isSelesai)
                                            <p class="text-[9px] text-emerald-500 mt-1 font-bold">Selesai 100%</p>
                                        @else
                                            <p class="text-[9px] text-blue-500 mt-1 font-bold">Progres 50%</p>
                                        @endif
                                    </div>
                                </div>
                                @php $voiceId++; @endphp
                            @empty
                                <div class="text-center py-4 text-xs font-bold text-slate-400">Belum ada sesi pertemuan di kelas ini.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({ once: true, easing: "ease-out-cubic" });

            // DATA SESI UNTUK VOICE NAVIGATOR
            const sesiList = [
                @php $vId = 5; @endphp
                @foreach($kelas->courseSessions as $sess)
                    {
                        id: {{ $sess->id }},
                        urutan: "{{ $sess->urutan }}",
                        judul: "{{ $sess->judul ?? 'Pertemuan '.$sess->urutan }}",
                        voiceId: {{ $vId }}
                    },
                    @php $vId++; @endphp
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

            // Fungsi untuk membuat panduan suara yang dinamis dan terperinci
            function getPanduanSuara() {
                const namaMatkul = "{{ $kelas->mataKuliah->nama }}";
                const deskripsiMatkul = document.getElementById('deskripsi-matkul').innerText.trim();
                
                let teks = `Anda berada di kelas mata kuliah ${namaMatkul}. Deskripsi: ${deskripsiMatkul}. `;
                teks += "Berikut adalah daftar Alur Belajar Anda. ";
                
                if (sesiList.length > 0) {
                    sesiList.forEach(s => {
                        teks += `Pertemuan ${s.urutan} dengan judul ${s.judul}. Sebutkan angka ${s.voiceId} untuk membuka materi tersebut. `;
                    });
                } else {
                    teks += "Saat ini belum ada materi pertemuan yang diunggah oleh dosen. ";
                }

                teks += "Untuk navigasi menu lainnya: Sebutkan angka satu untuk tetap di Pembelajaran, dua untuk Presensi, tiga untuk Penugasan, empat untuk Anggota kelas. Atau sebutkan angka nol untuk kembali. Katakan Ulang, jika Anda ingin mendengar panduan ini dari awal.";
                
                return teks;
            }

            function bukaSession(sessionId) {
                const url = "{{ route('topic.detail', ['kelas' => $kelas->id, 'session' => 'SESSION_ID']) }}";
                window.location.href = url.replace('SESSION_ID', sessionId);
            }

            const urlPembelajaran = "{{ route('course.detail', ['kelas' => $kelas->id]) }}";
            const urlPenugasan = "{{ route('course.assignments', ['kelas' => $kelas->id]) }}";
            const urlAnggota = "{{ route('course.members', ['kelas' => $kelas->id]) }}";
            const urlPresensi = "{{ $session ? route('course.attendance', ['session' => $session->id]) : '#' }}";

            function navigasiKe(nomor) {
                let tujuan = "";
                let teks = "";

                if (nomor === 0) {
                    tujuan = "{{ route('courses.index') }}";
                    teks = "Kembali ke Daftar Mata Kuliah.";
                } else if (nomor === 1) {
                    teks = "Anda sudah berada di halaman Pembelajaran.";
                } else if (nomor === 2) {
                    tujuan = urlPresensi;
                    teks = tujuan === '#' ? "Halaman presensi belum tersedia di kelas ini karena belum ada pertemuan." : "Membuka halaman Presensi.";
                } else if (nomor === 3) {
                    tujuan = urlPenugasan;
                    teks = "Membuka halaman Penugasan.";
                } else if (nomor === 4) {
                    tujuan = urlAnggota;
                    teks = "Membuka daftar Anggota kelas.";
                } else if (nomor >= 5) {
                    let sesiTujuan = sesiList.find(s => s.voiceId === nomor);
                    if(sesiTujuan) {
                        teks = `Membuka materi ${sesiTujuan.judul}.`;
                        const baseUrl = "{{ route('topic.detail', ['kelas' => $kelas->id, 'session' => 'SESSION_ID']) }}"; 
                        tujuan = baseUrl.replace('SESSION_ID', sesiTujuan.id);
                    } else {
                        teks = "Nomor pertemuan tidak ditemukan.";
                    }
                }

                if (teks !== "") {
                    bicara(teks);
                    if (tujuan !== "" && tujuan !== "#") {
                        setTimeout(() => { window.location.href = tujuan; }, 1500);
                    } else {
                        setTimeout(() => { if (rec) rec.start(); }, 1500);
                    }
                }
            }

            function mulaiMendengar() {
                if (!rec) return;
                try {
                    rec.start();
                    rec.onresult = (event) => {
                        const hasil = event.results[event.results.length - 1][0].transcript.toLowerCase().trim();
                        
                        // FUNGSI PANDUAN / ULANGI
                        if(hasil.includes("ulang") || hasil.includes("panduan") || hasil.includes("bantuan") || hasil.includes("tolong")) {
                            bicara(getPanduanSuara(), () => { mulaiMendengar(); });
                            return;
                        }

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
                        } else if (hasil.includes("kembali") || hasil.includes("daftar")) { navigasiKe(0); }
                        else if (hasil.includes("pembelajaran")) { navigasiKe(1); }
                        else if (hasil.includes("presensi")) { navigasiKe(2); }
                        else if (hasil.includes("penugasan")) { navigasiKe(3); }
                        else if (hasil.includes("anggota")) { navigasiKe(4); }
                    };
                    rec.onend = () => { rec.start(); };
                } catch (e) {
                    console.error("Error recognition:", e);
                }
            }

            window.onload = () => {
                let orientasi = getPanduanSuara();
                document.body.addEventListener("click", () => {}, { once: true });
                
                setTimeout(() => {
                    bicara(orientasi, () => { mulaiMendengar(); });
                }, 800);
            };
        </script>
    </body>
</html>