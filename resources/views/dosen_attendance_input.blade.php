<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Input Manual - Pertemuan {{ $session->urutan ?? $session->pertemuan }}: {{ $session->judul }} | Portal Dosen</title>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        /* Custom Radio Style */
        .radio-input:checked + .radio-label {
            background-color: var(--bg-color);
            color: white;
            border-color: var(--border-color);
            box-shadow: 0 4px 10px -2px var(--shadow-color);
            transform: scale(1.05);
        }
    </style>
</head>
<body class="font-['Plus_Jakarta_Sans'] bg-[#f1f5f9] text-slate-800 min-h-full flex flex-col border-box overflow-x-hidden overflow-y-scroll selection:bg-blue-200">
    
    <div class="bg-white/90 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm transition-all w-full">
        <div class="max-w-7xl mx-auto flex items-center justify-between relative">
            
            <div class="flex items-center gap-4 relative z-10">
                <a href="{{ route('dosen.attendance.index', $kelas->id) }}" class="w-11 h-11 md:w-12 md:h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all shadow-sm shrink-0 group border border-slate-200 hover:border-blue-600">
                    <svg class="w-5 h-5 md:w-6 md:h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
            </div>

            <div class="text-center absolute left-1/2 transform -translate-x-1/2 w-full max-w-[60%] md:max-w-md">
                <h1 class="text-lg md:text-2xl font-black text-slate-900 tracking-tight leading-tight truncate">
                    Input Presensi
                </h1>
                <div class="flex items-center justify-center gap-2 mt-1">
                    <span class="text-[9px] md:text-[10px] font-bold text-blue-600 uppercase tracking-widest bg-blue-100 px-2 py-0.5 rounded-md">
                        Kelas {{ $kelas->kode_kelas ?? '-' }}
                    </span>
                    <span class="text-[10px] md:text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">
                        Sesi {{ $session->urutan ?? $session->pertemuan }}
                    </span>
                </div>
            </div>
            
            <div class="w-11 md:w-12 relative z-10"></div>
            
        </div>
    </div>

    <main class="flex-1 max-w-7xl mx-auto p-4 md:p-8 w-full space-y-6 md:space-y-8 mb-20 relative">
        
        <form action="{{ route('dosen.attendance.storeManual', $session->id) }}" method="POST">
            @csrf
            
            <div data-aos="fade-down" data-aos-duration="600" class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 bg-white p-6 sm:p-8 md:p-10 rounded-[2rem] sm:rounded-[2.5rem] border border-slate-200 shadow-sm mb-6">
                <div class="w-full lg:w-auto">
                    <span class="inline-block px-3.5 py-1.5 bg-blue-50 text-blue-600 rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest mb-3 border border-blue-100">
                        Status: Sedang Berlangsung
                    </span>
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-black text-slate-900 tracking-tight mb-2">
                        Pertemuan {{ $session->urutan ?? $session->pertemuan }}: {{ $session->judul }}
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium">
                        {{ $session->tanggal ? \Carbon\Carbon::parse($session->tanggal)->translatedFormat('l, d M Y') : 'Hari Ini' }} 
                        @if($session->jam_mulai)
                            <span class="inline-block mx-1">•</span> {{ \Carbon\Carbon::parse($session->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($session->jam_selesai)->format('H:i') }} WIB
                        @endif
                    </p>
                </div>
                
                <div class="flex gap-2 sm:gap-3 w-full lg:w-auto mt-2 lg:mt-0">
                    <button type="reset" class="flex-1 lg:flex-none px-4 sm:px-6 py-3 sm:py-3.5 rounded-xl border-2 border-slate-200 text-slate-500 font-black text-[10px] sm:text-[11px] uppercase tracking-widest hover:bg-slate-100 hover:text-slate-700 transition-all">
                        Reset
                    </button>
                    <button type="submit" class="flex-1 lg:flex-none px-4 sm:px-8 py-3 sm:py-3.5 bg-blue-600 text-white rounded-xl font-black text-[10px] sm:text-[11px] uppercase tracking-widest hover:bg-blue-700 hover:-translate-y-0.5 transition-all shadow-lg shadow-blue-200">
                        Simpan ({{ $mahasiswa->count() }})
                    </button>
                </div>
            </div>

            <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="100" class="bg-white rounded-[2rem] sm:rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                
                <div class="bg-slate-50/80 p-5 sm:p-6 md:px-8 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="font-black text-slate-800 text-xs sm:text-sm uppercase tracking-wider">
                        Mahasiswa ({{ $mahasiswa->count() }})
                    </h3>
                    <div class="flex items-center gap-2 bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-sm">
                        <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full inline-block animate-pulse"></span>
                        <span class="text-[9px] sm:text-[10px] font-bold text-slate-500 uppercase tracking-widest">Default: Hadir</span>
                    </div>
                </div>

                <div class="divide-y divide-slate-100 p-2 sm:p-4">

                    @foreach($mahasiswa as $index => $mhs)
                        @php
                            // REVISI: Default 'hadir' (kata lengkap)
                            $selected = isset($attendances[$mhs->id]) ? $attendances[$mhs->id]->status : 'hadir';
                        @endphp

                        <div class="p-4 md:p-5 flex flex-col md:flex-row md:items-center justify-between gap-4 sm:gap-5 hover:bg-slate-50 rounded-2xl transition-colors group">
                            
                            <div class="flex items-center gap-4 sm:gap-5">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-base sm:text-lg shrink-0 border border-indigo-100 group-hover:bg-indigo-100 transition-colors">
                                    {{ strtoupper(substr($mhs->nama, 0, 2)) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm sm:text-base mb-0.5 group-hover:text-blue-600 transition-colors line-clamp-1">
                                        {{ $mhs->nama }}
                                    </h4>
                                    <p class="text-[10px] sm:text-xs font-mono text-slate-400 font-medium tracking-wide">
                                        {{ $mhs->nim }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-1.5 sm:gap-2 bg-slate-50/50 sm:bg-white p-1.5 sm:p-2 rounded-2xl sm:rounded-[1.25rem] border border-slate-100 sm:border-slate-200 shadow-sm w-full md:w-auto mt-2 md:mt-0">

                                {{-- HADIR --}}
                                <label class="cursor-pointer relative group/radio flex-1 md:flex-none">
                                    <input type="radio" name="attendance[{{ $mhs->id }}]" value="hadir" class="radio-input hidden" {{ $selected == 'hadir' ? 'checked' : '' }} />
                                    <div class="radio-label w-full md:w-14 h-10 md:h-12 rounded-xl flex items-center justify-center font-black text-xs md:text-sm text-slate-400 bg-white sm:bg-slate-50 hover:bg-emerald-50 hover:text-emerald-500 transition-all border border-slate-100 shadow-sm sm:shadow-none" 
                                         style="--bg-color: #10b981; --border-color: #059669; --shadow-color: rgba(16, 185, 129, 0.4);">
                                        H
                                    </div>
                                </label>

                                {{-- IZIN --}}
                                <label class="cursor-pointer relative group/radio flex-1 md:flex-none">
                                    <input type="radio" name="attendance[{{ $mhs->id }}]" value="izin" class="radio-input hidden" {{ $selected == 'izin' ? 'checked' : '' }} />
                                    <div class="radio-label w-full md:w-14 h-10 md:h-12 rounded-xl flex items-center justify-center font-black text-xs md:text-sm text-slate-400 bg-white sm:bg-slate-50 hover:bg-blue-50 hover:text-blue-500 transition-all border border-slate-100 shadow-sm sm:shadow-none" 
                                         style="--bg-color: #3b82f6; --border-color: #2563eb; --shadow-color: rgba(59, 130, 246, 0.4);">
                                        I
                                    </div>
                                </label>

                                {{-- SAKIT --}}
                                <label class="cursor-pointer relative group/radio flex-1 md:flex-none">
                                    <input type="radio" name="attendance[{{ $mhs->id }}]" value="sakit" class="radio-input hidden" {{ $selected == 'sakit' ? 'checked' : '' }} />
                                    <div class="radio-label w-full md:w-14 h-10 md:h-12 rounded-xl flex items-center justify-center font-black text-xs md:text-sm text-slate-400 bg-white sm:bg-slate-50 hover:bg-amber-50 hover:text-amber-500 transition-all border border-slate-100 shadow-sm sm:shadow-none" 
                                         style="--bg-color: #f59e0b; --border-color: #d97706; --shadow-color: rgba(245, 158, 11, 0.4);">
                                        S
                                    </div>
                                </label>

                                {{-- ALPHA --}}
                                <label class="cursor-pointer relative group/radio flex-1 md:flex-none">
                                    <input type="radio" name="attendance[{{ $mhs->id }}]" value="alpha" class="radio-input hidden" {{ $selected == 'alpha' ? 'checked' : '' }} />
                                    <div class="radio-label w-full md:w-14 h-10 md:h-12 rounded-xl flex items-center justify-center font-black text-xs md:text-sm text-slate-400 bg-white sm:bg-slate-50 hover:bg-red-50 hover:text-red-500 transition-all border border-slate-100 shadow-sm sm:shadow-none" 
                                         style="--bg-color: #ef4444; --border-color: #dc2626; --shadow-color: rgba(239, 68, 68, 0.4);">
                                        A
                                    </div>
                                </label>

                            </div>
                        </div>

                    @endforeach

                </div>

                <div class="p-5 sm:p-6 bg-slate-50/50 border-t border-slate-100 flex justify-center">
                    <span class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        Total: {{ $mahasiswa->count() }} Mahasiswa
                    </span>
                </div>
            </div>
        </form>
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, easing: 'ease-out-cubic', duration: 800 });

        // REVISI: Fungsi Reset mengembalikan ke "hadir"
        document.querySelector('button[type="reset"]').addEventListener('click', function(e) {
            e.preventDefault(); 
            document.querySelectorAll('input[value="hadir"]').forEach(function(el) {
                el.checked = true;
            });
        });
    </script>
</body>
</html>