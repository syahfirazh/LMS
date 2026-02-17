<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Periksa Tugas | Portal Dosen</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
            rel="stylesheet"
        />
        <style>
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
            .custom-scrollbar::-webkit-scrollbar {
                width: 5px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background-color: #cbd5e1;
                border-radius: 20px;
            }
        </style>
    </head>
    <body
        class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-full flex flex-col border-box overflow-x-hidden text-slate-800"
    >
        <div
    class="bg-white/90 backdrop-blur-xl border-b border-slate-200 sticky top-0 z-30 px-6 py-4"
>
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div class="flex items-center gap-4">
            {{-- BACK --}}
            <a
                href="{{ route('dosen.course.assignments', $kelas->id) }}"
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

            {{-- INFO TUGAS --}}
            <div>
                <h1 class="text-lg font-extrabold text-slate-900 tracking-tight">
                    {{ $assignment->judul }}
                </h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">
                    {{ $kelas->nama }}
                    {{ $assignment->submissions()->count() }}/{{ $mahasiswas->count() }} Terkumpul
                </p>
            </div>
        </div>

        {{-- NAV MAHASISWA --}}
        <div class="flex items-center gap-2">
            {{-- PREV --}}
            @php
    $index = $mahasiswas->search(fn($m) => $m->id == $activeMahasiswaId);

    if($index === false) {
        $index = 0;
    }

    $prev = $mahasiswas->get($index - 1);
    $next = $mahasiswas->get($index + 1);
@endphp


            <a
                href="{{ $prev
    ? route('dosen.assignment.grade', [$kelas->id, $assignment->id, $prev->id])
    : '#' }}"

                class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-50 transition-all flex items-center gap-2 {{ !$prev ? 'opacity-50 pointer-events-none' : '' }}"
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
                        d="M15 19l-7-7 7-7"
                    ></path>
                </svg>
                Prev
            </a>

            {{-- COUNTER --}}
            <div class="text-xs font-bold text-slate-400 uppercase tracking-widest px-2">
                Mhs {{ $index + 1 }} dari {{ $mahasiswas->count() }}
            </div>

            {{-- NEXT --}}
            <a
                href="{{ $next
    ? route('dosen.assignment.grade', [$kelas->id, $assignment->id, $next->id])
    : '#' }}"

                class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-blue-600 transition-all flex items-center gap-2 shadow-lg {{ !$next ? 'opacity-50 pointer-events-none' : '' }}"
            >
                Next
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
                        d="M9 5l7 7-7 7"
                    ></path>
                </svg>
            </a>
        </div>
    </div>
</div>

        <main
            class="flex-1 max-w-7xl mx-auto p-6 w-full h-[calc(100vh-80px)] grid grid-cols-1 lg:grid-cols-12 gap-6"
        >
            <div
    class="hidden lg:block lg:col-span-3 bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden flex flex-col"
>
    <div class="p-4 border-b border-slate-100 bg-slate-50">
        <input
            type="text"
            placeholder="Cari Mahasiswa..."
            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-xs font-bold focus:outline-none focus:border-blue-500 transition-all"
        />
    </div>

    <div
        class="flex-1 overflow-y-auto custom-scrollbar p-2 space-y-1"
    >
        @foreach ($mahasiswas as $mhs)
