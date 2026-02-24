<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Daftar Mata Kuliah | LMS Inklusi UMMI</title>

        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

        <style>
            .custom-scrollbar::-webkit-scrollbar { width: 5px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        </style>
    </head>
    <body class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-full flex flex-col border-box overflow-x-hidden text-slate-800">
        
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute top-[-10%] right-[-5%] w-[400px] h-[400px] bg-blue-100/40 rounded-full blur-3xl opacity-50"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] bg-indigo-50/40 rounded-full blur-3xl opacity-50"></div>
        </div>

        <main class="flex-1 flex flex-col h-screen overflow-y-auto custom-scrollbar relative">
            
            <div class="bg-white/90 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm transition-all w-full">
                <div class="max-w-7xl mx-auto flex items-center justify-between relative">
                    <div class="flex items-center gap-4 relative z-10 md:w-auto w-full justify-start">
                        <button onclick="navigasiKe(0)" class="w-11 h-11 md:w-12 md:h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm shrink-0 group border border-slate-200 hover:border-blue-600 relative cursor-pointer">
                            <svg class="w-5 h-5 md:w-6 md:h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            <span class="absolute -bottom-1 -right-1 bg-slate-800 text-white text-[9px] font-black px-1.5 py-0.5 rounded-md border border-white">0</span>
                        </button>
                        <div class="hidden sm:block text-left cursor-pointer group" onclick="navigasiKe(0)">
                            <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest">Navigasi Suara</span>
                            <span class="block text-xs font-black text-slate-700 group-hover:text-blue-600 transition-colors">0 - Kembali</span>
                        </div>
                    </div>

                    <div class="text-center absolute left-1/2 transform -translate-x-1/2 w-full max-w-[60%] md:max-w-md mt-2 md:mt-0">
                        <h1 class="text-lg md:text-2xl font-black text-slate-900 tracking-tight leading-tight truncate">
                            Daftar Mata Kuliah
                        </h1>
                        <div class="flex items-center justify-center gap-2 mt-1">
                            <span class="text-[9px] md:text-[10px] font-bold text-blue-600 uppercase tracking-widest bg-blue-100 px-2 py-0.5 rounded-md">
                                Sem. Berjalan
                            </span>
                            <span class="text-[10px] md:text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">
                                2025/2026
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pl-6 border-l border-slate-200 relative z-10 justify-end">
                        <div class="flex items-center gap-[2px] h-4 w-10 justify-center" id="wave-container">
                            <div class="wave-bar w-[2px] bg-blue-500 rounded-full h-1 transition-all"></div>
                            <div class="wave-bar w-[2px] bg-blue-400 rounded-full h-1 transition-all"></div>
                            <div class="wave-bar w-[2px] bg-blue-600 rounded-full h-1 transition-all"></div>
                        </div>
                        <span id="status-desc" class="hidden md:block text-[9px] font-black text-slate-400 uppercase tracking-widest">Siap</span>
                    </div>
                </div>
            </div>

            <div class="max-w-4xl mx-auto w-full p-4 md:p-8 space-y-5 pt-6 md:pt-8 pb-20">
                
                @if(count($kelas) > 0)
                    @foreach ($kelas as $i => $item)
                    @php
                        $nomor = $item['nomor']; // Ini diambil dari array Controller (1, 2, 3...)

                        // mapping warna berdasarkan urutan
                        $themes = [
                            0 => ['blue', 'blue'],
                            1 => ['orange', 'orange'],
                            2 => ['indigo', 'indigo'],
                        ];
                        $theme = $themes[$i % 3];
                    @endphp

                    <div data-aos="fade-up" data-aos-duration="600" data-aos-delay="{{ $i * 100 }}" onclick="window.location.href='{{ route('course.detail', ['kelas' => $item['id']]) }}'" class="group relative bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer overflow-hidden flex flex-col sm:flex-row items-start sm:items-center gap-5">
                        
                        {{-- STRIP KIRI KECIL --}}
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-{{ $theme[0] }}-500 group-hover:w-2 transition-all"></div>

                        {{-- NOMOR --}}
                        <div class="flex w-full sm:w-auto items-center justify-between sm:justify-start">
                            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-{{ $theme[0] }}-50 text-{{ $theme[0] }}-600 flex items-center justify-center shrink-0 border border-{{ $theme[0] }}-100 group-hover:bg-{{ $theme[0] }}-600 group-hover:text-white transition-all shadow-inner">
                                <span class="text-xl sm:text-2xl font-black tracking-tighter">
                                    {{ $nomor }}
                                </span>
                            </div>
                            <span class="sm:hidden px-4 py-2 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest">
                                Masuk
                            </span>
                        </div>

                        {{-- INFO MATKUL --}}
                        <div class="flex-1 min-w-0 w-full sm:pl-2">
                            <div class="flex items-center gap-3 mb-1">
                                <h2 class="text-lg sm:text-xl font-black text-slate-900 group-hover:text-{{ $theme[0] }}-700 transition-colors tracking-tight truncate">
                                    {{ $item['nama'] }}
                                </h2>
                                <span class="px-2 py-1 rounded-md bg-emerald-50 text-emerald-600 text-[9px] sm:text-[10px] font-bold uppercase border border-emerald-100 shrink-0">
                                    {{ $item['sks'] }} SKS
                                </span>
                            </div>

                            <div class="flex items-center gap-2 text-xs sm:text-sm font-medium text-slate-500 mb-3 sm:mb-4">
                                <span>{{ $item['kode'] }}</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                <span class="truncate">{{ Str::limit($item['deskripsi'], 60) }}</span>
                            </div>

                            {{-- PROGRESS BELAJAR --}}
                            <div class="flex items-center gap-3 w-full max-w-sm">
                                <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-{{ $theme[0] }}-500 rounded-full transition-all duration-1000" style="width: {{ $item['progress'] }}%"></div>
                                </div>
                                <span class="text-[10px] font-bold text-{{ $theme[0] }}-600 shrink-0">
                                    {{ $item['progress'] }}% Selesai
                                </span>
                            </div>
                        </div>

                        {{-- TOMBOL (DESKTOP) --}}
                        <button class="hidden sm:flex bg-slate-900 text-white px-8 py-4 rounded-xl font-black text-xs uppercase tracking-wider shadow-md group-hover:bg-{{ $theme[0] }}-600 transition-all pointer-events-none">
                            Masuk
                        </button>
                    </div>
                    @endforeach
                @else
                    {{-- TAMPILAN JIKA BELUM ADA KELAS SAMA SEKALI --}}
                    <div class="flex flex-col items-center justify-center py-20 text-center" data-aos="fade-up">
                        <div class="w-24 h-24 bg-slate-100 text-slate-300 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h2 class="text-xl font-black text-slate-800 mb-2">Belum Ada Mata Kuliah</h2>
                        <p class="text-sm text-slate-500 max-w-md">Anda belum tergabung di kelas manapun. Silakan gunakan menu Gabung Kelas untuk mendaftar menggunakan Kode Akses Dosen.</p>
                        <a href="{{ route('courses.join') }}" class="mt-6 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-blue-200 transition-all">Gabung Kelas Sekarang</a>
                    </div>
                @endif
                
            </div>
        </main>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

        <script>
            // INIT ANIMASI
            AOS.init({ once: true, easing: "ease-out-cubic" });

            // Menyiapkan Data Kelas dari PHP ke format Array JavaScript
            const kelasList = [
                @foreach($kelas as $k)
                    {
                        nomor: {{ $k['nomor'] }},
                        nama: "{{ $k['nama'] }}",
                        url: "{{ route('course.detail', ['kelas' => $k['id']]) }}"
                    },
                @endforeach
            ];

            // ==========================================
            // LOGIKA VOICE ASSISTANT
            // ==========================================
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
            } else {
                console.warn("Browser tidak mendukung Web Speech API");
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

                // Ambil kecepatan suara dari pengaturan (jika ada)
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
                    teks = "Kembali ke Dashboard utama.";
                } else {
                    // Cari kelas berdasarkan nomor yang disebutkan
                    let kelasTujuan = kelasList.find(k => k.nomor === nomor);
                    if (kelasTujuan) {
                        tujuan = kelasTujuan.url;
                        teks = `Membuka detail kelas ${kelasTujuan.nama}.`;
                    } else {
                        teks = "Maaf, nomor kelas tidak ditemukan.";
                    }
                }

                if (teks !== "") {
                    bicara(teks);
                    setTimeout(() => {
                        if (tujuan !== "") window.location.href = tujuan;
                    }, 1500);
                }
            }

            function mulaiMendengar() {
                if (!rec) return;
                try {
                    rec.start();
                    rec.onresult = (event) => {
                        const hasil = event.results[event.results.length - 1][0].transcript.toLowerCase().trim();
                        
                        // Objek Konversi Kata ke Angka
                        const kataAngka = {
                            "nol": 0, "satu": 1, "dua": 2, "tiga": 3, "empat": 4, "lima": 5, 
                            "enam": 6, "tujuh": 7, "delapan": 8, "sembilan": 9, "sepuluh": 10,
                            "sebelas": 11, "dua belas": 12, "tiga belas": 13, "empat belas": 14, "lima belas": 15
                        };

                        let terdeteksiAngka = null;
                        const regexAngka = hasil.match(/\d+/);
                        
                        // Cek angka numerik (1, 2, 3)
                        if (regexAngka) {
                            terdeteksiAngka = parseInt(regexAngka[0]);
                        } else {
                            // Cek angka huruf (satu, dua, tiga)
                            for (let kata in kataAngka) {
                                if (hasil.includes(kata)) { 
                                    terdeteksiAngka = kataAngka[kata]; 
                                    break; 
                                }
                            }
                        }

                        // Eksekusi Navigasi
                        if (terdeteksiAngka !== null) {
                            navigasiKe(terdeteksiAngka);
                        } else if (hasil.includes("kembali") || hasil.includes("beranda")) {
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

            // AUTO-START KETIKA HALAMAN DIMUAT
            window.onload = () => {
                let orientasi = "";
                
                // Jika kelas kosong
                if (kelasList.length === 0) {
                    orientasi = "Anda belum mendaftar di mata kuliah apapun. Silakan kembali ke menu utama dengan menyebutkan angka nol, lalu cari menu gabung kelas.";
                } 
                // Jika ada kelas
                else {
                    orientasi = `Daftar mata kuliah aktif. Anda memiliki ${kelasList.length} kelas. `;
                    
                    // Baca maksimal 3 kelas pertama agar tidak kelamaan
                    let maxRead = kelasList.length > 3 ? 3 : kelasList.length;
                    for (let i = 0; i < maxRead; i++) {
                        orientasi += `Sebutkan angka ${kelasList[i].nomor} untuk membuka kelas ${kelasList[i].nama}. `;
                    }
                    
                    if(kelasList.length > 3) orientasi += "Dan seterusnya. ";
                    orientasi += "Sebutkan angka nol jika Anda ingin kembali ke halaman utama.";
                }

                document.body.addEventListener("click", () => {}, { once: true });

                setTimeout(() => {
                    bicara(orientasi, () => {
                        mulaiMendengar();
                    });
                }, 800);
            };
        </script>
    </body>
</html>