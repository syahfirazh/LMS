<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Topik: {{ $session->judul ?? 'Materi' }} | LMS Inklusi UMMI</title>

        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
        
        <script src="https://unpkg.com/wavesurfer.js@7"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>

        <style>
            html { scrollbar-gutter: stable; }
            .scrollbar-hide::-webkit-scrollbar { display: none; }
            .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
            .custom-scrollbar::-webkit-scrollbar { width: 6px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background-color: #94a3b8; }

            @keyframes popIn { 0% { opacity: 0; transform: translateY(15px) scale(0.95); } 100% { opacity: 1; transform: translateY(0) scale(1); } }
            .chat-bubble-new { animation: popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
            #chatContainer { scroll-behavior: smooth; }

            @keyframes wave-bounce { 0%, 100% { height: 4px; } 50% { height: 16px; } }
            .recording-wave .bar { width: 3px; background-color: #ef4444; border-radius: 99px; animation: wave-bounce 1s ease-in-out infinite; }
            .recording-wave .bar:nth-child(1) { animation-delay: 0s; height: 8px; }
            .recording-wave .bar:nth-child(2) { animation-delay: 0.2s; height: 12px; }
            .recording-wave .bar:nth-child(3) { animation-delay: 0.4s; height: 16px; }
            .recording-wave .bar:nth-child(4) { animation-delay: 0.1s; height: 10px; }
            .recording-wave .bar:nth-child(5) { animation-delay: 0.3s; height: 14px; }
            .recording-wave .bar:nth-child(6) { animation-delay: 0.5s; height: 8px; }

            @keyframes pulse-border { 0% { border-color: #3b82f6; box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4); } 70% { border-color: #60a5fa; box-shadow: 0 0 0 6px rgba(59, 130, 246, 0); } 100% { border-color: #3b82f6; box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); } }
            .dictating-active { animation: pulse-border 1.5s infinite; background-color: #eff6ff !important; }
            .confirming-active { background-color: #fef3c7 !important; border-color: #f59e0b !important; }
            .safe-fade-in { animation: popIn 0.4s ease-out forwards; opacity: 0; }
            
            .modal-active { opacity: 1 !important; pointer-events: auto !important; }
            .modal-content-active { transform: scale(1) !important; opacity: 1 !important; }
        </style>
    </head>
    <body class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-full flex flex-col border-box overflow-x-hidden text-slate-800">
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute top-[-10%] right-[-5%] w-[400px] h-[400px] bg-blue-100/40 rounded-full blur-3xl opacity-50"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] bg-indigo-50/40 rounded-full blur-3xl opacity-50"></div>
        </div>

        <main class="flex-1 flex flex-col h-screen overflow-y-scroll custom-scrollbar relative">
            <div class="bg-white/90 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm transition-all w-full">
                <div class="max-w-7xl mx-auto flex items-center justify-between relative h-12">
                    <div class="flex items-center gap-4 relative z-10 shrink-0">
                        <button onclick="navigasiKe(0)" class="w-11 h-11 md:w-12 md:h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm group border border-slate-200 hover:border-blue-600 relative cursor-pointer active:scale-95">
                            <svg class="w-5 h-5 md:w-6 md:h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                    </div>

                    <div class="absolute left-1/2 transform -translate-x-1/2 text-center w-[50%] md:w-[60%] z-0 pointer-events-none">
                        <h1 class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight leading-none truncate pointer-events-auto">{{ $kelas->mataKuliah->nama ?? 'Nama Kelas' }}</h1>
                        <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1 truncate pointer-events-auto">Topik: {{ $session->judul ?? 'Nama Topik' }}</p>
                    </div>

                    <div class="flex items-center justify-end gap-3 pl-4 relative z-10 shrink-0">
                        <div class="flex items-center gap-[2px] h-4 w-10 justify-center" id="wave-container">
                            <div class="wave-bar w-[2px] bg-blue-500 rounded-full h-1 transition-all"></div>
                            <div class="wave-bar w-[2px] bg-blue-400 rounded-full h-1 transition-all"></div>
                            <div class="wave-bar w-[2px] bg-blue-600 rounded-full h-1 transition-all"></div>
                        </div>
                        <span id="status-desc" class="hidden md:block text-[9px] font-black text-slate-400 uppercase tracking-widest text-left w-20">SIAP</span>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto w-full px-4 md:px-8 py-6 md:py-8 space-y-6 md:space-y-8 pb-20">
                
                <div data-aos="fade-up" data-aos-duration="600" onclick="navigasiKe(1)" class="bg-blue-50 border-l-4 border-blue-500 rounded-r-[2rem] p-6 shadow-sm cursor-pointer hover:bg-blue-100 transition-all group relative active:scale-[0.98]">
                    <div class="absolute right-4 top-4 w-8 h-8 bg-blue-500 text-white shadow-md rounded-lg flex items-center justify-center font-black text-xs">1</div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-blue-200 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                        </div>
                        <div class="pr-10 flex-1">
                            <h3 class="text-[10px] md:text-xs font-black text-blue-800 uppercase tracking-[0.2em] mb-1">Pesan Dosen</h3>
                            <p id="text-pengumuman" class="text-sm md:text-base font-medium text-slate-700 leading-relaxed">{{ $session->instruksi ?? 'Belum ada pesan/instruksi dari dosen.' }}</p>
                        </div>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-duration="600" data-aos-delay="100" class="bg-white rounded-[2rem] md:rounded-[2.5rem] p-6 md:p-8 border border-slate-200 shadow-sm relative">
                    <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <h3 class="text-base md:text-lg font-black text-slate-900 uppercase tracking-widest">Materi Pembelajaran</h3>
                    </div>

                    <div id="materi-container" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @forelse($session->materis as $index => $materi)
                            @php
                                $type = $materi->type ?? 'file';
                                
                                $voiceNum = 2; // PDF
                                if($type === 'video' || $type === 'link') $voiceNum = 3;
                                if($type === 'voice') $voiceNum = 4;

                                $config = [
                                    'file'  => ['color' => 'blue',   'label' => 'PDF',   'bg' => 'bg-red-50',    'border' => 'border-red-100',    'text' => 'text-red-500'],
                                    'video' => ['color' => 'red',    'label' => 'VIDEO', 'bg' => 'bg-red-100',   'border' => 'border-red-200',   'text' => 'text-red-600'],
                                    'link'  => ['color' => 'red',    'label' => 'YOUTUBE', 'bg' => 'bg-red-100', 'border' => 'border-red-200',   'text' => 'text-red-600'],
                                    'voice' => ['color' => 'purple', 'label' => 'AUDIO', 'bg' => 'bg-purple-100', 'border' => 'border-purple-200', 'text' => 'text-purple-600'],
                                ];
                                $ui = $config[$type] ?? $config['file'];
                                
                                $fileUrl = $materi->file ? asset('storage/'.$materi->file) : ($materi->link ? $materi->link : '#');
                                $isYT = ($type === 'link' && (str_contains($materi->link, 'youtu') || str_contains($materi->link, 'youtube'))) ? 'true' : 'false';
                            @endphp

                            <div id="materi-{{ $voiceNum }}" data-url="{{ $fileUrl }}" data-materi-type="{{ $type }}" data-yt="{{ $isYT }}" data-title="{{ $materi->judul }}" onclick="navigasiKe({{ $voiceNum }})" class="group border border-slate-100 rounded-2xl p-4 md:p-5 hover:border-{{ $ui['color'] }}-300 hover:bg-{{ $ui['color'] }}-50/30 transition-all cursor-pointer relative active:scale-[0.98]">
                                <div class="absolute right-4 top-4 w-6 h-6 bg-{{ $ui['color'] }}-500 text-white shadow-md rounded-lg flex items-center justify-center font-black text-[10px] transition-colors">
                                    {{ $voiceNum }}
                                </div>
                                <div class="flex flex-col gap-3">
                                    <div class="w-12 h-14 {{ $ui['bg'] }} rounded-lg border {{ $ui['border'] }} flex items-center justify-center shrink-0 {{ $ui['text'] }}">
                                        @if($type === 'file')
                                            <span class="text-[9px] font-black uppercase">PDF</span>
                                        @elseif($type === 'video' || $type === 'link')
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" /></svg>
                                        @elseif($type === 'voice')
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-800 group-hover:text-{{ $ui['color'] }}-700 line-clamp-1">{{ $materi->judul }}</h4>
                                        <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-wider">{{ $ui['label'] }} • Klik Putar/Buka</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-1 md:col-span-3 bg-slate-50 border border-dashed border-slate-300 rounded-2xl p-8 text-center flex flex-col items-center justify-center">
                                <svg class="w-10 h-10 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <h4 class="text-slate-500 font-bold text-sm">Materi Kosong</h4>
                                <p class="text-xs text-slate-400 mt-1">Dosen belum mengunggah file materi untuk sesi ini.</p>
                            </div>
                        @endforelse
                    </div>

                    <div id="module-reader" class="hidden mt-6 bg-slate-900 text-slate-200 p-6 rounded-2xl shadow-2xl animate-fade-in-up relative">
                        <div class="flex justify-between items-center mb-4 border-b border-slate-700 pb-4">
                            <h3 class="text-xs font-black text-white uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span> Membacakan Modul...
                            </h3>
                            <button onclick="stopBicara()" class="text-[9px] font-bold uppercase bg-red-500/20 text-red-400 px-3 py-1 rounded-lg hover:bg-red-500 hover:text-white transition-all cursor-pointer active:scale-95">Stop</button>
                        </div>
                        <p id="reader-text" class="text-sm leading-loose font-medium font-mono h-32 overflow-y-auto custom-scrollbar">Sedang mengekstrak isi PDF...</p>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-duration="600" data-aos-delay="200" class="bg-white rounded-[2rem] md:rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden flex flex-col h-[600px]">
                    <div class="p-5 md:p-6 md:px-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 z-10">
                        <div>
                            <h3 class="text-base md:text-lg font-black text-slate-900 uppercase tracking-tight">Ruang Diskusi Kelas</h3>
                            <p class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Tanya jawab sesi ini bersama Dosen</p>
                        </div>
                        <span class="text-[9px] font-bold bg-blue-100 text-blue-700 px-3 py-1.5 rounded-full flex items-center gap-1.5">
                            Sebut "Sembilan" untuk Baca Chat
                        </span>
                    </div>

                    <div id="chatContainer" class="flex-1 p-4 md:p-6 flex flex-col gap-6 overflow-y-auto custom-scrollbar bg-white">
                        @forelse($session->discussions->sortBy('created_at') as $diskusi)
                            @php
                                $sender = $diskusi->sender;
                                $loggedInId = Auth::guard('mahasiswa')->id() ?? 0;
                                
                                $isMe = (in_array($diskusi->sender_type, ['mahasiswa', 'App\Models\Mahasiswa'])) && ($diskusi->sender_id == $loggedInId);
                                $isDosen = in_array($diskusi->sender_type, ['dosen', 'App\Models\Dosen']);
                                
                                $namaAsli = $sender->nama ?? 'Mahasiswa';
                                $labelTeks = $isMe ? 'Anda' : ($isDosen ? ($sender->nama ?? 'Dosen') : $namaAsli);
                                $avatarName = $isMe ? $namaAsli : $labelTeks;
                                $avatarBg = $isMe ? '2563eb' : ($isDosen ? 'f59e0b' : '64748b'); 
                                
                                // LOGIKA PENGAMBILAN FOTO DARI DATABASE
                                $fotoProfil = $sender->foto_profil ?? $sender->foto ?? null;
                                $fallbackAvatar = "https://ui-avatars.com/api/?name=" . urlencode($avatarName) . "&background=" . $avatarBg . "&color=fff";
                                $avatarUrl = $fotoProfil ? asset('storage/' . $fotoProfil) : $fallbackAvatar;
                            @endphp
                            
                            <div id="msg-{{ $diskusi->id }}" class="flex {{ $isMe ? 'justify-end' : 'justify-start' }} safe-fade-in chat-bubble-new">
                                <div class="flex gap-2 md:gap-3 items-end max-w-[90%] md:max-w-[70%] {{ $isMe ? 'flex-row-reverse' : '' }}">
                                    <img src="{{ $avatarUrl }}" onerror="this.src='{{ $fallbackAvatar }}'" class="w-8 h-8 md:w-9 md:h-9 rounded-full shrink-0 shadow-sm object-cover border border-slate-100" />
                                    
                                    <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }}">
                                        <p class="text-[9px] md:text-[10px] font-bold mb-1 px-1 {{ $isDosen ? 'text-orange-500' : 'text-slate-400' }}">
                                            {{ $labelTeks }} 
                                            @if($isDosen)
                                                <span class="bg-orange-100 text-orange-600 px-1.5 py-0.5 rounded ml-1 text-[8px] uppercase">Dosen</span>
                                            @endif
                                        </p>
                                        
                                        <div class="p-3 md:p-4 rounded-2xl shadow-sm border {{ $isMe ? 'bg-blue-600 text-white rounded-tr-none border-blue-700' : 'bg-slate-50 text-slate-800 rounded-tl-none border-slate-200' }}">
                                            @if($diskusi->message)
                                                <p class="text-xs md:text-[13px] leading-relaxed font-medium whitespace-pre-wrap break-words">{{ $diskusi->message }}</p>
                                            @endif
                                            @if(isset($diskusi->image) && $diskusi->image)
                                                <img src="{{ asset('storage/'.$diskusi->image) }}" class="mt-2 rounded-xl max-w-full border {{ $isMe ? 'border-white/20' : 'border-slate-200' }}">
                                            @endif
                                            @if(isset($diskusi->voice) && $diskusi->voice)
                                                <div class="mt-2 flex items-center gap-3 bg-white/20 p-2 rounded-xl backdrop-blur-sm border {{ $isMe ? 'border-white/30' : 'border-slate-300 bg-white' }} w-[200px] sm:w-[240px]">
                                                    <button type="button" onclick="togglePlay('wave-{{ $diskusi->id }}')" id="btn-wave-{{ $diskusi->id }}" class="w-7 h-7 sm:w-8 sm:h-8 shrink-0 flex items-center justify-center rounded-full {{ $isMe ? 'bg-white text-blue-600' : 'bg-blue-600 text-white' }} shadow hover:scale-105 transition-transform text-[10px] sm:text-xs">▶</button>
                                                    <div id="wave-{{ $diskusi->id }}" class="flex-1" data-audio="{{ asset('storage/' . $diskusi->voice) }}"></div>
                                                </div>
                                            @endif
                                        </div>
                                        <p class="text-[8px] md:text-[9px] mt-1.5 px-1 font-bold text-slate-400">{{ $diskusi->created_at->format('H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div id="emptyChat" class="h-full flex flex-col items-center justify-center text-center opacity-70">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-blue-50 text-blue-400 rounded-full flex items-center justify-center mb-4 border border-blue-100">
                                    <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                </div>
                                <p class="text-xs sm:text-sm text-slate-600 font-bold">Ruang diskusi masih kosong.</p>
                                <p class="text-[9px] sm:text-[10px] text-slate-400 uppercase tracking-widest mt-1">Mulai obrolan materi ini bersama dosen!</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="p-3 md:p-4 border-t border-slate-100 bg-white shrink-0 shadow-[0_-4px_10px_rgba(0,0,0,0.02)] relative z-20">
                        <div id="imagePreviewContainer" class="hidden mb-3 relative p-2 bg-slate-50 border border-slate-200 rounded-2xl w-fit">
                            <img id="imagePreviewElement" src="" class="h-20 sm:h-24 w-auto object-cover rounded-xl shadow-sm border border-slate-200">
                            <button type="button" onclick="cancelImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center font-bold text-xs shadow-lg hover:bg-red-600 hover:scale-110 transition-transform">✕</button>
                        </div>

                        <form id="chatForm" action="{{ route('discussion.store', $session->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="sender_type" value="mahasiswa">
                            <input type="file" name="image" id="imageInput" accept="image/*" class="hidden" onchange="previewImage(this)">
                            <input type="file" name="voice" id="voiceInput" accept="audio/webm" class="hidden">

                            <div class="relative flex items-center gap-2 sm:gap-3 bg-slate-50 p-2 sm:p-3 rounded-[1.25rem] sm:rounded-2xl border border-slate-200 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100 transition-all">
                                
                                <div id="uploadImageContainer" class="relative shrink-0 hidden md:block">
                                    <button type="button" id="btnUploadImage" onclick="document.getElementById('imageInput').click()" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-white transition-all cursor-pointer shadow-sm border border-transparent hover:border-blue-100">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </button>
                                    <span class="absolute -top-1.5 -right-1.5 bg-slate-900 text-white text-[8px] font-black px-1.5 py-0.5 rounded-md shadow-sm border border-white">6</span>
                                </div>

                                <div id="normalInputWrapper" class="flex-1 min-w-0 relative flex items-center">
                                    <div class="absolute left-2 text-[10px] font-black text-white bg-slate-900 px-1.5 py-0.5 rounded-md shadow-sm hidden md:block z-10">5</div>
                                    <input type="text" name="message" id="messageInput" placeholder="Sebutkan 5 untuk ketik suara..." autocomplete="off" class="w-full bg-transparent text-xs sm:text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none transition-all py-1.5 pl-1 md:pl-8" />
                                    
                                    <button type="button" id="cancelVoiceToTextBtn" onclick="batalKetikSuara()" class="hidden absolute right-1 sm:right-2 text-[10px] font-black uppercase text-white bg-red-500 hover:bg-red-600 px-2.5 py-1.5 rounded-lg shadow-sm transition-all cursor-pointer z-20">Batal Dikte ✕</button>
                                    
                                    <button type="button" id="cancelVoiceBtn" class="hidden absolute right-1 sm:right-2 text-[10px] font-black uppercase text-white bg-red-500 hover:bg-red-600 px-2.5 py-1.5 rounded-lg shadow-sm transition-all cursor-pointer z-20">Batal Suara ✕</button>
                                </div>

                                <div id="recordingWrapper" class="hidden flex-1 items-center justify-between px-2">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 sm:w-2.5 sm:h-2.5 bg-red-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(239,68,68,0.8)]"></span>
                                        <span class="text-[10px] sm:text-xs font-bold text-red-500 font-mono tracking-wider" id="recordTimer">00:00</span>
                                        <div class="recording-wave flex items-center gap-1 h-5 sm:h-6 ml-1 sm:ml-2">
                                            <div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div>
                                        </div>
                                    </div>
                                    <button type="button" id="cancelRecordBtn" class="text-[9px] sm:text-[10px] font-black uppercase text-slate-400 hover:text-red-500 px-1 sm:px-2 transition-colors cursor-pointer">Batal</button>
                                </div>

                                <div id="recordBtnContainer" class="relative shrink-0">
                                    <button type="button" id="recordBtn" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all cursor-pointer border border-transparent hover:border-red-100 shadow-sm">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"></path></svg>
                                    </button>
                                    <span class="absolute -top-1.5 -right-1.5 bg-slate-900 text-white text-[8px] font-black px-1.5 py-0.5 rounded-md shadow-sm border border-white">7</span>
                                </div>

                                <div class="relative shrink-0">
                                    <button type="submit" id="sendChatBtn" class="w-10 h-9 sm:w-12 sm:h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-transform transform hover:scale-105 active:scale-95 shadow-md shadow-blue-200 cursor-pointer">
                                        <span id="sendIcon"><svg class="w-4 h-4 sm:w-5 sm:h-5 transform rotate-90 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg></span>
                                        <span id="sendLoading" class="hidden"><svg class="w-4 h-4 sm:w-5 sm:h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg></span>
                                    </button>
                                    <span class="absolute -top-1.5 -right-1.5 bg-slate-900 text-white text-[8px] font-black px-1.5 py-0.5 rounded-md shadow-sm border border-white z-10">8</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <audio id="globalAudioPlayer" class="hidden"></audio>

        <div id="modalBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] opacity-0 pointer-events-none transition-opacity duration-300"></div>
        <div id="videoPlayerModal" class="fixed inset-0 flex items-center justify-center z-[70] opacity-0 pointer-events-none transition-opacity duration-300 p-4 sm:p-8">
            <div class="bg-black w-full max-w-4xl rounded-2xl sm:rounded-[2rem] overflow-hidden shadow-2xl transform scale-95 transition-transform duration-300 modal-box flex flex-col border border-slate-800">
                <div class="flex justify-between items-center p-4 sm:p-5 bg-gradient-to-b from-black/80 to-transparent absolute top-0 w-full z-10 pointer-events-auto">
                    <h3 id="videoPlayerTitle" class="text-white font-bold text-sm sm:text-base truncate pr-4 drop-shadow-md">Pemutar Video</h3>
                    <button type="button" onclick="closeVideoPlayer()" class="text-white hover:text-red-500 w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-full transition-all shrink-0">✕</button>
                </div>
                <div id="videoPlayerContainer" class="w-full aspect-video bg-black flex items-center justify-center relative">
                </div>
            </div>
        </div>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

        <script>
            AOS.init({ once: true, easing: "ease-out-cubic" });
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

            const statusDesc = document.getElementById("status-desc");
            const waveBars = document.querySelectorAll(".wave-bar");
            const readerBox = document.getElementById("module-reader");
            const readerText = document.getElementById("reader-text");
            const synth = window.speechSynthesis;
            const SpeechRec = window.webkitSpeechRecognition || window.SpeechRecognition;

            let rec = null; let interval; let modeKetikSuara = false; let menungguKonfirmasiKirim = false; let jedaKetikTimer = null;

            const teksPanduanLengkap = "Sebutkan 1 untuk Pesan Dosen, 2 baca PDF, 3 putar Video, 4 putar Audio. Untuk diskusi, sebutkan 5 ketik pesan, 6 lampiran, 7 rekam suara, 8 kirim, atau 9 untuk baca diskusi kelas. Nol untuk kembali.";

            if (SpeechRec) { rec = new SpeechRec(); rec.lang = "id-ID"; rec.continuous = true; }

            function setWave(active) {
                if (waveBars.length > 0) {
                    waveBars.forEach((bar) => { bar.style.height = active ? `${Math.floor(Math.random() * 12) + 4}px` : "4px"; });
                }
            }

            function bicara(teks, callback) {
                synth.cancel();
                const utter = new SpeechSynthesisUtterance(teks);
                utter.lang = "id-ID";
                utter.rate = localStorage.getItem("speechRate") ? parseFloat(localStorage.getItem("speechRate")) : 1.0;
                utter.onstart = () => { if (statusDesc) statusDesc.innerText = "BERBICARA..."; interval = setInterval(() => setWave(true), 150); };
                utter.onend = () => { if (statusDesc) statusDesc.innerText = "MENDENGARKAN..."; clearInterval(interval); setWave(false); if (callback) callback(); };
                synth.speak(utter);
            }

            function stopBicara() {
                synth.cancel();
                if(readerBox) readerBox.classList.add("hidden");
                let globalAudio = document.getElementById('globalAudioPlayer');
                if(globalAudio) { globalAudio.pause(); globalAudio.currentTime = 0; }
                closeVideoPlayer();
            }

            function arahkanSingkat(pesanAwal) {
                bicara(pesanAwal + ". Silakan sebutkan angka menu selanjutnya, atau sebut Panduan untuk mendengar opsi.", () => { mulaiMendengar(); });
            }

            async function readPDFText(url) {
                try {
                    let pdf = await pdfjsLib.getDocument(url).promise;
                    let fullText = "";
                    let maxPages = Math.min(pdf.numPages, 2); 
                    for(let i = 1; i <= maxPages; i++) {
                        let page = await pdf.getPage(i);
                        let textContent = await page.getTextContent();
                        fullText += textContent.items.map(s => s.str).join(" ") + " ";
                    }
                    return fullText.trim() || "Dokumen PDF ini berisi gambar yang tidak dapat dibaca teksnya.";
                } catch(e) {
                    return "Maaf, sistem gagal mengekstrak isi dokumen PDF ini.";
                }
            }

            function openVideoPlayer(url, isYoutube, title) {
                document.getElementById('videoPlayerTitle').innerText = title || "Video Player";
                const container = document.getElementById('videoPlayerContainer');
                container.innerHTML = '';

                if (isYoutube === 'true' || isYoutube === true || url.includes('youtu')) {
                    let videoId = '';
                    const regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|shorts\/)([^#\&\?]*).*/;
                    const match = url.match(regExp);
                    
                    if (match && match[2].length === 11) {
                        videoId = match[2];
                    } else {
                        try {
                            let urlObj = new URL(url);
                            videoId = urlObj.searchParams.get("v") || url.split('/').pop();
                        } catch(e) { videoId = ''; }
                    }
                    
                    let embedUrl = videoId ? `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0` : url;
                    container.innerHTML = `<iframe src="${embedUrl}" class="w-full h-full border-0 absolute top-0 left-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;
                } else {
                    container.innerHTML = `<video controls autoplay class="w-full h-full absolute top-0 left-0 outline-none"><source src="${url}" type="video/mp4">Browser Anda tidak mendukung HTML5 video.</video>`;
                }

                const modal = document.getElementById('videoPlayerModal');
                const box = modal.querySelector('.modal-box');
                document.getElementById('modalBackdrop').classList.add('modal-active');
                modal.classList.add('modal-active');
                setTimeout(() => { box.classList.add('modal-content-active'); }, 10);
            }

            function closeVideoPlayer() {
                const modal = document.getElementById('videoPlayerModal');
                const box = modal.querySelector('.modal-box');
                box.classList.remove('modal-content-active');
                document.getElementById('modalBackdrop').classList.remove('modal-active');
                setTimeout(() => { 
                    modal.classList.remove('modal-active'); 
                    document.getElementById('videoPlayerContainer').innerHTML = ''; 
                }, 300);
            }

            window.batalKetikSuara = function() {
                modeKetikSuara = false; menungguKonfirmasiKirim = false; clearTimeout(jedaKetikTimer);
                document.getElementById('normalInputWrapper').classList.remove('dictating-active', 'confirming-active');
                document.getElementById('cancelVoiceToTextBtn').classList.add('hidden');
                document.getElementById("messageInput").value = "";
                document.getElementById("messageInput").placeholder = "Sebutkan 5 untuk ketik suara...";
            }

            let imageInput = document.getElementById("imageInput");
            let messageInput = document.getElementById("messageInput");
            let voiceInput = document.getElementById("voiceInput");
            const recordBtn = document.getElementById('recordBtn');
            const btnUploadImage = document.getElementById('btnUploadImage');
            const normalInputWrapper = document.getElementById('normalInputWrapper');
            const recordingWrapper = document.getElementById('recordingWrapper');
            const cancelVoiceBtn = document.getElementById('cancelVoiceBtn');
            const uploadImageContainer = document.getElementById('uploadImageContainer');
            const recordBtnContainer = document.getElementById('recordBtnContainer');

            window.previewImage = function(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('imagePreviewElement').src = e.target.result;
                        document.getElementById('imagePreviewContainer').classList.remove('hidden');
                        document.getElementById('imagePreviewContainer').classList.add('inline-block');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            window.cancelImage = function() {
                if(imageInput) imageInput.value = '';
                document.getElementById('imagePreviewContainer').classList.remove('inline-block');
                document.getElementById('imagePreviewContainer').classList.add('hidden');
            }

            let mediaRecorder, audioChunks = [], recordInterval, recordSeconds = 0;
            function updateTimer() {
                recordSeconds++;
                document.getElementById('recordTimer').innerText = `${String(Math.floor(recordSeconds / 60)).padStart(2, '0')}:${String(recordSeconds % 60).padStart(2, '0')}`;
            }

            if(recordBtn) {
                recordBtn.addEventListener('click', async () => {
                    if (!mediaRecorder || mediaRecorder.state === "inactive") {
                        try {
                            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                            mediaRecorder = new MediaRecorder(stream);
                            mediaRecorder.start();
                            
                            normalInputWrapper.classList.add('hidden'); 
                            if(uploadImageContainer) uploadImageContainer.classList.add('hidden');
                            recordingWrapper.classList.remove('hidden'); recordingWrapper.classList.add('flex');
                            recordBtn.classList.remove('text-slate-400');
                            recordBtn.classList.add('text-white', 'bg-red-500', 'animate-pulse', 'border-red-600');
                            
                            recordSeconds = 0; document.getElementById('recordTimer').innerText = "00:00";
                            recordInterval = setInterval(updateTimer, 1000);
                            audioChunks = []; mediaRecorder.ondataavailable = event => { audioChunks.push(event.data); };
                        } catch(err) { alert("Mikrofon tidak diizinkan!"); }
                    } else {
                        mediaRecorder.onstop = () => {
                            const file = new File([new Blob(audioChunks, { type: 'audio/webm' })], "voice.webm", { type: "audio/webm" });
                            const dataTransfer = new DataTransfer(); dataTransfer.items.add(file); voiceInput.files = dataTransfer.files;
                            
                            recordingWrapper.classList.add('hidden'); recordingWrapper.classList.remove('flex');
                            normalInputWrapper.classList.remove('hidden');
                            
                            if(recordBtnContainer) recordBtnContainer.classList.add('hidden');
                            
                            messageInput.placeholder = "▶ ılıılı Voice Note siap dikirim...";
                            messageInput.disabled = true; 
                            messageInput.classList.add('font-bold', 'text-blue-600', 'bg-blue-100/50', 'rounded-xl', 'px-4');
                            messageInput.classList.remove('bg-transparent', 'pl-1', 'md:pl-8');
                            
                            cancelVoiceBtn.classList.remove('hidden');
                        };
                        mediaRecorder.stop(); clearInterval(recordInterval);
                    }
                });

                document.getElementById('cancelRecordBtn').addEventListener('click', () => {
                    if(mediaRecorder && mediaRecorder.state !== "inactive") mediaRecorder.stop();
                    clearInterval(recordInterval); audioChunks = []; voiceInput.value = '';
                    recordingWrapper.classList.add('hidden'); recordingWrapper.classList.remove('flex');
                    normalInputWrapper.classList.remove('hidden'); 
                    if(uploadImageContainer) uploadImageContainer.classList.remove('hidden');
                    recordBtn.classList.remove('text-white', 'bg-red-500', 'animate-pulse', 'border-red-600');
                    recordBtn.classList.add('text-slate-400');
                    messageInput.disabled = false;
                    messageInput.placeholder = "Sebutkan 5 untuk ketik suara...";
                    
                    arahkanSingkat("Perekaman suara dibatalkan"); 
                });

                cancelVoiceBtn.addEventListener('click', () => {
                    voiceInput.value = ''; 
                    
                    messageInput.placeholder = "Sebutkan 5 untuk ketik suara...";
                    messageInput.disabled = false;
                    messageInput.classList.remove('font-bold', 'text-blue-600', 'bg-blue-100/50', 'rounded-xl', 'px-4');
                    messageInput.classList.add('bg-transparent', 'pl-1', 'md:pl-8');
                    
                    cancelVoiceBtn.classList.add('hidden');
                    if(uploadImageContainer) uploadImageContainer.classList.remove('hidden');
                    if(recordBtnContainer) recordBtnContainer.classList.remove('hidden');
                    recordBtn.classList.remove('hidden', 'text-white', 'bg-red-500', 'animate-pulse', 'border-red-600');
                    recordBtn.classList.add('text-slate-400');

                    arahkanSingkat("Voice note dibatalkan");
                });
            }

            function navigasiKe(nomor) {
                let tujuan = ""; let teks = "";

                if (nomor === 0) {
                    tujuan = "{{ route('course.detail', $kelas->id) }}";
                    teks = "Kembali ke Menu Utama.";
                } else if (nomor === 1) {
                    teks = "Pesan Dosen: " + document.getElementById("text-pengumuman").innerText;
                } else if (nomor === 2) {
                    let pdfEl = document.getElementById("materi-2");
                    if(pdfEl) {
                        let url = pdfEl.getAttribute("data-url");
                        readerBox.classList.remove("hidden");
                        readerText.innerText = "Mengekstrak teks asli PDF, mohon tunggu sebentar...";
                        bicara("Mengekstrak isi file PDF, mohon tunggu.");
                        
                        readPDFText(url).then(extractedText => {
                            readerText.innerText = extractedText.substring(0, 300) + "..."; 
                            bicara("Membacakan PDF: " + extractedText, () => { 
                                arahkanSingkat("Selesai membaca materi PDF"); 
                            });
                        });
                        return;
                    } else { teks = "Materi PDF kosong atau belum diunggah dosen."; }
                } else if (nomor === 3) {
                    let videoEl = document.getElementById("materi-3");
                    if(videoEl) {
                        let url = videoEl.getAttribute("data-url");
                        let isYt = videoEl.getAttribute("data-yt");
                        let title = videoEl.getAttribute("data-title");
                        teks = "Membuka dan memutar video di dalam layar.";
                        bicara(teks, () => { openVideoPlayer(url, isYt, title); mulaiMendengar(); });
                        return;
                    } else { teks = "Materi Video kosong atau belum diunggah dosen."; }
                } else if (nomor === 4) {
                    let audioEl = document.getElementById("materi-4");
                    if(audioEl) {
                        let url = audioEl.getAttribute("data-url");
                        teks = "Memutar audio pembelajaran.";
                        bicara(teks, () => {
                            let player = document.getElementById('globalAudioPlayer');
                            player.src = url; 
                            player.play(); 
                            
                            player.onended = () => { arahkanSingkat("Pemutaran audio selesai"); };
                            mulaiMendengar();
                        });
                        return;
                    } else { teks = "Materi Audio kosong atau belum diunggah dosen."; }
                } else if (nomor === 5) {
                    modeKetikSuara = true; menungguKonfirmasiKirim = false;
                    document.getElementById('normalInputWrapper').classList.add('dictating-active');
                    document.getElementById('normalInputWrapper').classList.remove('confirming-active');
                    document.getElementById('cancelVoiceToTextBtn').classList.remove('hidden');
                    document.getElementById("messageInput").value = "";
                    document.getElementById("messageInput").placeholder = "Mendengarkan teks...";
                    teks = "Silakan berbicara untuk mendikte pesan teks.";
                } else if (nomor === 6) {
                    teks = "Membuka galeri. Pilih gambar, lalu sebutkan delapan untuk mengirim.";
                    bicara(teks, () => { document.getElementById('imageInput').click(); mulaiMendengar(); });
                    return;
                } else if (nomor === 7) {
                    if (!recordBtn.classList.contains('text-white')) {
                        teks = "Merekam suara. Silakan bicara setelah bip. Sebutkan Selesai untuk berhenti.";
                        bicara(teks, () => { recordBtn.click(); });
                        return;
                    } else {
                        recordBtn.click(); teks = "Suara disimpan. Sebutkan delapan untuk mengirim.";
                    }
                } else if (nomor === 8) {
                    modeKetikSuara = false; menungguKonfirmasiKirim = false; clearTimeout(jedaKetikTimer);
                    document.getElementById('normalInputWrapper').classList.remove('dictating-active', 'confirming-active');
                    document.getElementById('cancelVoiceToTextBtn').classList.add('hidden');
                    
                    const textVal = document.getElementById("messageInput").value.trim();
                    const imgVal = document.getElementById("imageInput").files.length;
                    const voiceVal = document.getElementById("voiceInput").files.length;

                    if (textVal !== "" || imgVal > 0 || voiceVal > 0) {
                        document.getElementById("sendChatBtn").click(); return; 
                    } else { teks = "Maaf, pesan masih kosong."; }
                } else if (nomor === 9) {
                    let chats = document.querySelectorAll('#chatContainer .chat-bubble-new');
                    if(chats.length === 0) {
                        teks = "Belum ada diskusi di ruang ini.";
                    } else {
                        let textToRead = "Membacakan riwayat pesan diskusi. ";
                        chats.forEach(chat => {
                            let senderEl = chat.querySelector('.text-slate-400, .text-orange-500');
                            let sender = senderEl ? senderEl.innerText.replace('Dosen', '').trim() : "Seseorang";
                            
                            let msgElement = chat.querySelector('p.whitespace-pre-wrap');
                            let msg = msgElement ? msgElement.innerText.trim() : "Mengirim lampiran media.";
                            
                            textToRead += sender + " bilang: " + msg + ". ";
                        });
                        teks = textToRead;
                        bicara(teks, () => { arahkanSingkat("Selesai membacakan diskusi kelas"); });
                        return;
                    }
                }

                if (teks !== "") bicara(teks, () => {
                    if (tujuan !== "" && tujuan !== "#") window.location.href = tujuan; 
                    else mulaiMendengar(); 
                });
            }

            function mulaiMendengar() {
                if (!rec) return;
                try {
                    rec.start();
                    rec.onresult = (event) => {
                        const hasil = event.results[event.results.length - 1][0].transcript.toLowerCase().trim();

                        if (hasil.includes("panduan") || hasil.includes("bantuan")) {
                            bicara(teksPanduanLengkap, () => { mulaiMendengar(); });
                            return;
                        }

                        if (menungguKonfirmasiKirim) {
                            if (hasil.includes("kirim") || hasil.includes("delapan") || hasil.includes("ya")) { navigasiKe(8); return; }
                            if (hasil.includes("batal") || hasil.includes("tidak") || hasil.includes("engga")) { 
                                window.batalKetikSuara(); 
                                arahkanSingkat("Pesan dibatalkan"); 
                                return; 
                            }
                            return; 
                        }

                        if (modeKetikSuara) {
                            if (hasil === "batal") { 
                                window.batalKetikSuara(); 
                                arahkanSingkat("Pengetikan dibatalkan");
                                return; 
                            }
                            let inputEl = document.getElementById("messageInput");
                            inputEl.value += (inputEl.value === "" ? "" : " ") + hasil;
                            clearTimeout(jedaKetikTimer);
                            jedaKetikTimer = setTimeout(() => {
                                modeKetikSuara = false; menungguKonfirmasiKirim = true;
                                document.getElementById('normalInputWrapper').classList.remove('dictating-active');
                                document.getElementById('normalInputWrapper').classList.add('confirming-active');
                                bicara(`Pesan Anda adalah: ${inputEl.value}. Mau dikirim atau tidak? Sebutkan kirim, atau batal.`, () => { mulaiMendengar(); });
                            }, 2500); 
                            return; 
                        }

                        if (recordBtn && recordBtn.classList.contains('text-white')) {
                            if (hasil.includes("selesai")) {
                                recordBtn.click();
                                bicara("Suara telah disimpan. Sebutkan delapan untuk mengirim pesan suara ini.", () => { mulaiMendengar(); });
                            }
                            return; 
                        }

                        if (hasil.includes("nol") || hasil.includes("kembali")) navigasiKe(0);
                        else if (hasil.includes("satu") || hasil.includes("pesan") || hasil.includes("instruksi")) navigasiKe(1);
                        else if (hasil.includes("dua") || hasil.includes("baca modul") || hasil.includes("baca pdf")) navigasiKe(2);
                        else if (hasil.includes("tiga") || hasil.includes("video") || hasil.includes("youtube")) navigasiKe(3);
                        else if (hasil.includes("empat") || hasil.includes("audio")) navigasiKe(4);
                        else if (hasil.includes("lima") || hasil.includes("ketik") || hasil.includes("dikte")) navigasiKe(5);
                        else if (hasil.includes("enam") || hasil.includes("lampiran") || hasil.includes("gambar")) navigasiKe(6);
                        else if (hasil.includes("tujuh") || hasil.includes("rekam") || hasil.includes("suara")) navigasiKe(7);
                        else if (hasil.includes("delapan") || hasil.includes("kirim")) navigasiKe(8);
                        else if (hasil.includes("sembilan") || (hasil.includes("baca") && (hasil.includes("pesan") || hasil.includes("diskusi") || hasil.includes("chat")))) navigasiKe(9);
                        else if (hasil.includes("stop") || hasil.includes("berhenti")) {
                            stopBicara();
                            arahkanSingkat("Pembacaan dihentikan");
                        }
                        else {
                            const angka = hasil.match(/\d+/);
                            if (angka) navigasiKe(parseInt(angka[0]));
                        }
                    };
                    rec.onend = () => { rec.start(); };
                } catch (e) { console.error("Error recognition:", e); }
            }

            window.onload = () => {
                document.body.addEventListener("click", () => {}, { once: true });
                setTimeout(() => { 
                    bicara("Anda berada di Topik Pembelajaran. " + teksPanduanLengkap, () => { mulaiMendengar(); }); 
                }, 800);
            };

            const wavesurfers = {};
            function initWaveSurfer(containerId, audioUrl, isMe) {
                const ws = WaveSurfer.create({
                    container: '#' + containerId,
                    waveColor: isMe ? 'rgba(255, 255, 255, 0.4)' : '#cbd5e1',
                    progressColor: isMe ? '#ffffff' : '#2563eb',
                    height: 20, barWidth: 2, barGap: 2, barRadius: 2, cursorWidth: 0, url: audioUrl
                });
                wavesurfers[containerId] = ws;
                ws.on('finish', () => { document.getElementById('btn-' + containerId).innerHTML = '▶'; });
            }
            function togglePlay(containerId) {
                const ws = wavesurfers[containerId];
                const btn = document.getElementById('btn-' + containerId);
                if(ws) { ws.playPause(); btn.innerHTML = ws.isPlaying() ? '⏸' : '▶'; }
            }

            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('[id^="wave-"]').forEach(el => {
                    const url = el.getAttribute('data-audio');
                    const isMe = el.parentElement.classList.contains('border-white/30');
                    initWaveSurfer(el.id, url, isMe);
                });
            });

            /* =========================================
               SUBMIT CHAT (AJAX) - MENGALIR TANPA REFRESH
            ========================================= */
            const sessionId = {{ $session->id }};
            const chatForm = document.getElementById("chatForm");
            const chatContainer = document.getElementById("chatContainer");
            const actionUrl = chatForm.getAttribute("action");

            chatForm.addEventListener("submit", async function(e){
                e.preventDefault();
                
                if (!messageInput.value.trim() && (!imageInput || !imageInput.files.length) && (!voiceInput || !voiceInput.files.length)) return;

                const btnSubmit = document.getElementById('sendChatBtn'); 
                btnSubmit.disabled = true;
                document.getElementById('sendIcon').classList.add('hidden'); 
                document.getElementById('sendLoading').classList.remove('hidden');

                const formData = new FormData(this);

                try {
                    const response = await fetch(actionUrl, {
                        method: "POST",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            "Accept": "application/json"
                        },
                        body: formData
                    });

                    const responseData = await response.json();

                    if (response.ok && responseData.success) {
                        this.reset(); window.cancelImage();
                        
                        if(voiceInput) voiceInput.value = '';
                        messageInput.placeholder = "Sebutkan 5 untuk ketik suara..."; 
                        messageInput.disabled = false;
                        messageInput.classList.remove('font-bold', 'text-blue-600', 'bg-blue-100/50', 'rounded-xl', 'px-4');
                        messageInput.classList.add('bg-transparent', 'pl-1', 'md:pl-8');
                        
                        cancelVoiceBtn.classList.add('hidden');
                        if(uploadImageContainer) uploadImageContainer.classList.remove('hidden');
                        if(recordBtnContainer) recordBtnContainer.classList.remove('hidden');
                        
                        const recordBtn = document.getElementById('recordBtn');
                        if(recordBtn) {
                            recordBtn.classList.remove('hidden', 'text-white', 'bg-red-500', 'animate-pulse', 'border-red-600');
                            recordBtn.classList.add('text-slate-400');
                        }

                        // Render Chat Langsung
                        const d = responseData.diskusi;
                        const myRealName = "{{ Auth::guard('mahasiswa')->user()->nama ?? 'Mahasiswa' }}";
                        
                        // LOGIKA PENGAMBILAN FOTO DARI DATABASE UNTUK AJAX
                        const myDbFoto = "{{ Auth::guard('mahasiswa')->user()->foto_profil ?? Auth::guard('mahasiswa')->user()->foto ?? '' }}";
                        const fallbackAvatar = `https://ui-avatars.com/api/?name=${encodeURIComponent(myRealName)}&background=2563eb&color=fff`;
                        const myAvatar = myDbFoto ? `/storage/${myDbFoto}` : fallbackAvatar;
                        
                        const uniqueWaveId = 'wave-new-' + Date.now();
                        let mediaHtml = '';
                        
                        if (d.image) { 
                            mediaHtml += `<img src="${d.image}" class="mt-2 rounded-xl max-w-full border border-white/20 shadow">`; 
                        }
                        if (d.voice) { 
                            mediaHtml += `
                            <div class="mt-2 flex items-center gap-3 bg-white/20 p-2 rounded-xl backdrop-blur-sm border border-white/30 w-[200px] sm:w-[240px]">
                                <button type="button" onclick="togglePlay('${uniqueWaveId}')" id="btn-${uniqueWaveId}" class="w-7 h-7 sm:w-8 sm:h-8 shrink-0 flex items-center justify-center rounded-full bg-white text-blue-600 shadow hover:scale-105 transition-transform text-[10px] sm:text-xs">▶</button>
                                <div id="${uniqueWaveId}" class="flex-1" data-audio="${d.voice}"></div>
                            </div>`; 
                        }

                        let msgHtml = d.message ? `<p class="text-xs md:text-[13px] leading-relaxed font-medium whitespace-pre-wrap break-words">${d.message}</p>` : '';

                        const chatHtml = `
                        <div class="flex justify-end chat-bubble-new safe-fade-in">
                            <div class="flex gap-2 md:gap-3 items-end max-w-[90%] md:max-w-[70%] flex-row-reverse">
                                <img src="${myAvatar}" onerror="this.src='${fallbackAvatar}'" class="w-8 h-8 md:w-9 md:h-9 rounded-full shrink-0 shadow-sm object-cover border border-slate-100" />
                                <div class="flex flex-col items-end">
                                    <p class="text-[9px] md:text-[10px] font-bold mb-1 px-1 text-slate-400">Anda</p>
                                    <div class="p-3 md:p-4 rounded-2xl shadow-sm border bg-blue-600 text-white rounded-tr-none border-blue-700">
                                        ${msgHtml}
                                        ${mediaHtml}
                                    </div>
                                    <p class="text-[8px] md:text-[9px] mt-1.5 px-1 font-bold text-slate-400">${d.time}</p>
                                </div>
                            </div>
                        </div>`;

                        let emptyChatEl = document.getElementById("emptyChat");
                        if(emptyChatEl) emptyChatEl.remove();

                        chatContainer.insertAdjacentHTML("beforeend", chatHtml);
                        chatContainer.scrollTop = chatContainer.scrollHeight;

                        if(d.voice) { setTimeout(() => initWaveSurfer(uniqueWaveId, d.voice, true), 100); }
                        
                        arahkanSingkat("Pesan berhasil terkirim ke ruang diskusi");
                        
                    } else {
                        alert("Gagal mengirim: " + (responseData.error || "Terjadi kesalahan sistem."));
                        arahkanSingkat("Maaf, pesan gagal dikirim.");
                    }
                } catch (error) {
                    alert("Gagal terhubung ke server. Pastikan internet aktif.");
                    arahkanSingkat("Gagal terhubung ke server.");
                } finally {
                    btnSubmit.disabled = false; 
                    document.getElementById('sendLoading').classList.add('hidden'); 
                    document.getElementById('sendIcon').classList.remove('hidden');
                }
            });

            // Echo Realtime
            document.addEventListener("DOMContentLoaded", function () {
                function scrollBottom() { if(chatContainer) chatContainer.scrollTop = chatContainer.scrollHeight; }
                scrollBottom();

                if (!window.Echo) { return; }

                window.Echo.private(`session.${sessionId}`)
                    .listen('.discussion.created', (e) => {
                        const d = e.discussion;
                        const loggedInId = {{ Auth::guard('mahasiswa')->id() ?? 0 }};
                        const isMe = (d.sender_type === 'mahasiswa' || d.sender_type === 'App\\Models\\Mahasiswa') && (d.sender_id == loggedInId);
                        
                        if (isMe) return; 

                        const isDosen = (d.sender_type === 'dosen' || d.sender_type === 'App\\Models\\Dosen');
                        
                        const senderNameLengkap = d.sender_name ?? 'Seseorang';
                        const labelName = isDosen ? (d.sender_name ?? 'Dosen') : senderNameLengkap;
                        const avatarBg = isDosen ? 'f59e0b' : '64748b'; 
                        
                        // LOGIKA PENGAMBILAN FOTO UNTUK PESAN MASUK REALTIME
                        const fallbackAvatarIn = `https://ui-avatars.com/api/?name=${encodeURIComponent(senderNameLengkap)}&background=${avatarBg}&color=fff`;
                        const senderAvatarUrl = d.sender_avatar ? d.sender_avatar : fallbackAvatarIn;

                        const labelColor = isDosen ? 'text-orange-500' : 'text-slate-400';
                        const badgeHtml = isDosen ? `<span class="bg-orange-100 text-orange-600 px-1.5 py-0.5 rounded ml-1 text-[8px] uppercase">Dosen</span>` : '';

                        let media = '';
                        const uniqueWaveId = 'wave-new-' + Date.now();
                        
                        if (d.image) { media += `<img src="${d.image}" class="rounded-lg mt-2 max-w-xs shadow">`; }
                        if (d.voice) { 
                            media += `
                            <div class="mt-2 flex items-center gap-3 bg-white/20 p-2 rounded-xl backdrop-blur-sm border border-slate-300 w-[200px] sm:w-[240px]">
                                <button type="button" onclick="togglePlay('${uniqueWaveId}')" id="btn-${uniqueWaveId}" class="w-7 h-7 sm:w-8 sm:h-8 shrink-0 flex items-center justify-center rounded-full bg-blue-600 text-white shadow hover:scale-105 transition-transform text-[10px] sm:text-xs">▶</button>
                                <div id="${uniqueWaveId}" class="flex-1" data-audio="${d.voice}"></div>
                            </div>`; 
                        }

                        const timeStr = d.time || new Date().getHours().toString().padStart(2,"0") + ":" + new Date().getMinutes().toString().padStart(2,"0");

                        const html = `
                            <div class="flex justify-start chat-bubble-new safe-fade-in">
                                <div class="flex gap-2 md:gap-3 items-end max-w-[90%] md:max-w-[70%]">
                                    <img src="${senderAvatarUrl}" onerror="this.src='${fallbackAvatarIn}'" class="w-8 h-8 md:w-9 md:h-9 rounded-full shadow object-cover border border-slate-100" />
                                    <div class="flex flex-col items-start">
                                        <p class="text-[9px] md:text-[10px] font-bold mb-1 px-1 ${labelColor}">
                                            ${labelName} ${badgeHtml}
                                        </p>
                                        <div class="p-3 md:p-4 rounded-2xl shadow-sm border bg-slate-50 text-slate-800 rounded-tl-none border-slate-200">
                                            <p class="text-xs md:text-[13px] leading-relaxed font-medium whitespace-pre-wrap break-words">${d.message ?? ''}</p>
                                            ${media}
                                        </div>
                                        <p class="text-[8px] md:text-[9px] mt-1.5 px-1 text-slate-400 font-bold">${timeStr}</p>
                                    </div>
                                </div>
                            </div>
                        `;

                        let emptyChatEl = document.getElementById("emptyChat");
                        if(emptyChatEl) emptyChatEl.remove();

                        chatContainer.insertAdjacentHTML("beforeend", html);
                        scrollBottom();

                        if(d.voice) { setTimeout(() => initWaveSurfer(uniqueWaveId, d.voice, false), 100); }
                    });
            });
        </script>
    </body>
</html>