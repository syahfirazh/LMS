<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Edit Nilai Mahasiswa | Portal Dosen</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
            rel="stylesheet"
        />
        <style>
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
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
                    href="{{ route('dosen.course.grades', $kelas->id) }}"
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

                <div class="flex-1">
                    <h1
                        class="text-xl font-extrabold text-slate-900 tracking-tight leading-tight"
                    >
                        Input Nilai
                    </h1>
                    <p
                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1"
                    >
                        Siti Rahmawati - 2230511043
                    </p>
                </div>
            </div>
        </div>

        <main
            class="flex-1 max-w-6xl mx-auto p-4 md:p-6 lg:p-8 w-full space-y-8"
        >
            <form action="#" class="space-y-8">
                <div
                    class="flex items-center gap-6 bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm"
                >
                    <div
                        class="w-16 h-16 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-black text-2xl shrink-0"
                    >
                        SR
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900">
                            Siti Rahmawati
                        </h2>
                        <p class="text-sm text-slate-500 font-mono mt-1">
                            NIM: 2230511043 • Kelas 3C
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div
                            class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm"
                        >
                            <h3
                                class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3"
                            >
                                Komponen Tugas (20%)
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-400 uppercase mb-2"
                                        >Tugas 1: Array</label
                                    >
                                    <input
                                        type="number"
                                        value="95"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-400 uppercase mb-2"
                                        >Tugas 2: Linked List</label
                                    >
                                    <input
                                        type="number"
                                        value="88"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    />
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm"
                        >
                            <h3
                                class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3"
                            >
                                Komponen Ujian
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-400 uppercase mb-2"
                                        >UTS (30%)</label
                                    >
                                    <input
                                        type="number"
                                        value="90"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-400 uppercase mb-2"
                                        >UAS (40%)</label
                                    >
                                    <input
                                        type="number"
                                        value="92"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div
                            class="bg-slate-900 p-6 rounded-[2rem] text-white shadow-xl shadow-slate-300"
                        >
                            <p
                                class="text-[10px] font-bold uppercase tracking-widest opacity-60 mb-2"
                            >
                                Prediksi Nilai Akhir
                            </p>
                            <h3 class="text-5xl font-black">93.5</h3>
                            <div
                                class="mt-4 pt-4 border-t border-white/10 flex justify-between items-center"
                            >
                                <span class="text-sm font-medium">Grade:</span>
                                <span
                                    class="px-3 py-1 bg-emerald-500 text-white rounded-lg font-bold text-xs uppercase tracking-widest"
                                    >A (Lulus)</span
                                >
                            </div>
                        </div>

                        <button
                            class="w-full py-4 bg-blue-600 text-white rounded-xl font-bold uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-200"
                        >
                            Simpan Nilai
                        </button>
                    </div>
                </div>
            </form>
        </main>
    </body>
</html>
