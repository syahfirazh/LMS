<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Topik: Array & Memori | LMS Inklusi UMMI</title>

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
                width: 6px;
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
                    <div class="flex items-center gap-4 relative z-10 shrink-0">
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
                            class="hidden sm:block text-left cursor-pointer group shrink-0"
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
                        class="absolute left-1/2 transform -translate-x-1/2 text-center w-[50%] md:w-[60%] z-0 pointer-events-none"
                    >
                        <h1
                            class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight leading-none truncate pointer-events-auto"
                        >
                            {{ $kelas->mataKuliah->nama ?? 'Nama Kelas' }}
                        </h1>
                        <p
                            class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1 truncate pointer-events-auto"
                        >
                            Topik: {{ $session->judul ?? 'Nama Topik' }}
                        </p>
                    </div>

                    <div
                        class="flex items-center justify-end gap-3 pl-4 relative z-10 shrink-0"
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
                            class="hidden md:block text-[9px] font-black text-slate-400 uppercase tracking-widest text-left w-20"
                            >SIAP</span
                        >
                    </div>
                </div>
            </div>

            <div
                class="max-w-7xl mx-auto w-full px-4 md:px-8 py-6 md:py-8 space-y-6 md:space-y-8 pb-20"
            >
                <div
                    data-aos="fade-up"
                    data-aos-duration="600"
                    onclick="navigasiKe(1)"
                    class="bg-blue-50 border-l-4 border-blue-500 rounded-r-[2rem] p-6 shadow-sm cursor-pointer hover:bg-blue-100 transition-all group relative active:scale-[0.98]"
                >
                    <div
                        class="absolute right-4 top-4 w-8 h-8 bg-blue-500 text-white shadow-md rounded-lg flex items-center justify-center font-black text-xs"
                    >
                        1
                    </div>
                    <div class="flex items-start gap-4">
                        <div
                            class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-blue-200 flex items-center justify-center shrink-0"
                        >
                            <svg
                                class="w-5 h-5 md:w-6 md:h-6 text-blue-700"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"
                                ></path>
                            </svg>
                        </div>
                        <div class="pr-10 flex-1">
                            <h3
                                class="text-[10px] md:text-xs font-black text-blue-800 uppercase tracking-[0.2em] mb-1"
                            >
                                Pesan Dosen
                            </h3>
                            <p
                                id="text-pengumuman"
                                class="text-sm md:text-base font-medium text-slate-700 leading-relaxed"
                            >
                                {{ $session->description ?? 'Belum ada pesan dari dosen.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    data-aos="fade-up"
                    data-aos-duration="600"
                    data-aos-delay="100"
                    class="bg-white rounded-[2rem] md:rounded-[2.5rem] p-6 md:p-8 border border-slate-200 shadow-sm relative"
                >
                    <div
                        class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4"
                    >
                        <svg
                            class="w-6 h-6 text-red-500"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                            ></path>
                        </svg>
                        <h3
                            class="text-base md:text-lg font-black text-slate-900 uppercase tracking-widest"
                        >
                            Materi Pembelajaran
                        </h3>
                    </div>

                    <div id="materi-container" class="grid grid-cols-1 md:grid-cols-3 gap-4">
    @foreach($session->materis as $index => $materi)
        
        {{-- Logika Penentuan Warna & Icon Berdasarkan Tipe --}}
        @php
            $config = [
                'file'  => ['color' => 'blue',   'label' => 'PDF',   'bg' => 'bg-red-50',    'border' => 'border-red-100',    'text' => 'text-red-500'],
                'video' => ['color' => 'red',    'label' => 'VIDEO', 'bg' => 'bg-red-100',   'border' => 'border-red-200',   'text' => 'text-red-600'],
                'voice' => ['color' => 'purple', 'label' => 'AUDIO', 'bg' => 'bg-purple-100', 'border' => 'border-purple-200', 'text' => 'text-purple-600'],
            ];
            $type = $materi->type ?? 'file';
            $ui = $config[$type] ?? $config['file'];
        @endphp

        <div
            onclick="window.open('{{ asset('storage/'.$materi->file) }}', '_blank')"
            class="group border border-slate-100 rounded-2xl p-4 md:p-5 hover:border-{{ $ui['color'] }}-300 hover:bg-{{ $ui['color'] }}-50/30 transition-all cursor-pointer relative active:scale-[0.98]"
        >
            {{-- Badge Nomor Urut --}}
            <div class="absolute right-4 top-4 w-6 h-6 bg-{{ $ui['color'] }}-500 text-white shadow-md rounded-lg flex items-center justify-center font-black text-[10px] transition-colors">
                {{ $index + 1 }}
            </div>

            <div class="flex flex-col gap-3">
                {{-- Thumbnail / Icon --}}
                <div class="w-12 h-14 {{ $ui['bg'] }} rounded-lg border {{ $ui['border'] }} flex items-center justify-center shrink-0 {{ $ui['text'] }}">
                    @if($type === 'file')
                        <span class="text-[9px] font-black uppercase">PDF</span>
                    @elseif($type === 'video')
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                        </svg>
                    @elseif($type === 'voice')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                        </svg>
                    @endif
                </div>

                {{-- Judul & Info --}}
                <div>
                    <h4 class="text-sm font-bold text-slate-800 group-hover:text-{{ $ui['color'] }}-700 line-clamp-1">
                        {{ $materi->judul }}
                    </h4>
                    <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-wider">
                        {{ $ui['label'] }} • Klik untuk Lihat
                    </p>
                </div>
            </div>
        </div>
    @endforeach
</div>

                    <div
                        id="module-reader"
                        class="hidden mt-6 bg-slate-900 text-slate-200 p-6 rounded-2xl shadow-2xl animate-fade-in-up"
                    >
                        <div
                            class="flex justify-between items-center mb-4 border-b border-slate-700 pb-4"
                        >
                            <h3
                                class="text-xs font-black text-white uppercase tracking-widest flex items-center gap-2"
                            >
                                <span
                                    class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"
                                ></span>
                                Membacakan...
                            </h3>
                            <button
                                onclick="stopBicara()"
                                class="text-[9px] font-bold uppercase bg-red-500/20 text-red-400 px-3 py-1 rounded-lg hover:bg-red-500 hover:text-white transition-all cursor-pointer active:scale-95"
                            >
                                Stop
                            </button>
                        </div>
                        <p
                            id="reader-text"
                            class="text-sm leading-loose font-medium font-mono"
                        >
                            Sedang memuat...
                        </p>
                    </div>
                </div>

                <div
                    data-aos="fade-up"
                    data-aos-duration="600"
                    data-aos-delay="200"
                    class="bg-white rounded-[2rem] md:rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden flex flex-col h-[600px]"
                >
                    <div
                        class="p-5 md:p-6 md:px-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 z-10"
                    >
                        <div>
                            <h3
                                class="text-base md:text-lg font-black text-slate-900 uppercase tracking-tight"
                            >
                                Ruang Diskusi
                            </h3>
                            <p
                                class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5"
                            >
                                Tanya jawab sesi ini
                            </p>
                        </div>
                        <span
                            class="text-[9px] md:text-[10px] font-bold bg-green-100 text-green-700 px-3 py-1.5 rounded-full flex items-center gap-1.5"
                        >
                            <span
                                class="w-2 h-2 bg-green-500 rounded-full animate-pulse"
                            ></span>
                            <span class="hidden sm:inline">{{ $onlineUsers->count() }} Online</span>
                            <span class="sm:hidden">{{ $onlineUsers->count() }}</span>
                        </span>
                    </div>

                    <div
                        id="chatContainer"
                        class="flex-1 p-4 md:p-6 flex flex-col gap-6 overflow-y-auto custom-scrollbar bg-white"
                    >
                     @foreach($messages as $msg)

    @php
        $isDosen = $msg->sender_type === 'dosen';
        $senderName = $isDosen
            ? ($kelas->dosen->nama ?? 'Dosen')
            : ($msg->sender->nama ?? 'Mahasiswa');

        $avatarName = urlencode($senderName);
    @endphp
                        <div class="flex justify-start">
                            <div
                                class="flex gap-2 md:gap-3 items-end max-w-[90%] md:max-w-[70%]"
                            >
                                <img
                                    src="https://ui-avatars.com/api/?name={{ $avatarName }}&background=random&color=fff"
                                    class="w-8 h-8 md:w-9 md:h-9 rounded-full shrink-0 shadow-sm object-cover border border-slate-100"
                                />
                                <div class="flex flex-col items-start">
                                    <p
                                        class="text-[9px] md:text-[10px] font-bold mb-1 px-1 text-slate-400"
                                    >
                                        {{ $senderName }} {{ $isDosen ? '(Dosen)' : '' }}
                                    </p>
                                    <div
                                        class="p-3 md:p-4 rounded-2xl shadow-sm border bg-slate-50 text-slate-800 rounded-tl-none border-slate-200"
                                    >
                                        <p
                                            class="text-xs md:text-[13px] leading-relaxed font-medium whitespace-pre-wrap break-words"
                                        >
                                            {{ $msg->body }}
                                        </p>
                                    </div>
                                    <p
                                        class="text-[8px] md:text-[9px] mt-1.5 px-1 font-bold text-slate-400"
                                    >
                                        08:00
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-start">
                            <div
                                class="flex gap-2 md:gap-3 items-end max-w-[90%] md:max-w-[70%]"
                            >
                                <img
                                    src="https://ui-avatars.com/api/?name=Budi+S&background=random"
                                    class="w-8 h-8 md:w-9 md:h-9 rounded-full shrink-0 shadow-sm object-cover border border-slate-100"
                                />
                                <div class="flex flex-col items-start">
                                    <p
                                        class="text-[9px] md:text-[10px] font-bold mb-1 px-1 text-slate-400"
                                    >
                                        Budi Santoso
                                    </p>
                                    <div
                                        class="p-3 md:p-4 rounded-2xl shadow-sm border bg-slate-50 text-slate-800 rounded-tl-none border-slate-200"
                                    >
                                        <p
                                            class="text-xs md:text-[13px] leading-relaxed font-medium whitespace-pre-wrap break-words"
                                        >
                                            Pak, untuk array 2 dimensi apakah
                                            harus ukurannya sama tiap baris?
                                        </p>
                                    </div>
                                    <p
                                        class="text-[8px] md:text-[9px] mt-1.5 px-1 font-bold text-slate-400"
                                    >
                                        08:05
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div
                        class="p-3 md:p-4 border-t border-slate-100 bg-white shrink-0 shadow-[0_-4px_10px_rgba(0,0,0,0.02)]"
                    >
                        <form
                            id="chatForm"
                            onsubmit="
                                event.preventDefault();
                                kirimChatManual();
                            "
                        >
                            <div
                                class="relative flex items-center gap-2 md:gap-3 bg-slate-50 p-2 md:p-3 rounded-[1.25rem] md:rounded-2xl border border-slate-200 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100 transition-all"
                            >
                                <button
                                    type="button"
                                    onclick="navigasiKe(6)"
                                    class="w-9 h-9 md:w-10 md:h-10 rounded-xl flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-white transition-all cursor-pointer shadow-sm border border-transparent hover:border-blue-100 shrink-0 relative group"
                                >
                                    <span
                                        class="absolute -top-1 -right-1 bg-slate-800 text-white text-[8px] font-black w-4 h-4 flex items-center justify-center rounded-full z-10 group-hover:bg-blue-600 transition-colors"
                                        >6</span
                                    >
                                    <svg
                                        class="w-5 h-5 md:w-6 md:h-6"
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
                                        class="absolute -top-3 left-0 bg-slate-800 text-white text-[8px] font-black px-1.5 py-0.5 rounded-md z-10 hidden md:block"
                                        >5 (Dikte Pesan)</span
                                    >
                                    <input
                                        type="text"
                                        id="chat-input"
                                        placeholder="Sebut 'Lima' untuk mendikte pesan..."
                                        class="w-full bg-transparent text-xs md:text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none pl-1"
                                        autocomplete="off"
                                    />
                                </div>

                                <button
                                    type="button"
                                    onclick="navigasiKe(5)"
                                    class="w-9 h-9 md:w-10 md:h-10 rounded-xl flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all cursor-pointer border border-transparent hover:border-red-100 shadow-sm shrink-0 relative group"
                                    title="Merekam Suara"
                                >
                                    <span
                                        class="absolute -top-1 -right-1 bg-slate-800 text-white text-[8px] font-black w-4 h-4 flex items-center justify-center rounded-full z-10 group-hover:bg-red-500 transition-colors md:hidden"
                                        >5</span
                                    >
                                    <svg
                                        class="w-4 h-4 md:w-5 md:h-5"
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
                                    class="w-10 h-9 md:w-12 md:h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-transform transform hover:scale-105 active:scale-95 shadow-md shadow-blue-200 cursor-pointer shrink-0 relative group"
                                >
                                    <span
                                        class="absolute -top-1 -right-1 bg-red-500 text-white text-[8px] font-black w-4 h-4 flex items-center justify-center rounded-full z-10"
                                        >7</span
                                    >
                                    <span id="sendIcon"
                                        ><svg
                                            class="w-4 h-4 md:w-5 md:h-5 transform rotate-90 ml-0.5"
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
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

        <script>
            // INIT ANIMASI SCROLL
            AOS.init({ once: true, easing: "ease-out-cubic" });

            // LOGIKA VOICE ASSISTANT
            const statusDesc = document.getElementById("status-desc");
            const waveBars = document.querySelectorAll(".wave-bar");
            const readerBox = document.getElementById("module-reader");
            const readerText = document.getElementById("reader-text");
            const synth = window.speechSynthesis;
            const SpeechRec =
                window.webkitSpeechRecognition || window.SpeechRecognition;

            let rec = null;
            let dikteRec = null;
            let interval;

            if (SpeechRec) {
                rec = new SpeechRec();
                rec.lang = "id-ID";
                rec.continuous = true;

                dikteRec = new SpeechRec();
                dikteRec.lang = "id-ID";
                dikteRec.continuous = false;
            }

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
                const savedRate = localStorage.getItem("speechRate");
                utter.rate = savedRate ? parseFloat(savedRate) : 1.0;

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

            function stopBicara() {
                synth.cancel();
                readerBox.classList.add("hidden");
            }

            function renderChatUI(pesanTeks) {
                const chatContainer = document.getElementById("chatContainer");
                const now = new Date();
                const timeStr =
                    now.getHours().toString().padStart(2, "0") +
                    ":" +
                    now.getMinutes().toString().padStart(2, "0");

                const chatHtml = `
                    <div class="flex justify-end chat-bubble-new">
                        <div class="flex gap-2 md:gap-3 items-end max-w-[90%] md:max-w-[70%] flex-row-reverse">
                            <img src="https://ui-avatars.com/api/?name=Anda&background=2563eb&color=fff" class="w-8 h-8 md:w-9 md:h-9 rounded-full shrink-0 shadow-sm object-cover border border-slate-100" />
                            <div class="flex flex-col items-end">
                                <p class="text-[9px] md:text-[10px] font-bold mb-1 px-1 text-slate-400">Anda</p>
                                <div class="p-3 md:p-4 rounded-2xl shadow-sm border bg-blue-600 text-white rounded-tr-none border-blue-700">
                                    <p class="text-xs md:text-[13px] leading-relaxed font-medium whitespace-pre-wrap break-words">${pesanTeks}</p>
                                </div>
                                <p class="text-[8px] md:text-[9px] mt-1.5 px-1 font-bold text-slate-400">${timeStr}</p>
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

            function navigasiKe(nomor) {
                let tujuan = "";
                let teks = "";

                if (nomor === 0) {
                    tujuan = "{{ route('course.detail', $kelas->id) }}";
                    teks = "Kembali ke Menu Utama.";
                } else if (nomor === 1) {
                    teks =
                        "Pesan Dosen: " +
                        document.getElementById("text-pengumuman").innerText;
                } else if (nomor === 2) {
                    readerBox.classList.remove("hidden");
                    readerText.innerText =
                        document.getElementById("pdf-content-2").innerText;
                    teks = "Membuka PDF. " + readerText.innerText;
                } else if (nomor === 3) {
                    teks = "Memutar Video Pembelajaran.";
                    setTimeout(
                        () => window.open("https://youtube.com", "_blank"),
                        2000,
                    );
                } else if (nomor === 4) {
                    teks = "Memutar Audio Dosen.";
                } else if (nomor === 5) {
                    teks = "Silahkan bicara isi pesan Anda...";
                    rec.stop();
                    bicara(teks, () => {
                        const chatInput = document.getElementById("chat-input");
                        chatInput.placeholder = "Mendengarkan suara Anda...";
                        chatInput.classList.add("text-blue-600", "font-bold");
                        dikteRec.start();
                    });
                    return;
                } else if (nomor === 6) {
                    teks = "Membuka jendela upload lampiran.";
                } else if (nomor === 7) {
                    const input = document.getElementById("chat-input");
                    if (input.value.trim() !== "") {
                        teks = "Pesan terkirim.";
                        renderChatUI(input.value);
                        input.value = "";
                    } else {
                        teks =
                            "Pesan kosong. Sebutkan angka 5 untuk mendikte chat.";
                    }
                }

                if (teks !== "") bicara(teks);
                if (tujuan !== "" && tujuan !== "#") {
                    setTimeout(() => (window.location.href = tujuan), 1500);
                }
            }

            function mulaiMendengar() {
                if (!rec) return;
                try {
                    rec.start();
                    rec.onresult = (event) => {
                        const hasil = event.results[
                            event.results.length - 1
                        ][0].transcript
                            .toLowerCase()
                            .trim();

                        if (hasil.includes("nol") || hasil.includes("kembali"))
                            navigasiKe(0);
                        else if (
                            hasil.includes("satu") ||
                            hasil.includes("pesan")
                        )
                            navigasiKe(1);
                        else if (hasil.includes("dua") || hasil.includes("pdf"))
                            navigasiKe(2);
                        else if (
                            hasil.includes("tiga") ||
                            hasil.includes("video")
                        )
                            navigasiKe(3);
                        else if (
                            hasil.includes("empat") ||
                            hasil.includes("audio")
                        )
                            navigasiKe(4);
                        else if (
                            hasil.includes("lima") ||
                            hasil.includes("tulis") ||
                            hasil.includes("dikte")
                        )
                            navigasiKe(5);
                        else if (
                            hasil.includes("enam") ||
                            hasil.includes("lampiran") ||
                            hasil.includes("gambar")
                        )
                            navigasiKe(6);
                        else if (
                            hasil.includes("tujuh") ||
                            hasil.includes("kirim")
                        )
                            navigasiKe(7);
                        else if (
                            hasil.includes("stop") ||
                            hasil.includes("berhenti")
                        )
                            stopBicara();
                        else {
                            const angka = hasil.match(/\d+/);
                            if (angka) navigasiKe(parseInt(angka[0]));
                        }
                    };
                    rec.onend = () => {
                        rec.start();
                    };
                } catch (e) {
                    console.error("Error recognition:", e);
                }
            }

            if (dikteRec) {
                dikteRec.onresult = (event) => {
                    const hasilDikte = event.results[0][0].transcript;
                    const inputChat = document.getElementById("chat-input");

                    inputChat.value = hasilDikte;
                    inputChat.placeholder = "Pesan siap dikirim";
                    inputChat.classList.remove("text-blue-600", "font-bold");

                    bicara("Pesan ditangkap. Mengirim...", () => {
                        navigasiKe(7);
                        inputChat.placeholder =
                            "Sebut 'Lima' untuk mendikte pesan...";
                        rec.start();
                    });
                };
                dikteRec.onerror = () => {
                    const inputChat = document.getElementById("chat-input");
                    inputChat.placeholder =
                        "Gagal mendengar, sebut 'Lima' lagi.";
                    inputChat.classList.remove("text-blue-600", "font-bold");
                    rec.start();
                };
            }

            window.onload = () => {
                const orientasi =
                    "Anda berada di Topik Array dan Memori. " +
                    "Sebutkan angka untuk interaksi. " +
                    "Satu untuk Pesan. " +
                    "Dua untuk PDF. " +
                    "Tiga untuk Video. " +
                    "Empat untuk Audio. " +
                    "Untuk Diskusi: Sebutkan angka Lima untuk mulai mendikte pesan, " +
                    "Enam untuk lampiran, dan Tujuh untuk kirim. " +
                    "Atau nol untuk kembali.";

                document.body.addEventListener("click", () => {}, {
                    once: true,
                });

                setTimeout(() => {
                    bicara(orientasi, () => {
                        mulaiMendengar();
                    });
                }, 800);
            };

            const sessionId = {{ $session->id }};
    let lastMessageCount = 0;
    let lastMateriCount = 0;

    async function fetchRealtime() {
        try {
            const res = await fetch(`/session/${sessionId}/realtime`);
            const data = await res.json();

            // =====================
            // UPDATE PESAN DOSEN
            // =====================
            const pengumuman = document.getElementById("text-pengumuman");
            if (pengumuman && data.description) {
                pengumuman.innerText = data.description;
            }

            // =====================
            // UPDATE MATERI
            // =====================
            const materiContainer = document.getElementById("materi-container");

            if (materiContainer && data.materis.length !== lastMateriCount) {

                materiContainer.innerHTML = "";

                data.materis.forEach(materi => {

                    let html = "";

                    if (materi.type === "file") {
                        html = `
                            <div class="border p-4 rounded-2xl">
                                <a href="/storage/${materi.file}" target="_blank"
                                   class="font-bold text-blue-600">
                                   📄 ${materi.judul}
                                </a>
                            </div>
                        `;
                    }

                    if (materi.type === "video") {
                        html = `
                            <div class="border p-4 rounded-2xl">
                                <video controls class="w-full rounded-xl">
                                    <source src="/storage/${materi.file}">
                                </video>
                                <p class="mt-2 font-semibold">${materi.judul}</p>
                            </div>
                        `;
                    }

                    if (materi.type === "voice") {
                        html = `
                            <div class="border p-4 rounded-2xl">
                                <audio controls class="w-full">
                                    <source src="/storage/${materi.file}">
                                </audio>
                                <p class="mt-2 font-semibold">${materi.judul}</p>
                            </div>
                        `;
                    }

                    materiContainer.insertAdjacentHTML("beforeend", html);
                });

                lastMateriCount = data.materis.length;
            }

            // =====================
            // UPDATE CHAT
            // =====================
            const chatContainer = document.getElementById("chatContainer");

            if (chatContainer && data.messages.length !== lastMessageCount) {

                chatContainer.innerHTML = "";

                data.messages.reverse().forEach(msg => {

                    const chatHtml = `
                        <div class="flex justify-start">
                            <div class="bg-slate-100 p-3 rounded-xl max-w-[70%]">
                                <p class="text-sm">${msg.body}</p>
                            </div>
                        </div>
                    `;

                    chatContainer.insertAdjacentHTML("beforeend", chatHtml);
                });

                chatContainer.scrollTop = chatContainer.scrollHeight;

                lastMessageCount = data.messages.length;
            }

        } catch (err) {
            console.error("Realtime error:", err);
        }
    }

    // Polling tiap 3 detik
    setInterval(fetchRealtime, 3000);

    const pengumuman = document.getElementById("text-pengumuman");
            if (pengumuman && data.description) {
                pengumuman.innerText = data.description;
            }
        </script>
    </body>
</html>