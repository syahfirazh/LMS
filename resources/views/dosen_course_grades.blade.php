<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Rekap & Evaluasi Nilai | Portal Dosen</title>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        input[type="number"] { -moz-appearance: textfield; }
        input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        
        .modal-active { display: flex !important; }
        @keyframes popUp { from { opacity: 0; transform: scale(0.95) translateY(10px); } to { opacity: 1; transform: scale(1) translateY(0); } }
        .animate-pop { animation: popUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
</head>
<body class="font-['Plus_Jakarta_Sans'] bg-[#f1f5f9] text-slate-800 min-h-full flex flex-col border-box overflow-x-hidden selection:bg-blue-200">
    
    {{-- NAVBAR UTAMA (Disamakan 100% dengan Halaman Kelola Kelas) --}}
    <div class="bg-white/80 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm transition-all">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-5">
            
            <div class="flex items-center gap-4 w-full md:w-auto">
                <a href="{{ route('dosen.courses') }}" class="w-12 h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all shadow-sm shrink-0 group">
                    <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="overflow-hidden">
                    <h1 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight leading-tight truncate">
                        {{ $kelas->mataKuliah->nama }}
                    </h1>
                    <div class="flex items-center gap-3 mt-1">
                        <span class="text-[10px] font-black text-blue-700 uppercase tracking-widest bg-blue-100 px-2.5 py-1 rounded-md">
                            Kelas {{ $kelas->kode_kelas }}
                        </span>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">
                            Dosen: {{ auth('dosen')->user()->nama ?? 'Dosen' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="hidden md:block w-px h-10 bg-slate-200"></div>

            <nav class="w-full md:w-auto flex p-1.5 bg-slate-100/80 rounded-2xl overflow-x-auto scrollbar-hide snap-x gap-2 border border-slate-200/50">
                <a href="{{ route('dosen.course.manage', $kelas->id) }}" class="snap-start shrink-0 px-6 py-2.5 rounded-xl text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/60 flex items-center justify-center">
                    Materi & Modul
                </a>
                <a href="{{ route('dosen.attendance.index', $kelas->id) }}" class="snap-start shrink-0 px-6 py-2.5 rounded-xl text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/60 flex items-center justify-center">
                    Absensi
                </a>
                <a href="{{ route('dosen.course.assignments', $kelas->id) }}" class="snap-start shrink-0 px-6 py-2.5 rounded-xl text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/60 flex items-center justify-center">
                    Penugasan
                </a>
                <a href="{{ route('dosen.course.students', $kelas->id) }}" class="snap-start shrink-0 px-6 py-2.5 rounded-xl text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/60 flex items-center justify-center">
                    Peserta
                </a>
                <a href="{{ route('dosen.grades.recap', $kelas->id) }}" class="snap-start shrink-0 px-6 py-2.5 rounded-xl bg-white text-blue-700 font-black text-[10px] uppercase tracking-widest shadow-sm border border-slate-200/60 whitespace-nowrap transition-all flex items-center justify-center">
                    Rekap Nilai
                </a>
            </nav>
        </div>
    </div>

    <main class="flex-1 max-w-7xl mx-auto p-4 md:p-8 w-full space-y-8 mb-20 relative">
        
        {{-- HEADER ACTION --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-slate-200 pb-6" data-aos="fade-down">
            <div>
                <h2 class="text-xl font-black text-slate-800 tracking-tight">Overview Kelulusan</h2>
                <p class="text-xs text-slate-500 font-medium mt-1">Pantau performa dan statistik keseluruhan kelas.</p>
            </div>
            <div class="flex gap-3 w-full md:w-auto">
                <button onclick="openModalBobot()" class="flex-1 md:flex-none px-6 py-3.5 bg-white border border-slate-200 rounded-xl text-[11px] font-black uppercase tracking-widest text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Ubah Bobot
                </button>
                <button class="flex-1 md:flex-none px-6 py-3.5 bg-emerald-600 text-white rounded-xl text-[11px] font-black uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-bold text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl font-bold text-sm">{{ session('error') }}</div>
        @endif

        {{-- ROW 1: KARTU SUMMARY --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" data-aos="fade-up" data-aos-delay="100">
            <div class="bg-blue-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-blue-200 relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-2">Rata-rata Kelas</p>
                    <h3 class="text-4xl font-black">{{ $rataRata ?? '-' }}</h3>
                </div>
                <div class="absolute -right-6 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            </div>

            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-200 shadow-sm flex flex-col justify-center relative overflow-hidden group">
                <div class="absolute right-0 top-0 bottom-0 w-2 bg-emerald-500"></div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nilai Tertinggi</p>
                <div class="flex flex-col gap-1">
                    <h3 class="text-4xl font-black text-emerald-600">{{ $tertinggi['akhir'] ?? '-' }}</h3>
                    <span class="text-sm font-bold text-slate-600 mt-1 truncate">{{ $tertinggi['nama'] ?? '-' }}</span>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-200 shadow-sm flex flex-col justify-center relative overflow-hidden group">
                <div class="absolute right-0 top-0 bottom-0 w-2 bg-red-500"></div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nilai Terendah</p>
                <div class="flex flex-col gap-1">
                    <h3 class="text-4xl font-black text-red-500">{{ $terendah['akhir'] ?? '-' }}</h3>
                    <span class="text-sm font-bold text-slate-600 mt-1 truncate">{{ $terendah['nama'] ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- ROW 2: PANEL STATISTIK KELULUSAN --}}
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-6 sm:p-8" data-aos="fade-up" data-aos-delay="150">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="w-full md:w-1/3 text-center md:text-left border-b md:border-b-0 md:border-r border-slate-100 pb-6 md:pb-0 pr-0 md:pr-6">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tingkat Kelulusan (A, B, C)</p>
                    <div class="flex items-baseline justify-center md:justify-start gap-2">
                        <h3 class="text-5xl font-black {{ $persentaseLulus >= 70 ? 'text-emerald-500' : 'text-orange-500' }}">{{ $persentaseLulus }}%</h3>
                    </div>
                    <p class="text-xs font-bold text-slate-500 mt-2">{{ $distribusi['A'] + $distribusi['B'] + $distribusi['C'] }} dari {{ $totalMhs }} Mahasiswa Lulus</p>
                </div>
                
                <div class="w-full md:w-2/3 grid grid-cols-5 gap-2 sm:gap-4 text-center">
                    <div class="bg-slate-50 rounded-2xl p-3 border border-slate-100">
                        <span class="block text-xl font-black text-emerald-600">{{ $distribusi['A'] }}</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Grade A</span>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-3 border border-slate-100">
                        <span class="block text-xl font-black text-blue-600">{{ $distribusi['B'] }}</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Grade B</span>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-3 border border-slate-100">
                        <span class="block text-xl font-black text-yellow-500">{{ $distribusi['C'] }}</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Grade C</span>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-3 border border-slate-100">
                        <span class="block text-xl font-black text-orange-500">{{ $distribusi['D'] }}</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Grade D</span>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-3 border border-slate-100">
                        <span class="block text-xl font-black text-red-500">{{ $distribusi['E'] }}</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Grade E</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ROW 3: TABEL DATA --}}
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="200">
            <div class="bg-slate-50/50 p-5 border-b border-slate-100 flex items-center justify-between">
                <span class="text-xs font-black text-slate-600 uppercase tracking-widest ml-2">Tabel Nilai</span>
                <span class="text-[9px] font-bold text-blue-600 bg-blue-100 px-3 py-1 rounded-lg border border-blue-200">
                    Bobot: A({{ $bobot->absen }}%) T({{ $bobot->tugas }}%) UTS({{ $bobot->uts }}%) UAS({{ $bobot->uas }}%)
                </span>
            </div>
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-sm text-left whitespace-nowrap">
                    <thead class="bg-white border-b border-slate-100 text-[10px] text-slate-400 uppercase tracking-widest font-black">
                        <tr>
                            <th class="px-6 py-5 w-10 text-center">#</th>
                            <th class="px-6 py-5">Mahasiswa</th>
                            <th class="px-4 py-5 text-center">Absen</th>
                            <th class="px-4 py-5 text-center">Tugas</th>
                            <th class="px-4 py-5 text-center">UTS</th>
                            <th class="px-4 py-5 text-center">UAS</th>
                            <th class="px-6 py-5 text-center">Akhir</th>
                            <th class="px-6 py-5 text-center">Huruf</th>
                            <th class="px-6 py-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($mahasiswas as $i => $mhs)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4 font-bold text-slate-400 text-center">{{ $i + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-xs border border-indigo-100 shrink-0">
                                        {{ strtoupper(substr($mhs['nama'], 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ $mhs['nama'] }}</p>
                                        <p class="text-[10px] font-mono text-slate-400 tracking-wide mt-0.5">{{ $mhs['nim'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center font-bold text-slate-600">{{ $mhs['absen'] }}</td>
                            <td class="px-4 py-4 text-center font-bold text-slate-600">{{ $mhs['tugas'] }}</td>
                            <td class="px-4 py-4 text-center font-bold text-slate-600">{{ $mhs['uts'] }}</td>
                            <td class="px-4 py-4 text-center font-bold text-slate-600">{{ $mhs['uas'] }}</td>
                            <td class="px-6 py-4 text-center font-black text-slate-900 text-lg">{{ $mhs['akhir'] }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest
                                    @if($mhs['huruf'] === 'A') bg-emerald-100 text-emerald-700
                                    @elseif($mhs['huruf'] === 'B') bg-blue-100 text-blue-700
                                    @elseif($mhs['huruf'] === 'C') bg-yellow-100 text-yellow-700
                                    @elseif($mhs['huruf'] === 'D') bg-orange-100 text-orange-700
                                    @elseif($mhs['huruf'] === 'E') bg-red-100 text-red-700
                                    @endif">
                                    {{ $mhs['huruf'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button type="button" 
                                    onclick="openModalEdit('{{ $mhs['id'] }}', '{{ addslashes($mhs['nama']) }}', '{{ $mhs['absen'] }}', '{{ $mhs['tugas'] }}', '{{ $mhs['uts'] }}', '{{ $mhs['uas'] }}')" 
                                    class="inline-block px-4 py-2 bg-white text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg font-bold text-[10px] uppercase tracking-widest transition-all border border-slate-200 hover:border-blue-600 shadow-sm cursor-pointer">
                                    Edit
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-12 text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 mb-3 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    <span class="font-bold text-sm">Belum ada data nilai mahasiswa.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    {{-- MODAL 1: UBAH BOBOT NILAI --}}
    <div id="modalBobot" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm items-center justify-center p-4 transition-opacity">
        <div class="bg-white rounded-[2rem] w-full max-w-md shadow-2xl overflow-hidden animate-pop">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="font-black text-slate-800 text-lg">Atur Bobot Penilaian</h3>
                <button type="button" onclick="closeModalBobot()" class="text-slate-400 hover:text-red-500 transition-colors p-1"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <form action="{{ route('dosen.grades.settings.update', $kelas->id) }}" method="POST">
                @csrf
                <div class="p-6 space-y-5">
                    <div class="flex justify-between items-center bg-blue-50 p-3 rounded-xl border border-blue-100">
                        <span class="text-xs font-bold text-blue-800">Total Harus 100%:</span>
                        <span id="modalTotalBadge" class="px-2 py-1 bg-emerald-500 text-white text-xs font-black rounded-md">100%</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Absensi (%)</label><input type="number" id="m_absen" name="absen" value="{{ $bobot->absen }}" class="b-input w-full bg-slate-50 border border-slate-200 rounded-xl p-3 font-black text-slate-700 focus:ring-2 focus:ring-blue-500 outline-none" oninput="cekTotalBobot()"></div>
                        <div><label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Tugas (%)</label><input type="number" id="m_tugas" name="tugas" value="{{ $bobot->tugas }}" class="b-input w-full bg-slate-50 border border-slate-200 rounded-xl p-3 font-black text-slate-700 focus:ring-2 focus:ring-blue-500 outline-none" oninput="cekTotalBobot()"></div>
                        <div><label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">UTS (%)</label><input type="number" id="m_uts" name="uts" value="{{ $bobot->uts }}" class="b-input w-full bg-slate-50 border border-slate-200 rounded-xl p-3 font-black text-slate-700 focus:ring-2 focus:ring-blue-500 outline-none" oninput="cekTotalBobot()"></div>
                        <div><label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">UAS (%)</label><input type="number" id="m_uas" name="uas" value="{{ $bobot->uas }}" class="b-input w-full bg-slate-50 border border-slate-200 rounded-xl p-3 font-black text-slate-700 focus:ring-2 focus:ring-blue-500 outline-none" oninput="cekTotalBobot()"></div>
                    </div>
                </div>
                <div class="p-5 border-t border-slate-100 flex gap-3 bg-slate-50">
                    <button type="button" onclick="closeModalBobot()" class="flex-1 px-4 py-3 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-100 transition-colors text-sm">Batal</button>
                    <button type="submit" id="btnSaveBobot" class="flex-1 px-4 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors text-sm shadow-md">Simpan Bobot</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL 2: EDIT NILAI INDIVIDU --}}
    <div id="modalEditNilai" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm items-center justify-center p-4 transition-opacity">
        <div class="bg-white rounded-[2rem] w-full max-w-lg shadow-2xl overflow-hidden animate-pop relative">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="font-black text-slate-800 text-lg">Edit Nilai Individu</h3>
                <button type="button" onclick="closeModalEdit()" class="text-slate-400 hover:text-red-500 transition-colors p-1"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            
            <form id="formEditNilai" method="POST">
                @csrf @method('PUT')
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-6 p-4 bg-indigo-50 border border-indigo-100 rounded-xl">
                        <div class="w-10 h-10 rounded-full bg-white text-indigo-600 flex items-center justify-center font-black shadow-sm" id="editInitials">--</div>
                        <div>
                            <p class="font-black text-slate-900" id="editNama">Nama Mahasiswa</p>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-0.5">Ubah Nilai</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                        <div><label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Absen</label><input type="number" id="e_absen" name="absen" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 font-black text-slate-700 text-center focus:ring-2 focus:ring-blue-500 outline-none"></div>
                        <div><label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Tugas</label><input type="number" id="e_tugas" name="tugas" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 font-black text-slate-700 text-center focus:ring-2 focus:ring-blue-500 outline-none"></div>
                        <div><label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">UTS</label><input type="number" id="e_uts" name="uts" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 font-black text-slate-700 text-center focus:ring-2 focus:ring-blue-500 outline-none"></div>
                        <div><label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">UAS</label><input type="number" id="e_uas" name="uas" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 font-black text-slate-700 text-center focus:ring-2 focus:ring-blue-500 outline-none"></div>
                    </div>
                </div>
                <div class="p-5 border-t border-slate-100 flex gap-3 bg-slate-50">
                    <button type="button" onclick="closeModalEdit()" class="flex-1 px-4 py-3 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-100 transition-colors text-sm">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors text-sm shadow-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, easing: 'ease-out-cubic', duration: 800 });

        // LOGIKA MODAL BOBOT
        const mBobot = document.getElementById('modalBobot');
        const bInputs = document.querySelectorAll('.b-input');
        
        function openModalBobot() { mBobot.classList.add('modal-active'); }
        function closeModalBobot() { mBobot.classList.remove('modal-active'); }
        
        function cekTotalBobot() {
            let tot = 0;
            bInputs.forEach(i => tot += (parseFloat(i.value) || 0));
            let badge = document.getElementById('modalTotalBadge');
            let btn = document.getElementById('btnSaveBobot');
            
            badge.innerText = tot + '%';
            if(tot === 100) {
                badge.className = 'px-2 py-1 bg-emerald-500 text-white text-xs font-black rounded-md';
                btn.disabled = false; btn.classList.replace('bg-slate-400', 'bg-blue-600');
            } else {
                badge.className = 'px-2 py-1 bg-red-500 text-white text-xs font-black rounded-md';
                btn.disabled = true; btn.classList.replace('bg-blue-600', 'bg-slate-400');
            }
        }

        // LOGIKA MODAL EDIT NILAI
        const mEdit = document.getElementById('modalEditNilai');
        function openModalEdit(id, nama, absen, tugas, uts, uas) {
            document.getElementById('formEditNilai').action = `/dosen/kelas/{{ $kelas->id }}/rekap-nilai/edit/${id}`;
            document.getElementById('editNama').innerText = nama;
            document.getElementById('editInitials').innerText = nama.substring(0,2).toUpperCase();
            document.getElementById('e_absen').value = absen;
            document.getElementById('e_tugas').value = tugas;
            document.getElementById('e_uts').value = uts;
            document.getElementById('e_uas').value = uas;
            mEdit.classList.add('modal-active');
        }
        function closeModalEdit() { mEdit.classList.remove('modal-active'); }
    </script>
</body>
</html>