<a href="{{ route('dosen.assignment.grade', [$kelas->id, $assignment->id, $mhs->id]) }}">
    <div
        class="p-3 {{ $activeMahasiswaId == $mhs->id ? 'bg-blue-50 border border-blue-100' : 'hover:bg-slate-50 border border-transparent hover:border-slate-100' }} rounded-xl cursor-pointer flex items-center justify-between group transition-all"
    >
        <div class="flex items-center gap-3">
            <img
                src="https://ui-avatars.com/api/?name={{ urlencode($mhs->nama) }}&background=0ea5e9&color=fff"
                class="w-8 h-8 rounded-full {{ $activeMahasiswaId == $mhs->id ? '' : 'grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100 transition-all' }}"
            />
            <div>
                <h4 class="text-xs font-bold {{ $activeMahasiswaId == $mhs->id ? 'text-slate-900' : 'text-slate-600 group-hover:text-slate-900' }}">
                    {{ $mhs->nama }}
                </h4>
                <p class="text-[9px] font-bold {{ $mhs->status_pengumpulan === 'tepat_waktu' ? 'text-blue-600' : 'text-red-500' }} uppercase">
                    {{ $mhs->status_label ?? 'Belum Mengumpulkan' }}
                </p>
            </div>
        </div>

        @if ($activeMahasiswaId == $mhs->id)
            <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
        @endif
    </div>
</a>
@endforeach

    </div>
</div>


            <div
    class="lg:col-span-9 grid grid-cols-1 lg:grid-cols-3 gap-6 h-full overflow-hidden"
>
    {{-- PREVIEW FILE --}}
    <div
        class="lg:col-span-2 bg-slate-800 rounded-[2rem] shadow-lg flex flex-col overflow-hidden relative"
    >
        <div class="absolute top-4 right-4 z-10 flex gap-2">
            @if ($submission)
                <a
                    href="{{ $submission->file_url }}"
                    target="_blank"
                    class="bg-black/50 text-white px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase backdrop-blur-md hover:bg-black/70 transition-all"
                >
                    Download
                </a>
            @endif
        </div>

        <div
            class="flex-1 flex items-center justify-center bg-slate-900/50"
        >
            @if ($submission)
                <iframe
                    src="{{ $submission->file_url }}"
                    class="w-full h-full"
                ></iframe>
            @else
                <div class="text-center">
                    <svg
                        class="w-16 h-16 text-slate-600 mx-auto mb-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 2H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                        ></path>
                    </svg>
                    <p class="text-slate-400 text-sm font-medium">
                        Pratinjau PDF Jawaban
                    </p>
                    <p class="text-slate-600 text-xs mt-1">
                        Belum ada file
                    </p>
                </div>
            @endif
        </div>

        <div
            class="h-12 bg-slate-900 border-t border-slate-700 flex items-center justify-center gap-4 text-white text-xs font-bold"
        >
            <button class="hover:text-blue-400"><</button>
            <span>Halaman {{ $currentPage ?? 1 }} / {{ $totalPages ?? 1 }}</span>
            <button class="hover:text-blue-400">></button>
        </div>
    </div>

    {{-- PANEL KANAN --}}
    <div
        class="lg:col-span-1 flex flex-col gap-4 h-full overflow-hidden"
    >
        {{-- FORM NILAI --}}
        <form
            method="POST"
            action="{{ route('dosen.assignment.grade.store', [
        'kelas' => $kelas->id,
    'assignment' => $assignment->id,
    'mahasiswa' => $activeMahasiswaId
    ]) }}"
            class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-5 overflow-y-auto custom-scrollbar shrink-0 max-h-[50%] flex flex-col"
        >
            @csrf

            <div class="mb-3 pb-3 border-b border-slate-100">
                <h3
                    class="text-sm font-black text-slate-900 uppercase tracking-widest mb-1"
                >
                    Form Penilaian
                </h3>
                <p class="text-xs text-slate-400">
                    @if($activeMahasiswa)
    {{ $activeMahasiswa->nama }} ({{ $activeMahasiswa->nim }})
@else
    <span class="text-red-500">Belum ada mahasiswa di kelas ini</span>
