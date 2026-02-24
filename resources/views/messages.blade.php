<!DOCTYPE html>
@php
    $activeDosenId = $dosen ?? null;
    $messages = $chatMessages ?? collect();
    $listPercakapan = $conversations ?? []; 
    
    $mahasiswaId = Auth::guard('mahasiswa')->id() ?? 1; 
    $unreadCount = \App\Models\Message::where('receiver_type', 'mahasiswa')
                    ->where('receiver_id', $mahasiswaId)
                    ->where('is_read', 0)
                    ->count();

    // DEFINISI NAMA DOSEN AKTIF
    $displayName = 'Dosen';
    if($activeDosenId) {
        $currentDosen = \App\Models\Dosen::find($activeDosenId);
        $displayName = $currentDosen->nama ?? 'Dosen';
    }

    // VARIABEL UNTUK VOICE ASSISTANT (AGAR TIDAK UNDEFINED)
    $lastMsgVA = $messages->last();
    $hasVoice = ($lastMsgVA && $lastMsgVA->voice_path) ? 'true' : 'false';
    $lastWaveId = ($lastMsgVA && $lastMsgVA->voice_path) ? 'wave-' . $lastMsgVA->id : '';
    $lastMsgTextVA = $lastMsgVA ? ($lastMsgVA->body ?: ($lastMsgVA->voice_path ? 'Pesan suara' : 'Mengirim gambar')) : 'Belum ada pesan';
    $senderNameVA = ($lastMsgVA && $lastMsgVA->sender_type == 'dosen') ? $displayName : 'Anda';
