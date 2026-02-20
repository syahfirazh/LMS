<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Peserta Kelas | Portal Dosen</title>
        
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
                    <button class="snap-start shrink-0 px-6 py-2.5 rounded-xl bg-white text-blue-700 font-black text-[10px] uppercase tracking-widest shadow-sm border border-slate-200/60 whitespace-nowrap transition-all flex items-center justify-center">
                        Peserta
                    </button>
                    <a href="{{ route('dosen.grades.recap', $kelas->id) }}" class="snap-start shrink-0 px-6 py-2.5 rounded-xl text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/60 flex items-center justify-center">
                        Rekap Nilai
                    </a>
                </nav>
            </div>
        </div>

        <main
            class="flex-1 max-w-7xl mx-auto p-4 md:p-8 w-full space-y-10 mb-20"
        >
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" data-aos="fade-up">
                
                <div class="space-y-6">
                    <div
                        class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[2.5rem] p-8 text-white shadow-xl shadow-blue-100 flex flex-col justify-between relative overflow-hidden h-64"
                        data-aos="fade-up" data-aos-delay="100"
                    >
                        <div class="relative z-10">
                            <div
                                class="flex items-center gap-3 mb-4 text-blue-200"
                            >
                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"
                                    ></path>
                                </svg>
                                <span
                                    class="text-xs font-black uppercase tracking-widest"
                                    >Cara Cepat</span
                                >
                            </div>
                            <h3 class="text-2xl font-black mb-2">
                                Kode Akses Kelas
                            </h3>
                            <div
                                class="bg-white/10 border border-white/20 rounded-2xl p-4 text-center backdrop-blur-md mt-4"
                            >
                                <span
                                    class="block text-4xl font-black tracking-widest font-mono"
                                    >{{ $kelas->kode_akses }}</span
                                >
                            </div>
                        </div>
                        <div class="relative z-10 mt-4 flex gap-3">
                            <button
                                onclick="copyKodeAkses()"
                                class="flex-1 py-3 bg-white text-blue-600 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-blue-50 transition-all shadow-lg"
                            >
                                Salin Kode
                            </button>
                        </div>
                        <div
                            class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"
                        ></div>
                    </div>

                    <div
                        class="bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm"
                        data-aos="fade-up" data-aos-delay="200"
                    >
                        <h3
                            class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4"
                        >
                            Tambah Manual
                        </h3>
                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('dosen.course.addStudent', $kelas->id) }}" class="flex gap-2 w-full">
                                @csrf
                                <input
                                    type="text"
                                    name="nim"
                                    placeholder="NIM..."
                                    class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-blue-500 outline-none w-full"
                                />
                                <button
                                    class="bg-slate-900 text-white p-3 rounded-xl hover:bg-slate-700 transition-all"
                                >
                                    +
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2" data-aos="fade-up" data-aos-delay="150">
                    <div
                        class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden h-full"
                    >
                        <div
                            class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50"
                        >
                            <h3 class="font-bold text-slate-700">
                                Daftar Mahasiswa ({{ $kelas->mahasiswa->count() }})
                            </h3>
                            <div class="flex gap-2 opacity-50 pointer-events-none">
                                <button class="p-2 text-slate-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg></button>
                                <button class="p-2 text-slate-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </div>
                        </div>

                        <div class="overflow-y-auto max-h-[600px]">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-slate-50 text-slate-500 uppercase tracking-widest text-[10px] sticky top-0 z-10">
                                    <tr>
                                        <th class="px-6 py-4 font-black">Mahasiswa</th>
                                        <th class="px-6 py-4 font-black">NIM</th>
                                        <th class="px-6 py-4 font-black text-center">Status</th>
                                        <th class="px-6 py-4 font-black text-right">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-slate-100">
                                    @forelse($kelas->mahasiswa as $mhs)
                                    <tr class="hover:bg-blue-50/50 transition-colors group">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-slate-200 overflow-hidden shrink-0">
                                                    <img
                                                        src="https://ui-avatars.com/api/?name={{ urlencode($mhs->nama) }}&background=0D8ABC&color=fff"
                                                        class="w-full h-full object-cover"
                                                    />
                                                </div>
                                                <span class="font-bold text-slate-900">
                                                    {{ $mhs->nama }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-mono text-slate-500 font-bold">
                                            {{ $mhs->nim }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded text-[10px] font-bold uppercase tracking-wide">
                                                {{ $mhs->status ?? 'Aktif' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <form method="POST" action="{{ route('dosen.course.removeStudent', [$kelas->id, $mhs->id]) }}" onsubmit="return confirm('Hapus mahasiswa ini dari kelas?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-slate-400 hover:text-red-600 transition-colors font-bold text-xs p-2 hover:bg-red-50 rounded-lg">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-6 text-slate-400">
                                            Belum ada mahasiswa
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({ once: true, easing: 'ease-out-cubic', duration: 800 });

            function copyKodeAkses() {
                const kode = "{{ $kelas->kode_akses }}";
                navigator.clipboard.writeText(kode);

                const btn = event.target;
                const originalText = btn.innerText;
                btn.innerText = "Tersalin!";
                btn.classList.add('bg-blue-50', 'text-blue-700'); // Feedback visual

                setTimeout(() => {
                    btn.innerText = originalText;
                    btn.classList.remove('bg-blue-50', 'text-blue-700');
                }, 2000);
            }
        </script>

    </body>
</html>