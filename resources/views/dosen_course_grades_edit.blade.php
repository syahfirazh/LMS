<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Edit Nilai Mahasiswa | Portal Dosen</title>

        <link
            href="https://unpkg.com/aos@2.3.1/dist/aos.css"
            rel="stylesheet"
        />
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
        <div
            class="bg-white/90 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm transition-all w-full"
        >
            <div
                class="max-w-7xl mx-auto flex items-center justify-between relative"
            >
                <div
                    class="flex items-center gap-4 relative z-10 md:w-auto w-full justify-start"
                >
                    <a
                        href="{{ route('dosen.grades.recap', $kelas->id) }}"
                        class="w-11 h-11 md:w-12 md:h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all shadow-sm shrink-0 group border border-slate-200 hover:border-blue-600"
                    >
                        <svg
                            class="w-5 h-5 md:w-6 md:h-6 transform group-hover:-translate-x-1 transition-transform"
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
                </div>

                <div
                    class="text-center absolute left-1/2 transform -translate-x-1/2 w-full max-w-[60%] md:max-w-md mt-2 md:mt-0"
                >
                    <h1
                        class="text-lg md:text-2xl font-black text-slate-900 tracking-tight leading-tight truncate"
                    >
                        Input Nilai
                    </h1>
                    <div class="flex items-center justify-center gap-2 mt-1">
                        <span
                            class="text-[9px] md:text-[10px] font-bold text-blue-600 uppercase tracking-widest bg-blue-100 px-2 py-0.5 rounded-md truncate"
                        >
                            Siti Rahmawati
                        </span>
                        <span
                            class="text-[10px] md:text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate"
                        >
                            2230511043
                        </span>
                    </div>
                </div>

                <div class="w-11 md:w-12 hidden md:block relative z-10"></div>
            </div>
        </div>

        <main
            class="flex-1 max-w-7xl mx-auto p-4 md:p-8 w-full space-y-6 md:space-y-8 mb-20 relative"
        >
            <form action="#" class="space-y-8">
                <div
                    class="flex items-center gap-4 sm:gap-6 bg-white p-6 rounded-[2rem] sm:rounded-[2.5rem] border border-slate-200 shadow-sm"
                    data-aos="fade-down"
                    data-aos-duration="600"
                >
                    <div
                        class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl sm:rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-black text-xl sm:text-2xl shrink-0"
                    >
                        SR
                    </div>
                    <div>
                        <h2
                            class="text-lg sm:text-xl font-black text-slate-900"
                        >
                            Siti Rahmawati
                        </h2>
                        <p
                            class="text-xs sm:text-sm text-slate-500 font-mono mt-1"
                        >
                            NIM: 2230511043
                            <span class="hidden sm:inline"
                                >• Kelas {{ $kelas->kode_kelas ?? '3C' }}</span
                            >
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div
                            class="bg-white p-6 sm:p-8 rounded-[2rem] border border-slate-200 shadow-sm"
                            data-aos="fade-up"
                            data-aos-delay="100"
                        >
                            <h3
                                class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3"
                            >
                                Komponen Tugas (20%)
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2"
                                        >Tugas 1: Array</label
                                    >
                                    <input
                                        type="number"
                                        value="95"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all shadow-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2"
                                        >Tugas 2: Linked List</label
                                    >
                                    <input
                                        type="number"
                                        value="88"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all shadow-sm"
                                    />
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-white p-6 sm:p-8 rounded-[2rem] border border-slate-200 shadow-sm"
                            data-aos="fade-up"
                            data-aos-delay="200"
                        >
                            <h3
                                class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3"
                            >
                                Komponen Ujian
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2"
                                        >UTS (30%)</label
                                    >
                                    <input
                                        type="number"
                                        value="90"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all shadow-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2"
                                        >UAS (40%)</label
                                    >
                                    <input
                                        type="number"
                                        value="92"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all shadow-sm"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="space-y-6"
                        data-aos="fade-left"
                        data-aos-delay="300"
                    >
                        <div
                            class="bg-slate-900 p-8 rounded-[2rem] text-white shadow-xl shadow-slate-300 relative overflow-hidden"
                        >
                            <div class="relative z-10">
                                <p
                                    class="text-[10px] font-bold uppercase tracking-widest opacity-60 mb-2"
                                >
                                    Prediksi Nilai Akhir
                                </p>
                                <h3 class="text-5xl font-black">93.5</h3>
                                <div
                                    class="mt-6 pt-5 border-t border-white/10 flex justify-between items-center"
                                >
                                    <span
                                        class="text-sm font-medium text-slate-300"
                                        >Grade:</span
                                    >
                                    <span
                                        class="px-3 py-1.5 bg-emerald-500 text-white rounded-lg font-black text-xs uppercase tracking-widest"
                                    >
                                        A (Lulus)
                                    </span>
                                </div>
                            </div>
                            <div
                                class="absolute -right-6 -bottom-10 w-32 h-32 bg-white/5 rounded-full blur-2xl"
                            ></div>
                        </div>

                        <button
                            type="submit"
                            class="w-full py-4 sm:py-5 bg-blue-600 text-white rounded-2xl font-black text-[11px] sm:text-xs uppercase tracking-widest hover:bg-blue-700 hover:-translate-y-0.5 transition-all shadow-lg shadow-blue-200"
                        >
                            Simpan Nilai
                        </button>
                    </div>
                </div>
            </form>
        </main>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({ once: true, easing: "ease-out-cubic", duration: 800 });
        </script>
    </body>
</html>
