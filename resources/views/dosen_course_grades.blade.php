<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Rekap Nilai | Portal Dosen</title>
        
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap"
            rel="stylesheet"
        />
        <style>
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
        class="font-['Plus_Jakarta_Sans'] bg-[#f1f5f9] text-slate-800 min-h-full flex flex-col border-box overflow-x-hidden overflow-y-scroll selection:bg-blue-200"
    >
        
        <div class="w-full bg-white/80 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm transition-all">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-5">
                
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <a href="{{ route('dosen.courses') }}" class="w-12 h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all shadow-sm shrink-0 group border border-slate-200 hover:border-blue-600">
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
                                Dosen: {{ auth('dosen')->user()->nama }}
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
                    <button class="snap-start shrink-0 px-6 py-2.5 rounded-xl bg-white text-blue-700 font-black text-[10px] uppercase tracking-widest shadow-sm border border-slate-200/60 whitespace-nowrap transition-all flex items-center justify-center">
                        Rekap Nilai
                    </button>
                </nav>
            </div>
        </div>

        <main
            class="flex-1 max-w-7xl mx-auto p-4 md:p-8 w-full space-y-8 mb-20"
        >
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-slate-200 pb-6"
                data-aos="fade-down"
            >
                <div>
                    <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">
                        Rekapitulasi Nilai
                    </h2>
                    <p class="text-sm text-slate-500 font-medium mt-1">
                        Pantau performa akademik mahasiswa semester ini.
                    </p>
                </div>
                <div class="flex gap-3 w-full md:w-auto">
                    <a
                        href="{{ route('dosen.grades.settings', $kelas->id) }}"
                        class="flex-1 md:flex-none px-6 py-3.5 bg-white border border-slate-200 rounded-xl text-[11px] font-black uppercase tracking-widest text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm flex items-center justify-center"
                    >
                        Edit Bobot
                    </a>

                    <button
                        class="flex-1 md:flex-none px-6 py-3.5 bg-emerald-600 text-white rounded-xl text-[11px] font-black uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200 flex items-center justify-center gap-2"
                    >
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2.5"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                            ></path>
                        </svg>
                        Export Excel
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-blue-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-blue-200 relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-2">
                            Rata-rata Kelas
                        </p>
                        <h3 class="text-4xl font-black">{{ $rataRata ?? '-' }}</h3>
                        <p class="text-[10px] font-bold mt-3 bg-white/20 inline-block px-3 py-1.5 rounded-lg backdrop-blur-sm">
                            +2.4 dari semester lalu
                        </p>
                    </div>
                    <div class="absolute -right-6 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                </div>

                <div class="bg-white rounded-[2.5rem] p-8 border border-slate-200 shadow-sm flex flex-col justify-center relative overflow-hidden group">
                    <div class="absolute right-0 top-0 bottom-0 w-2 bg-emerald-500"></div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">
                        Nilai Tertinggi
                    </p>
                    <div class="flex flex-col gap-1">
                        <h3 class="text-4xl font-black text-emerald-600">
                            {{ $tertinggi['akhir'] ?? '-' }}
                        </h3>
                        <span class="text-sm font-bold text-slate-600 mt-1 truncate">
                            {{ $tertinggi['nama'] ?? '-' }}
                        </span>
                    </div>
                </div>

                <div class="bg-white rounded-[2.5rem] p-8 border border-slate-200 shadow-sm flex flex-col justify-center relative overflow-hidden group">
                    <div class="absolute right-0 top-0 bottom-0 w-2 bg-red-500"></div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">
                        Nilai Terendah
                    </p>
                    <div class="flex flex-col gap-1">
                        <h3 class="text-4xl font-black text-red-500">
                             {{ $terendah['akhir'] ?? '-' }}
                        </h3>
                        <span class="text-sm font-bold text-slate-600 mt-1 truncate">
                            {{ $terendah['nama'] ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden"
                data-aos="fade-up" data-aos-delay="200"
            >
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left whitespace-nowrap">
                        <thead class="bg-slate-50 border-b border-slate-100 text-[10px] text-slate-500 uppercase tracking-widest font-black">
                            <tr>
                                <th class="px-6 py-5 w-10 text-center">#</th>
                                <th class="px-6 py-5">Mahasiswa</th>
                                <th class="px-6 py-5 text-center">Tugas ({{ $bobot->tugas ?? 0 }}%)</th>
                                <th class="px-6 py-5 text-center">UTS ({{ $bobot->uts ?? 0 }}%)</th>
                                <th class="px-6 py-5 text-center">UAS ({{ $bobot->uas ?? 0 }}%)</th>
                                <th class="px-6 py-5 text-center">Absen ({{ $bobot->absen ?? 0 }}%)</th>
                                <th class="px-6 py-5 text-center">Akhir</th>
                                <th class="px-6 py-5 text-center">Huruf</th>
                                <th class="px-6 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($mahasiswas as $i => $mhs)
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="px-6 py-4 font-bold text-slate-400 text-center">
                                    {{ $i + 1 }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-xs border border-indigo-100 shrink-0">
                                            {{ strtoupper(substr($mhs['nama'], 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors">
                                                {{ $mhs['nama'] }}
                                            </p>
                                            <p class="text-[10px] font-mono text-slate-400 tracking-wide mt-0.5">
                                                {{ $mhs['nim'] }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center font-bold text-slate-600">
                                    {{ $mhs['tugas'] }}
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-slate-600">
                                    {{ $mhs['uts'] }}
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-slate-600">
                                    {{ $mhs['uas'] }}
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-slate-600">
                                    {{ $mhs['absen'] }}
                                </td>

                                <td class="px-6 py-4 text-center font-black text-slate-900 text-lg">
                                    {{ $mhs['akhir'] }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest
                                        @if($mhs['huruf'] === 'A') bg-emerald-100 text-emerald-700
                                        @elseif($mhs['huruf'] === 'B') bg-blue-100 text-blue-700
                                        @elseif($mhs['huruf'] === 'C') bg-yellow-100 text-yellow-700
                                        @elseif($mhs['huruf'] === 'D') bg-orange-100 text-orange-700
                                        @elseif($mhs['huruf'] === 'E') bg-red-100 text-red-700
                                        @else bg-slate-100 text-slate-500
                                        @endif">
                                        {{ $mhs['huruf'] }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('dosen.grades.edit', [$kelas->id, $mhs['id']]) }}"
                                       class="inline-block px-4 py-2 bg-slate-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg font-bold text-[10px] uppercase tracking-widest transition-all border border-slate-100 hover:border-blue-600">
                                        Edit
                                    </a>
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

                <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex justify-center">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                        Menampilkan {{ count($mahasiswas ?? []) }} Mahasiswa
                    </span>
                </div>
            </div>
        </main>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({ once: true, easing: 'ease-out-cubic', duration: 800 });
        </script>
    </body>
</html>