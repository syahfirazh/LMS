<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Pemberitahuan | LMS Inklusi UMMI</title>

        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

        <style>
            .custom-scrollbar::-webkit-scrollbar { width: 5px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        </style>
    </head>

    <body class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-screen flex flex-col lg:flex-row border-box text-slate-800 custom-scrollbar">
        <div id="mobileBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden transition-opacity"></div>

        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-80 bg-white border-r border-slate-200 flex flex-col h-screen transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="p-8 border-b border-slate-100 flex items-center gap-4">
                <img src="{{ asset('images/logo-ummi.png') }}" class="w-10 h-10 object-contain" alt="Logo UMMI" onerror="this.src = 'https://via.placeholder.com/40'" />
                <div>
                    <h1 class="text-lg font-black text-slate-900 tracking-tight leading-none">LMS Inklusi</h1>
                    <p class="text-[9px] font-bold text-blue-600 uppercase tracking-widest mt-1">Portal Mahasiswa</p>
                </div>
                <button onclick="toggleSidebar()" class="lg:hidden ml-auto text-slate-400 hover:text-slate-600 cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <nav class="flex-1 p-6 space-y-3 overflow-y-auto custom-scrollbar">
                <a href="{{ route('dashboard') ?? '#' }}" onclick="navigasiKe(5); return false;" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span>Beranda</span>
                    </div>
                    <span class="text-[10px] bg-black text-white px-2 py-1 rounded-lg font-black shadow-sm">5</span>
                </a>

                <a href="{{ route('profile') ?? '#' }}" onclick="navigasiKe(6); return false;" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>Profil Saya</span>
                    </div>
                    <span class="text-[10px] bg-black text-white px-2 py-1 rounded-lg font-black shadow-sm">6</span>
                </a>

                <a href="{{ route('notifications') ?? '#' }}" onclick="navigasiKe(7); return false;" class="flex items-center justify-between p-4 bg-blue-50 text-blue-700 rounded-2xl font-bold transition-all shadow-sm border border-blue-100">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span>Pemberitahuan</span>
                    </div>
                    <span class="text-[10px] bg-black text-white px-2 py-1 rounded-lg font-black shadow-sm">7</span>
                </a>

                <a href="{{ route('messages') ?? '#' }}" onclick="navigasiKe(8); return false;" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        <span>Pesan</span>
                    </div>
                    <span class="text-[10px] bg-black text-white px-2 py-1 rounded-lg font-black shadow-sm">8</span>
                </a>

                <a href="{{ route('help') ?? '#' }}" onclick="navigasiKe(9); return false;" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Bantuan</span>
                    </div>
                    <span class="text-[10px] bg-black text-white px-2 py-1 rounded-lg font-black shadow-sm">9</span>
                </a>
            </nav>

            <div class="p-6 border-t border-slate-100">
                <button onclick="navigasiKe(0)" class="w-full p-4 flex items-center justify-between text-red-600 font-bold bg-red-50 rounded-2xl hover:bg-red-100 transition-all border border-red-100 cursor-pointer">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Keluar</span>
                    </div>
                    <span class="text-[10px] bg-black text-white px-2 py-1 rounded-lg font-black shadow-sm">0</span>
                </button>
            </div>
        </aside>

        <main class="flex-1 min-h-screen flex flex-col relative lg:ml-80 transition-all duration-300 custom-scrollbar">
            <div class="absolute top-0 left-0 w-full h-80 bg-gradient-to-b from-blue-50 to-transparent -z-10"></div>

            <header class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-8 py-6 sticky top-0 z-30">
                <div class="max-w-7xl mx-auto flex items-center justify-between h-14">
                    <div class="flex items-center gap-4">
                        <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg cursor-pointer">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                        <div>
                            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pemberitahuan</h2>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Informasi Akademik</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-3 pr-4 border-r border-slate-200">
                            <button onclick="navigasiKe(7)" class="relative p-2 text-slate-400 hover:text-blue-600 transition-all cursor-pointer">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                @if($unreadCount > 0)
                                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                                @endif
                            </button>
                            <button onclick="navigasiKe(9)" class="p-2 text-slate-400 hover:text-blue-600 transition-all cursor-pointer">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </button>
                        </div>
                        <div class="hidden md:flex items-center gap-3 pl-4">
                            <div id="wave-container" class="flex items-center gap-[2px] h-4 w-10 justify-center">
                                <div class="wave-bar w-[2px] bg-blue-500 rounded-full h-1 transition-all"></div>
                                <div class="wave-bar w-[2px] bg-blue-400 rounded-full h-1 transition-all"></div>
                                <div class="wave-bar w-[2px] bg-blue-600 rounded-full h-1 transition-all"></div>
                            </div>
                            <span id="status-desc" class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Siap</span>
                        </div>
                    </div>
                </div>
            </header>

            <div class="p-6 lg:p-10 max-w-6xl mx-auto w-full space-y-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest">Terbaru ({{ $unreadCount ?? 0 }})</h3>
                    @if($unreadCount > 0)
                    <form method="POST" action="{{ route('notifications.read') }}">
                        @csrf
                        <button class="text-[10px] font-bold text-blue-600 uppercase tracking-widest hover:underline hover:text-blue-700 transition-all cursor-pointer">
                            Tandai semua dibaca
                        </button>
                    </form>
                    @endif
                </div>

                <div class="space-y-4">
                    @forelse ($notifications as $notif)
                    <div onclick="window.location.href='{{ $notif->url ?? '#' }}'" class="bg-white p-8 rounded-[2.5rem] border-l-8 {{ $notif->is_read ? 'border-slate-200 opacity-80' : 'border-blue-500' }} shadow-sm hover:shadow-lg transition-all flex flex-col md:flex-row items-start md:items-center gap-6 cursor-pointer group">
                        <div class="w-16 h-16 bg-blue-50 rounded-3xl flex items-center justify-center text-blue-600 shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <div class="flex-1 w-full">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ $notif->title }}</h4>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50 px-2 py-1 rounded-lg whitespace-nowrap">{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-slate-500 leading-relaxed font-medium">{{ $notif->message }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10 bg-white rounded-[2.5rem] border border-slate-100">
                        <p class="text-slate-400 font-bold">Tidak ada pemberitahuan.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </main>
        
        @php
            $voiceText = '';
            if ($unreadCount > 0) {
                $voiceText .= "Halo, Anda memiliki {$unreadCount} pemberitahuan baru. ";
                foreach ($notifications->take(3) as $notif) {
                    $voiceText .= "Pemberitahuan: {$notif->title}. {$notif->message}. ";
                }
            } else {
                $voiceText .= "Halo, saat ini tidak ada pemberitahuan baru.";
            }
            $voiceText .= " Silakan ucapkan angka lima untuk Beranda, enam untuk Profil, tujuh untuk Pemberitahuan, delapan untuk Pesan, sembilan untuk Bantuan, dan nol untuk Keluar.";
        @endphp

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({ once: true, easing: "ease-out-cubic" });

            function toggleSidebar() {
                const sidebar = document.getElementById("sidebar");
                const backdrop = document.getElementById("mobileBackdrop");
                sidebar.classList.toggle("-translate-x-full");
                backdrop.classList.toggle("hidden");
            }

            const statusDesc = document.getElementById("status-desc");
            const waveBars = document.querySelectorAll(".wave-bar");
            const synth = window.speechSynthesis;

            const SpeechRec = window.webkitSpeechRecognition || window.SpeechRecognition;
            let rec = null;

            if (SpeechRec) {
                rec = new SpeechRec();
                rec.lang = "id-ID";
                rec.continuous = true;

                // PERBAIKAN 2: Cegah Infinite Loop Jika Mikrofon Diblokir
                rec.onerror = (event) => {
                    console.error("Mic Error:", event.error);
                    if (event.error === 'not-allowed' || event.error === 'service-not-allowed') {
                        rec.onend = null; // Hentikan loop start
                        if(statusDesc) statusDesc.innerText = "MIC DIBLOKIR";
                    }
                };
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

            let interval;
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

            // PERBAIKAN 1: Pindah halaman SETELAH suara selesai bicara
            function navigasiKe(nomor) {
                let tujuan = ""; let teks = "";

                if (nomor === 5) { tujuan = "{{ route('dashboard') ?? '#' }}"; teks = "Kembali ke Beranda."; }
                else if (nomor === 6) { tujuan = "{{ route('profile') ?? '#' }}"; teks = "Membuka Profil Saya."; }
                else if (nomor === 7) { teks = "Anda sudah berada di Halaman Pemberitahuan."; }
                else if (nomor === 8) { tujuan = "{{ route('messages') ?? '#' }}"; teks = "Membuka Pesan."; }
                else if (nomor === 9) { tujuan = "{{ route('help') ?? '#' }}"; teks = "Membuka Bantuan."; }
                else if (nomor === 0) { tujuan = "{{ route('logout') ?? '#' }}"; teks = "Keluar akun. Sampai jumpa."; }

                if (teks !== "") {
                    // Jika ada link tujuan, pindah halaman setelah bicara selesai
                    if (tujuan !== "" && tujuan !== "#") {
                        bicara(teks, () => {
                            window.location.href = tujuan;
                        });
                    } else {
                        bicara(teks); // Jika hanya info (seperti no 7)
                    }
                }
            }

            function mulaiMendengar() {
                if (!rec) return;
                try {
                    rec.start();
                    rec.onresult = (event) => {
                        const hasil = event.results[event.results.length - 1][0].transcript.toLowerCase().trim();
                        const angka = hasil.match(/\d+/);

                        if (angka) navigasiKe(parseInt(angka[0]));
                        else if (hasil.includes("lima") || hasil.includes("beranda")) navigasiKe(5);
                        else if (hasil.includes("enam") || hasil.includes("profil")) navigasiKe(6);
                        else if (hasil.includes("tujuh") || hasil.includes("pemberitahuan")) navigasiKe(7);
                        else if (hasil.includes("delapan") || hasil.includes("pesan")) navigasiKe(8);
                        else if (hasil.includes("sembilan") || hasil.includes("bantuan")) navigasiKe(9);
                        else if (hasil.includes("nol") || hasil.includes("keluar")) navigasiKe(0);
                    };

                    // Loop terus mendengarkan selama tidak error
                    if(rec.onend !== null) {
                         rec.onend = () => { rec.start(); };
                    }
                } catch (e) {
                    console.error("Error recognition:", e);
                }
            }

            // PERBAIKAN 3: Memastikan suara terpicu (User wajib interaksi kalau diblokir Chrome)
            window.onload = () => {
                const orientasi = @json($voiceText);
                
                // Coba bicara otomatis
                setTimeout(() => { 
                    bicara(orientasi, () => { mulaiMendengar(); }); 
                }, 800);

                // Cadangan: Jika diblokir oleh browser autoplay policy, klik di mana saja untuk memutar
                document.body.addEventListener("click", () => {
                    if(synth.speaking === false && statusDesc.innerText === "Siap") {
                        bicara(orientasi, () => { mulaiMendengar(); });
                    }
                }, { once: true });
            };
        </script>
    </body>
</html>