<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Detail Riwayat - Pertemuan 1 | Portal Dosen</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
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
        class="font-['Plus_Jakarta_Sans'] bg-[#f8fafc] text-slate-800 min-h-full flex flex-col border-box overflow-x-hidden"
    >
        <div
            class="bg-white/90 backdrop-blur-xl border-b border-slate-200 sticky top-0 z-40 px-4 md:px-6 py-4 shadow-sm transition-all"
        >
            <div class="max-w-6xl mx-auto flex items-center gap-4">
                <a
                    href="{{ route('dosen.attendance.index', $session->kelas_id) }}"
                    class="w-10 h-10 rounded-full bg-slate-50 hover:bg-slate-100 text-slate-400 hover:text-slate-600 flex items-center justify-center transition-all border border-slate-200 shrink-0"
                >
                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2.5"
                            d="M15 19l-7-7 7-7"
                        ></path>
                    </svg>
                </a>

                <div class="overflow-hidden">
                    <h1
                        class="text-xl font-extrabold text-slate-900 tracking-tight leading-none truncate"
                    >
                        Detail Riwayat
                    </h1>
                    <p
                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 truncate"
                    >
                        Pertemuan {{ $session->urutan }}: {{ $session->judul }}
                    </p>
                </div>
            </div>
        </div>

        <main
            class="flex-1 max-w-6xl mx-auto p-4 md:p-6 lg:p-8 w-full space-y-6"
        >
            <div
                class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm"
            >
                <div
                    class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-slate-100 pb-6 mb-6"
                >
                    <div>
                        <h2 class="text-2xl font-black text-slate-900">
                            {{ $session->judul }}
                        </h2>
                        <p class="text-sm text-slate-500 font-medium mt-1">
                            {{ \Carbon\Carbon::parse($session->tanggal)->translatedFormat('l, d M Y') }}
    • {{ $session->jam_mulai }} - {{ $session->jam_selesai }} WIB
                        </p>
                    </div>
                    <a
                        href="{{ route('dosen.attendance.manual', $session->id) }}"
                        class="px-5 py-2 bg-slate-100 text-slate-600 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-blue-50 hover:text-blue-600 transition-all border border-slate-200 flex items-center gap-2"
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
                                stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                            ></path>
                        </svg>
                        Edit Absensi
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div
                        class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-center"
                    >
                        <span class="block text-2xl font-black text-emerald-600"
                            >{{ $rekap['hadir'] }}</span
                        >
                        <span
                            class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest"
                            >Hadir</span
                        >
                    </div>
                    <div
                        class="p-4 rounded-2xl bg-blue-50 border border-blue-100 text-center"
                    >
                        <span class="block text-2xl font-black text-blue-600"
                            >{{ $rekap['izin'] }}</span
                        >
                        <span
                            class="text-[10px] font-bold text-blue-400 uppercase tracking-widest"
                            >Izin</span
                        >
                    </div>
                    <div
                        class="p-4 rounded-2xl bg-orange-50 border border-orange-100 text-center"
                    >
                        <span class="block text-2xl font-black text-orange-600"
                            >{{ $rekap['sakit'] }}</span
                        >
                        <span
                            class="text-[10px] font-bold text-orange-400 uppercase tracking-widest"
                            >Sakit</span
                        >
                    </div>
                    <div
                        class="p-4 rounded-2xl bg-red-50 border border-red-100 text-center"
                    >
                        <span class="block text-2xl font-black text-red-600"
                            >{{ $rekap['alpha'] }}</span
                        >
                        <span
                            class="text-[10px] font-bold text-red-400 uppercase tracking-widest"
                            >Alpha</span
                        >
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden"
            >
                <div
                    class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center"
                >
                    <h3
                        class="font-bold text-slate-700 text-sm uppercase tracking-wider"
                    >
                        Detail Kehadiran
                    </h3>
                    <div class="relative">
                        <input
                            type="text"
                            placeholder="Cari..."
                            class="pl-8 pr-4 py-1.5 rounded-lg border border-slate-200 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 w-32 md:w-48"
                        />
                        <svg
                            class="w-3 h-3 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            ></path>
                        </svg>
                    </div>
                </div>

                <div class="divide-y divide-slate-100">
                    @foreach ($detail as $mhs)
                    <div
                        class="p-4 md:p-6 flex items-center justify-between hover:bg-slate-50 transition-colors"
                    >
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs shrink-0"
                            >
                                {{ strtoupper(substr($mhs->nama, 0, 2)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">
                                    {{ $mhs->nama }}
                                </h4>
                                <p class="text-[10px] text-slate-400 font-mono">
                                    {{ $mhs->nim }}
                                </p>
                            </div>
                        </div>
                        <span
                            class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-bold uppercase tracking-widest"
                            >@if ($mhs->status == 'hadir') bg-emerald-100 text-emerald-700
                @elseif ($mhs->status == 'izin') bg-blue-100 text-blue-700
                @elseif ($mhs->status == 'sakit') bg-orange-100 text-orange-700
                @else bg-red-100 text-red-700 @endif">
                {{ ucfirst($mhs->status) }}</span
                        >
                    </div>
@endforeach
                    
        </main>
    </body>
</html>
