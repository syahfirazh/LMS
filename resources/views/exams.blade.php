<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Daftar Ujian | LMS Inklusi UMMI</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    
    <style>
        html { scroll-behavior: smooth; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .safe-fade-in { animation: fadeIn 0.6s ease-out forwards; opacity: 0; }
        
        /* Voice Wave Animation */
        @keyframes wave-bounce {
            0%, 100% { height: 4px; }
            50% { height: 16px; }
        }
        .wave-bar { transition: height 0.1s ease; }
    </style>
</head>
<body class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] text-slate-800 relative custom-scrollbar flex flex-col h-screen overflow-hidden">
    
    {{-- BACKGROUND DEKORASI (Nuansa Biru) --}}
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-[-10%] right-[-5%] w-[400px] h-[400px] bg-blue-100/40 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] bg-indigo-50/40 rounded-full blur-3xl opacity-50"></div>
    </div>

    {{-- NAVBAR & VOICE STATUS --}}
    <header class="bg-white/90 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm w-full shrink-0">
        <div class="max-w-7xl mx-auto flex items-center justify-between relative h-12">
            
            {{-- Kiri: Tombol 0 (Kembali ke Dashboard) --}}
            <div class="flex items-center gap-4 relative z-10 w-1/3 justify-start shrink-0">
                <button onclick="navigasiKe(0)" class="flex w-11 h-11 md:w-12 md:h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white items-center justify-center transition-all duration-300 shadow-sm shrink-0 group border border-slate-200 hover:border-blue-600 relative cursor-pointer active:scale-95">
                    <svg class="w-5 h-5 md:w-6 md:h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span class="absolute -bottom-1 -right-1 bg-slate-800 text-white text-[9px] font-black px-1.5 py-0.5 rounded-md border border-white">0</span>
                </button>
                <div class="hidden sm:block text-left cursor-pointer group shrink-0" onclick="navigasiKe(0)">
                    <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest">Navigasi Suara</span>
                    <span class="block text-xs font-black text-slate-700 group-hover:text-blue-600 transition-colors">0 - Kembali</span>
                </div>
            </div>

            {{-- Tengah: Judul (Center Absolute) --}}
            <div class="text-center absolute left-1/2 transform -translate-x-1/2 w-1/3 z-0 pointer-events-none flex flex-col items-center justify-center">
                <h1 class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight leading-none truncate pointer-events-auto">
                    Ujian Online
                </h1>
                <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1 truncate pointer-events-auto">
                    Daftar Ujian Tersedia
                </p>
            </div>

            {{-- Kanan: Indikator Voice --}}
            <div class="flex items-center justify-end gap-3 relative z-10 w-1/3 shrink-0">
                <div class="flex items-center gap-[2px] h-4 w-10 justify-center" id="wave-container">
                    <div class="wave-bar w-[2px] bg-blue-500 rounded-full h-1 transition-all"></div>
                    <div class="wave-bar w-[2px] bg-blue-400 rounded-full h-1 transition-all"></div>
                    <div class="wave-bar w-[2px] bg-blue-600 rounded-full h-1 transition-all"></div>
                </div>
                <span id="status-desc" class="hidden sm:block text-[9px] font-black text-slate-400 uppercase tracking-widest w-20 text-left">SIAP</span>
            </div>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto custom-scrollbar relative">
        <div class="p-4 sm:p-6 lg:p-10 max-w-5xl mx-auto w-full space-y-8 pb-24">
            
            {{-- Pesan Sukses Ujian Selesai --}}
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-bold text-sm safe-fade-in flex items-center gap-3 shadow-sm">
                    <div class="p-1.5 bg-emerald-100 rounded-lg shrink-0">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    {{ session('success') }}
                </div>
            @endif

            {{-- TOMBOL 1: MASUKKAN TOKEN --}}
            <div onclick="navigasiKe(1)" class="group bg-gradient-to-r from-blue-600 to-indigo-600 rounded-[2.5rem] p-6 md:p-8 text-white shadow-xl shadow-blue-200/50 cursor-pointer relative overflow-hidden transform hover:-translate-y-1 transition-all safe-fade-in" style="animation-delay: 0.1s">
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-white/20 border border-white/10 flex items-center justify-center backdrop-blur-md shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-black tracking-tight">Punya Token Ujian?</h2>
                            <p class="text-blue-50 text-sm font-medium mt-1">Gabung ujian dadakan atau kuis khusus menggunakan kode dari dosen.</p>
                        </div>
                    </div>
                    <button class="bg-white text-blue-700 px-8 py-3.5 rounded-xl font-black text-xs uppercase tracking-widest group-hover:bg-blue-50 transition-all shadow-lg flex items-center gap-2 shrink-0">
                        <span class="opacity-50 text-blue-400">1</span> Masukkan Token
                    </button>
                </div>
                <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
            </div>

            <div class="space-y-6">
                
                {{-- FILTER TABS --}}
                <div class="flex gap-2 border-b border-slate-200 mb-6 safe-fade-in overflow-x-auto custom-scrollbar pb-2" style="animation-delay: 0.2s" id="filterTabs">
                    <button onclick="filterExams('Semua', this)" class="tab-btn px-6 py-3 border-b-2 border-blue-600 text-blue-600 font-bold text-sm whitespace-nowrap transition-colors">Semua</button>
                    <button onclick="filterExams('UTS', this)" class="tab-btn px-6 py-3 border-b-2 border-transparent text-slate-400 font-bold text-sm hover:text-slate-800 transition-colors whitespace-nowrap">UTS</button>
                    <button onclick="filterExams('UAS', this)" class="tab-btn px-6 py-3 border-b-2 border-transparent text-slate-400 font-bold text-sm hover:text-slate-800 transition-colors whitespace-nowrap">UAS</button>
                    <button onclick="filterExams('Kuis', this)" class="tab-btn px-6 py-3 border-b-2 border-transparent text-slate-400 font-bold text-sm hover:text-slate-800 transition-colors whitespace-nowrap">Kuis</button>
                </div>

                {{-- GRID UJIAN --}}
                <div class="grid grid-cols-1 gap-5">
                    @forelse ($exams as $index => $exam)
                        @php
                            $voiceId = $index + 2; 

                            $mahasiswaId = Auth::guard('mahasiswa')->id();
                            $userResult = \App\Models\ExamResult::where('exam_id', $exam->id)
                                            ->where('mahasiswa_id', $mahasiswaId)
                                            ->first();
                            
                            $sudahSelesai = $userResult && $userResult->status === 'selesai';

                            $isPublished = $exam->is_published ?? (isset($exam->status) ? $exam->status != 'draft' : true);
                            $inTimeWindow = (now() >= $exam->waktu_mulai && now() <= $exam->waktu_selesai);
                            
                            // Logika Kombinasi Status
                            if ($sudahSelesai) {
                                $isAktif = false;
                                $status_text = 'Sudah Dikerjakan';
                                $bgClass = 'bg-emerald-50'; $textClass = 'text-emerald-700'; $dateTextClass = 'text-emerald-600'; $borderClass = 'border-emerald-200';
                            } elseif (!$isPublished) {
                                $isAktif = false;
                                $status_text = 'Belum Terbit';
                                $bgClass = 'bg-slate-50'; $textClass = 'text-slate-400'; $dateTextClass = 'text-slate-400'; $borderClass = 'border-slate-200';
                            } elseif (!$inTimeWindow && now() > $exam->waktu_selesai) {
                                $isAktif = false;
                                $status_text = 'Waktu Habis';
                                $bgClass = 'bg-slate-100'; $textClass = 'text-slate-700'; $dateTextClass = 'text-slate-600'; $borderClass = 'border-slate-200';
                            } elseif (!$inTimeWindow && now() < $exam->waktu_mulai) {
                                $isAktif = false;
                                $status_text = 'Belum Dimulai';
                                $bgClass = 'bg-slate-50'; $textClass = 'text-slate-500'; $dateTextClass = 'text-slate-400'; $borderClass = 'border-slate-200';
                            } else {
                                $isAktif = true;
                                $status_text = 'Sedang Berlangsung';
                                $bgClass = 'bg-blue-50'; $textClass = 'text-blue-700'; $dateTextClass = 'text-blue-600'; $borderClass = 'border-blue-200';
                            }

                            // Card Styling
                            $cardClass = $isAktif 
                                ? "bg-white border-blue-200 shadow-lg shadow-blue-100/50 cursor-pointer hover:-translate-y-1" 
                                : ($sudahSelesai ? "bg-emerald-50/40 border-emerald-200 shadow-sm cursor-pointer hover:-translate-y-1" : "bg-slate-50 border-slate-200 shadow-sm cursor-not-allowed opacity-80");
                            
                            $badgeBg = $isAktif ? 'bg-slate-800 text-white' : ($sudahSelesai ? 'bg-emerald-600 text-white' : 'bg-slate-300 text-slate-500');
                        @endphp

                        <div onclick="navigasiKe({{ $voiceId }})" class="exam-card group p-5 rounded-[2rem] border-2 transition-all relative overflow-hidden flex flex-col lg:flex-row items-center gap-6 safe-fade-in {{ $cardClass }}" data-kategori="{{ $exam->kategori }}" style="animation-delay: 0.3s">
                            
                            @if($isAktif)
                                <div class="absolute top-0 right-0 bg-blue-500 text-white text-[9px] font-black px-4 py-1 rounded-bl-xl uppercase tracking-widest animate-pulse shadow-sm">
                                    Sedang Berlangsung
                                </div>
                            @elseif($sudahSelesai)
                                <div class="absolute top-0 right-0 bg-emerald-500 text-white text-[9px] font-black px-4 py-1 rounded-bl-xl uppercase tracking-widest shadow-sm flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    Selesai
                                </div>
                            @endif

                            {{-- Tanggal Box --}}
                            <div class="w-full lg:w-24 h-24 {{ $bgClass }} {{ $dateTextClass }} rounded-[1.5rem] flex flex-col items-center justify-center shrink-0 border {{ $borderClass }} relative">
                                <div class="absolute -top-3 -left-3 w-8 h-8 rounded-full {{ $badgeBg }} flex items-center justify-center font-black text-xs border-[3px] border-white shadow-sm z-10">
                                    {{ $voiceId }}
                                </div>
                                <span class="text-[10px] font-black bg-white/60 px-2 py-0.5 rounded-md mb-1 shadow-sm mt-2">{{ $exam->kategori }}</span>
                                <span class="text-3xl font-black leading-none">{{ \Carbon\Carbon::parse($exam->waktu_mulai)->format('d') }}</span>
                            </div>
                            
                            {{-- Info Box --}}
                            <div class="flex-1 w-full text-center lg:text-left pr-0">
                                <div class="flex flex-col lg:flex-row items-center gap-3 mb-2 mt-2 lg:mt-0">
                                    <h4 class="text-lg sm:text-xl font-black {{ $isAktif ? 'text-slate-900 group-hover:text-blue-600' : 'text-slate-600' }} transition-colors">
                                        {{ $exam->judul }}
                                    </h4>
                                    <span class="px-3 py-1 {{ $bgClass }} {{ $textClass }} text-[10px] font-bold rounded-full uppercase tracking-wide border {{ $borderClass }}">
                                        {{ $status_text }}
                                    </span>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-xs sm:text-sm {{ $isAktif ? 'text-slate-500' : 'text-slate-400' }} font-medium justify-center lg:justify-start">
                                    <span class="flex items-center gap-1.5 justify-center lg:justify-start">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        {{ $exam->kelas->mataKuliah->nama ?? 'Kelas' }}
                                    </span>
                                    <span class="hidden sm:inline text-slate-300">•</span>
                                    <span class="flex items-center gap-1.5 justify-center lg:justify-start">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ \Carbon\Carbon::parse($exam->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($exam->waktu_selesai)->format('H:i') }} WIB
                                    </span>
                                </div>
                            </div>
                            
                            {{-- Tombol Aksi Utama --}}
                            <div class="flex flex-wrap items-center justify-center lg:justify-end w-full lg:w-auto mt-4 lg:mt-0">
                                @if($sudahSelesai)
                                    <div class="flex flex-col items-center sm:items-end">
                                        <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1">Nilai Anda</span>
                                        <span class="px-5 py-2.5 bg-white text-emerald-600 font-black rounded-xl text-lg border border-emerald-200 shadow-sm">
                                            {{ rtrim(rtrim(number_format($userResult->nilai, 2, '.', ''), '0'), '.') }}
                                        </span>
                                    </div>
                                @elseif($status_text == 'Belum Terbit' || $status_text == 'Belum Dimulai' || $status_text == 'Waktu Habis')
                                    <button disabled class="px-5 py-3 bg-slate-100 text-slate-400 font-bold rounded-xl text-xs uppercase tracking-widest flex items-center gap-2 cursor-not-allowed border border-slate-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        {{ $status_text }}
                                    </button>
                                @elseif($status_text == 'Sedang Berlangsung')
                                    <a href="{{ route('exam.preparation', $exam->id) }}" class="px-6 py-3 bg-blue-600 text-white font-black rounded-xl text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-md shadow-blue-200 flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                                        Kerjakan
                                    </a>
                                @endif
                            </div>

                        </div>
                    @empty
                        <div class="text-center py-20 bg-white rounded-[2rem] border border-slate-200 shadow-sm exam-empty">
                            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-5">
                                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h4 class="text-xl font-black text-slate-700">Belum ada ujian yang tersedia.</h4>
                            <p class="text-sm font-medium text-slate-500 mt-2">Daftar ujian akan muncul jika dosen sudah menerbitkannya.</p>
                        </div>
                    @endforelse

                    <div id="noDataFiltered" class="hidden text-center py-20 bg-white rounded-[2rem] border border-slate-200 shadow-sm">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-600">Tidak ada ujian di kategori ini.</h4>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script>
        // --- Logika Filter Tabs ---
        function filterExams(kategori, btnElement) {
            const tabs = document.querySelectorAll('.tab-btn');
            tabs.forEach(tab => {
                tab.classList.remove('border-blue-600', 'text-blue-600');
                tab.classList.add('border-transparent', 'text-slate-400');
            });
            btnElement.classList.remove('border-transparent', 'text-slate-400');
            btnElement.classList.add('border-blue-600', 'text-blue-600');

            const cards = document.querySelectorAll('.exam-card');
            let countVisible = 0;

            cards.forEach(card => {
                if (kategori === 'Semua' || card.getAttribute('data-kategori') === kategori) {
                    card.style.display = 'flex';
                    countVisible++;
                } else {
                    card.style.display = 'none';
                }
            });

            const noDataMsg = document.getElementById('noDataFiltered');
            if (countVisible === 0 && cards.length > 0) {
                noDataMsg.classList.remove('hidden');
            } else {
                noDataMsg.classList.add('hidden');
            }
        }

        // ==================================================
        // LOGIKA VOICE ASSISTANT
        // ==================================================
        const examList = [
            @foreach($exams as $index => $ex)
                @php 
                    $userRes = \App\Models\ExamResult::where('exam_id', $ex->id)->where('mahasiswa_id', Auth::guard('mahasiswa')->id())->first();
                    $isSelesaiJS = $userRes && $userRes->status === 'selesai';
                    $nilaiJS = $isSelesaiJS ? rtrim(rtrim(number_format($userRes->nilai, 2, '.', ''), '0'), '.') : '0';

                    $isPub = $ex->is_published ?? (isset($ex->status) ? $ex->status != 'draft' : true);
                    
                    $isActiveVoice = $isPub && (now() >= $ex->waktu_mulai && now() <= $ex->waktu_selesai) && !$isSelesaiJS; 
                    
                    $alasan = $isSelesaiJS ? "sudah berhasil Anda kerjakan" : "belum dibuka atau sudah berakhir";
                @endphp
                {
                    id: {{ $ex->id }},
                    judul: "{{ addslashes($ex->judul) }}",
                    kategori: "{{ addslashes($ex->kategori) }}",
                    mataKuliah: "{{ addslashes($ex->kelas->mataKuliah->nama ?? 'Kelas') }}",
                    voiceId: {{ $index + 2 }},
                    isAktif: {{ $isActiveVoice ? 'true' : 'false' }},
                    isSelesai: {{ $isSelesaiJS ? 'true' : 'false' }},
                    nilai: "{{ $nilaiJS }}",
                    alasan: "{{ $alasan }}"
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

        // FUNGSI PANDUAN UTAMA
        function getPanduanUtama(isInitial = false) {
            let teks = "";
            
            if (isInitial && "{{ session('success') }}") {
                teks += "Terima kasih telah mengikuti ujian. Jawaban Anda telah berhasil disimpan. ";
            }

            let totalUjian = {{ count($exams) }};
            teks += "Anda berada di Halaman Daftar Ujian. ";
            
            if (totalUjian > 0) {
                teks += "Sebutkan angka satu untuk memasukkan Token Ujian secara manual. ";
                
                let activeExams = examList.filter(e => e.isAktif);
                let finishedExams = examList.filter(e => e.isSelesai);

                if(activeExams.length > 0) {
                    teks += "Terdapat ujian yang bisa Anda ikuti: ";
                    activeExams.forEach(e => {
                        // Penyebutan Jenis Ujian dengan lebih eksplisit
                        teks += `Sebutkan angka ${e.voiceId} untuk mengikuti ${e.kategori} mata kuliah ${e.mataKuliah}, dengan judul ${e.judul}. `;
                    });
                } else {
                    teks += "Saat ini tidak ada ujian yang sedang aktif untuk dikerjakan. ";
                }

                if(finishedExams.length > 0) {
                    teks += "Berikut adalah ujian yang sudah Anda kerjakan: ";
                    finishedExams.forEach(e => {
                        // Penyebutan Jenis Ujian dengan lebih eksplisit
                        teks += `${e.kategori} mata kuliah ${e.mataKuliah} dengan judul ${e.judul}, nilai Anda adalah ${e.nilai}. `;
                    });
                }
                
                teks += "Sebutkan nol untuk kembali ke dashboard utama.";
            } else {
                teks += "Saat ini belum ada ujian yang diterbitkan oleh dosen. Sebutkan angka satu untuk memasukkan Token Ujian manual, atau sebutkan nol untuk kembali ke dashboard.";
            }
            
            teks += " Katakan Ulang, jika Anda butuh mendengarkan panduan ini lagi.";
            return teks;
        }

        function navigasiKe(nomor) {
            let tujuan = "";
            let teks = "";

            if (nomor === 0) {
                tujuan = "{{ route('dashboard') }}"; 
                teks = "Kembali ke Dashboard utama.";
            } else if (nomor === 1) {
                tujuan = "{{ route('join.exam') }}";
                teks = "Membuka halaman untuk memasukkan token ujian manual.";
            } else if (nomor >= 2) {
                let examTujuan = examList.find(e => e.voiceId === nomor);
                
                if (examTujuan) {
                    if (examTujuan.isAktif) {
                        teks = `Membuka persiapan untuk ujian ${examTujuan.kategori} mata kuliah ${examTujuan.mataKuliah}.`;
                        const baseUrl = "{{ route('exam.preparation', 'EXAM_ID') }}";
                        tujuan = baseUrl.replace('EXAM_ID', examTujuan.id);
                    } else if (examTujuan.isSelesai) {
                        tujuan = "#";
                        teks = `Ujian ${examTujuan.judul} sudah Anda kerjakan dengan nilai ${examTujuan.nilai}.`;
                    } else {
                        tujuan = "#";
                        teks = `Maaf, ujian ${examTujuan.judul} ${examTujuan.alasan}.`;
                    }
                } else {
                    tujuan = "#";
                    teks = "Nomor ujian tidak ditemukan.";
                }
            }

            if (teks !== "") {
                bicara(teks, () => {
                    setTimeout(() => {
                        if (tujuan !== "" && tujuan !== "#") {
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
                    const hasil = event.results[event.results.length - 1][0].transcript.toLowerCase().trim();
                    
                    // Fitur Ulangi / Panduan
                    if (hasil.includes("ulang") || hasil.includes("panduan") || hasil.includes("bantuan")) {
                        rec.stop();
                        bicara(getPanduanUtama(false), () => { rec.start(); });
                        return;
                    }

                    const kataAngka = {
                        "nol": 0, "satu": 1, "dua": 2, "tiga": 3, "empat": 4, "lima": 5, 
                        "enam": 6, "tujuh": 7, "delapan": 8, "sembilan": 9, "sepuluh": 10
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
                        rec.stop();
                        navigasiKe(terdeteksiAngka);
                    } else if (hasil.includes("kembali") || hasil.includes("dashboard")) { 
                        rec.stop();
                        navigasiKe(0); 
                    } else if (hasil.includes("token")) { 
                        rec.stop();
                        navigasiKe(1); 
                    }
                };
                rec.onend = () => { rec.start(); };
            } catch (e) {
                console.error("Error recognition:", e);
            }
        }

        window.onload = () => {
            document.body.addEventListener("click", () => {}, { once: true });
            setTimeout(() => { 
                // isInitial = true agar session success terbaca pertama kali
                bicara(getPanduanUtama(true), () => { 
                    mulaiMendengar(); 
                }); 
            }, 800);
        };
    </script>
</body>
</html>