@endif

                </p>
            </div>

            <div class="space-y-3">
                <div>
                    <label
                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block"
                    >
                        Nilai (0-100)
                    </label>
                    <input
                        type="number"
                        name="nilai"
                        value="{{ $submission->nilai ?? '' }}"
                        class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-2 text-lg font-black text-slate-800 focus:outline-none focus:border-blue-500 text-center transition-all"
                    />
                </div>

                <div>
                    <label
                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 block"
                    >
                        Feedback
                    </label>
                    <textarea
                        name="feedback"
                        rows="3"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs font-medium text-slate-700 focus:outline-none focus:border-blue-500 transition-all resize-none"
                        placeholder="Catatan..."
                    >{{ $submission->feedback ?? '' }}</textarea>
                </div>

                <button
                    type="submit"
                    class="w-full py-3 bg-emerald-500 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-100 flex items-center justify-center gap-2"
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
                            d="M5 13l4 4L19 7"
                        ></path>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>

        {{-- DISKUSI --}}
        <div
            class="bg-white rounded-[2rem] border border-slate-200 shadow-sm flex flex-col flex-1 overflow-hidden min-h-0"
        >
            <div
                class="p-4 border-b border-slate-100 flex justify-between items-center bg-white shrink-0"
            >
                <h3
                    class="text-xs font-black text-slate-900 uppercase tracking-widest"
                >
                    Diskusi Pribadi
                </h3>
                <span
                    class="text-[9px] font-bold bg-blue-50 text-blue-600 px-2 py-0.5 rounded uppercase"
                >
                    Privat
                </span>
            </div>

            <div
                class="flex-1 overflow-y-auto custom-scrollbar p-4 space-y-4 bg-white"
            >
                @foreach ($submission?->messages ?? [] as $message)
                    @if ($message->from == 'mahasiswa')
                        <div class="flex gap-3 items-start">
                            <img
                                src="https://ui-avatars.com/api/?name={{ urlencode($activeMahasiswa->nama) }}"
                                class="w-8 h-8 rounded-full shrink-0 shadow-sm"
                            />
                            <div
                                class="bg-slate-50 p-3 rounded-2xl rounded-tl-none border border-slate-100 max-w-[90%]"
                            >
                                <p class="text-[10px] font-bold text-slate-700 mb-1">
                                    {{ $activeMahasiswa->nama }}
                                </p>
                                <p class="text-xs text-slate-600 leading-relaxed font-medium">
                                    {{ $message->body }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="flex gap-3 flex-row-reverse items-start">
                            <div
                                class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-[10px] shrink-0 shadow-md"
                            >
                                Anda
                            </div>
                            <div
                                class="bg-blue-600 p-3 rounded-2xl rounded-tr-none shadow-md text-white max-w-[90%]"
                            >
                                <p class="text-[10px] font-bold mb-1 text-blue-100 text-right">
                                    Anda
                                </p>
                                <p class="text-xs leading-relaxed font-medium">
                                    {{ $message->body }}
                                </p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
@if($submission)
            <form
                method="POST"
                action="{{ route('dosen.assignment.message', [$submission->id]) }}"
                class="p-3 bg-white border-t border-slate-100 shrink-0"
            >
                @csrf

                <div
                    class="w-full flex items-center gap-2 bg-slate-50 p-2 rounded-2xl border border-slate-200 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100 transition-all"
                >
                    <input
                        type="text"
                        name="body"
                        placeholder="Balas..."
                        class="flex-1 min-w-0 bg-transparent text-xs font-medium text-slate-700 placeholder-slate-400 focus:outline-none"
                    />

                    <button
                        type="submit"
                        class="w-8 h-8 shrink-0 rounded-xl bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-all shadow-md"
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
                                stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
                            ></path>
                        </svg>
                    </button>
                </div>
            </form>
            @else
    <div class="p-3 text-xs text-slate-400 italic">
        Mahasiswa belum mengumpulkan tugas.
    </div>
@endif
        </div>
    </div>
</div>

        </main>
        {{-- FILTER SCRIPT --}}
<script>
    function filterMahasiswa(keyword) {
        keyword = keyword.toLowerCase();
        document.querySelectorAll('.mahasiswa-item').forEach(item => {
            const name = item.dataset.name;
            item.style.display = name.includes(keyword) ? 'flex' : 'none';
        });
    }
</script>
    </body>
</html>
