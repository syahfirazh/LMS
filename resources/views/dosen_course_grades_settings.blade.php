<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Edit Bobot Nilai | Portal Dosen</title>

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
                        Pengaturan Bobot
                    </h1>
                    <div class="flex items-center justify-center gap-2 mt-1">
                        <span
                            class="text-[9px] md:text-[10px] font-bold text-blue-600 uppercase tracking-widest bg-blue-100 px-2 py-0.5 rounded-md"
                        >
                            Kelas {{ $kelas->kode_kelas ?? '-' }}
                        </span>
                        <span
                            class="text-[10px] md:text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate"
                        >
                            {{ $kelas->mataKuliah->nama ?? 'Mata Kuliah' }}
                        </span>
                    </div>
                </div>

                <div class="w-11 md:w-12 hidden md:block relative z-10"></div>
            </div>
        </div>

        <main
            class="flex-1 max-w-7xl mx-auto p-4 md:p-8 w-full space-y-6 md:space-y-8 mb-20 relative"
        >
            <form
                action="{{ route('dosen.grades.settings.update', $kelas->id) }}"
                method="POST"
                class="space-y-6 sm:space-y-8"
            >
                @csrf

                <div
                    class="bg-blue-50 border border-blue-100 p-6 sm:p-8 rounded-[2rem] sm:rounded-[2.5rem] flex flex-col sm:flex-row items-start gap-4 shadow-sm"
                    data-aos="fade-down"
                    data-aos-duration="600"
                >
                    <div
                        class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 text-blue-600 rounded-2xl sm:rounded-full flex items-center justify-center shrink-0"
                    >
                        <svg
                            class="w-5 h-5 sm:w-6 sm:h-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                    </div>
                    <div>
                        <h3
                            class="font-black text-blue-900 text-base sm:text-lg"
                        >
                            Aturan Bobot Nilai
                        </h3>
                        <p
                            class="text-xs sm:text-sm text-blue-700 mt-1.5 leading-relaxed font-medium"
                        >
                            Total persentase bobot harus berjumlah
                            <strong>100%</strong>. Perubahan komposisi bobot ini
                            akan secara otomatis mengkalkulasi ulang seluruh
                            Nilai Akhir mahasiswa pada Rekap Nilai kelas.
                        </p>
                    </div>
                </div>

                <div
                    class="bg-white p-6 sm:p-8 md:p-10 rounded-[2rem] sm:rounded-[2.5rem] border border-slate-200 shadow-sm grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6"
                    data-aos="fade-up"
                    data-aos-delay="100"
                >
                    <div>
                        <label
                            class="block text-[10px] sm:text-xs font-black text-slate-500 uppercase tracking-widest mb-2.5"
                            >Absensi</label
                        >
                        <div class="relative group">
                            <input
                                type="number"
                                name="absen"
                                value="{{ $bobot->absen ?? 10 }}"
                                class="bobot w-full bg-slate-50 border-2 border-slate-100 rounded-2xl pl-5 pr-12 py-3.5 sm:py-4 font-black text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white text-xl transition-all shadow-sm"
                            />
                            <span
                                class="absolute right-5 top-1/2 -translate-y-1/2 font-black text-slate-300 group-focus-within:text-blue-500 transition-colors"
                                >%</span
                            >
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-[10px] sm:text-xs font-black text-slate-500 uppercase tracking-widest mb-2.5"
                            >Tugas / Kuis</label
                        >
                        <div class="relative group">
                            <input
                                type="number"
                                name="tugas"
                                value="{{ $bobot->tugas ?? 20 }}"
                                class="bobot w-full bg-slate-50 border-2 border-slate-100 rounded-2xl pl-5 pr-12 py-3.5 sm:py-4 font-black text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white text-xl transition-all shadow-sm"
                            />
                            <span
                                class="absolute right-5 top-1/2 -translate-y-1/2 font-black text-slate-300 group-focus-within:text-blue-500 transition-colors"
                                >%</span
                            >
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-[10px] sm:text-xs font-black text-slate-500 uppercase tracking-widest mb-2.5"
                            >Ujian Tengah Semester</label
                        >
                        <div class="relative group">
                            <input
                                type="number"
                                name="uts"
                                value="{{ $bobot->uts ?? 30 }}"
                                class="bobot w-full bg-slate-50 border-2 border-slate-100 rounded-2xl pl-5 pr-12 py-3.5 sm:py-4 font-black text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white text-xl transition-all shadow-sm"
                            />
                            <span
                                class="absolute right-5 top-1/2 -translate-y-1/2 font-black text-slate-300 group-focus-within:text-blue-500 transition-colors"
                                >%</span
                            >
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-[10px] sm:text-xs font-black text-slate-500 uppercase tracking-widest mb-2.5"
                            >Ujian Akhir Semester</label
                        >
                        <div class="relative group">
                            <input
                                type="number"
                                name="uas"
                                value="{{ $bobot->uas ?? 40 }}"
                                class="bobot w-full bg-slate-50 border-2 border-slate-100 rounded-2xl pl-5 pr-12 py-3.5 sm:py-4 font-black text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white text-xl transition-all shadow-sm"
                            />
                            <span
                                class="absolute right-5 top-1/2 -translate-y-1/2 font-black text-slate-300 group-focus-within:text-blue-500 transition-colors"
                                >%</span
                            >
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white p-6 sm:p-8 rounded-[2rem] sm:rounded-[2.5rem] border border-slate-200 shadow-sm flex justify-between items-center"
                    data-aos="fade-up"
                    data-aos-delay="200"
                >
                    <span
                        class="font-black text-slate-500 uppercase tracking-widest text-[11px] sm:text-sm"
                        >Total Bobot Kalkulasi:</span
                    >
                    <span
                        id="totalBobot"
                        class="text-3xl sm:text-4xl font-black text-emerald-600 transition-colors duration-300"
                    >
                        100%
                    </span>
                </div>

                <div
                    class="flex flex-col-reverse sm:flex-row justify-end gap-3 sm:gap-4 pt-4"
                    data-aos="fade-up"
                    data-aos-delay="300"
                >
                    <a
                        href="{{ route('dosen.grades.recap', $kelas->id) }}"
                        class="w-full sm:w-auto px-8 py-3.5 sm:py-4 rounded-xl font-black text-slate-500 bg-slate-100 border border-slate-200 hover:bg-slate-200 hover:text-slate-700 transition-all text-center text-[10px] sm:text-[11px] uppercase tracking-widest"
                    >
                        Batal
                    </a>
                    <button
                        type="submit"
                        id="btnSubmit"
                        class="w-full sm:w-auto px-8 sm:px-10 py-3.5 sm:py-4 bg-blue-600 text-white rounded-xl font-black text-[10px] sm:text-[11px] uppercase tracking-widest hover:bg-blue-700 hover:-translate-y-0.5 transition-all shadow-lg shadow-blue-200 text-center"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </main>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({ once: true, easing: "ease-out-cubic", duration: 800 });

            const inputs = document.querySelectorAll(".bobot");
            const totalEl = document.getElementById("totalBobot");
            const btnSubmit = document.getElementById("btnSubmit");

            function hitungTotal() {
                let total = 0;
                inputs.forEach((i) => (total += Number(i.value || 0)));
                totalEl.innerText = total + "%";

                if (total === 100) {
                    totalEl.classList.remove("text-red-500");
                    totalEl.classList.add("text-emerald-600");
                    btnSubmit.disabled = false;
                    btnSubmit.classList.remove(
                        "opacity-50",
                        "cursor-not-allowed",
                    );
                } else {
                    totalEl.classList.remove("text-emerald-600");
                    totalEl.classList.add("text-red-500");
                    btnSubmit.disabled = true;
                    btnSubmit.classList.add("opacity-50", "cursor-not-allowed");
                }
            }

            inputs.forEach((i) => i.addEventListener("input", hitungTotal));
            hitungTotal(); // Initial check on page load
        </script>
    </body>
</html>
