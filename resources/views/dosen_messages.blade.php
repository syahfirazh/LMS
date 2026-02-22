<!DOCTYPE html>
@php
    $activeMahasiswaId = $mahasiswa ?? null;
    $messages = $chatMessages ?? collect();
    $listPercakapan = $conversations ?? []; 
    
    $dosenId = Auth::guard('dosen')->id();
    $unreadCount = \App\Models\Message::where('receiver_type', 'dosen')
                    ->where('receiver_id', $dosenId)
                    ->where('is_read', 0)
                    ->count();
@endphp
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Pesan | Portal Dosen</title>
    
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
    </style>
</head>

<body class="m-0 font-['Plus_Jakarta_Sans'] bg-slate-50 text-slate-800 antialiased h-screen flex overflow-hidden">
    
    <div id="mobileBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden transition-opacity"></div>

    <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-80 bg-white border-r border-slate-200 flex flex-col h-full transform -translate-x-full lg:translate-x-0 transition-transform duration-300 shrink-0 shadow-2xl lg:shadow-none">
       <div class="p-8 border-b border-slate-100 flex items-center gap-4 shrink-0">
            <img src="{{ asset('images/logo-ummi.png') }}" class="w-10 h-10 object-contain" alt="Logo" onerror="this.src='https://ui-avatars.com/api/?name=UMMI&background=0D8ABC&color=fff'" />
            <div>
                <h1 class="text-lg font-black text-slate-900 tracking-tight leading-none">LMS Inklusi</h1>
                <p class="text-[9px] font-bold text-blue-600 uppercase tracking-widest mt-1">Portal Dosen</p>
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden ml-auto text-slate-400 hover:text-slate-600 bg-slate-50 p-2 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <nav class="flex-1 p-6 space-y-3 overflow-y-auto custom-scrollbar">
            <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span>Beranda</span>
            </a>
            <a href="{{ route('dosen.courses') }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span>Mata Kuliah</span>
            </a>
            <a href="{{ route('dosen.schedule') ?? '#' }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Jadwal Mengajar</span>
            </a>
            <a href="{{ route('dosen.grading') ?? '#' }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span>Input Nilai</span>
            </a>
            <a href="{{ route('dosen.exams') ?? '#' }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Kelola Ujian</span>
            </a>
            <a href="{{ route('dosen.messages') }}" class="flex items-center justify-between p-4 bg-blue-50 text-blue-700 rounded-2xl font-bold transition-all shadow-sm border border-blue-100">
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    <span>Pesan</span>
                </div>
                @if($unreadCount > 0)
                    <span class="text-[10px] bg-red-500 text-white px-2 py-1 rounded-lg font-black shadow-sm">{{ $unreadCount }} Baru</span>
                @else
                    <span class="text-[10px] bg-blue-100 text-blue-600 px-2 py-1 rounded-lg font-black">Aktif</span>
                @endif
            </a>
            <a href="{{ route('dosen.notifications') ?? '#' }}" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span>Pemberitahuan</span>
                </div>
            </a>
            <a href="{{ route('dosen.profile') ?? '#' }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span>Profil Saya</span>
            </a>
        </nav>
        <div class="p-6 border-t border-slate-100 shrink-0">
            <a href="{{ route('logout.dosen') }}" class="w-full p-4 flex items-center justify-between text-red-600 font-bold bg-red-50 rounded-2xl hover:bg-red-100 transition-all border border-red-100">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Keluar</span>
                </div>
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full relative min-w-0 bg-[#f8fafc] overflow-hidden">
        
        <header class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-4 md:px-8 py-4 sm:py-6 shrink-0 z-20">
            <div class="max-w-7xl mx-auto flex items-center justify-between h-10 sm:h-14">
                <div class="flex items-center gap-3 sm:gap-4">
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-800 rounded-lg transition-all focus:outline-none cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div>
                        <h2 class="text-lg sm:text-2xl font-black text-slate-900 tracking-tight leading-none">Pesan Masuk</h2>
                        <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 block">Komunikasi Mahasiswa</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 flex overflow-hidden max-w-7xl mx-auto w-full">
            
            <div class="w-full md:w-80 bg-white border-r border-l border-slate-200 flex-col overflow-y-auto z-10 shrink-0 safe-fade-in {{ $activeMahasiswaId ? 'hidden md:flex' : 'flex' }}">
                <div class="p-4 border-b border-slate-100 sticky top-0 bg-white/90 backdrop-blur-sm z-10">
                    <input type="text" id="searchInput" placeholder="Ketik nama mahasiswa..." class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-slate-400" />
                </div>
                <div id="contactList" class="p-2 space-y-1 overflow-y-auto">
                    @forelse($listPercakapan as $m_id => $msgs)
                        @php
                            $last = $msgs->last();
                            $mhs = \App\Models\Mahasiswa::find($m_id);
                            $isUnread = $last->sender_type == 'mahasiswa' && $last->is_read == 0;
                        @endphp
                        @if($mhs)
                        <a href="{{ route('dosen.messages.show', ['mahasiswa' => $m_id]) }}" class="block">
                            <div class="p-3 {{ $activeMahasiswaId == $m_id ? 'bg-blue-50 border border-blue-100 shadow-sm' : 'hover:bg-slate-50 border border-transparent hover:border-slate-100' }} rounded-xl flex gap-3 cursor-pointer transition-all relative">
                                @if($isUnread) <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 rounded-full animate-pulse border-2 border-white"></span> @endif
                                <div class="w-10 h-10 rounded-xl bg-slate-200 shrink-0 overflow-hidden border border-slate-100 flex items-center justify-center">
                                    {{-- KODE YANG DIUBAH 1: background disamakan menjadi 0D8ABC --}}
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($mhs->nama) }}&background=0D8ABC&color=fff" class="w-full h-full object-cover" />
                                </div>
                                <div class="flex-1 overflow-hidden">
                                    <div class="flex justify-between items-center mb-0.5">
                                        <h4 class="font-bold {{ $isUnread ? 'text-slate-900' : 'text-slate-700' }} text-xs truncate">{{ $mhs->nama }}</h4>
                                        <span class="text-[9px] font-bold {{ $isUnread ? 'text-blue-600' : 'text-slate-400' }} shrink-0 ml-2">{{ $last ? $last->created_at->format('H:i') : '' }}</span>
                                    </div>
                                    <p class="text-[10px] {{ $isUnread ? 'text-slate-800 font-bold' : 'text-slate-500 font-medium' }} truncate">
                                        {{ $last && $last->body ? $last->body : ($last && $last->voice_path ? '[Voice Note]' : ($last && $last->image_path ? '[Gambar]' : 'Belum ada pesan')) }}
                                    </p>
                                </div>
                            </div>
                        </a>
                        @endif
                    @empty
                        <div class="p-6 text-center"><p class="text-xs text-slate-400 font-bold">Belum ada riwayat kontak.</p></div>
                    @endforelse
                </div>
            </div>

            <div class="flex-1 flex-col bg-[#f0f4f8] relative safe-fade-in {{ $activeMahasiswaId ? 'flex' : 'hidden md:flex' }}">
                @if($activeMahasiswaId)
                    @php
                        $currentMahasiswa = \App\Models\Mahasiswa::find($activeMahasiswaId);
                        $displayName = $currentMahasiswa->nama ?? 'Mahasiswa';
                    @endphp
                    
                    <div class="p-3 sm:p-4 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between sticky top-0 z-10 shrink-0 shadow-sm">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('dosen.messages') }}" class="md:hidden flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all border border-slate-200 mr-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </a>
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-blue-100 overflow-hidden border border-blue-200 shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($displayName) }}&background=0D8ABC&color=fff" class="w-full h-full object-cover" />
                            </div>
                            <div>
                                <h4 class="font-black text-slate-900 text-xs sm:text-sm leading-tight truncate max-w-[150px] sm:max-w-xs">{{ $displayName }}</h4>
                                <span class="inline-flex items-center text-[9px] font-bold text-emerald-600 uppercase tracking-widest mt-0.5">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5 animate-pulse"></span> Online
                                </span>
                            </div>
                        </div>
                    </div>

                    <div id="chatBox" class="flex-1 p-4 sm:p-6 overflow-y-auto space-y-6 custom-scrollbar bg-white">
                        @forelse($messages as $msg)
                            @php $isMe = $msg->sender_type === 'dosen'; @endphp
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
                                <p class="text-[9px] sm:text-[10px] text-slate-400 uppercase tracking-widest mt-1">Mulai sapa mahasiswa Anda!</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="p-3 sm:p-4 border-t border-slate-100 bg-white shrink-0 shadow-[0_-4px_10px_rgba(0,0,0,0.02)]">
                        <div id="imagePreviewContainer" class="hidden mb-3 relative p-2 bg-slate-50 border border-slate-200 rounded-2xl w-fit">
                            <img id="imagePreviewElement" src="" class="h-20 sm:h-24 w-auto object-cover rounded-xl shadow-sm border border-slate-200">
                            <button type="button" onclick="cancelImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center font-bold text-xs shadow-lg hover:bg-red-600 hover:scale-110 transition-transform">✕</button>
                        </div>
                        <form id="chatForm" method="POST" action="{{ route('dosen.messages.send') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $activeMahasiswaId }}">
                            <input type="file" name="image" id="imageInput" accept="image/*" class="hidden" onchange="previewImage(this)">
                            <input type="file" name="voice" id="voiceInput" accept="audio/webm" class="hidden">

                            <div class="relative flex items-center gap-2 sm:gap-3 bg-slate-50 p-2 sm:p-3 rounded-[1.25rem] sm:rounded-2xl border border-slate-200 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100 transition-all">
                                
                                <button type="button" id="btnUploadImage" onclick="document.getElementById('imageInput').click()" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-white transition-all cursor-pointer shadow-sm border border-transparent hover:border-blue-100 shrink-0">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </button>

                                <div id="normalInputWrapper" class="flex-1 min-w-0 relative flex items-center">
                                    <input type="text" id="messageInput" name="body" placeholder="Tulis pesan Anda..." class="w-full bg-transparent text-xs sm:text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none transition-all py-1.5" autocomplete="off" />
                                    <button type="button" id="cancelVoiceBtn" class="hidden absolute right-1 sm:right-2 text-[10px] font-black uppercase text-white bg-red-500 hover:bg-red-600 px-2.5 py-1.5 rounded-lg shadow-sm transition-all cursor-pointer">Batal ✕</button>
                                </div>

                                <div id="recordingWrapper" class="hidden flex-1 items-center justify-between px-2">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 sm:w-2.5 sm:h-2.5 bg-red-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(239,68,68,0.8)]"></span>
                                        <span class="text-[10px] sm:text-xs font-bold text-red-500 font-mono tracking-wider" id="recordTimer">00:00</span>
                                        <div class="recording-wave flex items-center gap-1 h-5 sm:h-6 ml-1 sm:ml-2">
                                            <div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div>
                                        </div>
                                    </div>
                                    <button type="button" id="cancelRecordBtn" class="text-[9px] sm:text-[10px] font-black uppercase text-slate-400 hover:text-red-500 px-1 sm:px-2 transition-colors">Batal</button>
                                </div>

                                <button type="button" id="recordBtn" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all cursor-pointer border border-transparent hover:border-red-100 shadow-sm shrink-0">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z" /></svg>
                                </button>

                                <button type="submit" id="sendChatBtn" class="w-10 h-9 sm:w-12 sm:h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-transform transform hover:scale-105 active:scale-95 shadow-md shadow-blue-200 cursor-pointer shrink-0">
                                    <span id="sendIcon"><svg class="w-4 h-4 sm:w-5 sm:h-5 transform rotate-90 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg></span>
                                    <span id="sendLoading" class="hidden"><svg class="w-4 h-4 sm:w-5 sm:h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg></span>
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="flex-1 flex flex-col items-center justify-center text-center p-6 safe-fade-in">
                        <div class="w-20 h-20 bg-blue-50 text-blue-300 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-700">Pesan Inklusi</h3>
                        <p class="text-sm text-slate-500 mt-2 max-w-xs">Ketik nama mahasiswa di kotak pencarian atau pilih kontak untuk memulai chat.</p>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('mobileBackdrop').classList.toggle('hidden');
        }

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

        document.addEventListener("DOMContentLoaded", function () {
            let chatBox = document.getElementById("chatBox");
            function scrollBottom(){ if(chatBox) chatBox.scrollTop = chatBox.scrollHeight; }
            scrollBottom();

            document.querySelectorAll('[id^="wave-"]').forEach(el => {
                initWaveSurfer(el.id, el.getAttribute('data-audio'), el.parentElement.classList.contains('border-white/30'));
            });

            let searchInput = document.getElementById("searchInput");
            let contactList = document.getElementById("contactList");
            let originalContactHTML = contactList ? contactList.innerHTML : '';
            if(searchInput && contactList) {
                searchInput.addEventListener("input", function() {
                    let keyword = this.value.trim();
                    if(keyword.length === 0) { contactList.innerHTML = originalContactHTML; return; }
                    contactList.innerHTML = `<div class="p-6 text-center"><p class="text-xs text-slate-400 font-bold animate-pulse">Mencari...</p></div>`;
                    fetch(`{{ route('dosen.messages.search') }}?q=${encodeURIComponent(keyword)}`)
                    .then(res => res.json())
                    .then(data => {
                        if(data.length === 0) { contactList.innerHTML = `<div class="p-6 text-center"><p class="text-xs text-slate-400 font-bold">Tidak ditemukan.</p></div>`; return; }
                        let html = '';
                        data.forEach(mhs => {
                            html += `
                            <a href="{{ url('/dosen/messages') }}/${mhs.id}" class="block safe-fade-in">
                                <div class="p-3 hover:bg-slate-50 border border-transparent hover:border-slate-100 rounded-xl flex gap-3 cursor-pointer transition-all">
                                    <div class="w-10 h-10 rounded-xl bg-slate-200 shrink-0 overflow-hidden border border-slate-100 flex items-center justify-center">
                                        {{-- KODE YANG DIUBAH 2: background disamakan menjadi 0D8ABC --}}
                                        <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(mhs.nama)}&background=0D8ABC&color=fff" class="w-full h-full object-cover" />
                                    </div>
                                    <div class="flex-1 flex flex-col justify-center overflow-hidden">
                                        <h4 class="font-bold text-slate-900 text-xs truncate">${mhs.nama}</h4>
                                        <p class="text-[10px] text-slate-500 truncate font-medium">Mulai obrolan baru</p>
                                    </div>
                                </div>
                            </a>`;
                        });
                        contactList.innerHTML = html;
                    });
                });
            }

            let imageInput = document.getElementById("imageInput");
            let messageInput = document.getElementById("messageInput");
            let voiceInput = document.getElementById("voiceInput");
            const btnUploadImage = document.getElementById('btnUploadImage');
            const recordBtn = document.getElementById('recordBtn');
            const cancelRecordBtn = document.getElementById('cancelRecordBtn');
            const cancelVoiceBtn = document.getElementById('cancelVoiceBtn');
            const normalInputWrapper = document.getElementById('normalInputWrapper');
            const recordingWrapper = document.getElementById('recordingWrapper');
            const timerText = document.getElementById('recordTimer');

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
                timerText.innerText = `${String(Math.floor(recordSeconds / 60)).padStart(2, '0')}:${String(recordSeconds % 60).padStart(2, '0')}`;
            }

            if(recordBtn) {
                recordBtn.addEventListener('click', async () => {
                    if (!mediaRecorder || mediaRecorder.state === "inactive") {
                        try {
                            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                            mediaRecorder = new MediaRecorder(stream);
                            mediaRecorder.start();
                            
                            normalInputWrapper.classList.add('hidden');
                            recordingWrapper.classList.remove('hidden');
                            recordingWrapper.classList.add('flex');
                            
                            recordBtn.classList.remove('text-slate-400', 'bg-red-50', 'hover:bg-red-100');
                            recordBtn.classList.add('text-red-500', 'bg-red-100', 'animate-pulse', 'border-red-500');
                            
                            recordSeconds = 0; timerText.innerText = "00:00";
                            recordInterval = setInterval(updateTimer, 1000);
                            audioChunks = [];
                            mediaRecorder.ondataavailable = event => { audioChunks.push(event.data); };
                        } catch(err) { alert("Mikrofon tidak diizinkan!"); }
                    } else {
                        // Selesai rekam
                        mediaRecorder.onstop = () => {
                            const file = new File([new Blob(audioChunks, { type: 'audio/webm' })], "voice.webm", { type: "audio/webm" });
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            voiceInput.files = dataTransfer.files;
                            
                            recordingWrapper.classList.add('hidden'); recordingWrapper.classList.remove('flex');
                            normalInputWrapper.classList.remove('hidden');
                            recordBtn.classList.add('hidden'); btnUploadImage.classList.add('hidden');
                            
                            // Ubah input jadi status siap kirim
                            messageInput.placeholder = "▶ ılıılı Voice Note siap dikirim...";
                            messageInput.disabled = true; 
                            messageInput.classList.add('font-bold', 'text-blue-600', 'bg-blue-50', 'rounded-xl', 'px-4');
                            messageInput.classList.remove('bg-transparent');
                            
                            // Tampilkan Tombol Batal
                            cancelVoiceBtn.classList.remove('hidden');
                        };
                        mediaRecorder.stop(); clearInterval(recordInterval);
                    }
                });

                // Batal pas lagi merekam
                cancelRecordBtn.addEventListener('click', () => {
                    if(mediaRecorder && mediaRecorder.state !== "inactive") mediaRecorder.stop();
                    clearInterval(recordInterval); audioChunks = []; voiceInput.value = '';
                    recordingWrapper.classList.add('hidden'); recordingWrapper.classList.remove('flex');
                    normalInputWrapper.classList.remove('hidden');
                    recordBtn.classList.remove('text-red-500', 'bg-red-100', 'animate-pulse', 'border-red-500', 'hidden');
                    recordBtn.classList.add('text-slate-400', 'bg-red-50', 'hover:bg-red-100');
                    btnUploadImage.classList.remove('hidden'); cancelVoiceBtn.classList.add('hidden');
                });

                // Batal pas rekaman udah jadi (Tombol X merah)
                cancelVoiceBtn.addEventListener('click', () => {
                    voiceInput.value = ''; // Hapus file dari input
                    
                    messageInput.placeholder = "Tulis pesan Anda...";
                    messageInput.disabled = false;
                    messageInput.classList.remove('font-bold', 'text-blue-600', 'bg-blue-50', 'rounded-xl', 'px-4');
                    messageInput.classList.add('bg-transparent');
                    
                    cancelVoiceBtn.classList.add('hidden');
                    btnUploadImage.classList.remove('hidden');
                    recordBtn.classList.remove('hidden', 'text-red-500', 'bg-red-100', 'animate-pulse', 'border-red-500');
                    recordBtn.classList.add('text-slate-400');
                });
            }

            let form = document.getElementById("chatForm");
            if(form) {
                form.addEventListener("submit", async function(e){
                    e.preventDefault();
                    if (!messageInput.value.trim() && (!imageInput || !imageInput.files.length) && (!voiceInput || !voiceInput.files.length)) return;
                    const btnSubmit = document.getElementById('sendChatBtn');
                    btnSubmit.disabled = true;
                    document.getElementById('sendIcon').classList.add('hidden');
                    document.getElementById('sendLoading').classList.remove('hidden');

                    try {
                        const response = await fetch("{{ route('dosen.messages.send') }}", {
                            method: "POST", body: new FormData(this), headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                        });
                        const data = await response.json();
                        if(data.success){
                            this.reset(); cancelImage();
                            
                            // Reset State Voice setelah ngirim
                            if(voiceInput) voiceInput.value = '';
                            messageInput.placeholder = "Tulis pesan Anda..."; messageInput.disabled = false;
                            messageInput.classList.remove('font-bold', 'text-blue-600', 'bg-blue-50', 'rounded-xl', 'px-4');
                            messageInput.classList.add('bg-transparent');
                            cancelVoiceBtn.classList.add('hidden'); btnUploadImage.classList.remove('hidden');
                            recordBtn.classList.remove('hidden', 'text-red-500', 'bg-red-100', 'animate-pulse', 'border-red-500');
                            recordBtn.classList.add('text-slate-400');
                            
                            let mediaHtml = '';
                            if (data.message.image_path) mediaHtml += `<img src="/storage/${data.message.image_path}" class="mt-2 rounded-xl max-w-full border border-white/20">`;
                            const uniqueWaveId = 'wave-new-' + Date.now();
                            if (data.message.voice_path) {
                                mediaHtml += `<div class="mt-2 flex items-center gap-3 bg-white/20 p-2 rounded-xl backdrop-blur-sm border border-white/30 w-[200px] sm:w-[240px]"><button type="button" onclick="togglePlay('${uniqueWaveId}')" id="btn-${uniqueWaveId}" class="w-7 h-7 sm:w-8 sm:h-8 shrink-0 flex items-center justify-center rounded-full bg-white text-blue-600 shadow hover:scale-105 transition-transform text-[10px] sm:text-xs">▶</button><div id="${uniqueWaveId}" class="flex-1" data-audio="/storage/${data.message.voice_path}"></div></div>`;
                            }
                            let msgHtml = data.message.body ? `<p class="text-xs sm:text-[13px] leading-relaxed font-medium whitespace-pre-wrap break-words">${data.message.body}</p>` : '';
                            let html = `<div class="flex justify-end safe-fade-in"><div class="flex flex-col items-end max-w-[85%] md:max-w-[70%]"><div class="p-3 sm:p-4 rounded-2xl shadow-sm border bg-blue-600 text-white rounded-tr-none border-blue-700">${msgHtml}${mediaHtml}</div><span class="text-[9px] font-bold text-slate-400 mt-1 mr-1">${data.message.time}</span></div></div>`;

                            let emptyNotice = document.getElementById('emptyChat');
                            if(emptyNotice) emptyNotice.remove();
                            chatBox.insertAdjacentHTML('beforeend', html);
                            scrollBottom();
                            if(data.message.voice_path) setTimeout(() => initWaveSurfer(uniqueWaveId, `/storage/${data.message.voice_path}`, true), 100);
                        } else { alert("Gagal mengirim pesan."); }
                    } catch (err) { alert("Terjadi kesalahan."); } finally {
                        btnSubmit.disabled = false;
                        document.getElementById('sendLoading').classList.add('hidden');
                        document.getElementById('sendIcon').classList.remove('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>