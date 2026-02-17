<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Kelola Penugasan | Portal Dosen</title>
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
            class="bg-white/90 backdrop-blur-xl border-b border-slate-200 sticky top-0 z-30 px-4 md:px-6 py-4 shadow-sm transition-all"
        >
            <div
                class="max-w-6xl mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-4 md:gap-6"
            >
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <a
                        href="{{ route('dosen.courses') }}"
                        class="w-10 h-10 rounded-full bg-slate-50 hover:bg-blue-50 text-slate-400 hover:text-blue-600 flex items-center justify-center transition-all border border-slate-200 shrink-0"
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
                            class="text-xl font-extrabold text-slate-900 tracking-tight leading-none truncate max-w-[250px] md:max-w-none"
                        >
                                {{ $kelas->mataKuliah->nama }}
                        </h1>
                        <div class="flex items-center gap-2 mt-1">
                            <span
                                class="text-[10px] font-bold text-blue-600 uppercase tracking-widest bg-blue-50 px-2 py-0.5 rounded"
                                >Kelas {{ $kelas->kode_kelas ?? '' }}</span
                            >
                            <span
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest truncate"
                                >Dosen: {{ auth()->guard('dosen')->user()->nama }}</span
                            >
                        </div>
                    </div>
                </div>

                <div class="hidden md:block w-px h-8 bg-slate-200"></div>

                <nav
                    class="w-full md:w-auto flex p-1 bg-slate-100 rounded-xl overflow-x-auto scrollbar-hide snap-x gap-1"
                >
                    <a
                        href="{{ route('dosen.course.manage', $kelas->id) }}"
                        class="snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/50 flex items-center justify-center"
                        >Materi & Modul</a
                    >
                    <a
                        href="{{ route('dosen.attendance.index', $kelas->id) }}"
                        class="snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/50 flex items-center justify-center"
                        >Absensi</a
                    >
                    <button
                        class="snap-start shrink-0 px-5 py-2 rounded-lg bg-white text-blue-700 font-bold text-[10px] uppercase tracking-widest shadow-sm border border-slate-200 whitespace-nowrap transition-all"
                    >
                        Penugasan
                    </button>
                    <a
                        href="{{ route('dosen.course.students', $kelas->id) }}"
                        class="snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/50 flex items-center justify-center"
                        >Peserta</a
                    >
                    <a
                        href="{{ route('dosen.grades.recap', $kelas->id) }}"
                        class="snap-start shrink-0 px-5 py-2 rounded-lg text-slate-500 hover:text-slate-900 font-bold text-[10px] uppercase tracking-widest transition-all whitespace-nowrap hover:bg-white/50 flex items-center justify-center"
                        >Rekap Nilai</a
                    >
                </nav>

                <div class="hidden md:flex items-center justify-end w-10"></div>
            </div>
        </div>

        <main
            class="flex-1 max-w-6xl mx-auto p-4 md:p-6 lg:p-8 w-full space-y-8"
        >
            <div
                class="flex flex-col md:flex-row justify-between items-end md:items-center gap-4"
            >
                <div>
                    <h2
                        class="text-2xl font-black text-slate-900 tracking-tight"
                    >
                        Daftar Tugas
                    </h2>
                    <p class="text-sm text-slate-500 font-medium mt-1">
                        Kelola tugas, kuis, dan pengumpulan mahasiswa.
                    </p>
                </div>
                <a
                    href="{{ route('dosen.assignment.create', $kelas) }}"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-blue-700 transition-all flex items-center gap-2 shadow-lg shadow-blue-200 group"
                >
                    <svg
                        class="w-4 h-4 group-hover:scale-110 transition-transform"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4v16m8-8H4"
                        ></path>
                    </svg>
                    Buat Tugas Baru
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    @forelse($assignments as $assignment)
    <div
        class="block bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm hover:shadow-md transition-all group relative overflow-hidden"
    >

        {{-- Deadline --}}
        @if($assignment->deadline)
        <div
            class="absolute top-0 right-0 bg-orange-100 text-orange-700 px-4 py-2 rounded-bl-2xl text-[10px] font-bold uppercase tracking-widest"
        >
            Deadline: {{ \Carbon\Carbon::parse($assignment->deadline)->translatedFormat('d M Y') }}
        </div>
        @endif

        <div class="mt-4">
            {{-- Icon Box (warna sesuai urutan seperti desain awal) --}}
            @php
                $colors = [
                    ['bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
                    ['bg' => 'bg-purple-100', 'text' => 'text-purple-600'],
                ];
                $color = $colors[$loop->index % 2];
            @endphp

            <div
                class="w-14 h-14 {{ $color['bg'] }} {{ $color['text'] }} rounded-2xl flex items-center justify-center font-black text-xl mb-4"
            >
                T{{ $loop->iteration }}
            </div>

            <h3
                class="text-lg font-black text-slate-900 group-hover:text-blue-600 transition-colors"
            >
                {{ $assignment->judul }}
            </h3>

            <p
                class="text-sm text-slate-500 mt-2 line-clamp-2 leading-relaxed"
            >
                {{ $assignment->deskripsi }}
            </p>
        </div>

        <div
            class="mt-6 pt-6 border-t border-slate-100 flex justify-between items-center"
        >

            @if($assignment->status === 'published')
                <div>
                    <span
                        class="block text-2xl font-black text-slate-900"
                    >
                        {{ $assignment->submissions_count }}
                        <span
                            class="text-sm text-slate-400 font-bold"
                        >
                            /{{ $kelas->mahasiswa_count }}
                        </span>
                    </span>
                    <span
                        class="text-[9px] font-bold text-slate-400 uppercase tracking-widest"
                    >
                        Sudah Submit
                    </span>
                </div>

                <a
                    href="{{ route('dosen.assignment.grade', [
        'kelas' => $kelas->id,
        'assignment' => $assignment->id
    ]) }}"
                    class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all text-center"
                >
                    Periksa
                </a>
            @else
                <div>
                    <span
                        class="px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-bold uppercase tracking-widest"
                    >
                        Draft
                    </span>
                </div>

                <a
                    href="{{ route('dosen.assignment.edit', [$kelas->id, $assignment->id]) }}"
                    class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold hover:bg-slate-50 transition-all text-center text-slate-600"
                >
                    Edit
                </a>
            @endif

        </div>
    </div>
    @empty
        <div class="col-span-full text-center text-slate-400 font-medium py-20">
            Belum ada tugas dibuat.
        </div>
    @endforelse


    {{-- Tombol tambah (IDENTIK seperti desain awal) --}}
    <a
        href="{{ route('dosen.assignment.create', $kelas->id) }}"
        class="block border-2 border-dashed border-slate-300 rounded-[2.5rem] p-6 flex flex-col items-center justify-center text-slate-400 hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50 transition-all gap-3 min-h-[250px] group cursor-pointer"
    >
        <div
            class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform"
        >
            <svg
                class="w-8 h-8"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 4v16m8-8H4"
                ></path>
            </svg>
        </div>
        <span class="font-bold text-sm uppercase tracking-widest">
            Buat Tugas Baru
        </span>
    </a>

</div>


        </main>
    </body>
</html>