@endphp
<html lang="id" class="h-full">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Pesan | LMS Inklusi UMMI</title>

        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
        <script src="https://unpkg.com/wavesurfer.js@7"></script>

        <style>
            .scrollbar-hide::-webkit-scrollbar { display: none; }
            .custom-scrollbar::-webkit-scrollbar { width: 4px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
            @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
            .safe-fade-in { animation: fadeIn 0.4s ease-out forwards; opacity: 0; }
            @keyframes wave-bounce { 0%, 100% { height: 4px; } 50% { height: 16px; } }
            .recording-wave .bar { width: 3px; background-color: #ef4444; border-radius: 99px; animation: wave-bounce 1s ease-in-out infinite; }
            .recording-wave .bar:nth-child(1) { animation-delay: 0.0s; height: 8px;}
            .recording-wave .bar:nth-child(2) { animation-delay: 0.2s; height: 12px;}
            .recording-wave .bar:nth-child(3) { animation-delay: 0.4s; height: 16px;}
            .recording-wave .bar:nth-child(4) { animation-delay: 0.1s; height: 10px;}
            .recording-wave .bar:nth-child(5) { animation-delay: 0.3s; height: 14px;}
            .recording-wave .bar:nth-child(6) { animation-delay: 0.5s; height: 8px;}
            
            /* Animasi indikator saat Voice to Text aktif */
            @keyframes pulse-border { 0% { border-color: #3b82f6; box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4); } 70% { border-color: #60a5fa; box-shadow: 0 0 0 6px rgba(59, 130, 246, 0); } 100% { border-color: #3b82f6; box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); } }
            .dictating-active { animation: pulse-border 1.5s infinite; background-color: #eff6ff !important; }
            .confirming-active { background-color: #fef3c7 !important; border-color: #f59e0b !important; }
        </style>
    </head>
    <body class="m-0 font-['Plus_Jakarta_Sans'] bg-slate-50 text-slate-800 antialiased h-screen flex overflow-hidden">
        <div id="mobileBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden transition-opacity"></div>

        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-80 bg-white border-r border-slate-200 flex flex-col h-full transform -translate-x-full lg:translate-x-0 transition-transform duration-300 shrink-0 shadow-2xl lg:shadow-none">
            <div class="p-8 border-b border-slate-100 flex items-center gap-4 shrink-0">
                <img src="{{ asset('images/logo-ummi.png') }}" class="w-10 h-10 object-contain" alt="Logo UMMI" onerror="this.src = 'https://via.placeholder.com/40'" />
                <div>
                    <h1 class="text-lg font-black text-slate-900 tracking-tight leading-none">LMS Inklusi</h1>
                    <p class="text-[9px] font-bold text-blue-600 uppercase tracking-widest mt-1">Portal Mahasiswa</p>
                </div>
                <button onclick="toggleSidebar()" class="lg:hidden ml-auto text-slate-400 hover:text-slate-600 bg-slate-50 p-2 rounded-lg cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <nav class="flex-1 p-6 space-y-3 overflow-y-auto custom-scrollbar">
                <a href="{{ url('/dashboard') }}" onclick="navigasiKe(5)" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7m9 9l-2-2m0 0l-7-7m7 7v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span>Beranda</span>
                    </div>
                    <span class="text-[10px] bg-slate-900 text-white px-2 py-1 rounded-lg font-black shadow-sm">5</span>
                </a>

                <a href="{{ url('/mahasiswa/profile') }}" onclick="navigasiKe(6)" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>Profil Saya</span>
                    </div>
                    <span class="text-[10px] bg-slate-900 text-white px-2 py-1 rounded-lg font-black shadow-sm">6</span>
                </a>

                <a href="{{ url('/pemberitahuan') }}" onclick="navigasiKe(7)" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span>Pemberitahuan</span>
                    </div>
                    <span class="text-[10px] bg-slate-900 text-white px-2 py-1 rounded-lg font-black shadow-sm">7</span>
                </a>

                <a href="{{ url('/pesan') }}" onclick="navigasiKe(8)" class="flex items-center justify-between p-4 bg-blue-50 text-blue-700 rounded-2xl font-bold transition-all shadow-sm border border-blue-100">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        <span>Pesan</span>
                    </div>
                    <span class="text-[10px] bg-slate-900 text-white px-2 py-1 rounded-lg font-black shadow-sm">8</span>
                </a>

                <a href="{{ url('/bantuan') }}" onclick="navigasiKe(9)" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Bantuan</span>
                    </div>
                    <span class="text-[10px] bg-slate-900 text-white px-2 py-1 rounded-lg font-black shadow-sm">9</span>
                </a>
            </nav>

            <div class="p-6 border-t border-slate-100 shrink-0">
                <button onclick="navigasiKe(0)" class="w-full p-4 flex items-center justify-between text-red-600 font-bold bg-red-50 rounded-2xl hover:bg-red-100 transition-all border border-red-100 cursor-pointer">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Keluar</span>
                    </div>
                    <span class="text-[10px] bg-slate-900 text-white px-2 py-1 rounded-lg font-black shadow-sm">0</span>
                </button>
            </div>
        </aside>

        <main class="flex-1 flex flex-col h-full relative min-w-0 bg-[#f8fafc] overflow-hidden">
            <header class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-4 md:px-8 py-4 sm:py-6 shrink-0 z-20">
                <div class="max-w-7xl mx-auto flex items-center justify-between h-10 sm:h-14">
                    <div class="flex items-center gap-3 sm:gap-4">
                        <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-800 rounded-lg transition-all focus:outline-none cursor-pointer">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                        <div>
                            <h2 class="text-lg sm:text-2xl font-black text-slate-900 tracking-tight leading-none">Pesan Masuk</h2>
                            <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 block">Komunikasi Akademik</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-3 pr-4 border-r border-slate-200">
                            <button onclick="navigasiKe(7)" class="relative p-2 text-slate-400 hover:text-blue-600 transition-all cursor-pointer">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                @if($unreadCount > 0)<span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>@endif
                            </button>
                            <button onclick="navigasiKe(9)" class="p-2 text-slate-400 hover:text-blue-600 transition-all cursor-pointer relative">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </button>
                        </div>
                        <div class="hidden md:flex items-center gap-3 pl-4">
                            <div class="flex items-center gap-[2px] h-4 w-10 justify-center">
                                <div class="wave-bar w-[2px] bg-blue-500 rounded-full h-1 transition-all"></div>
                                <div class="wave-bar w-[2px] bg-blue-400 rounded-full h-1 transition-all"></div>
                                <div class="wave-bar w-[2px] bg-blue-600 rounded-full h-1 transition-all"></div>
                            </div>
                            <span id="status-desc" class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Siap</span>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex-1 flex overflow-hidden max-w-7xl mx-auto w-full">
                <div data-aos="fade-right" data-aos-duration="600" class="w-full md:w-80 bg-white border-r border-l border-slate-200 flex-col overflow-y-auto z-10 shrink-0 safe-fade-in {{ $activeDosenId ? 'hidden md:flex' : 'flex' }}">
                    <div class="p-4 border-b border-slate-100 sticky top-0 bg-white/90 backdrop-blur-sm z-10">
                        <input type="text" id="searchInput" placeholder="Cari Dosen..." class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-slate-400 pl-10" />
                        <svg class="w-4 h-4 absolute left-7 top-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    
                    <div id="contactList" class="p-2 space-y-1 overflow-y-auto">
                        @php $voiceIdCounter = 15; @endphp
                        @forelse($listPercakapan as $d_id => $msgs)
                            @php
                                $last = $msgs->last();
                                $dsn = \App\Models\Dosen::find($d_id);
                                $isUnread = $last->sender_type == 'dosen' && $last->is_read == 0;
                            @endphp
                            @if($dsn)
                            <a href="{{ url('/messages/'.$d_id) }}" data-voice-id="{{ $voiceIdCounter }}" class="block safe-fade-in contact-item relative mt-2">
                                <div class="p-3 {{ $activeDosenId == $d_id ? 'bg-blue-50 border border-blue-100 shadow-sm' : 'hover:bg-slate-50 border border-transparent hover:border-slate-100' }} rounded-xl flex gap-3 cursor-pointer transition-all relative">
                                    @if($isUnread) <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 rounded-full animate-pulse border-2 border-white z-10"></span> @endif
                                    
                                    <div class="absolute -left-1 -top-1 bg-slate-900 text-white text-[10px] font-black px-1.5 py-0.5 rounded-md shadow-sm z-10">{{ $voiceIdCounter }}</div>

                                    <div class="w-10 h-10 rounded-xl bg-slate-200 shrink-0 overflow-hidden border border-slate-100 flex items-center justify-center ml-1">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($dsn->nama) }}&background=0D8ABC&color=fff" class="w-full h-full object-cover" />
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <div class="flex justify-between items-center mb-0.5">
                                            <h4 class="font-bold {{ $isUnread ? 'text-slate-900' : 'text-slate-700' }} text-xs truncate">{{ $dsn->nama }}</h4>
                                            <span class="text-[9px] font-bold {{ $isUnread ? 'text-blue-600' : 'text-slate-400' }} shrink-0 ml-2">{{ $last ? $last->created_at->format('H:i') : '' }}</span>
                                        </div>
                                        <p class="text-[10px] {{ $isUnread ? 'text-slate-800 font-bold' : 'text-slate-500 font-medium' }} truncate">
                                            {{ $last && $last->body ? $last->body : ($last && $last->voice_path ? '[Voice Note]' : ($last && $last->image_path ? '[Gambar]' : 'Belum ada pesan')) }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                            @php $voiceIdCounter++; @endphp
                            @endif
                        @empty
                            <div class="p-6 text-center"><p class="text-xs text-slate-400 font-bold">Belum ada riwayat obrolan.</p></div>
                        @endforelse
                    </div>
                </div>

                <div class="flex-1 flex-col bg-[#f0f4f8] relative safe-fade-in {{ $activeDosenId ? 'flex' : 'hidden md:flex' }}">
                    @if($activeDosenId)
                        <div class="p-3 sm:p-4 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between sticky top-0 z-10 shrink-0 shadow-sm">
                            <div class="flex items-center gap-3" data-aos="fade-down" data-aos-duration="500">
                                <a href="{{ url('/pesan') }}" class="md:hidden flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all border border-slate-200 mr-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                </a>
                                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-blue-100 overflow-hidden border border-blue-200 shrink-0">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($displayName) }}&background=0D8ABC&color=fff" class="w-full h-full object-cover" />
                                </div>
                                <div>
                                    <h4 class="font-black text-slate-900 text-xs sm:text-sm leading-tight max-w-[150px] sm:max-w-xs truncate">{{ $displayName }}</h4>
                                    <span class="inline-flex items-center text-[9px] font-bold text-emerald-600 uppercase tracking-widest mt-0.5">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5 animate-pulse"></span> Online
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex-1 p-4 sm:p-6 overflow-y-auto space-y-6 custom-scrollbar bg-white" id="chatBox">
                            @forelse($messages as $msg)
                                @php $isMe = $msg->sender_type === 'mahasiswa'; @endphp
                                <div id="msg-{{ $msg->id }}" class="flex {{ $isMe ? 'justify-end' : 'justify-start' }} safe-fade-in">
                                    <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }} max-w-[85%] md:max-w-[70%]">
                                        <div class="p-3 sm:p-4 rounded-2xl shadow-sm border {{ $isMe ? 'bg-blue-600 text-white rounded-tr-none border-blue-700' : 'bg-slate-50 text-slate-800 rounded-tl-none border-slate-200' }}">
                                            @if($msg->body)<p class="text-xs sm:text-[13px] leading-relaxed font-medium whitespace-pre-wrap break-words">{{ $msg->body }}</p>@endif
                                            @if($msg->image_path)<img src="{{ asset('storage/'.$msg->image_path) }}" class="mt-2 rounded-xl max-w-full border {{ $isMe ? 'border-white/20' : 'border-slate-200' }}">@endif
                                            @if(isset($msg->voice_path) && $msg->voice_path)
                                                <div class="mt-2 flex items-center gap-3 bg-white/20 p-2 rounded-xl backdrop-blur-sm border {{ $isMe ? 'border-white/30' : 'border-slate-300 bg-white' }} w-[200px] sm:w-[240px]">
                                                    <button type="button" onclick="togglePlay('wave-{{ $msg->id }}')" id="btn-wave-{{ $msg->id }}" class="w-7 h-7 sm:w-8 sm:h-8 shrink-0 flex items-center justify-center rounded-full {{ $isMe ? 'bg-white text-blue-600' : 'bg-blue-600 text-white' }} shadow hover:scale-105 transition-transform text-[10px] sm:text-xs">▶</button>
                                                    <div id="wave-{{ $msg->id }}" class="flex-1" data-audio="{{ asset('storage/' . $msg->voice_path) }}"></div>
                                                </div>
                                            @endif
                                        </div>
                                        <span class="text-[9px] font-bold text-slate-400 mt-1 {{ $isMe ? 'mr-1' : 'ml-1' }}">{{ $msg->created_at->format('H:i') }}</span>
                                    </div>
                                </div>
                            @empty
                                <div id="emptyChat" class="h-full flex flex-col items-center justify-center text-center opacity-70">
                                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-blue-50 text-blue-400 rounded-full flex items-center justify-center mb-4 border border-blue-100">
                                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    </div>
                                    <p class="text-xs sm:text-sm text-slate-600 font-bold">Belum ada percakapan.</p>
                                    <p class="text-[9px] sm:text-[10px] text-slate-400 uppercase tracking-widest mt-1">Sapa Dosen Anda!</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="p-3 sm:p-4 border-t border-slate-100 bg-white shrink-0 shadow-[0_-4px_10px_rgba(0,0,0,0.02)] relative z-20">
                            <div id="imagePreviewContainer" class="hidden mb-3 relative p-2 bg-slate-50 border border-slate-200 rounded-2xl w-fit">
                                <img id="imagePreviewElement" src="" class="h-20 sm:h-24 w-auto object-cover rounded-xl shadow-sm border border-slate-200">
                                <button type="button" onclick="cancelImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center font-bold text-xs shadow-lg hover:bg-red-600 hover:scale-110 transition-transform">✕</button>
                            </div>

                            <form id="chatForm" method="POST" action="{{ url('/messages/send') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $activeDosenId }}">
                                <input type="file" name="image" id="imageInput" accept="image/*" class="hidden" onchange="previewImage(this)">
                                <input type="file" name="voice" id="voiceInput" accept="audio/webm" class="hidden">

                                <div class="flex items-center gap-2 sm:gap-3">
                                    
                                    {{-- TEXT MESSAGE (1 - Voice to Text) --}}
                                    <div id="normalInputWrapper" class="flex-1 min-w-0 relative flex items-center bg-slate-50 p-2 sm:p-3 rounded-[1.25rem] sm:rounded-2xl border border-slate-200 transition-all">
                                        <div class="absolute left-2 text-[10px] font-black text-white bg-slate-900 px-1.5 py-0.5 rounded-md shadow-sm">1</div>
                                        <input type="text" name="body" id="messageInput" placeholder="Sebutkan 1 untuk ketik suara..." autocomplete="off" class="w-full bg-transparent text-xs sm:text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none transition-all py-1.5 pl-8" />
                                        <button type="button" id="cancelVoiceToTextBtn" onclick="batalKetikSuara()" class="hidden absolute right-1 sm:right-2 text-[10px] font-black uppercase text-white bg-red-500 hover:bg-red-600 px-2.5 py-1.5 rounded-lg shadow-sm transition-all cursor-pointer">Batal ✕</button>
                                    </div>

                                    {{-- BUTTON IMAGE (2) --}}
                                    <div class="relative shrink-0">
                                        <button type="button" id="btnUploadImage" onclick="document.getElementById('imageInput').click()" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-white transition-all cursor-pointer shadow-sm border border-transparent hover:border-blue-100">
                                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </button>
                                        <span class="absolute -top-1.5 -right-1.5 bg-slate-900 text-white text-[8px] font-black px-1.5 py-0.5 rounded-md shadow-sm border border-white">2</span>
                                    </div>

                                    {{-- RECORDING STATE UI (Tersembunyi) --}}
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

                                    {{-- BUTTON VOICE NOTE (3) --}}
                                    <div class="relative shrink-0">
                                        <button type="button" id="recordBtn" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all cursor-pointer border border-transparent hover:border-red-100 shadow-sm">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"></path></svg>
                                        </button>
                                        <span class="absolute -top-1.5 -right-1.5 bg-slate-900 text-white text-[8px] font-black px-1.5 py-0.5 rounded-md shadow-sm border border-white">3</span>
                                    </div>

                                    {{-- BUTTON SEND (4) --}}
                                    <div class="relative shrink-0">
                                        <button type="submit" id="sendChatBtn" class="w-10 h-9 sm:w-12 sm:h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-transform transform hover:scale-105 active:scale-95 shadow-md shadow-blue-200 cursor-pointer">
                                            <span id="sendIcon"><svg class="w-4 h-4 sm:w-5 sm:h-5 transform rotate-90 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg></span>
                                            <span id="sendLoading" class="hidden"><svg class="w-4 h-4 sm:w-5 sm:h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg></span>
                                        </button>
                                        <span class="absolute -top-1.5 -right-1.5 bg-slate-900 text-white text-[8px] font-black px-1.5 py-0.5 rounded-md shadow-sm border border-white z-10">4</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="flex-1 flex flex-col items-center justify-center text-center p-6 safe-fade-in">
                            <div class="w-20 h-20 bg-blue-50 text-blue-300 rounded-full flex items-center justify-center mb-4"><svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg></div>
                            <h3 class="text-xl font-black text-slate-700">Pesan Inklusi</h3>
                            <p class="text-sm text-slate-500 mt-2 max-w-xs">Pilih kontak Dosen atau ucapkan "Cari [Nama]" untuk memulai obrolan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

        <script>
            // DATA PHP KE JAVASCRIPT
            const listDosenVA = [
                @php $vId = 15; @endphp
                @foreach($listPercakapan as $d_id => $msgs)
                    @php $dsnName = \App\Models\Dosen::find($d_id)->nama ?? 'Dosen'; @endphp
                    { id: {{ $d_id }}, nama: "{{ $dsnName }}", voiceId: {{ $vId }} },
                    @php $vId++; @endphp
                @endforeach
            ];

            const isActiveChat = {{ $activeDosenId ? 'true' : 'false' }};
            const currentDosenName = "{{ $displayName ?? '' }}";
            const mahasiswaId = {{ $mahasiswaId }};
            
            const lastMessageText = "{{ addslashes($lastMsgTextVA) }}";
            const lastMessageSender = "{{ $senderNameVA }}";

            AOS.init({ once: true, easing: "ease-out-cubic" });

            function toggleSidebar() {
                document.getElementById("sidebar").classList.toggle("-translate-x-full");
                document.getElementById("mobileBackdrop").classList.toggle("hidden");
            }

            // ==========================================
            // LOGIKA AUDIO WAVESURFER
            // ==========================================
            let isAutoPlaying = false; // Flag untuk mencegah Voice Assistant ngomong saat audio putar otomatis

            const wavesurfers = {};
            function initWaveSurfer(containerId, audioUrl, isMe) {
                const ws = WaveSurfer.create({
                    container: '#' + containerId,
                    waveColor: isMe ? 'rgba(255, 255, 255, 0.4)' : '#cbd5e1',
                    progressColor: isMe ? '#ffffff' : '#2563eb',
                    height: 20, barWidth: 2, barGap: 2, barRadius: 2, cursorWidth: 0, url: audioUrl
                });
                wavesurfers[containerId] = ws;
                ws.on('finish', () => { 
                    document.getElementById('btn-' + containerId).innerHTML = '▶'; 
                    // Jika selesai autoplay, VA tanya mau dibalas apa
                    if(isAutoPlaying) {
                        isAutoPlaying = false;
                        setTimeout(() => { bicara("Audio selesai. Apakah ingin membalas? Sebutkan satu untuk ketik, atau tiga untuk suara.", () => { mulaiMendengar(); }); }, 800);
                    }
                });
            }
            function togglePlay(containerId) {
                const ws = wavesurfers[containerId];
                const btn = document.getElementById('btn-' + containerId);
                if(ws) { ws.playPause(); btn.innerHTML = ws.isPlaying() ? '⏸' : '▶'; }
            }

            document.addEventListener("DOMContentLoaded", function () {
                let chatBox = document.getElementById("chatBox");
                function scrollBottom(){ if(chatBox) chatBox.scrollTop = chatBox.scrollHeight; }
                scrollBottom();

                document.querySelectorAll('[id^="wave-"]').forEach(el => {
                    initWaveSurfer(el.id, el.getAttribute('data-audio'), el.parentElement.classList.contains('border-white/30'));
                });

                // ==========================================
                // REAL-TIME (LARAVEL ECHO)
                // ==========================================
                if(window.Echo && isActiveChat) {
                    window.Echo.private(`chat.mahasiswa.${mahasiswaId}`)
                        .listen('.message.sent', (e) => {
                            let mediaHtml = '';
                            if (e.message.image_path) mediaHtml += `<img src="/storage/${e.message.image_path}" class="mt-2 rounded-lg max-w-xs">`;
                            
                            const uniqueWaveId = 'wave-incoming-' + Date.now();
                            if (e.message.voice_path) {
                                mediaHtml += `<div class="mt-2 flex items-center gap-3 bg-white/20 p-2 rounded-xl backdrop-blur-sm border border-slate-300 bg-white w-[200px] sm:w-[240px]"><button type="button" onclick="togglePlay('${uniqueWaveId}')" id="btn-${uniqueWaveId}" class="w-7 h-7 shrink-0 flex items-center justify-center rounded-full bg-blue-600 text-white shadow hover:scale-105 transition-transform text-xs">▶</button><div id="${uniqueWaveId}" class="flex-1" data-audio="/storage/${e.message.voice_path}"></div></div>`;
                            }
                            
                            let msgHtml = e.message.body ? `<p class="text-sm leading-relaxed font-medium whitespace-pre-wrap break-words">${e.message.body}</p>` : '';
                            
                            let html = `<div class="flex flex-col items-start max-w-[80%] safe-fade-in"><div class="bg-white text-slate-700 rounded-2xl rounded-tl-none border border-slate-100 shadow-sm p-4">${msgHtml}${mediaHtml}</div><span class="text-[9px] font-bold text-slate-400 mt-1 ml-1">${e.message.time}</span></div>`;

                            let emptyNotice = document.getElementById('emptyChat');
                            if(emptyNotice) emptyNotice.remove();
                            chatBox.insertAdjacentHTML('beforeend', html);
                            scrollBottom();

                            // JIKA PESAN BARU ADALAH VOICE NOTE, LANGSUNG PUTAR OTOMATIS
                            if (e.message.voice_path) {
                                setTimeout(() => {
                                    initWaveSurfer(uniqueWaveId, `/storage/${e.message.voice_path}`, false);
                                    wavesurfers[uniqueWaveId].on('ready', function () {
                                        isAutoPlaying = true;
                                        bicara(`Ada pesan suara baru.`, () => {
                                            wavesurfers[uniqueWaveId].play();
                                            document.getElementById('btn-' + uniqueWaveId).innerHTML = '⏸';
                                        });
                                    });
                                }, 100);
                            }
                        });
                }

                // ==========================================
                // LOGIKA PENCARIAN DOSEN
                // ==========================================
                let searchInput = document.getElementById("searchInput");
                let contactList = document.getElementById("contactList");
                let originalContactHTML = contactList ? contactList.innerHTML : '';
                
                window.lakukanPencarian = function(keyword) {
                    if(!searchInput || !contactList) return;
                    if(keyword.length === 0) { contactList.innerHTML = originalContactHTML; return; }
                    
                    contactList.innerHTML = `<div class="p-6 text-center"><p class="text-xs text-slate-400 font-bold animate-pulse">Mencari...</p></div>`;
                    
                    fetch(`{{ url('/messages/search') }}?q=${encodeURIComponent(keyword)}`)
                    .then(res => res.json())
                    .then(data => {
                        if(data.length === 0) { 
                            contactList.innerHTML = `<div class="p-6 text-center"><p class="text-xs text-slate-400 font-bold">Tidak ditemukan.</p></div>`; 
                            bicara(`Tidak ditemukan dosen bernama ${keyword}.`); return; 
                        }
                        
                        let html = ''; let searchVoiceId = 30; // Hasil cari mulai dari 30
                        data.forEach(dsn => {
                            html += `
                            <a href="{{ url('/messages') }}/${dsn.id}" data-voice-id="${searchVoiceId}" class="block safe-fade-in relative mt-2">
                                <div class="p-3 hover:bg-slate-50 border border-transparent hover:border-slate-100 rounded-xl flex gap-3 cursor-pointer transition-all">
                                    <div class="absolute -left-1 -top-1 bg-slate-900 text-white text-[10px] font-black px-1.5 py-0.5 rounded-md shadow-sm z-10">${searchVoiceId}</div>
                                    <div class="w-10 h-10 rounded-xl bg-slate-200 shrink-0 overflow-hidden border border-slate-100 flex items-center justify-center ml-1">
                                        <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(dsn.nama)}&background=0D8ABC&color=fff" class="w-full h-full object-cover" />
                                    </div>
                                    <div class="flex-1 flex flex-col justify-center overflow-hidden">
                                        <h4 class="font-bold text-slate-900 text-xs truncate">${dsn.nama}</h4>
                                        <p class="text-[10px] text-slate-500 truncate font-medium">Sebutkan ${searchVoiceId} untuk chat</p>
                                    </div>
                                </div>
                            </a>`;
                            searchVoiceId++;
                        });
                        contactList.innerHTML = html;
                        bicara(`Ditemukan ${data.length} dosen. Sebutkan nomor di layar untuk obrolan.`);
                    });
                };

                if(searchInput) searchInput.addEventListener("input", function() { window.lakukanPencarian(this.value.trim()); });

                // ==========================================
                // INPUT GAMBAR & VOICE NOTE
                // ==========================================
                let imageInput = document.getElementById("imageInput");
                let messageInput = document.getElementById("messageInput");
                let voiceInput = document.getElementById("voiceInput");
                const recordBtn = document.getElementById('recordBtn');
                const btnUploadImage = document.getElementById('btnUploadImage');
                const normalInputWrapper = document.getElementById('normalInputWrapper');
                const recordingWrapper = document.getElementById('recordingWrapper');

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
                                
                                normalInputWrapper.classList.add('hidden'); btnUploadImage.classList.add('hidden');
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
                                
                                messageInput.placeholder = "▶ ılıılı Suara siap dikirim...";
                                messageInput.disabled = true; 
                                messageInput.classList.add('font-bold', 'text-blue-600');
                            };
                            mediaRecorder.stop(); clearInterval(recordInterval);
                        }
                    });

                    document.getElementById('cancelRecordBtn').addEventListener('click', () => {
                        if(mediaRecorder && mediaRecorder.state !== "inactive") mediaRecorder.stop();
                        clearInterval(recordInterval); audioChunks = []; voiceInput.value = '';
                        recordingWrapper.classList.add('hidden'); recordingWrapper.classList.remove('flex');
                        normalInputWrapper.classList.remove('hidden'); btnUploadImage.classList.remove('hidden');
                        recordBtn.classList.remove('text-white', 'bg-red-500', 'animate-pulse', 'border-red-600');
                        recordBtn.classList.add('text-slate-400');
                    });
                }

                // ==========================================
                // SUBMIT AJAX
                // ==========================================
                let form = document.getElementById("chatForm");
                if(form) {
                    form.addEventListener("submit", async function(e){
                        e.preventDefault();
                        if (!messageInput.value.trim() && (!imageInput || !imageInput.files.length) && (!voiceInput || !voiceInput.files.length)) return;
                        
                        const btnSubmit = document.getElementById('sendChatBtn'); btnSubmit.disabled = true;
                        document.getElementById('sendIcon').classList.add('hidden'); document.getElementById('sendLoading').classList.remove('hidden');

                        try {
                            const actionUrl = this.getAttribute('action');
                            const response = await fetch(actionUrl, { method: "POST", body: new FormData(this), headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
                            const data = await response.json();
                            
                            if(data.success){
                                this.reset(); cancelImage();
                                if(voiceInput) voiceInput.value = '';
                                messageInput.placeholder = "Sebutkan 1 untuk ketik suara..."; messageInput.disabled = false;
                                messageInput.classList.remove('font-bold', 'text-blue-600');
                                btnUploadImage.classList.remove('hidden');
                                recordBtn.classList.remove('text-white', 'bg-red-500', 'animate-pulse', 'border-red-600');
                                recordBtn.classList.add('text-slate-400');
                                
                                let mediaHtml = '';
                                if (data.message.image_path) mediaHtml += `<img src="/storage/${data.message.image_path}" class="mt-2 rounded-lg max-w-xs">`;
                                const uniqueWaveId = 'wave-new-' + Date.now();
                                if (data.message.voice_path) {
                                    mediaHtml += `<div class="mt-2 flex items-center gap-3 bg-white/20 p-2 rounded-xl backdrop-blur-sm border border-white/30 w-[200px] sm:w-[240px]"><button type="button" onclick="togglePlay('${uniqueWaveId}')" id="btn-${uniqueWaveId}" class="w-7 h-7 shrink-0 flex items-center justify-center rounded-full bg-white text-blue-600 shadow hover:scale-105 transition-transform text-xs">▶</button><div id="${uniqueWaveId}" class="flex-1" data-audio="/storage/${data.message.voice_path}"></div></div>`;
                                }
                                let msgHtml = data.message.body ? `<p class="text-sm leading-relaxed font-medium whitespace-pre-wrap break-words">${data.message.body}</p>` : '';
                                
                                let html = `<div class="flex flex-col items-end ml-auto max-w-[80%] safe-fade-in"><div class="bg-blue-600 text-white rounded-2xl rounded-tr-none shadow-md shadow-blue-100 p-4">${msgHtml}${mediaHtml}</div><span class="text-[9px] font-bold text-slate-400 mt-1 mr-1">${data.message.time}</span></div>`;

                                let emptyNotice = document.getElementById('emptyChat'); if(emptyNotice) emptyNotice.remove();
                                chatBox.insertAdjacentHTML('beforeend', html); scrollBottom();
                                if(data.message.voice_path) setTimeout(() => initWaveSurfer(uniqueWaveId, `/storage/${data.message.voice_path}`, true), 100);
                                
                                // ARAHAN SETELAH KIRIM
                                bicara("Pesan berhasil terkirim. Apa selanjutnya? Sebutkan satu untuk membalas lagi, atau lima untuk kembali ke beranda.");
                            } else { alert("Gagal mengirim pesan."); }
                        } catch (err) { alert("Terjadi kesalahan sistem."); } finally {
                            btnSubmit.disabled = false; document.getElementById('sendLoading').classList.add('hidden'); document.getElementById('sendIcon').classList.remove('hidden');
                        }
                    });
                }
            });

            // ==========================================
            // LOGIKA VOICE ASSISTANT CERDAS & KONFIRMASI KETIK
            // ==========================================
            const statusDesc = document.getElementById("status-desc");
            const waveBars = document.querySelectorAll(".wave-bar");
            const synth = window.speechSynthesis;
            const SpeechRec = window.webkitSpeechRecognition || window.SpeechRecognition;
            let rec = null;
            
            let modeKetikSuara = false; 
            let menungguKonfirmasiKirim = false;
            let jedaKetikTimer = null;

            if (SpeechRec) { rec = new SpeechRec(); rec.lang = "id-ID"; rec.continuous = true; }

            function setWave(active) {
                if (waveBars.length > 0) waveBars.forEach((bar) => { bar.style.height = active ? `${Math.floor(Math.random() * 12) + 4}px` : "4px"; });
            }

            let interval;
            function bicara(teks, callback) {
                synth.cancel();
                const utter = new SpeechSynthesisUtterance(teks); utter.lang = "id-ID";
                utter.rate = localStorage.getItem("speechRate") ? parseFloat(localStorage.getItem("speechRate")) : 1.0;

                utter.onstart = () => { if (statusDesc) statusDesc.innerText = "BERBICARA..."; interval = setInterval(() => setWave(true), 150); };
                utter.onend = () => { if (statusDesc) statusDesc.innerText = "MENDENGARKAN..."; clearInterval(interval); setWave(false); if (callback) callback(); };
                synth.speak(utter);
            }

            window.batalKetikSuara = function() {
                modeKetikSuara = false;
                menungguKonfirmasiKirim = false;
                clearTimeout(jedaKetikTimer);
                document.getElementById('normalInputWrapper').classList.remove('dictating-active', 'confirming-active');
                document.getElementById('cancelVoiceToTextBtn').classList.add('hidden');
                document.getElementById("messageInput").value = "";
                document.getElementById("messageInput").placeholder = "Sebutkan 1 untuk ketik suara...";
            }

            function navigasiKe(nomor) {
                let tujuan = ""; let teks = "";

                if (nomor === 5) { tujuan = "{{ url('/dashboard') }}"; teks = "Kembali ke Beranda."; }
                else if (nomor === 6) { tujuan = "{{ url('/mahasiswa/profile') }}"; teks = "Membuka Profil Saya."; }
                else if (nomor === 7) { tujuan = "{{ url('/pemberitahuan') }}"; teks = "Membuka Pemberitahuan."; }
                else if (nomor === 8) { teks = "Halaman Pesan."; }
                else if (nomor === 9) { tujuan = "{{ url('/bantuan') }}"; teks = "Membuka Bantuan."; }
                else if (nomor === 0) { tujuan = "{{ url('/logout') }}"; teks = "Keluar."; }
                
                // Fitur Chat
                else if (nomor === 1) {
                    modeKetikSuara = true;
                    menungguKonfirmasiKirim = false;
                    document.getElementById('normalInputWrapper').classList.add('dictating-active');
                    document.getElementById('normalInputWrapper').classList.remove('confirming-active');
                    document.getElementById('cancelVoiceToTextBtn').classList.remove('hidden');
                    document.getElementById("messageInput").value = "";
                    document.getElementById("messageInput").placeholder = "Mendengarkan teks...";
                    teks = "Silakan berbicara.";
                } else if (nomor === 2) {
                    teks = "Membuka galeri. Pilih gambar, lalu sebutkan empat untuk mengirim.";
                    bicara(teks, () => { document.getElementById('imageInput').click(); });
                    return;
                } else if (nomor === 3) {
                    const recordBtn = document.getElementById('recordBtn');
                    if (!recordBtn.classList.contains('text-white')) {
                        teks = "Merekam suara. Silakan bicara setelah suara bip. Untuk berhenti, sebutkan kata Selesai.";
                        bicara(teks, () => { recordBtn.click(); });
                        return;
                    } else {
                        recordBtn.click(); teks = "Suara disimpan. Sebutkan empat untuk mengirim.";
                    }
                } else if (nomor === 4) {
                    modeKetikSuara = false; 
                    menungguKonfirmasiKirim = false;
                    clearTimeout(jedaKetikTimer);
                    document.getElementById('normalInputWrapper').classList.remove('dictating-active', 'confirming-active');
                    document.getElementById('cancelVoiceToTextBtn').classList.add('hidden');
                    
                    const textVal = document.getElementById("messageInput").value.trim();
                    const imgVal = document.getElementById("imageInput").files.length;
                    const voiceVal = document.getElementById("voiceInput").files.length;

                    if (textVal !== "" || imgVal > 0 || voiceVal > 0) {
                        document.getElementById("sendChatBtn").click(); 
                        return; 
                    } else {
                        teks = "Maaf, pesan masih kosong.";
                    }
                } 
                else if (nomor >= 15) {
                    let targetLink = document.querySelector(`a[data-voice-id="${nomor}"]`);
                    if (targetLink) { teks = "Membuka obrolan."; tujuan = targetLink.getAttribute("href"); }
                }

                if (teks !== "") { bicara(teks, () => { if (tujuan !== "" && tujuan !== "#") window.location.href = tujuan; }); }
            }

            function mulaiMendengar() {
                if (!rec) return;
                try {
                    rec.start();
                    rec.onresult = (event) => {
                        const hasil = event.results[event.results.length - 1][0].transcript.toLowerCase().trim();
                        
                        if (menungguKonfirmasiKirim) {
                            if (hasil.includes("kirim") || hasil.includes("empat") || hasil.includes("ya")) { navigasiKe(4); return; }
                            if (hasil.includes("batal") || hasil.includes("tidak") || hasil.includes("engga")) { 
                                window.batalKetikSuara(); bicara("Pesan dibatalkan. Sebutkan satu untuk mengulang."); return; 
                            }
                            return; 
                        }

                        if (modeKetikSuara) {
                            if (hasil === "batal") { window.batalKetikSuara(); bicara("Dibatalkan."); return; }
                            
                            let inputEl = document.getElementById("messageInput");
                            inputEl.value += (inputEl.value === "" ? "" : " ") + hasil;
                            
                            clearTimeout(jedaKetikTimer);
                            jedaKetikTimer = setTimeout(() => {
                                modeKetikSuara = false;
                                menungguKonfirmasiKirim = true;
                                document.getElementById('normalInputWrapper').classList.remove('dictating-active');
                                document.getElementById('normalInputWrapper').classList.add('confirming-active');
                                bicara(`Pesan Anda adalah: ${inputEl.value}. Mau dikirim atau tidak? Sebutkan kirim, atau batal.`);
                            }, 2500); 
                            return; 
                        }

                        const recordBtn = document.getElementById('recordBtn');
                        if (recordBtn && recordBtn.classList.contains('text-white')) {
                            if (hasil.includes("selesai")) {
                                recordBtn.click();
                                bicara("Suara telah disimpan. Sebutkan empat untuk mengirim pesan suara ini.");
                            }
                            return; 
                        }

                        if (hasil.startsWith("cari ")) {
                            let namaDosen = hasil.replace("cari ", "").trim();
                            document.getElementById("searchInput").value = namaDosen; window.lakukanPencarian(namaDosen); return;
                        }

                        const angka = hasil.match(/\d+/);
                        if (angka) navigasiKe(parseInt(angka[0]));
                        else if (hasil.includes("lima") || hasil.includes("beranda")) navigasiKe(5);
                        else if (hasil.includes("enam") || hasil.includes("profil")) navigasiKe(6);
                        else if (hasil.includes("tujuh") || hasil.includes("pemberitahuan")) navigasiKe(7);
                        else if (hasil.includes("delapan") || hasil.includes("pesan")) navigasiKe(8);
                        else if (hasil.includes("sembilan") || hasil.includes("bantuan")) navigasiKe(9);
                        else if (hasil.includes("satu") || hasil.includes("ketik")) navigasiKe(1);
                        else if (hasil.includes("dua") || hasil.includes("gambar")) navigasiKe(2);
                        else if (hasil.includes("tiga") || hasil.includes("suara") || hasil.includes("voice")) navigasiKe(3);
                        else if (hasil.includes("empat") || hasil.includes("kirim")) navigasiKe(4);
                        else if (hasil.includes("nol") || hasil.includes("keluar")) navigasiKe(0);
                    };
                    rec.onend = () => { rec.start(); };
                } catch (e) { console.error("Error recognition:", e); }
            }

            window.onload = () => {
                let sapaanAkhir = "Sebutkan satu untuk mengetik pesan, dua untuk gambar, atau tiga untuk suara.";
                
                document.body.addEventListener("click", () => {}, { once: true });

                setTimeout(() => {
                    if (!isActiveChat) {
                        let sapaan = "Halo, ini halaman Pesan. ";
                        if (listDosenVA.length > 0) {
                            sapaan += "Anda memiliki riwayat obrolan. ";
                            listDosenVA.forEach(d => { sapaan += `Untuk ${d.nama}, sebutkan ${d.voiceId}. `; });
                            sapaan += "Atau sebutkan 'Cari' diikuti nama untuk mencari dosen.";
                        } else { sapaan += "Sebutkan 'Cari' diikuti nama dosen untuk memulai."; }
                        bicara(sapaan, () => { mulaiMendengar(); });
                    } else {
                        const isLastMsgVoice = {{ $hasVoice }};
                        
                        // JIKA PESAN TERAKHIR ADALAH VOICE NOTE
                        if (isLastMsgVoice) {
                            isAutoPlaying = true; // Set flag agar VA nunggu audio selesai
                            let sapaan = `Obrolan dengan ${currentDosenName}. Pesan terakhir adalah suara. Memutar pesan.`;
                            bicara(sapaan, () => {
                                const waveId = "{{ $lastWaveId }}";
                                if (wavesurfers[waveId]) {
                                    let playPromise = wavesurfers[waveId].play();
                                    if (playPromise !== undefined) {
                                        playPromise.then(_ => {
                                            document.getElementById('btn-' + waveId).innerHTML = '⏸';
                                            // Pertanyaan lanjut akan ditangani di event 'finish' wavesurfer
                                        }).catch(error => {
                                            isAutoPlaying = false;
                                            bicara("Browser memblokir pemutaran otomatis. Silakan ketuk layar sekali.", () => { mulaiMendengar(); });
                                        });
                                    }
                                }
                            });
                        } else {
                            if (lastMessageSender !== 'Anda') {
                                bicara(`Obrolan dengan ${currentDosenName}. Pesan terakhir adalah: ${lastMessageText}. ${sapaanAkhir}`, () => { mulaiMendengar(); });
                            } else {
                                bicara(`Obrolan dengan ${currentDosenName} terbuka. ${sapaanAkhir}`, () => { mulaiMendengar(); });
                            }
                        }
                    }
                }, 800);
            };
        </script>
    </body>
</html>