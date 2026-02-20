<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Periksa Tugas | Portal Dosen</title>
        
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
        <script src="https://unpkg.com/wavesurfer.js@7"></script>

        <style>
            .scrollbar-hide::-webkit-scrollbar { display: none; }
            .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
            .custom-scrollbar::-webkit-scrollbar { width: 5px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
            
            #chat-wrapper { transition: transform 0.3s ease, box-shadow 0.3s ease, border-radius 0.3s ease; }
            .chat-expanded {
                position: fixed !important; top: 50% !important; left: 50% !important; transform: translate(-50%, -50%) !important;
                z-index: 9999 !important; height: 90vh !important; width: 90vw !important; max-width: 1200px !important;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important; display: flex !important; flex-direction: column !important;
                border-radius: 2rem !important;
            }

            #chat-overlay { display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(8px); z-index: 9998; }
            #chat-overlay.active { display: block; }

            @keyframes wave-bounce { 0%, 100% { height: 3px; } 50% { height: 12px; } }
            .recording-wave .bar { width: 3px; background-color: #ef4444; border-radius: 99px; animation: wave-bounce 1s ease-in-out infinite; }
            .recording-wave .bar:nth-child(1) { animation-delay: 0.0s; height: 6px;}
            .recording-wave .bar:nth-child(2) { animation-delay: 0.2s; height: 10px;}
            .recording-wave .bar:nth-child(3) { animation-delay: 0.4s; height: 12px;}
            .recording-wave .bar:nth-child(4) { animation-delay: 0.1s; height: 8px;}
            .recording-wave .bar:nth-child(5) { animation-delay: 0.3s; height: 10px;}
            
            @keyframes popIn { 0% { opacity: 0; transform: translateY(15px) scale(0.95); } 100% { opacity: 1; transform: translateY(0) scale(1); } }
            .chat-bubble-new { animation: popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
        </style>
    </head>
    <body class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-screen flex flex-col border-box overflow-x-hidden overflow-y-scroll text-slate-800 selection:bg-blue-200">
        
        <div id="chat-overlay" onclick="toggleChat()"></div>

        {{-- MAIN WRAPPER --}}
        <main class="flex-1 flex flex-col h-screen overflow-y-auto relative">
            
            {{-- NAVBAR (Sama persis seperti Detail Sesi) --}}
            <div class="bg-white/90 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm transition-all w-full">
                <div class="max-w-7xl mx-auto flex items-center justify-between relative">
                    
                    {{-- KIRI: TOMBOL BACK --}}
                    <div class="flex items-center gap-4 relative z-10 md:w-auto w-full justify-start">
                        <a href="{{ route('dosen.course.assignments', $kelas->id) }}" class="w-11 h-11 md:w-12 md:h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm shrink-0 group border border-slate-200 hover:border-blue-600">
                            <svg class="w-5 h-5 md:w-6 md:h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                    </div>
                    
                    {{-- TENGAH: INFO TUGAS --}}
                    <div class="text-center absolute left-1/2 transform -translate-x-1/2 w-full max-w-[60%] md:max-w-md mt-2 md:mt-0">
                        <h1 class="text-lg md:text-2xl font-black text-slate-900 tracking-tight leading-tight truncate">
                            {{ $assignment->judul ?? 'Tugas' }}
                        </h1>
                        <div class="flex items-center justify-center gap-2 mt-1">
                            <span class="text-[9px] md:text-[10px] font-bold text-blue-600 uppercase tracking-widest bg-blue-100 px-2 py-0.5 rounded-md">
                                {{ $kelas->nama ?? 'Kelas' }}
                            </span>
                            <span class="text-[10px] md:text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">
                                {{ $assignment ? $assignment->submissions()->count() : 0 }}/{{ $mahasiswas->count() }} Terkumpul
                            </span>
                        </div>
                    </div>
                    
                    {{-- KANAN: NAVIGASI MAHASISWA --}}
                    <div class="flex items-center gap-2 relative z-10">
                        @php
                            $index = $mahasiswas->search(fn($m) => $m->id == $activeMahasiswaId);
                            if($index === false) { $index = 0; }
                            $prev = $mahasiswas->get($index - 1);
                            $next = $mahasiswas->get($index + 1);
                        @endphp
                        
                        <a href="{{ $prev ? route('dosen.assignment.grade', [$kelas->id, $assignment->id, $prev->id]) : '#' }}" class="px-3 md:px-4 py-2 bg-white border border-slate-200 rounded-xl text-[10px] md:text-xs font-bold text-slate-600 hover:bg-slate-50 transition-all flex items-center gap-1 md:gap-2 {{ !$prev ? 'opacity-50 pointer-events-none' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            <span class="hidden sm:inline">Prev</span>
                        </a>
                        
                        <div class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest px-1 md:px-2 whitespace-nowrap">
                            {{ $index + 1 }} / {{ $mahasiswas->count() }}
                        </div>
                        
                        <a href="{{ $next ? route('dosen.assignment.grade', [$kelas->id, $assignment->id, $next->id]) : '#' }}" class="px-3 md:px-4 py-2 bg-slate-900 text-white rounded-xl text-[10px] md:text-xs font-bold hover:bg-blue-600 transition-all flex items-center gap-1 md:gap-2 shadow-lg {{ !$next ? 'opacity-50 pointer-events-none' : '' }}">
                            <span class="hidden sm:inline">Next</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- KONTEN BAWAH --}}
            <div class="max-w-7xl mx-auto w-full p-4 md:p-8 space-y-6 md:space-y-8 pb-24 relative grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                {{-- KOLOM 1: LIST MAHASISWA (Animasi) --}}
                <div class="hidden lg:flex lg:col-span-3 bg-white rounded-[2rem] border border-slate-200 shadow-sm flex-col overflow-hidden lg:sticky lg:top-[100px] lg:h-[calc(100vh-130px)]" data-aos="fade-right" data-aos-duration="600">
                    <div class="p-4 border-b border-slate-100 bg-slate-50/50">
                        <div class="relative">
                            <input type="text" onkeyup="filterMahasiswa(this.value)" placeholder="Cari Mahasiswa..." class="w-full bg-white border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-xs font-bold focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none" />
                            <svg class="w-4 h-4 absolute left-3.5 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                    <div class="flex-1 overflow-y-auto custom-scrollbar p-2 space-y-1">
                        @foreach ($mahasiswas as $mhs)
                        <a href="{{ route('dosen.assignment.grade', [$kelas->id, $assignment->id, $mhs->id]) }}" class="mahasiswa-item block" data-name="{{ strtolower($mhs->nama) }}">
                            <div class="p-3 {{ $activeMahasiswaId == $mhs->id ? 'bg-blue-50 border-blue-200 shadow-sm' : 'hover:bg-slate-50 border-transparent hover:border-slate-200' }} border rounded-xl flex items-center justify-between transition-all">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($mhs->nama) }}&background=0ea5e9&color=fff" class="w-9 h-9 rounded-full shadow-sm" />
                                    <div>
                                        <h4 class="text-xs font-bold {{ $activeMahasiswaId == $mhs->id ? 'text-slate-900' : 'text-slate-600' }}">{{ $mhs->nama }}</h4>
                                        <p class="text-[9px] font-bold {{ $mhs->status_pengumpulan === 'tepat_waktu' ? 'text-blue-600' : 'text-red-500' }} uppercase mt-0.5">{{ $mhs->status_label ?? 'Belum Mengumpulkan' }}</p>
                                    </div>
                                </div>
                                @if ($activeMahasiswaId == $mhs->id) <div class="w-2.5 h-2.5 bg-blue-600 rounded-full ring-4 ring-blue-100"></div> @endif
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- KOLOM 2: PREVIEW FILE (Animasi) --}}
                <div class="lg:col-span-6 bg-slate-900 rounded-[2rem] shadow-xl flex flex-col overflow-hidden relative border border-slate-800 h-[700px]" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                    <div class="flex-1 flex items-center justify-center bg-slate-900/50">
                        @if ($submission && $submission->file_url)
                            <iframe src="{{ $submission->file_url }}" class="w-full h-full bg-white"></iframe>
                        @else
                            <div class="text-center p-8">
                                <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-700">
                                    <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <h3 class="text-white text-sm font-bold">Belum Ada File</h3>
                                <p class="text-slate-400 text-xs mt-1">Mahasiswa belum mengirim file jawaban.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- KOLOM 3: FORM NILAI & DISKUSI (Animasi) --}}
                <div class="lg:col-span-3 flex flex-col gap-6 lg:sticky lg:top-[100px] lg:h-[calc(100vh-130px)] min-w-0" data-aos="fade-left" data-aos-duration="600" data-aos-delay="200">
                    
                    {{-- FORM NILAI --}}
                    <form method="POST" action="{{ route('dosen.assignment.grade.store', ['kelas' => $kelas->id, 'assignment' => $assignment->id, 'mahasiswa' => $activeMahasiswaId]) }}" class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-5 shrink-0">
                        @csrf
                        <div class="mb-3 border-b border-slate-100 pb-3">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">Penilaian</h3>
                        </div>
                        <div class="space-y-3">
                            <input type="number" name="nilai" value="{{ $submission->nilai ?? '' }}" placeholder="0 - 100" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xl font-black text-center focus:outline-none focus:border-blue-500" />
                            <button type="submit" class="w-full py-3 bg-emerald-500 text-white rounded-xl text-[10px] font-black uppercase hover:bg-emerald-600 transition-all shadow-md">Simpan Nilai</button>
                        </div>
                    </form>

                    <div id="chat-placeholder" class="hidden flex-1"></div>

                    {{-- DISKUSI CONTAINER --}}
                    <div id="chat-wrapper" class="bg-white rounded-[2rem] border border-slate-200 shadow-sm flex flex-col flex-1 overflow-hidden min-h-0 bg-white/90 backdrop-blur-xl">
                        
                        {{-- Header Chat --}}
                        <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 shrink-0">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest">Diskusi Privat</h3>
                            <button type="button" onclick="toggleChat()" class="text-slate-400 hover:text-blue-600 p-1 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                            </button>
                        </div>

                        {{-- Body Chat --}}
                        <div id="chatContainer" class="flex-1 p-4 flex flex-col gap-5 overflow-y-auto custom-scrollbar bg-white">
                            @php
                                $pesanDiskusi = ($submission && $submission->messages) ? $submission->messages->sortBy('created_at') : collect();
                            @endphp

                            @forelse ($pesanDiskusi as $diskusi)
                                @php
                                    $from = $diskusi->from ?? '';
                                    $isMe = $from != 'mahasiswa';
                                    $nama = $isMe ? 'Anda' : ($activeMahasiswa->nama ?? 'Mahasiswa');
                                    $foto = 'https://ui-avatars.com/api/?name=' . urlencode($nama) . '&background=' . ($isMe ? '2563eb' : 'f8fafc') . '&color=' . ($isMe ? 'fff' : '475569');
                                    
                                    $body = $diskusi->body ?? '';
                                    $image = $diskusi->image ?? null;
                                    $voice = $diskusi->voice ?? null;
                                    
                                    $time = !empty($diskusi->created_at) ? \Carbon\Carbon::parse($diskusi->created_at)->format('H:i') : '';
                                    $diskusiId = $diskusi->id ?? rand(100, 9999);
                                @endphp
                                <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                                    <div class="flex gap-2 items-end max-w-[90%] {{ $isMe ? 'flex-row-reverse' : '' }}">
                                        <img src="{{ $foto }}" class="w-7 h-7 rounded-full shrink-0 shadow-sm border border-slate-100" />
                                        <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }}">
                                            <div class="p-3 rounded-2xl shadow-sm text-xs {{ $isMe ? 'bg-blue-600 text-white rounded-tr-none' : 'bg-slate-50 text-slate-800 rounded-tl-none border border-slate-200' }}">
                                                
                                                @if(!empty($body)) 
                                                    <p class="whitespace-pre-wrap break-words leading-relaxed">{{ $body }}</p> 
                                                @endif

                                                @if(!empty($image)) 
                                                    <img src="{{ asset('storage/' . $image) }}" class="mt-2 rounded-xl max-w-full border {{ $isMe ? 'border-white/20' : 'border-slate-200' }}"> 
                                                @endif

                                                @if(!empty($voice))
                                                    <div class="mt-2 flex items-center gap-2 {{ $isMe ? 'bg-white/20 border-white/30' : 'bg-white border-slate-200' }} p-1.5 rounded-xl border w-[160px]">
                                                        <button type="button" onclick="togglePlay('wave-{{ $diskusiId }}')" id="btn-wave-{{ $diskusiId }}" class="w-6 h-6 shrink-0 flex items-center justify-center rounded-full {{ $isMe ? 'bg-white text-blue-600' : 'bg-blue-600 text-white' }} shadow text-[9px]">▶</button>
                                                        <div id="wave-{{ $diskusiId }}" class="flex-1 h-4" data-audio="{{ asset('storage/' . $voice) }}"></div>
                                                    </div>
                                                @endif
                                            </div>

                                            @if($time)
                                                <p class="text-[8px] mt-1 px-1 font-bold text-slate-400">
                                                    {{ $time }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div id="emptyChat" class="h-full flex flex-col items-center justify-center text-center opacity-70">
                                    <p class="text-xs text-slate-500 font-bold">Belum ada diskusi</p>
                                </div>
                            @endforelse
                        </div>

                        {{-- Form Input --}}
                        <div class="p-3 border-t border-slate-100 bg-white shrink-0">
                            <div id="imagePreviewContainer" class="hidden mb-2 relative w-fit">
                                <img id="imagePreviewElement" class="h-16 w-auto object-cover rounded-lg border border-slate-200">
                                <button type="button" onclick="cancelImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow">✕</button>
                            </div>

                            <form id="chatForm" method="POST" action="{{ $submission ? route('dosen.assignment.message', $submission->id) : '#' }}" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="image" id="imageInput" accept="image/*" class="hidden" onchange="previewImage(this)">
                                <input type="file" name="voice" id="voiceInput" accept="audio/webm" class="hidden">

                                <div class="flex items-center bg-white border border-slate-200 rounded-[1.25rem] p-1 shadow-sm focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100 transition-all w-full">
                                    
                                    <button type="button" onclick="document.getElementById('imageInput').click()" class="w-9 h-9 shrink-0 flex items-center justify-center rounded-[0.8rem] text-slate-400 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </button>

                                    <div id="normalInputWrapper" class="flex-1 min-w-0 px-2">
                                        <input type="text" id="messageInput" name="body" placeholder="Tulis balasan Anda..." class="w-full bg-transparent text-xs text-slate-700 outline-none placeholder-slate-400" autocomplete="off" />
                                    </div>

                                    <div id="recordingWrapper" class="hidden flex-1 items-center justify-between px-3 bg-red-50/80 rounded-xl h-8 mx-1">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                                            <span class="text-[10px] font-bold text-red-500 font-mono" id="recordTimer">00:00</span>
                                            <div class="recording-wave flex items-center gap-[2px] h-3 ml-1">
                                                <div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div>
                                            </div>
                                        </div>
                                        <button type="button" id="cancelRecordBtn" class="text-[9px] font-black uppercase text-red-500/70 hover:text-red-600">Batal</button>
                                    </div>

                                    <div class="flex items-center gap-1 shrink-0">
                                        <button type="button" id="recordBtn" class="w-9 h-9 flex items-center justify-center rounded-[0.8rem] text-slate-400 hover:bg-slate-50 transition-colors" title="Rekam Suara">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"></path></svg>
                                        </button>

                                        <button type="submit" id="sendChatBtn" class="w-9 h-9 flex items-center justify-center rounded-[0.8rem] bg-blue-600 text-white hover:bg-blue-700 transition-colors shadow-sm">
                                            <span id="sendIcon"><svg class="w-4 h-4 transform rotate-90 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg></span>
                                            <span id="sendLoading" class="hidden"><svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg></span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </main>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            // Init Animasi AOS
            AOS.init({ once: true, easing: "ease-out-cubic" });

            function filterMahasiswa(keyword) {
                keyword = keyword.toLowerCase();
                document.querySelectorAll('.mahasiswa-item').forEach(item => {
                    const name = item.dataset.name;
                    item.style.display = name.includes(keyword) ? 'block' : 'none';
                });
            }

            function toggleChat() {
                const chatWrapper = document.getElementById('chat-wrapper');
                const overlay = document.getElementById('chat-overlay');
                const placeholder = document.getElementById('chat-placeholder');
                const isExpanded = chatWrapper.classList.contains('chat-expanded');

                if (!isExpanded) {
                    placeholder.style.height = chatWrapper.offsetHeight + 'px';
                    placeholder.classList.remove('hidden');
                    document.body.appendChild(chatWrapper);
                    
                    chatWrapper.classList.add('chat-expanded');
                    overlay.classList.add('active');
                    document.body.style.overflow = 'hidden'; 
                } else {
                    chatWrapper.classList.remove('chat-expanded');
                    overlay.classList.remove('active');
                    document.body.style.overflow = 'auto'; 
                    
                    placeholder.parentNode.insertBefore(chatWrapper, placeholder);
                    placeholder.classList.add('hidden');
                }
            }

            const wavesurfers = {};
            function initWaveSurfer(containerId, audioUrl, isMe) {
                wavesurfers[containerId] = WaveSurfer.create({
                    container: '#' + containerId,
                    waveColor: isMe ? 'rgba(255,255,255,0.4)' : '#cbd5e1',
                    progressColor: isMe ? '#fff' : '#2563eb',
                    height: 16, barWidth: 2, barGap: 2, barRadius: 2, cursorWidth: 0,
                    url: audioUrl
                });
                wavesurfers[containerId].on('finish', () => document.getElementById('btn-'+containerId).innerHTML = '▶');
            }

            function togglePlay(id) {
                const ws = wavesurfers[id];
                if(ws) { ws.playPause(); document.getElementById('btn-'+id).innerHTML = ws.isPlaying() ? '⏸' : '▶'; }
            }

            document.addEventListener('DOMContentLoaded', () => {
                const chatContainer = document.getElementById('chatContainer');
                if(chatContainer) chatContainer.scrollTop = chatContainer.scrollHeight;
                document.querySelectorAll('[id^="wave-"]').forEach(el => {
                    initWaveSurfer(el.id, el.getAttribute('data-audio'), el.parentElement.classList.contains('bg-white/20'));
                });
            });

            function previewImage(input) {
                if (input.files && input.files[0]) {
                    const r = new FileReader();
                    r.onload = e => {
                        document.getElementById('imagePreviewElement').src = e.target.result;
                        document.getElementById('imagePreviewContainer').classList.remove('hidden');
                    }
                    r.readAsDataURL(input.files[0]);
                }
            }

            function cancelImage() {
                document.getElementById('imageInput').value = '';
                document.getElementById('imagePreviewContainer').classList.add('hidden');
            }

            let mediaRecorder, audioChunks = [], recordInterval, recordSeconds = 0;
            const recordBtn = document.getElementById('recordBtn');

            recordBtn.addEventListener('click', async () => {
                if (!mediaRecorder || mediaRecorder.state === "inactive") {
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                        mediaRecorder = new MediaRecorder(stream);
                        mediaRecorder.start();
                        
                        document.getElementById('normalInputWrapper').classList.add('hidden');
                        document.getElementById('recordingWrapper').classList.remove('hidden');
                        document.getElementById('recordingWrapper').classList.add('flex');
                        
                        recordBtn.classList.add('text-red-500', 'bg-red-50');
                        recordSeconds = 0; 
                        document.getElementById('recordTimer').innerText = "00:00";
                        recordInterval = setInterval(() => {
                            recordSeconds++;
                            const m = String(Math.floor(recordSeconds/60)).padStart(2,'0');
                            const s = String(recordSeconds%60).padStart(2,'0');
                            document.getElementById('recordTimer').innerText = `${m}:${s}`;
                        }, 1000);

                        audioChunks = [];
                        mediaRecorder.ondataavailable = e => audioChunks.push(e.data);
                    } catch(err) { alert("Mic error!"); }
                } else {
                    mediaRecorder.onstop = () => {
                        const file = new File([new Blob(audioChunks, { type: 'audio/webm' })], "voice.webm", { type: "audio/webm" });
                        const dt = new DataTransfer(); dt.items.add(file);
                        document.getElementById('voiceInput').files = dt.files;
                        
                        document.getElementById('recordingWrapper').classList.add('hidden');
                        document.getElementById('recordingWrapper').classList.remove('flex');
                        document.getElementById('normalInputWrapper').classList.remove('hidden');
                        recordBtn.classList.remove('text-red-500', 'bg-red-50');
                        
                        document.getElementById('messageInput').placeholder = "▶ Rekaman siap dikirim...";
                        document.getElementById('messageInput').disabled = true;
                    };
                    mediaRecorder.stop();
                    clearInterval(recordInterval);
                }
            });

            document.getElementById('cancelRecordBtn').addEventListener('click', () => {
                if(mediaRecorder && mediaRecorder.state !== "inactive") mediaRecorder.stop();
                clearInterval(recordInterval);
                document.getElementById('voiceInput').value = '';
                document.getElementById('recordingWrapper').classList.add('hidden');
                document.getElementById('recordingWrapper').classList.remove('flex');
                document.getElementById('normalInputWrapper').classList.remove('hidden');
                recordBtn.classList.remove('text-red-500', 'bg-red-50');
                document.getElementById('messageInput').placeholder = "Tulis balasan Anda...";
                document.getElementById('messageInput').disabled = false;
            });

            document.getElementById('chatForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                
                if (this.action.endsWith('#')) {
                    alert('Mahasiswa belum mengumpulkan tugas. Anda belum bisa memulai diskusi di tugas ini.');
                    return;
                }

                const msgVal = document.getElementById('messageInput').value.trim();
                const imgFile = document.getElementById('imageInput').files.length;
                const voiceFile = document.getElementById('voiceInput').files.length;
                if(!msgVal && !imgFile && !voiceFile) return;

                const formData = new FormData(this);
                const btn = document.getElementById('sendChatBtn');
                
                document.getElementById('sendIcon').classList.add('hidden');
                document.getElementById('sendLoading').classList.remove('hidden');
                btn.disabled = true;

                try {
                    const res = await fetch(this.action, {
                        method: 'POST', body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                    });
                    const data = await res.json();

                    if(res.ok && data.success) {
                        this.reset();
                        cancelImage();
                        document.getElementById('voiceInput').value = '';
                        document.getElementById('messageInput').disabled = false;
                        document.getElementById('messageInput').placeholder = "Tulis balasan Anda...";

                        const d = data.message || data.diskusi; 
                        if(d) {
                            let media = '';
                            const uid = 'wave-' + Date.now();
                            if(d.image) media += `<img src="${d.image}" class="mt-2 rounded-xl max-w-full border border-white/20">`;
                            if(d.voice) media += `<div class="mt-2 flex items-center gap-2 bg-white/20 border-white/30 p-1.5 rounded-xl border w-[160px]"><button type="button" onclick="togglePlay('${uid}')" id="btn-${uid}" class="w-6 h-6 shrink-0 flex items-center justify-center rounded-full bg-white text-blue-600 shadow text-[9px]">▶</button><div id="${uid}" class="flex-1 h-4" data-audio="${d.voice}"></div></div>`;
                            
                            const html = `<div class="flex justify-end chat-bubble-new"><div class="flex gap-2 items-end max-w-[90%] flex-row-reverse"><img src="https://ui-avatars.com/api/?name=Anda&background=2563eb&color=fff" class="w-7 h-7 rounded-full shrink-0 shadow-sm border border-slate-100"><div class="flex flex-col items-end"><div class="p-3 rounded-2xl shadow-sm text-xs bg-blue-600 text-white rounded-tr-none">${d.body ? `<p class="whitespace-pre-wrap break-words leading-relaxed">${d.body}</p>` : ''}${media}</div><p class="text-[8px] mt-1 px-1 font-bold text-slate-400">${d.time || 'Baru Saja'}</p></div></div></div>`;
                            
                            const box = document.getElementById('chatContainer');
                            const empty = document.getElementById('emptyChat');
                            if(empty) empty.remove();
                            
                            box.insertAdjacentHTML('beforeend', html);
                            box.scrollTop = box.scrollHeight;
                            if(d.voice) setTimeout(() => initWaveSurfer(uid, d.voice, true), 100);
                        } else {
                            window.location.reload();
                        }
                    } else {
                        alert("Gagal mengirim pesan: " + (data.message || "Server Error"));
                    }
                } catch(err) {
                    this.submit(); 
                } finally {
                    btn.disabled = false;
                    document.getElementById('sendLoading').classList.add('hidden');
                    document.getElementById('sendIcon').classList.remove('hidden');
                }
            });
        </script>
    </body>
</html>