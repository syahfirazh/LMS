<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Rekap Nilai Tugas | Portal Dosen</title>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .custom-scrollbar::-webkit-scrollbar { height: 8px; width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="font-['Plus_Jakarta_Sans'] bg-[#f1f5f9] text-slate-800 min-h-full flex flex-col border-box overflow-x-hidden selection:bg-blue-200">
    
    <div class="w-full bg-white/80 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm transition-all">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-5">
            
            <div class="flex items-center gap-4">
                <a href="{{ route('dosen.course.assignments', $kelas->id) }}" class="w-11 h-11 md:w-12 md:h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all shadow-sm shrink-0 group border border-slate-200 hover:border-blue-600">
                    <svg class="w-5 h-5 md:w-6 md:h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="overflow-hidden">
                    <h1 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight leading-tight truncate">
                        Rekap Nilai Tugas
                    </h1>
                    <div class="flex items-center gap-3 mt-1">
                        <span class="text-[10px] font-black text-blue-700 uppercase tracking-widest bg-blue-100 px-2.5 py-1 rounded-md">
                            Kelas {{ $kelas->kode_kelas }}
                        </span>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">
                            {{ $kelas->mataKuliah->nama }}
                        </span>
                    </div>
                </div>
            </div>

            <button onclick="window.print()" class="hidden md:flex px-5 py-2.5 bg-slate-800 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-900 transition-all items-center gap-2 shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak PDF
            </button>
            
        </div>
    </div>

    <main class="flex-1 max-w-7xl mx-auto p-4 md:p-8 w-full space-y-6 mb-20">
        
        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-duration="600">
            
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="font-black text-slate-800 text-sm uppercase tracking-wider">Matriks Nilai Mahasiswa</h3>
                    <p class="text-xs text-slate-500 font-medium mt-1">Menampilkan rekapitulasi nilai untuk {{ $assignments->count() }} Tugas.</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-100 border border-emerald-300"></span> <span class="text-[10px] font-bold text-slate-500 mr-2">Sudah Dinilai</span>
                    <span class="w-3 h-3 rounded-full bg-slate-100 border border-slate-300"></span> <span class="text-[10px] font-bold text-slate-500">Belum / Kosong</span>
                </div>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead>
                        <tr class="bg-slate-100/80 text-[10px] uppercase tracking-widest text-slate-500 border-b border-slate-200">
                            <th class="p-4 font-black w-10 text-center">No</th>
                            <th class="p-4 font-black min-w-[200px] sticky left-0 bg-slate-100/80 shadow-[2px_0_5px_rgba(0,0,0,0.02)] z-10">Mahasiswa</th>
                            
                            @foreach($assignments as $tugas)
                                <th class="p-4 font-black text-center min-w-[100px] border-l border-slate-200/60" title="{{ $tugas->judul }}">
                                    <div class="truncate w-24 mx-auto text-blue-600">Tugas {{ $loop->iteration }}</div>
                                    <div class="text-[8px] text-slate-400 mt-1 truncate">{{ Str::limit($tugas->judul, 15) }}</div>
                                </th>
                            @endforeach
                            
                            <th class="p-4 font-black text-center bg-blue-50 border-l border-blue-100 min-w-[100px]">Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm font-medium">
                        
                        @forelse($kelas->mahasiswa as $index => $mhs)
                            @php
                                $totalNilai = 0;
                                $jumlahDinilai = 0;
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="p-4 text-center text-slate-400">{{ $index + 1 }}</td>
                                <td class="p-4 sticky left-0 bg-white group-hover:bg-slate-50/90 shadow-[2px_0_5px_rgba(0,0,0,0.02)] z-10 transition-colors">
                                    <div class="font-bold text-slate-800">{{ $mhs->nama }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono tracking-wider mt-0.5">{{ $mhs->nim }}</div>
                                </td>
                                
                                @foreach($assignments as $tugas)
                                    @php
                                        // Cari nilai mahasiswa ini di tugas terkait
                                        // Sesuaikan 'mahasiswa_id' dan 'nilai' dengan kolom di database-mu
                                        $submission = $tugas->submissions->where('mahasiswa_id', $mhs->id)->first();
                                        $nilai = $submission ? $submission->nilai : null;
                                        
                                        if($nilai !== null) {
                                            $totalNilai += $nilai;
                                            $jumlahDinilai++;
                                        }
                                    @endphp
                                    
                                    <td class="p-4 text-center border-l border-slate-100">
                                        @if($nilai !== null)
                                            <span class="inline-flex items-center justify-center w-10 h-8 bg-emerald-50 text-emerald-700 font-black rounded-lg border border-emerald-100">
                                                {{ $nilai }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center w-10 h-8 bg-slate-50 text-slate-400 font-bold rounded-lg border border-slate-100">
                                                -
                                            </span>
                                        @endif
                                    </td>
                                @endforeach
                                
                                @php
                                    $rataRata = $jumlahDinilai > 0 ? round($totalNilai / $assignments->count(), 1) : 0;
                                    
                                    // Tentukan warna badge rata-rata
                                    $badgeColor = 'bg-slate-100 text-slate-500';
                                    if($rataRata >= 80) $badgeColor = 'bg-blue-100 text-blue-700 border border-blue-200';
                                    elseif($rataRata >= 60) $badgeColor = 'bg-amber-100 text-amber-700 border border-amber-200';
                                    elseif($rataRata > 0) $badgeColor = 'bg-red-100 text-red-700 border border-red-200';
                                @endphp
                                
                                <td class="p-4 text-center bg-blue-50/30 border-l border-blue-50">
                                    <span class="inline-flex items-center justify-center px-3 py-1.5 {{ $badgeColor }} font-black rounded-lg text-xs shadow-sm">
                                        {{ $rataRata > 0 ? $rataRata : '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $assignments->count() + 3 }}" class="p-10 text-center text-slate-400 font-bold">
                                    Belum ada data mahasiswa di kelas ini.
                                </td>
                            </tr>
                        @endforelse
                        
                    </tbody>
                </table>
            </div>
            
            <div class="bg-slate-50 p-4 border-t border-slate-100 text-center">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Gunakan layar laptop/desktop untuk tampilan tabel yang lebih optimal</p>
            </div>
        </div>

    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, easing: 'ease-out-cubic', duration: 800 });
    </script>
</body>
</html>