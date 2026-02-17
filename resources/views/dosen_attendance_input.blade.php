<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Input Manual - Pertemuan {{ $session->urutan }}: {{ $session->judul }}   | Portal Dosen</title>
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

            /* Custom Radio Style */
            .radio-input:checked + .radio-label {
                background-color: var(--bg-color);
                color: white;
                border-color: var(--border-color);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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
                    href="{{ route('dosen.attendance.history', $session->id) }}"
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
                        Input Presensi
                    </h1>
                    <p
                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 truncate"
                    >
                        Pertemuan : {{ $session->urutan }}: {{ $session->judul }}
                    </p>
                </div>
            </div>
        </div>

        <main
            class="flex-1 max-w-6xl mx-auto p-4 md:p-6 lg:p-8 w-full space-y-6"
        >
        <form action="{{ route('dosen.attendance.save', $session->id) }}" method="POST">
    @csrf
            <div
                class="flex flex-col md:flex-row justify-between items-end md:items-center gap-4 bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm"
            >
                <div>
                    <span
                        class="inline-block px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-bold uppercase tracking-widest mb-1"
                        >Status: 
@if($session->status == 'ongoing')
    Sedang Berlangsung
@elseif($session->status == 'finished')
    Selesai
@else
    Belum Dimulai
@endif
</span
                    >
                    <h2 class="text-lg font-black text-slate-900">
                        Pertemuan {{ $session->urutan }}: {{ $session->judul }}
                    </h2>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ \Carbon\Carbon::parse($session->tanggal )->translatedFormat('l, d M Y') }}
    • {{ $session->jam_mulai  }} - {{ $session->jam_selesai  }} WIB
                    </p>
                </div>
                <div class="flex gap-3 w-full md:w-auto">
                    <button
    type="reset"
    class="flex-1 md:flex-none px-6 py-3 rounded-xl border border-slate-200 text-slate-500 font-bold text-xs uppercase tracking-widest hover:bg-slate-50 transition-all"
>
    Reset
</button>

                    <button
                        class="flex-1 md:flex-none px-8 py-3 bg-blue-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-200"
                    >
                        Simpan ({{ $mahasiswa->count() }})
                    </button>
                </div>
            </div>

            <div
                class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden"
            >
                <div
                    class="bg-slate-50/50 p-4 md:p-6 border-b border-slate-100 flex justify-between items-center"
                >
                    <h3
                        class="font-bold text-slate-700 text-sm uppercase tracking-wider"
                    >
                        Daftar Mahasiswa ({{ $mahasiswa->count() }})
                    </h3>
                    <div class="flex gap-2">
                        <span
                            class="w-3 h-3 bg-emerald-500 rounded-full inline-block"
                        ></span>
                        <span
                            class="text-[10px] font-bold text-slate-400 uppercase"
                            >Hadir</span
                        >
                    </div>
                </div>

                <div class="divide-y divide-slate-100">

@foreach($mahasiswa as $index => $mhs)

@php
    $selected = $attendances[$mhs->id]->status ?? 'H';
@endphp

<div
    class="p-4 md:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-slate-50 transition-colors"
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

    <div
        class="flex items-center gap-2 bg-slate-50 p-1.5 rounded-xl border border-slate-200 w-full md:w-auto justify-between"
    >

        {{-- HADIR --}}
        <label class="cursor-pointer relative">
            <input
                type="radio"
                name="attendance[{{ $mhs->id }}]"
                value="H"
                class="radio-input hidden"
                {{ $selected == 'H' ? 'checked' : '' }}
            />
            <div
                class="radio-label w-10 h-10 md:w-12 md:h-10 rounded-lg flex items-center justify-center font-black text-xs text-slate-400 hover:bg-white transition-all border border-transparent"
                style="--bg-color: #10b981; --border-color: #059669;"
            >
                H
            </div>
        </label>

        {{-- IZIN --}}
        <label class="cursor-pointer relative">
            <input
                type="radio"
                name="attendance[{{ $mhs->id }}]"
                value="I"
                class="radio-input hidden"
                {{ $selected == 'I' ? 'checked' : '' }}
            />
            <div
                class="radio-label w-10 h-10 md:w-12 md:h-10 rounded-lg flex items-center justify-center font-black text-xs text-slate-400 hover:bg-white transition-all border border-transparent"
                style="--bg-color: #3b82f6; --border-color: #2563eb;"
            >
                I
            </div>
        </label>

        {{-- SAKIT --}}
        <label class="cursor-pointer relative">
            <input
                type="radio"
                name="attendance[{{ $mhs->id }}]"
                value="S"
                class="radio-input hidden"
                {{ $selected == 'S' ? 'checked' : '' }}
            />
            <div
                class="radio-label w-10 h-10 md:w-12 md:h-10 rounded-lg flex items-center justify-center font-black text-xs text-slate-400 hover:bg-white transition-all border border-transparent"
                style="--bg-color: #f59e0b; --border-color: #d97706;"
            >
                S
            </div>
        </label>

        {{-- ALPHA --}}
        <label class="cursor-pointer relative">
            <input
                type="radio"
                name="attendance[{{ $mhs->id }}]"
                value="A"
                class="radio-input hidden"
                {{ $selected == 'A' ? 'checked' : '' }}
            />
            <div
                class="radio-label w-10 h-10 md:w-12 md:h-10 rounded-lg flex items-center justify-center font-black text-xs text-slate-400 hover:bg-white transition-all border border-transparent"
                style="--bg-color: #ef4444; --border-color: #dc2626;"
            >
                A
            </div>
        </label>

    </div>
</div>

@endforeach

</div>


                <div
                    class="p-6 bg-slate-50 border-t border-slate-100 flex justify-center"
                >
                    <span class="text-xs font-bold text-slate-400"
                        >Menampilkan {{ $mahasiswa->count() }} Mahasiswa</span
                    >
                </div>
            </div>
            </form>
        </main>
        <script>
    document.querySelector('button[type="reset"]').addEventListener('click', function() {
        document.querySelectorAll('input[value="H"]').forEach(function(el) {
            el.checked = true;
        });
    });
</script>

    </body>
</html>
