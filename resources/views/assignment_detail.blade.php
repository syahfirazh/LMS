<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Detail Tugas | LMS Inklusi UMMI</title>

        <link
            href="https://unpkg.com/aos@2.3.1/dist/aos.css"
            rel="stylesheet"
        />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
            rel="stylesheet"
        />

        <script src="https://unpkg.com/wavesurfer.js@7"></script>

        <style>
            html {
                scrollbar-gutter: stable;
            }
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
            .scrollbar-hide {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
            .custom-scrollbar::-webkit-scrollbar {
                width: 5px;
                height: 5px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background-color: #cbd5e1;
                border-radius: 20px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background-color: #94a3b8;
            }

            /* Animasi Fade In */
            .fade-in {
                animation: fadeIn 0.5s ease-in-out;
            }
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Animasi Chat Bubble */
            @keyframes popIn {
                0% {
                    opacity: 0;
                    transform: translateY(15px) scale(0.95);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }
            .chat-bubble-new {
                animation: popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275)
                    forwards;
            }
            #chatContainer {
                scroll-behavior: smooth;
            }

            /* Animasi Wave Merah saat Mendikte Suara */
            @keyframes wave-bounce {
                0%,
                100% {
                    height: 4px;
                }
                50% {
                    height: 16px;
                }
            }
            .recording-wave .bar {
                width: 3px;
                background-color: #ef4444;
                border-radius: 99px;
                animation: wave-bounce 1s ease-in-out infinite;
            }
            .recording-wave .bar:nth-child(1) {
                animation-delay: 0s;
                height: 8px;
            }
            .recording-wave .bar:nth-child(2) {
                animation-delay: 0.2s;
                height: 12px;
            }
            .recording-wave .bar:nth-child(3) {
                animation-delay: 0.4s;
                height: 16px;
            }
            .recording-wave .bar:nth-child(4) {
                animation-delay: 0.1s;
                height: 10px;
            }
            .recording-wave .bar:nth-child(5) {
                animation-delay: 0.3s;
                height: 14px;
            }
            .recording-wave .bar:nth-child(6) {
                animation-delay: 0.5s;
                height: 8px;
            }
        </style>
    </head>
    <body
        class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-full flex flex-col border-box overflow-x-hidden text-slate-800"
    >
        <div
            class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none"
        >
            <div
                class="absolute top-[-10%] right-[-5%] w-[400px] h-[400px] bg-blue-100/40 rounded-full blur-3xl opacity-50"
            ></div>
            <div
                class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] bg-indigo-50/40 rounded-full blur-3xl opacity-50"
            ></div>
        </div>

        <main
            class="flex-1 flex flex-col h-screen overflow-y-scroll custom-scrollbar relative"
        >
            <div
                class="bg-white/90 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm transition-all w-full"
            >
                <div
                    class="max-w-7xl mx-auto flex items-center justify-between relative h-12"
                >
                    <div
                        class="flex items-center gap-4 relative z-10 w-1/3 shrink-0"
                    >
                        <button
                            onclick="navigasiKe(0)"
                            class="w-11 h-11 md:w-12 md:h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm group border border-slate-200 hover:border-blue-600 relative cursor-pointer active:scale-95"
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
                            <span
                                class="absolute -bottom-1 -right-1 bg-slate-800 text-white text-[9px] font-black px-1.5 py-0.5 rounded-md border border-white"
                                >0</span
                            >
                        </button>

                        <div
                            class="hidden sm:block text-left cursor-pointer group"
                            onclick="navigasiKe(0)"
                        >
                            <span
                                class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest"
                                >Navigasi Suara</span
                            >
                            <span
                                class="block text-xs font-black text-slate-700 group-hover:text-blue-600 transition-colors"
                                >0 - Kembali</span
                            >
                        </div>
                    </div>

                    <div
                        class="absolute left-1/2 transform -translate-x-1/2 text-center w-1/3 z-0 pointer-events-none"
                    >
                        <h1
                            class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight leading-none truncate pointer-events-auto"
                        >
                            Laporan Praktikum Modul 2
                        </h1>
                        <p
                            class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1 truncate pointer-events-auto"
                        >
                            Struktur Data 3C
                        </p>
                    </div>

                    <div
                        class="flex items-center justify-end gap-3 relative z-10 w-1/3 shrink-0"
                    >
                        <div
                            class="flex items-center gap-[2px] h-4 w-10 justify-center"
                            id="wave-container"
                        >
                            <div
                                class="wave-bar w-[2px] bg-blue-500 rounded-full h-1 transition-all"
                            ></div>
                            <div
                                class="wave-bar w-[2px] bg-blue-400 rounded-full h-1 transition-all"
                            ></div>
                            <div
                                class="wave-bar w-[2px] bg-blue-600 rounded-full h-1 transition-all"
                            ></div>
                        </div>
                        <span
                            id="status-desc"
                            class="hidden md:block text-[9px] font-black text-slate-400 uppercase tracking-widest w-20 text-left"
                            >SIAP</span
                        >
                    </div>
                </div>
            </div>

            <div
                class="max-w-7xl mx-auto w-full px-4 md:px-8 py-6 md:py-8 space-y-6 md:space-y-8 pb-20"
            >
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div
                        class="bg-orange-50 border border-orange-200 p-6 rounded-[2rem] flex items-center gap-4 shadow-sm"
                        data-aos="fade-up"
                        data-aos-duration="600"
                    >
                        <div
                            class="w-12 h-12 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0"
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
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <h3
                                class="text-sm font-black text-orange-700 uppercase tracking-wide"
                            >
                                Batas Waktu
                            </h3>
                            <p class="text-lg font-bold text-slate-800">
                                Besok, 23:59 WIB
                            </p>
                        </div>
                    </div>

                    <div
                        id="status-card"
                        class="bg-white border border-slate-200 p-6 rounded-[2rem] flex items-center gap-4 shadow-sm transition-all duration-300"
                        data-aos="fade-up"
                        data-aos-duration="600"
                        data-aos-delay="100"
                    >
                        <div
                            id="status-icon"
                            class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-500 flex items-center justify-center transition-all shrink-0"
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
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <h3
                                id="status-title"
                                class="text-sm font-black text-slate-400 uppercase tracking-wide transition-all"
                            >
                                Status
                            </h3>
                            <p
                                id="status-text"
                                class="text-lg font-bold text-slate-800 transition-all"
                            >
                                Belum Dikirim
                            </p>
                        </div>
                    </div>

                    <div
                        class="bg-white border border-slate-200 p-6 rounded-[2rem] flex items-center gap-4 shadow-sm"
                        data-aos="fade-up"
                        data-aos-duration="600"
                        data-aos-delay="200"
                    >
                        <div
                            class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0"
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
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <h3
                                class="text-sm font-black text-slate-400 uppercase tracking-wide"
                            >
                                Nilai
                            </h3>
                            <p class="text-lg font-bold text-slate-300">
                                -- / 100
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-sm relative overflow-hidden"
                    data-aos="fade-up"
                    data-aos-duration="600"
                >
                    <div
                        class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6"
                    >
                        <h3
                            class="text-lg font-black text-slate-900 uppercase tracking-tight"
                        >
                            Instruksi Tugas
                        </h3>
                        <button
                            onclick="navigasiKe(1)"
                            class="w-fit flex items-center gap-2 bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg text-[9px] font-bold uppercase tracking-widest hover:bg-blue-100 transition-all cursor-pointer active:scale-95 group"
                        >
                            <span
                                class="bg-blue-500 text-white w-4 h-4 rounded-md flex items-center justify-center font-black group-hover:bg-blue-600"
                                >1</span
                            >
                            Dengar Soal
                        </button>
                    </div>
                    <div
                        id="soal-text"
                        class="prose prose-slate text-sm text-slate-600 leading-relaxed font-medium max-w-none"
                    >
                        <p>
                            Buatlah program C++ untuk mengimplementasikan Array
                            1 Dimensi dan 2 Dimensi. Program harus memiliki
                            fitur:
                        </p>
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Input data mahasiswa (Nama, NIM, Nilai).</li>
                            <li>Menampilkan data yang sudah diinput.</li>
                            <li>Mencari nilai rata-rata kelas.</li>
                        </ul>
                        <p class="mt-4">
                            Kumpulkan jawaban anda berupa file
                            <strong>.PDF</strong> atau
                            <strong>.DOCX</strong> yang berisi source code dan
                            screenshot hasil running program.
                        </p>
                    </div>
                </div>

                <div
                    class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-sm relative overflow-hidden"
                    data-aos="fade-up"
                    data-aos-duration="600"
                >
                    <div id="submission-form">
                        <h3
                            class="text-lg font-black text-slate-900 uppercase tracking-tight mb-6"
                        >
                            Form Pengumpulan
                        </h3>

                        <div class="mb-6">
                            <label
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-2"
                            >
                                <span
                                    class="bg-slate-200 text-slate-500 w-4 h-4 rounded flex items-center justify-center"
                                    >2</span
                                >
                                Upload File
                            </label>
                            <div
                                onclick="navigasiKe(2)"
                                class="border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all group bg-slate-50 active:scale-[0.99]"
                            >
                                <input
                                    type="file"
                                    id="file-upload"
                                    class="hidden"
                                    onchange="handleFileSelect(this)"
                                />
                                <div
                                    class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform"
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
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                                        ></path>
                                    </svg>
                                </div>
                                <span
                                    id="file-label"
                                    class="text-sm font-bold text-slate-700 group-hover:text-blue-600 block"
                                    >Klik untuk Upload Jawaban (2)</span
                                >
                                <span
                                    class="text-[10px] text-slate-400 mt-1 block"
                                    >Format: PDF, DOCX (Max 5MB)</span
                                >
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-2">
                                <label
                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-2"
                                >
                                    <span
                                        class="bg-slate-200 text-slate-500 w-4 h-4 rounded flex items-center justify-center"
                                        >3</span
                                    >
                                    Tanggapan / Catatan
                                </label>
                                <textarea
                                    id="tanggapan-text"
                                    rows="3"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 text-xs font-medium focus:outline-none focus:border-blue-500 transition-all resize-none"
                                    placeholder="Klik angka (3) untuk mendikte catatan..."
                                ></textarea>
                            </div>
                            <div class="flex items-end">
                                <button
                                    onclick="navigasiKe(4)"
                                    class="w-full h-[100px] md:h-full bg-blue-600 text-white rounded-xl font-black text-xs uppercase tracking-[0.2em] shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all hover:scale-[1.02] active:scale-95 flex flex-col items-center justify-center gap-2 group relative overflow-hidden"
                                >
                                    <span
                                        class="absolute top-3 right-3 bg-white/20 text-white w-5 h-5 rounded-md flex items-center justify-center font-black text-[10px]"
                                        >4</span
                                    >
                                    <svg
                                        class="w-6 h-6 group-hover:-translate-y-1 transition-transform"
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
                                    <span>Kirim Tugas</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="submission-success" class="hidden fade-in">
                        <h3
                            class="text-lg font-black text-slate-900 uppercase tracking-tight mb-6"
                        >
                            Status Pengumpulan
                        </h3>

                        <div
                            class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 flex items-center gap-4 mb-6"
                        >
                            <div
                                class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center shrink-0 shadow-sm"
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
                                        stroke-width="3"
                                        d="M5 13l4 4L19 7"
                                    ></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-emerald-800">
                                    Terima kasih, Tugas Berhasil Dikirim!
                                </h4>
                                <p class="text-xs text-emerald-600 mt-0.5">
                                    Dikirim pada: Baru saja
                                </p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block"
                                >File Anda (2)</label
                            >
                            <div
                                onclick="navigasiKe(2)"
                                class="flex items-center gap-4 p-4 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-white hover:border-blue-300 hover:shadow-md transition-all cursor-pointer group active:scale-[0.99]"
                            >
                                <div
                                    class="w-12 h-14 bg-red-50 text-red-500 rounded-xl flex items-center justify-center shrink-0 border border-red-100 group-hover:scale-110 transition-transform"
                                >
                                    <span
                                        class="text-[10px] font-black uppercase"
                                        >PDF</span
                                    >
                                </div>
                                <div class="flex-1">
                                    <h4
                                        class="text-sm font-bold text-slate-800 group-hover:text-blue-700"
                                    >
                                        Jawaban_Praktikum_Ridwan.pdf
                                    </h4>
                                    <p class="text-xs text-slate-400 mt-1">
                                        1.8 MB
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block"
                                >Catatan Anda</label
                            >
                            <div
                                id="submitted-note"
                                class="w-full bg-slate-50 border border-slate-100 rounded-xl p-4 text-xs font-medium text-slate-600 italic"
                            >
                                - Tidak ada catatan -
                            </div>
                        </div>

                        <div
                            class="mt-6 pt-6 border-t border-slate-100 flex justify-end"
                        >
                            <button
                                onclick="navigasiKe(9)"
                                class="text-red-500 font-bold text-xs uppercase tracking-widest hover:text-red-700 transition-all flex items-center gap-2 px-4 py-2 hover:bg-red-50 rounded-xl cursor-pointer active:scale-95 group"
                            >
                                <span
                                    class="bg-red-100 text-red-600 w-4 h-4 rounded text-[9px] flex items-center justify-center group-hover:bg-red-200"
                                    >9</span
                                >
                                Kirim Ulang
                            </button>
                        </div>
                    </div>
                </div>

                <div
                    data-aos="fade-up"
                    data-aos-duration="600"
                    data-aos-delay="200"
                    class="bg-white rounded-[2rem] sm:rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden flex flex-col h-[600px]"
                >
                    <div
                        class="p-5 sm:p-6 md:px-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 z-10"
                    >
                        <div class="flex items-center gap-3">
                            <h3
                                class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-tight"
                            >
                                Diskusi Kelas
                            </h3>
                            <button
                                onclick="navigasiKe(8)"
                                class="text-[9px] font-bold bg-blue-50 text-blue-600 px-2 py-1 rounded-lg border border-blue-100 hover:bg-blue-100 transition-all cursor-pointer active:scale-95 hidden sm:flex items-center gap-1"
                            >
                                <span
                                    class="bg-blue-200 text-blue-700 rounded px-1"
                                    >8</span
                                >
                                Baca
                            </button>
                        </div>
                        <span
                            class="text-[9px] sm:text-[10px] font-bold bg-green-100 text-green-700 px-3 py-1.5 rounded-full flex items-center gap-1.5 shrink-0"
                        >
                            <span
                                class="w-2 h-2 bg-green-500 rounded-full animate-pulse"
                            ></span>
                            <span class="hidden sm:inline">12 Online</span>
                            <span class="sm:hidden">12</span>
                        </span>
                    </div>

                    <div
                        id="chatContainer"
                        class="flex-1 p-4 sm:p-6 flex flex-col gap-6 overflow-y-auto custom-scrollbar bg-white"
                    >
                        <div class="flex justify-start chat-bubble">
                            <div
                                class="flex gap-2 sm:gap-3 items-end max-w-[90%] md:max-w-[70%]"
                            >
                                <img
                                    src="https://ui-avatars.com/api/?name=Asril&background=random&color=fff"
                                    class="w-8 h-8 sm:w-9 sm:h-9 rounded-full shrink-0 shadow-sm object-cover border border-slate-100"
                                />
                                <div class="flex flex-col items-start">
                                    <p
                                        class="text-[9px] sm:text-[10px] font-bold mb-1 px-1 text-slate-400 sender-name"
                                    >
                                        Asril Adi Sunarto (Dosen)
                                    </p>
                                    <div
                                        class="p-3 sm:p-4 rounded-2xl shadow-sm border bg-slate-50 text-slate-800 rounded-tl-none border-slate-200"
                                    >
                                        <p
                                            class="text-xs sm:text-[13px] leading-relaxed font-medium whitespace-pre-wrap break-words message-text mb-2"
                                        >
                                            Ada yang masih bingung tentang modul
                                            2 ini?
                                        </p>

                                        <div
                                            class="flex items-center gap-3 bg-white p-2 rounded-xl border border-slate-300 w-[200px] sm:w-[240px]"
                                        >
                                            <button
                                                type="button"
                                                onclick="
                                                    togglePlay('wave-dosen')
                                                "
                                                id="btn-wave-dosen"
                                                class="w-7 h-7 sm:w-8 sm:h-8 shrink-0 flex items-center justify-center rounded-full bg-blue-600 text-white shadow hover:scale-105 transition-transform text-[10px] sm:text-xs"
                                            >
                                                ▶
                                            </button>
                                            <div
                                                id="wave-dosen"
                                                class="flex-1"
                                                data-audio="https://actions.google.com/sounds/v1/alarms/beep_short.ogg"
                                            ></div>
                                        </div>
                                    </div>
                                    <p
                                        class="text-[8px] sm:text-[9px] mt-1.5 px-1 font-bold text-slate-400"
                                    >
                                        08:00
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-3 sm:p-4 border-t border-slate-100 bg-white shrink-0 shadow-[0_-4px_10px_rgba(0,0,0,0.02)]"
                    >
                        <form
                            id="chatForm"
                            onsubmit="
                                event.preventDefault();
                                kirimChatManual();
                            "
                        >
                            <div
                                class="relative flex items-center gap-2 sm:gap-3 bg-slate-50 p-2 sm:p-3 rounded-[1.25rem] sm:rounded-2xl border border-slate-200 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100 transition-all"
                            >
                                <button
                                    type="button"
                                    onclick="navigasiKe(6)"
                                    class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-white transition-all cursor-pointer shadow-sm border border-transparent hover:border-blue-100 shrink-0 relative group"
                                >
                                    <span
                                        class="absolute -top-1 -right-1 bg-slate-800 text-white text-[8px] font-black w-4 h-4 flex items-center justify-center rounded-full z-10 group-hover:bg-blue-600 transition-colors"
                                        >6</span
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
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        ></path>
                                    </svg>
                                </button>

                                <div
                                    id="normalInputWrapper"
                                    class="flex-1 min-w-0 relative"
                                >
                                    <span
                                        class="absolute -top-3 left-0 bg-slate-800 text-white text-[8px] font-black px-1.5 py-0.5 rounded-md z-10 hidden sm:block"
                                        >5 (Dikte Suara)</span
                                    >
                                    <input
                                        type="text"
                                        id="chat-input"
                                        placeholder="Sebut 'Lima' untuk mendikte pesan..."
                                        class="w-full bg-transparent text-xs sm:text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none pl-1"
                                        autocomplete="off"
                                    />
                                </div>

                                <div
                                    id="recordingWrapper"
                                    class="hidden flex-1 items-center justify-between px-2"
                                >
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="w-2 h-2 sm:w-2.5 sm:h-2.5 bg-red-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(239,68,68,0.8)]"
                                        ></span>
                                        <span
                                            class="text-[10px] sm:text-xs font-bold text-red-500 font-mono tracking-wider"
                                            >Mendengarkan...</span
                                        >
                                        <div
                                            class="recording-wave flex items-center gap-1 h-5 sm:h-6 ml-1 sm:ml-2"
                                        >
                                            <div class="bar"></div>
                                            <div class="bar"></div>
                                            <div class="bar"></div>
                                            <div class="bar"></div>
                                            <div class="bar"></div>
                                            <div class="bar"></div>
                                        </div>
                                    </div>
                                    <button
                                        type="button"
                                        onclick="batalDikte()"
                                        class="text-[9px] sm:text-[10px] font-black uppercase text-slate-400 hover:text-red-500 px-1 sm:px-2 transition-colors"
                                    >
                                        Batal
                                    </button>
                                </div>

                                <button
                                    type="button"
                                    onclick="navigasiKe(5)"
                                    id="btnMicChat"
                                    class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all cursor-pointer border border-transparent hover:border-red-100 shadow-sm shrink-0 relative group"
                                    title="Merekam Suara"
                                >
                                    <span
                                        class="absolute -top-1 -right-1 bg-slate-800 text-white text-[8px] font-black w-4 h-4 flex items-center justify-center rounded-full z-10 group-hover:bg-red-500 transition-colors md:hidden"
                                        >5</span
                                    >
                                    <svg
                                        class="w-4 h-4 sm:w-5 sm:h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"
                                        />
                                    </svg>
                                </button>

                                <button
                                    type="submit"
                                    id="sendChatBtn"
                                    class="w-10 h-9 sm:w-12 sm:h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-transform transform hover:scale-105 active:scale-95 shadow-md shadow-blue-200 cursor-pointer shrink-0 relative group"
                                >
                                    <span
                                        class="absolute -top-1 -right-1 bg-red-500 text-white text-[8px] font-black w-4 h-4 flex items-center justify-center rounded-full z-10"
                                        >7</span
                                    >
                                    <span id="sendIcon"
                                        ><svg
                                            class="w-4 h-4 sm:w-5 sm:h-5 transform rotate-90 ml-0.5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
                                            ></path></svg
                                    ></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

        <script>
            AOS.init({ once: true, easing: "ease-out-cubic" });

            const statusDesc = document.getElementById("status-desc");
            const waveBars = document.querySelectorAll(".wave-bar");
            const synth = window.speechSynthesis;
            const SpeechRec =
                window.webkitSpeechRecognition || window.SpeechRecognition;

            // Instansiasi Voice (Mic Navigasi & Mic Dikte)
            let rec = null;
            let dikteRec = null;

            let isDictatingNote = false;
            let isDictatingChat = false;
            let isSubmitted = false;
            let interval;

            if (SpeechRec) {
                rec = new SpeechRec();
                rec.lang = "id-ID";
                rec.continuous = true;

                dikteRec = new SpeechRec();
                dikteRec.lang = "id-ID";
                dikteRec.continuous = false;
            }

            // Inisialisasi Audio Wave (Contoh Chat Dosen)
            const wavesurfers = {};
            function initWaveSurfer(containerId, audioUrl, isMe) {
                const waveColor = isMe ? "rgba(255, 255, 255, 0.4)" : "#cbd5e1";
                const progressColor = isMe ? "#ffffff" : "#2563eb";
                const ws = WaveSurfer.create({
                    container: "#" + containerId,
                    waveColor: waveColor,
                    progressColor: progressColor,
                    height: 20,
                    barWidth: 2,
                    barGap: 2,
                    barRadius: 2,
                    cursorWidth: 0,
                    url: audioUrl,
                });
                wavesurfers[containerId] = ws;
                ws.on("finish", () => {
                    document.getElementById("btn-" + containerId).innerHTML =
                        "▶";
                });
            }

            function togglePlay(containerId) {
                const ws = wavesurfers[containerId];
                const btn = document.getElementById("btn-" + containerId);
                if (ws) {
                    ws.playPause();
                    btn.innerHTML = ws.isPlaying() ? "⏸" : "▶";
                }
            }

            document.addEventListener("DOMContentLoaded", () => {
                document.querySelectorAll('[id^="wave-"]').forEach((el) => {
                    initWaveSurfer(el.id, el.getAttribute("data-audio"), false);
                });
            });

            // LOGIKA TTS (Pembicara Asisten)
            function setWave(active) {
                if (waveBars.length > 0) {
                    waveBars.forEach((bar) => {
                        bar.style.height = active
                            ? `${Math.floor(Math.random() * 12) + 4}px`
                            : "4px";
                    });
                }
            }

            function bicara(teks, callback) {
                synth.cancel();
                const utter = new SpeechSynthesisUtterance(teks);
                utter.lang = "id-ID";
                utter.rate = 1.0;

                utter.onstart = () => {
                    if (statusDesc) statusDesc.innerText = "BERBICARA...";
                    interval = setInterval(() => setWave(true), 150);
                };
                utter.onend = () => {
                    if (statusDesc) statusDesc.innerText = "MENDENGARKAN...";
                    clearInterval(interval);
                    setWave(false);
                    if (callback) callback();
                };
                synth.speak(utter);
            }

            // Aksi Tugas
            function handleFileSelect(input) {
                if (input.files && input.files[0]) {
                    document.getElementById("file-label").innerText =
                        "Terpilih: " + input.files[0].name;
                    bicara(
                        "File " +
                            input.files[0].name +
                            " siap. Sebutkan empat untuk mengirim tugas.",
                    );
                }
            }

            function kirimTugas() {
                isSubmitted = true;
                document.getElementById("status-icon").className =
                    "w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center transition-all shrink-0";
                document.getElementById("status-icon").innerHTML =
                    '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>';
                document.getElementById("status-title").className =
                    "text-sm font-black text-emerald-600 uppercase tracking-wide transition-all";
                document.getElementById("status-text").innerText =
                    "Sudah Dikirim";

                document
                    .getElementById("submission-form")
                    .classList.add("hidden");
                document
                    .getElementById("submission-success")
                    .classList.remove("hidden");

                const note = document.getElementById("tanggapan-text").value;
                if (note)
                    document.getElementById("submitted-note").innerText =
                        '"' + note + '"';

                bicara("Tugas berhasil dikirim. Terima kasih.");
            }

            function kirimUlang() {
                isSubmitted = false;
                document.getElementById("status-icon").className =
                    "w-12 h-12 rounded-2xl bg-slate-100 text-slate-500 flex items-center justify-center transition-all shrink-0";
                document.getElementById("status-icon").innerHTML =
                    '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>';
                document.getElementById("status-title").className =
                    "text-sm font-black text-slate-400 uppercase tracking-wide transition-all";
                document.getElementById("status-text").innerText =
                    "Belum Dikirim";

                document
                    .getElementById("submission-success")
                    .classList.add("hidden");
                document
                    .getElementById("submission-form")
                    .classList.remove("hidden");

                bicara("Silahkan upload file jawaban baru.");
            }

            // Render Pesan Diskusi UI
            function renderChatUI(pesanTeks) {
                const chatContainer = document.getElementById("chatContainer");
                const now = new Date();
                const timeStr =
                    now.getHours().toString().padStart(2, "0") +
                    ":" +
                    now.getMinutes().toString().padStart(2, "0");

                const chatHtml = `
                    <div class="flex justify-end chat-bubble-new chat-bubble">
                        <div class="flex gap-2 sm:gap-3 items-end max-w-[90%] md:max-w-[70%] flex-row-reverse">
                            <img src="https://ui-avatars.com/api/?name=Anda&background=2563eb&color=fff" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full shrink-0 shadow-sm object-cover border border-slate-100" />
                            <div class="flex flex-col items-end">
                                <p class="text-[9px] sm:text-[10px] font-bold mb-1 px-1 text-slate-400 sender-name">Anda</p>
                                <div class="p-3 sm:p-4 rounded-2xl shadow-sm border bg-blue-600 text-white rounded-tr-none border-blue-700">
                                    <p class="text-xs sm:text-[13px] leading-relaxed font-medium whitespace-pre-wrap break-words message-text">${pesanTeks}</p>
                                </div>
                                <p class="text-[8px] sm:text-[9px] mt-1.5 px-1 font-bold text-slate-400">${timeStr}</p>
                            </div>
                        </div>
                    </div>`;

                chatContainer.insertAdjacentHTML("beforeend", chatHtml);
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }

            function kirimChatManual() {
                const input = document.getElementById("chat-input");
                if (input.value.trim() !== "") {
                    renderChatUI(input.value);
                    input.value = "";
                }
            }

            function batalDikte() {
                if (isDictatingChat) dikteRec.stop();
                isDictatingChat = false;
                document
                    .getElementById("recordingWrapper")
                    .classList.add("hidden");
                document
                    .getElementById("recordingWrapper")
                    .classList.remove("flex");
                document
                    .getElementById("normalInputWrapper")
                    .classList.remove("hidden");

                document
                    .getElementById("btnMicChat")
                    .classList.remove(
                        "text-red-500",
                        "bg-red-100",
                        "animate-pulse",
                    );
                document
                    .getElementById("btnMicChat")
                    .classList.add("text-slate-400", "bg-transparent");

                bicara("Dikte pesan dibatalkan.", () => rec.start());
            }

            // Fungsi Sentral Navigasi
            function navigasiKe(nomor) {
                if (isDictatingNote || isDictatingChat) return;

                let teks = "";
                let tujuan = "";

                // Kembali
                if (nomor === 0) {
                    teks = "Kembali ke Menu Utama.";
                    tujuan = "{{ route('course.assignments') ?? '#' }}";
                }
                // Instruksi & Materi
                else if (nomor === 1) {
                    teks =
                        "Instruksi Tugas: " +
                        document.getElementById("soal-text").innerText;
                }
                // Form Tugas
                else if (nomor === 2) {
                    if (!isSubmitted) {
                        document.getElementById("file-upload").click();
                        teks = "Pilih file untuk diupload.";
                    } else {
                        teks = "Membuka file jawaban Anda.";
                    }
                } else if (nomor === 3) {
                    if (!isSubmitted) {
                        rec.stop();
                        isDictatingNote = true;
                        teks = "Silahkan bicara catatan tugas Anda.";
                        bicara(teks, () => {
                            document.getElementById(
                                "tanggapan-text",
                            ).placeholder = "Mendengarkan suara Anda...";
                            dikteRec.start();
                        });
                        return;
                    } else {
                        teks = "Tugas sudah dikirim.";
                    }
                } else if (nomor === 4) {
                    if (!isSubmitted) kirimTugas();
                    else teks = "Tugas sudah dikirim.";
                } else if (nomor === 9) {
                    if (isSubmitted) kirimUlang();
                }

                // DISKUSI
                else if (nomor === 5) {
                    rec.stop();
                    isDictatingChat = true;
                    teks = "Mendengarkan suara Anda...";

                    // Transisi UI Chat Dosen (Merah Wave)
                    document
                        .getElementById("normalInputWrapper")
                        .classList.add("hidden");
                    document
                        .getElementById("recordingWrapper")
                        .classList.remove("hidden");
                    document
                        .getElementById("recordingWrapper")
                        .classList.add("flex");
                    document
                        .getElementById("btnMicChat")
                        .classList.remove("text-slate-400", "bg-transparent");
                    document
                        .getElementById("btnMicChat")
                        .classList.add(
                            "text-red-500",
                            "bg-red-100",
                            "animate-pulse",
                        );

                    bicara(teks, () => {
                        dikteRec.start();
                    });
                    return;
                } else if (nomor === 6) {
                    teks = "Buka galeri upload lampiran.";
                } else if (nomor === 7) {
                    const input = document.getElementById("chat-input");
                    if (input.value.trim() !== "") {
                        teks = "Pesan terkirim.";
                        renderChatUI(input.value);
                        input.value = "";
                    } else {
                        teks = "Pesan kosong. Sebutkan angka 5 untuk mendikte.";
                    }
                } else if (nomor === 8) {
                    let bubbles = document.querySelectorAll(".chat-bubble");
                    let fullText = "Membacakan diskusi kelas. ";
                    bubbles.forEach((bubble) => {
                        fullText +=
                            "Dari " +
                            bubble.querySelector(".sender-name").innerText +
                            ": " +
                            bubble.querySelector(".message-text").innerText +
                            ". ";
                    });
                    teks = fullText;
                }

                if (teks !== "") bicara(teks);
                if (tujuan !== "" && tujuan !== "#") {
                    setTimeout(() => (window.location.href = tujuan), 1500);
                }
            }

            // Listener Mic Utama
            rec.onresult = (event) => {
                if (isDictatingNote || isDictatingChat) return;

                const hasil = event.results[
                    event.results.length - 1
                ][0].transcript
                    .toLowerCase()
                    .trim();
                const angka = hasil.match(/\d+/);

                if (angka) navigasiKe(parseInt(angka[0]));
                else if (hasil.includes("nol") || hasil.includes("kembali"))
                    navigasiKe(0);
                else if (hasil.includes("satu") || hasil.includes("soal"))
                    navigasiKe(1);
                else if (hasil.includes("dua") || hasil.includes("file"))
                    navigasiKe(2);
                else if (hasil.includes("tiga") || hasil.includes("catatan"))
                    navigasiKe(3);
                else if (
                    hasil.includes("empat") ||
                    hasil.includes("kirim tugas")
                )
                    navigasiKe(4);
                else if (hasil.includes("sembilan") || hasil.includes("ulang"))
                    navigasiKe(9);
                else if (
                    hasil.includes("lima") ||
                    hasil.includes("tulis") ||
                    hasil.includes("dikte")
                )
                    navigasiKe(5);
                else if (hasil.includes("enam") || hasil.includes("gambar"))
                    navigasiKe(6);
                else if (
                    hasil.includes("tujuh") ||
                    hasil.includes("kirim chat")
                )
                    navigasiKe(7);
                else if (hasil.includes("delapan") || hasil.includes("baca"))
                    navigasiKe(8);
            };
            rec.onend = () => {
                if (!isDictatingNote && !isDictatingChat) rec.start();
            };

            // Listener Mic Sekunder (Dikte Teks Catatan / Chat)
            dikteRec.onresult = (event) => {
                const hasilDikte = event.results[0][0].transcript;

                if (isDictatingNote) {
                    document.getElementById("tanggapan-text").value =
                        hasilDikte;
                    bicara(
                        "Catatan: " +
                            hasilDikte +
                            ". Sebutkan empat untuk kirim tugas.",
                        () => {
                            isDictatingNote = false;
                            rec.start();
                        },
                    );
                } else if (isDictatingChat) {
                    const inputChat = document.getElementById("chat-input");
                    inputChat.value = hasilDikte;

                    // Kembalikan UI Chat normal
                    document
                        .getElementById("recordingWrapper")
                        .classList.add("hidden");
                    document
                        .getElementById("recordingWrapper")
                        .classList.remove("flex");
                    document
                        .getElementById("normalInputWrapper")
                        .classList.remove("hidden");
                    document
                        .getElementById("btnMicChat")
                        .classList.remove(
                            "text-red-500",
                            "bg-red-100",
                            "animate-pulse",
                        );
                    document
                        .getElementById("btnMicChat")
                        .classList.add("text-slate-400", "bg-transparent");

                    bicara("Pesan ditangkap. Mengirim...", () => {
                        navigasiKe(7); // Otomatis kirim
                        isDictatingChat = false;
                        rec.start();
                    });
                }
            };

            dikteRec.onerror = () => {
                if (isDictatingNote) {
                    document.getElementById("tanggapan-text").placeholder =
                        "Gagal, sebut Tiga lagi.";
                    isDictatingNote = false;
                } else if (isDictatingChat) {
                    batalDikte();
                }
                rec.start();
            };

            window.onload = () => {
                const orientasi =
                    "Detail Tugas Terbuka. " +
                    "Satu: Baca Instruksi. Dua: Upload File. Tiga: Catatan. Empat: Kirim Tugas. " +
                    "Untuk Diskusi: Lima: Dikte Pesan, Enam: Lampiran, Tujuh: Kirim, Delapan: Baca Diskusi. " +
                    "Nol: Kembali.";

                document.body.addEventListener("click", () => {}, {
                    once: true,
                });

                setTimeout(() => {
                    bicara(orientasi, () => {
                        try {
                            rec.start();
                        } catch (e) {}
                    });
                }, 800);
            };
        </script>
    </body>
</html>
