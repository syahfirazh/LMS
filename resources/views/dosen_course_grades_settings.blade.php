<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Edit Bobot Nilai | Portal Dosen</title>
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
                    href="{{ route('dosen.grades.recap', $kelas->id) }}"
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
                        Pengaturan Bobot Nilai
                    </h1>
                    <p
                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1"
                    >
                        {{ $kelas->mata_kuliah }} {{ $kelas->nama }}
                    </p>
                </div>
            </div>
        </div>

        <main
            class="flex-1 max-w-6xl mx-auto p-4 md:p-6 lg:p-8 w-full space-y-8"
        >
            <form
                action="{{ route('dosen.grades.settings.update', $kelas->id) }}"
                method="POST"
                class="space-y-6"
            >
                @csrf

                <div
                    class="bg-blue-50 border border-blue-100 p-6 rounded-[2rem] flex items-start gap-4"
                >
                    <div
                        class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center shrink-0"
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
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-blue-800">Aturan Bobot</h3>
                        <p class="text-sm text-blue-600 mt-1 leading-relaxed">
                            Total persentase bobot harus berjumlah
                            <strong>100%</strong>. Perubahan bobot akan otomatis
                            mengkalkulasi ulang Nilai Akhir seluruh mahasiswa.
                        </p>
                    </div>
                </div>

                <div
                    class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"
                >
                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2"
                            >Absensi</label
                        >
                        <div class="relative">
                            <input
                                type="number"
                                name="absen"
                                value="{{ $bobot->absen }}"
                                class="bobot w-full bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-12 py-3 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xl"
                            />
                            <span
                                class="absolute right-4 top-1/2 -translate-y-1/2 font-bold text-slate-400"
                                >%</span
                            >
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2"
                            >Tugas / Kuis</label
                        >
                        <div class="relative">
                            <input
                                type="number"
                                name="tugas"
                                value="{{ $bobot->tugas }}"
                                class="bobot w-full bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-12 py-3 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xl"
                            />
                            <span
                                class="absolute right-4 top-1/2 -translate-y-1/2 font-bold text-slate-400"
                                >%</span
                            >
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2"
                            >UTS</label
                        >
                        <div class="relative">
                            <input
                                type="number"
                                name="uts"
                                value="{{ $bobot->uts }}"
                                class="bobot w-full bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-12 py-3 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xl"
                            />
                            <span
                                class="absolute right-4 top-1/2 -translate-y-1/2 font-bold text-slate-400"
                                >%</span
                            >
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2"
                            >UAS</label
                        >
                        <div class="relative">
                            <input
                                type="number"
                                name="uas"
                                value="{{ $bobot->uas }}"
                                class="bobot w-full bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-12 py-3 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xl"
                            />
                            <span
                                class="absolute right-4 top-1/2 -translate-y-1/2 font-bold text-slate-400"
                                >%</span
                            >
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex justify-between items-center"
                >
                    <span class="font-bold text-slate-500">Total Bobot:</span>
                    <span
                        id="totalBobot"
                        class="text-2xl font-black text-emerald-600"
                        >100%</span
                    >
                </div>

                <div class="flex justify-end gap-4 pt-4">
                    <a
                        href="{{ route('dosen.grades.recap', $kelas->id) }}"
                        class="px-8 py-3 rounded-xl font-bold text-slate-500 hover:bg-slate-100 transition-all"
                        >Batal</a
                    >
                    <button
                        type="submit"
                        class="px-10 py-3 bg-blue-600 text-white rounded-xl font-bold uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl shadow-blue-200"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </main>

        <script>
            const inputs = document.querySelectorAll(".bobot");
            const totalEl = document.getElementById("totalBobot");

            function hitungTotal() {
                let total = 0;
                inputs.forEach((i) => (total += Number(i.value || 0)));
                totalEl.innerText = total + "%";
                totalEl.classList.toggle(
                    "text-red-600",
                    total !== 100
                );
            }

            inputs.forEach((i) =>
                i.addEventListener("input", hitungTotal)
            );
            hitungTotal();
        </script>
    </body>
</html>
