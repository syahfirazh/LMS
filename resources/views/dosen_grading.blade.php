<!DOCTYPE html>
@php
    $dosenId = Auth::guard('dosen')->id();
    $unreadCount = \App\Models\Message::where('receiver_type', 'dosen')
                    ->where('receiver_id', $dosenId)
                    ->where('is_read', 0)
                    ->count();
@endphp
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Input Nilai | Portal Dosen</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        input[type="number"] { -moz-appearance: textfield; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .safe-fade-in { animation: fadeIn 0.6s ease-out forwards; opacity: 0; }
        .modal-enter { animation: modalFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .modal-card-enter { animation: cardPopUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes modalFadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes cardPopUp { from { opacity: 0; transform: scale(0.95) translateY(10px); } to { opacity: 1; transform: scale(1) translateY(0); } }
    </style>
</head>
<body class="m-0 font-['Plus_Jakarta_Sans'] bg-slate-50 text-slate-800 antialiased h-screen flex overflow-hidden">
    
    <div id="mobileBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden transition-opacity"></div>

    <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-80 bg-white border-r border-slate-200 flex flex-col h-full transform -translate-x-full lg:translate-x-0 transition-transform duration-300 shrink-0 shadow-2xl lg:shadow-none">
        <div class="p-8 border-b border-slate-100 flex items-center gap-4 shrink-0">
            <img src="{{ asset('images/logo-ummi.png') }}" class="w-10 h-10 object-contain" alt="Logo" onerror="this.src='https://ui-avatars.com/api/?name=UMMI&background=0D8ABC&color=fff'" />
            <div>
                <h1 class="text-lg font-black text-slate-900 tracking-tight leading-none">LMS Inklusi</h1>
                <p class="text-[9px] font-bold text-blue-600 uppercase tracking-widest mt-1">Portal Dosen</p>
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden ml-auto text-slate-400 hover:text-slate-600 bg-slate-50 p-2 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <nav class="flex-1 p-6 space-y-3 overflow-y-auto custom-scrollbar">
            <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span>Beranda</span>
            </a>
            <a href="{{ route('dosen.courses') }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span>Mata Kuliah</span>
            </a>
            <a href="{{ route('dosen.schedule') ?? '#' }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Jadwal Mengajar</span>
            </a>
            <a href="{{ route('dosen.grading') }}" class="flex items-center gap-4 p-4 bg-blue-50 text-blue-700 rounded-2xl font-bold transition-all shadow-sm border border-blue-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span>Input Nilai</span>
            </a>
            <a href="{{ route('dosen.exams') ?? '#' }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Kelola Ujian</span>
            </a>
            <a href="{{ route('dosen.messages') }}" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    <span>Pesan</span>
                </div>
                @if($unreadCount > 0)
                    <span class="text-[10px] bg-red-500 text-white px-2 py-1 rounded-lg font-black shadow-sm">{{ $unreadCount }} Baru</span>
                @endif
            </a>
            <a href="{{ route('dosen.notifications') ?? '#' }}" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span>Pemberitahuan</span>
                </div>
            </a>
            <a href="{{ route('dosen.profile') ?? '#' }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span>Profil Saya</span>
            </a>
        </nav>

        <div class="p-6 border-t border-slate-100 shrink-0">
            <a href="{{ route('logout') }}" class="w-full p-4 flex items-center justify-between text-red-600 font-bold bg-red-50 rounded-2xl hover:bg-red-100 transition-all border border-red-100">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Keluar</span>
                </div>
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full relative min-w-0 bg-[#f8fafc] overflow-y-auto custom-scrollbar">
        
        <header class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-4 md:px-8 py-4 sm:py-6 sticky top-0 z-30 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3 sm:gap-4 h-10 sm:h-14">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg cursor-pointer">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div>
                    <h2 class="text-lg sm:text-2xl font-black text-slate-900 tracking-tight">Input Nilai Kelas</h2>
                    <p class="text-[9px] sm:text-sm font-medium text-slate-500">
                        {{ isset($kelas) ? 'Kelas ' . $kelas->kode_kelas . ' - ' . ($kelas->mataKuliah->nama ?? '') : 'Pilih kelas untuk menilai' }}
                    </p>
                </div>
            </div>

            <div class="relative w-full sm:w-auto min-w-[250px]">
                <select onchange="changeClass(this.value)" class="appearance-none w-full bg-white border border-slate-300 rounded-xl px-4 py-2.5 sm:px-5 sm:py-3 font-bold text-xs sm:text-sm outline-none focus:ring-2 focus:ring-blue-500 shadow-sm text-slate-700 cursor-pointer">
                    @if(isset($listKelas) && $listKelas->count() > 0)
                        @foreach($listKelas as $k)
                            <option value="{{ $k->id }}" {{ (isset($kelas) && $kelas->id == $k->id) ? 'selected' : '' }}>
                                {{ $k->mataKuliah->nama ?? 'Kelas' }} - {{ $k->kode_kelas }}
                            </option>
                        @endforeach
                    @else
                        <option value="">Belum ada kelas</option>
                    @endif
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </header>

        <div class="p-4 sm:p-6 lg:p-10 w-full mb-10">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-bold text-sm safe-fade-in">
                    {{ session('success') }}
                </div>
            @endif

            {{-- CEK APAKAH KELAS SUDAH DIPILIH/TERSEDIA --}}
            @if(isset($kelas) && $kelas)
            <form action="{{ route('dosen.grading.store', $kelas->id) }}" method="POST" id="mainGradingForm">
                @csrf
                <input type="hidden" id="inputBobotAbsen" name="bobot_absen" value="{{ $bobot->absen ?? 10 }}" />
                <input type="hidden" id="inputBobotTugas" name="bobot_tugas" value="{{ $bobot->tugas ?? 20 }}" />
                <input type="hidden" id="inputBobotUts" name="bobot_uts" value="{{ $bobot->uts ?? 30 }}" />
                <input type="hidden" id="inputBobotUas" name="bobot_uas" value="{{ $bobot->uas ?? 40 }}" />

                <div class="bg-white rounded-[1.5rem] sm:rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden safe-fade-in w-full">
                    
                    <div class="p-4 sm:p-6 border-b border-slate-100 flex flex-col xl:flex-row justify-between items-start xl:items-center bg-slate-50/50 gap-4 sm:gap-5">
                        <div>
                            <h3 class="font-black text-slate-700 uppercase tracking-widest text-[10px] sm:text-xs mb-2">
                                Form Penilaian ({{ $kelas->mahasiswa->count() }} Mahasiswa)
                            </h3>
                            <span id="badgeInfoBobot" class="inline-block text-[9px] sm:text-[10px] font-bold text-blue-600 bg-blue-50 px-2 sm:px-2.5 py-1 rounded-lg border border-blue-100 break-words">
                                Bobot Saat Ini: Absen <span id="txtA">{{ $bobot->absen ?? 10 }}</span>% | Tugas <span id="txtT">{{ $bobot->tugas ?? 20 }}</span>% | UTS <span id="txtUts">{{ $bobot->uts ?? 30 }}</span>% | UAS <span id="txtUas">{{ $bobot->uas ?? 40 }}</span>%
                            </span>
                        </div>

                        <div class="flex flex-row flex-wrap gap-2 sm:gap-3 w-full xl:w-auto">
                            <button type="button" onclick="openModalBobot()" class="cursor-pointer flex-1 sm:flex-none bg-white border border-slate-200 px-3 py-2 sm:px-5 sm:py-2.5 rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all text-slate-600 shadow-sm flex items-center justify-center gap-1.5 sm:gap-2">
                                Atur Bobot
                            </button>
                            
                            {{-- TOMBOL EXPORT SUDAH DITAMBAHKAN DI SINI SEBAGAI LINK (A TAG) --}}
                            <a href="{{ route('dosen.grades.export', $kelas->id) }}" class="cursor-pointer flex-1 sm:flex-none bg-emerald-50 border border-emerald-200 px-3 py-2 sm:px-5 sm:py-2.5 rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest hover:bg-emerald-100 transition-all text-emerald-600 shadow-sm flex items-center justify-center gap-1.5 sm:gap-2">
                                Export Excel
                            </a>

                            <button type="submit" class="cursor-pointer w-full sm:w-auto bg-blue-600 text-white px-5 py-2.5 sm:px-7 sm:py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                                Simpan Nilai & Rekap
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="w-full text-left text-xs sm:text-sm whitespace-nowrap">
                            <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 uppercase tracking-widest text-[9px] sm:text-[10px]">
                                <tr>
                                    <th class="px-4 py-4 sm:px-6 sm:py-5 font-black w-10">#</th>
                                    <th class="px-3 py-4 sm:px-4 sm:py-5 font-black min-w-[150px] sm:min-w-[200px]">NIM & Nama</th>
                                    <th class="px-2 py-4 sm:px-3 sm:py-5 font-black text-center w-16 sm:w-24">Absen</th>
                                    <th class="px-2 py-4 sm:px-3 sm:py-5 font-black text-center w-16 sm:w-24">Tugas</th>
                                    <th class="px-2 py-4 sm:px-3 sm:py-5 font-black text-center w-16 sm:w-24">UTS</th>
                                    <th class="px-2 py-4 sm:px-3 sm:py-5 font-black text-center w-16 sm:w-24">UAS</th>
                                    <th class="px-4 py-4 sm:px-6 sm:py-5 font-black text-center w-24 sm:w-28">Total Akhir</th>
                                    <th class="px-3 py-4 sm:px-4 sm:py-5 font-black text-center w-20 sm:w-24">Huruf Mutu</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($kelas->mahasiswa as $i => $mhs)
                                    @php $nilaiMhs = $grades[$mhs->id] ?? null; @endphp
                                    <tr class="hover:bg-blue-50/30 transition-colors group">
                                        <td class="px-4 py-3 sm:px-6 sm:py-4 font-bold text-slate-400">{{ $i + 1 }}</td>
                                        <td class="px-3 py-3 sm:px-4 sm:py-4">
                                            <div class="font-bold text-slate-800 text-xs sm:text-sm">{{ $mhs->nama }}</div>
                                            <div class="font-mono text-slate-500 font-bold text-[9px] sm:text-[10px] mt-0.5">{{ $mhs->nim }}</div>
                                        </td>
                                        <td class="px-2 py-3 sm:px-3 sm:py-4 text-center">
                                            <input type="text" pattern="\d*" maxlength="3" name="grades[{{ $mhs->id }}][absen]" id="absen_{{ $mhs->id }}" value="{{ $nilaiMhs->absen ?? '' }}" class="w-12 sm:w-16 bg-white border border-slate-200 rounded-lg p-2 text-center font-bold text-slate-700 text-xs sm:text-sm focus:ring-2 focus:ring-blue-400 outline-none shadow-sm" onkeypress="return isNumberKey(event);" oninput="calculate('{{ $mhs->id }}')"/>
                                        </td>
                                        <td class="px-2 py-3 sm:px-3 sm:py-4 text-center">
                                            <input type="text" pattern="\d*" maxlength="3" name="grades[{{ $mhs->id }}][tugas]" id="tugas_{{ $mhs->id }}" value="{{ $nilaiMhs->tugas ?? '' }}" class="w-12 sm:w-16 bg-white border border-slate-200 rounded-lg p-2 text-center font-bold text-slate-700 text-xs sm:text-sm focus:ring-2 focus:ring-blue-400 outline-none shadow-sm" onkeypress="return isNumberKey(event);" oninput="calculate('{{ $mhs->id }}')"/>
                                        </td>
                                        <td class="px-2 py-3 sm:px-3 sm:py-4 text-center">
                                            <input type="text" pattern="\d*" maxlength="3" name="grades[{{ $mhs->id }}][uts]" id="uts_{{ $mhs->id }}" value="{{ $nilaiMhs->uts ?? '' }}" class="w-12 sm:w-16 bg-white border border-slate-200 rounded-lg p-2 text-center font-bold text-slate-700 text-xs sm:text-sm focus:ring-2 focus:ring-blue-400 outline-none shadow-sm" onkeypress="return isNumberKey(event);" oninput="calculate('{{ $mhs->id }}')"/>
                                        </td>
                                        <td class="px-2 py-3 sm:px-3 sm:py-4 text-center">
                                            <input type="text" pattern="\d*" maxlength="3" name="grades[{{ $mhs->id }}][uas]" id="uas_{{ $mhs->id }}" value="{{ $nilaiMhs->uas ?? '' }}" class="w-12 sm:w-16 bg-white border border-slate-200 rounded-lg p-2 text-center font-bold text-slate-700 text-xs sm:text-sm focus:ring-2 focus:ring-blue-400 outline-none shadow-sm" onkeypress="return isNumberKey(event);" oninput="calculate('{{ $mhs->id }}')"/>
                                        </td>
                                        <td class="px-4 py-3 sm:px-6 sm:py-4 text-center">
                                            <div id="total_{{ $mhs->id }}" class="font-black text-xs sm:text-sm text-slate-400">{{ $nilaiMhs->nilai_akhir ?? '--' }}</div>
                                        </td>
                                        <td class="px-3 py-3 sm:px-4 sm:py-4 text-center">
                                            <span id="huruf_{{ $mhs->id }}" class="px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-lg text-[9px] sm:text-[10px] font-black uppercase bg-slate-100 text-slate-400 border border-slate-200">{{ $nilaiMhs->huruf_mutu ?? '-' }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="text-center py-10 text-slate-500 font-bold">Belum ada mahasiswa di kelas ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
            @else
                <div class="text-center p-12 bg-white rounded-[2rem] border border-slate-200 shadow-sm mt-10 safe-fade-in">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="font-black text-slate-800 text-lg mb-1">Pilih Kelas Terlebih Dahulu</h3>
                    <p class="text-slate-500 font-medium text-sm">Gunakan dropdown di sudut kanan atas untuk memilih kelas yang ingin dinilai.</p>
                </div>
            @endif
        </div>
    </main>

    {{-- MODAL UBAH BOBOT SIMULASI --}}
    @if(isset($kelas) && $kelas)
    <div id="modalBobot" class="fixed inset-0 z-[60] hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
        <div class="bg-white rounded-[2rem] w-full max-w-md shadow-2xl overflow-hidden modal-card-enter">
            <div class="p-5 sm:p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="font-black text-slate-800 text-base sm:text-lg">Atur Bobot Penilaian</h3>
                <button type="button" onclick="closeModalBobot()" class="cursor-pointer text-slate-400 hover:text-red-500 transition-colors">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-5 sm:p-6 space-y-5">
                <div class="flex justify-between items-center bg-blue-50 p-3 rounded-xl border border-blue-100">
                    <span class="text-[10px] sm:text-xs font-bold text-blue-800">Total Persentase:</span>
                    <span id="modalTotalBadge" class="px-2 py-1 bg-blue-600 text-white text-[10px] sm:text-xs font-black rounded-md">100%</span>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[9px] sm:text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Absensi (%)</label>
                        <input type="text" pattern="\d*" maxlength="3" id="modalAbsen" value="{{ $bobot->absen ?? 10 }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 sm:p-3 font-bold text-slate-700 text-sm focus:ring-2 focus:ring-blue-500 outline-none" onkeypress="return isNumberKey(event);" oninput="checkModalTotal()"/>
                    </div>
                    <div>
                        <label class="block text-[9px] sm:text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Tugas (%)</label>
                        <input type="text" pattern="\d*" maxlength="3" id="modalTugas" value="{{ $bobot->tugas ?? 20 }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 sm:p-3 font-bold text-slate-700 text-sm focus:ring-2 focus:ring-blue-500 outline-none" onkeypress="return isNumberKey(event);" oninput="checkModalTotal()"/>
                    </div>
                    <div>
                        <label class="block text-[9px] sm:text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">UTS (%)</label>
                        <input type="text" pattern="\d*" maxlength="3" id="modalUts" value="{{ $bobot->uts ?? 30 }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 sm:p-3 font-bold text-slate-700 text-sm focus:ring-2 focus:ring-blue-500 outline-none" onkeypress="return isNumberKey(event);" oninput="checkModalTotal()"/>
                    </div>
                    <div>
                        <label class="block text-[9px] sm:text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">UAS (%)</label>
                        <input type="text" pattern="\d*" maxlength="3" id="modalUas" value="{{ $bobot->uas ?? 40 }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 sm:p-3 font-bold text-slate-700 text-sm focus:ring-2 focus:ring-blue-500 outline-none" onkeypress="return isNumberKey(event);" oninput="checkModalTotal()"/>
                    </div>
                </div>
            </div>
            <div class="p-5 sm:p-6 border-t border-slate-100 flex flex-col sm:flex-row gap-3 bg-slate-50">
                <button type="button" onclick="closeModalBobot()" class="cursor-pointer flex-1 px-4 py-2.5 sm:py-3 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-100 transition-colors text-xs sm:text-sm">Batal</button>
                <button type="button" onclick="saveBobot()" id="btnSaveBobot" class="cursor-pointer flex-1 px-4 py-2.5 sm:py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors text-xs sm:text-sm shadow-md">Terapkan Simulasi</button>
            </div>
        </div>
    </div>

    <script>
        // FUNGSI GANTI KELAS DARI DROPDOWN
        function changeClass(kelasId) {
            if(kelasId) window.location.href = '?kelas_id=' + kelasId;
        }

        const studentIds = @json(isset($kelas) ? $kelas->mahasiswa->pluck('id') : []);
        
        function isNumberKey(evt) {
            var charCode = evt.which ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
            return true;
        }

        document.addEventListener("DOMContentLoaded", () => calculateAll());

        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("-translate-x-full");
            document.getElementById("mobileBackdrop").classList.toggle("hidden");
        }

        const modal = document.getElementById("modalBobot");

        function openModalBobot() {
            document.getElementById("modalAbsen").value = document.getElementById("inputBobotAbsen").value;
            document.getElementById("modalTugas").value = document.getElementById("inputBobotTugas").value;
            document.getElementById("modalUts").value = document.getElementById("inputBobotUts").value;
            document.getElementById("modalUas").value = document.getElementById("inputBobotUas").value;
            checkModalTotal();
            modal.classList.remove("hidden");
            modal.classList.add("modal-enter");
        }

        function closeModalBobot() {
            modal.classList.add("hidden");
            modal.classList.remove("modal-enter");
        }

        function checkModalTotal() {
            const a = parseFloat(document.getElementById("modalAbsen").value) || 0;
            const t = parseFloat(document.getElementById("modalTugas").value) || 0;
            const ut = parseFloat(document.getElementById("modalUts").value) || 0;
            const ua = parseFloat(document.getElementById("modalUas").value) || 0;
            const total = a + t + ut + ua;

            const badge = document.getElementById("modalTotalBadge");
            const btnSave = document.getElementById("btnSaveBobot");

            badge.innerText = total + "%";

            if (total === 100) {
                badge.className = "px-2 py-1 bg-emerald-500 text-white text-[10px] sm:text-xs font-black rounded-md";
                btnSave.disabled = false;
                btnSave.classList.replace("bg-slate-400", "bg-blue-600");
                btnSave.classList.replace("cursor-not-allowed", "hover:bg-blue-700");
            } else {
                badge.className = "px-2 py-1 bg-red-500 text-white text-[10px] sm:text-xs font-black rounded-md";
                btnSave.disabled = true;
                btnSave.classList.replace("bg-blue-600", "bg-slate-400");
                btnSave.classList.replace("hover:bg-blue-700", "cursor-not-allowed");
            }
        }

        function saveBobot() {
            const a = document.getElementById("modalAbsen").value;
            const t = document.getElementById("modalTugas").value;
            const ut = document.getElementById("modalUts").value;
            const ua = document.getElementById("modalUas").value;

            document.getElementById("inputBobotAbsen").value = a;
            document.getElementById("inputBobotTugas").value = t;
            document.getElementById("inputBobotUts").value = ut;
            document.getElementById("inputBobotUas").value = ua;

            document.getElementById("txtA").innerText = a;
            document.getElementById("txtT").innerText = t;
            document.getElementById("txtUts").innerText = ut;
            document.getElementById("txtUas").innerText = ua;

            closeModalBobot();
            calculateAll();
        }

        function calculateAll() {
            studentIds.forEach((id) => calculate(id));
        }

        function getHurufMutu(nilai) {
            if (nilai >= 85) return { huruf: "A", class: "bg-emerald-100 text-emerald-700 border-emerald-200" };
            if (nilai >= 70) return { huruf: "B", class: "bg-blue-100 text-blue-700 border-blue-200" };
            if (nilai >= 60) return { huruf: "C", class: "bg-yellow-100 text-yellow-700 border-yellow-200" };
            if (nilai >= 50) return { huruf: "D", class: "bg-orange-100 text-orange-700 border-orange-200" };
            return { huruf: "E", class: "bg-red-100 text-red-700 border-red-200" };
        }

        function calculate(id) {
            const bA = (parseFloat(document.getElementById("inputBobotAbsen").value) || 0) / 100;
            const bT = (parseFloat(document.getElementById("inputBobotTugas").value) || 0) / 100;
            const bUts = (parseFloat(document.getElementById("inputBobotUts").value) || 0) / 100;
            const bUas = (parseFloat(document.getElementById("inputBobotUas").value) || 0) / 100;

            let elA = document.getElementById(`absen_${id}`);
            let elT = document.getElementById(`tugas_${id}`);
            let elUts = document.getElementById(`uts_${id}`);
            let elUas = document.getElementById(`uas_${id}`);

            if(!elA) return;

            if (elA.value > 100) elA.value = 100;
            if (elT.value > 100) elT.value = 100;
            if (elUts.value > 100) elUts.value = 100;
            if (elUas.value > 100) elUas.value = 100;

            const a = parseFloat(elA.value) || 0;
            const t = parseFloat(elT.value) || 0;
            const uts = parseFloat(elUts.value) || 0;
            const uas = parseFloat(elUas.value) || 0;

            let total = a * bA + t * bT + uts * bUts + uas * bUas;

            const elTotal = document.getElementById(`total_${id}`);
            const elHuruf = document.getElementById(`huruf_${id}`);

            if (elA.value === "" && elT.value === "" && elUts.value === "" && elUas.value === "") {
                elTotal.innerText = "--";
                elTotal.className = "font-black text-xs sm:text-sm text-slate-400";
                elHuruf.innerText = "-";
                elHuruf.className = "px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-lg text-[9px] sm:text-[10px] font-black uppercase bg-slate-100 text-slate-400 border border-slate-200";
                return;
            }

            elTotal.innerText = total.toFixed(1);
            if (total >= 60) elTotal.className = "font-black text-xs sm:text-sm text-blue-600";
            else elTotal.className = "font-black text-xs sm:text-sm text-red-600";

            const mutu = getHurufMutu(total);
            elHuruf.innerText = mutu.huruf;
            elHuruf.className = `px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-lg text-[9px] sm:text-[10px] font-black uppercase border ${mutu.class}`;
        }
    </script>
    @endif
</body>
</html>