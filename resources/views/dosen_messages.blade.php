<!DOCTYPE html>
@php
    // Memaksa true agar tampilan dummy chat langsung terbuka untuk preview desain
    $selectedMahasiswa = $selectedMahasiswa ?? 'dummy'; 
    $chatMessages = $chatMessages ?? collect();
    $conversations = $conversations ?? [];
@endphp
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Pesan | Portal Dosen</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .safe-fade-in { animation: fadeIn 0.4s ease-out forwards; opacity: 0; }
    </style>
</head>
<body class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-full flex overflow-hidden border-box text-slate-800">
    
    <div id="mobileBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden transition-opacity"></div>

    <aside id="sidebar" class="hidden lg:flex w-80 bg-white border-r border-slate-200 flex-col h-screen sticky top-0 z-20 flex-shrink-0 transition-transform duration-300">
        <div class="p-8 border-b border-slate-100 flex items-center gap-4">
            <img src="{{ asset('images/logo-ummi.png') }}" class="w-10 h-10 object-contain" alt="Logo" />
            <div>
                <h1 class="text-lg font-black text-slate-900 tracking-tight leading-none">LMS Inklusi</h1>
                <p class="text-[9px] font-bold text-blue-600 uppercase tracking-widest mt-1">Portal Dosen</p>
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden ml-auto text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
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
            
            <a href="{{ route('dosen.schedule') }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Jadwal Mengajar</span>
            </a>
            
            <a href="{{ route('dosen.grading') }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span>Input Nilai</span>
            </a>
            
            <a href="{{ route('dosen.exams') }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Kelola Ujian</span>
            </a>
            
            <a href="{{ route('dosen.messages') }}" class="flex items-center justify-between p-4 bg-blue-50 text-blue-700 rounded-2xl font-bold transition-all shadow-sm border border-blue-100">
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    <span>Pesan</span>
                </div>
                <span class="text-[10px] bg-red-100 text-red-600 px-2 py-1 rounded-lg font-black">3</span>
            </a>
            
            <a href="{{ route('dosen.notifications') }}" class="flex items-center justify-between p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span>Pemberitahuan</span>
                </div>
            </a>
            
            <a href="{{ route('dosen.profile') }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span>Profil Saya</span>
            </a>
        </nav>

        <div class="p-6 border-t border-slate-100">
            <a href="{{ route('logout') }}" class="w-full p-4 flex items-center justify-between text-red-600 font-bold bg-red-50 rounded-2xl hover:bg-red-100 transition-all border border-red-100">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Keluar</span>
                </div>
            </a>
        </div>
    </aside>

    <main class="flex-1 h-screen overflow-hidden flex flex-col relative bg-slate-50 lg:ml-0 transition-all duration-300">
        
        <header class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-8 py-6 sticky top-0 z-20 shrink-0">
            <div class="max-w-7xl mx-auto flex items-center justify-between h-14">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg transition-all focus:outline-none focus:ring-2 focus:ring-slate-200 cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight leading-none">Pesan Masuk</h2>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5 block">Komunikasi Mahasiswa</span>
                    </div>
                </div>

            </div>
        </header>

        <div class="flex-1 flex overflow-hidden max-w-7xl mx-auto w-full">
            
            <div class="w-full md:w-80 bg-white border-r border-l border-slate-200 flex flex-col overflow-y-auto z-10 shrink-0 safe-fade-in">
                <div class="p-4 border-b border-slate-100 sticky top-0 bg-white/90 backdrop-blur-sm z-10">
                    <input type="text" placeholder="Cari mahasiswa..." class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-slate-400" />
                </div>
                
                <div class="p-2 space-y-1">
                    @forelse($conversations ?? [] as $mahasiswa_id => $msgs)
                        @php
                            $last = $msgs->last();
                            $mahasiswa = \App\Models\Mahasiswa::find($mahasiswa_id);
                        @endphp

                        @if($mahasiswa)
                        <a href="{{ route('dosen.messages', ['mahasiswa' => $mahasiswa_id]) }}" class="block">
                            <div class="p-3 {{ $selectedMahasiswa == $mahasiswa_id ? 'bg-blue-50 border border-blue-100 shadow-sm' : 'hover:bg-slate-50 border border-transparent hover:border-slate-100' }} rounded-xl flex gap-3 cursor-pointer transition-all">
                                <div class="w-10 h-10 rounded-xl bg-slate-200 shrink-0 overflow-hidden border border-slate-100">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($mahasiswa->nama) }}&background=random&color=fff" class="w-full h-full object-cover" />
                                </div>
                                <div class="flex-1 overflow-hidden">
                                    <div class="flex justify-between items-center mb-0.5">
                                        <h4 class="font-bold text-slate-900 text-xs truncate">{{ $mahasiswa->nama }}</h4>
                                        <span class="text-[9px] font-bold text-slate-400 shrink-0 ml-2">
                                            {{ $last ? $last->created_at->format('H:i') : '' }}
                                        </span>
                                    </div>
                                    <p class="text-[10px] text-slate-500 truncate font-medium">
                                        {{ $last ? $last->body : 'Belum ada pesan' }}
                                    </p>
                                </div>
                            </div>
                        </a>
                        @endif
                    @empty
                        <div class="p-3 bg-blue-50 border border-blue-100 shadow-sm rounded-xl flex gap-3 cursor-pointer transition-all">
                            <div class="w-10 h-10 rounded-xl bg-slate-200 shrink-0 overflow-hidden border border-slate-100">
                                <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=0D8ABC&color=fff" class="w-full h-full object-cover" />
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <div class="flex justify-between items-center mb-0.5">
                                    <h4 class="font-bold text-slate-900 text-xs truncate">Budi Santoso</h4>
                                    <span class="text-[9px] font-bold text-blue-600 shrink-0 ml-2">10:45</span>
                                </div>
                                <p class="text-[10px] text-slate-500 truncate font-medium">Baik Pak, terima kasih informasinya.</p>
                            </div>
                        </div>

                        <div class="p-3 hover:bg-slate-50 border border-transparent hover:border-slate-100 rounded-xl flex gap-3 cursor-pointer transition-all">
                            <div class="w-10 h-10 rounded-xl bg-slate-200 shrink-0 overflow-hidden border border-slate-100">
                                <img src="https://ui-avatars.com/api/?name=Siti+Aisyah&background=random&color=fff" class="w-full h-full object-cover" />
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <div class="flex justify-between items-center mb-0.5">
                                    <h4 class="font-bold text-slate-900 text-xs truncate">Siti Aisyah</h4>
                                    <span class="text-[9px] font-bold text-slate-400 shrink-0 ml-2">Kemarin</span>
                                </div>
                                <p class="text-[10px] text-slate-500 truncate font-medium">Terima kasih banyak pak atas bimbingannya.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="flex-1 flex-col bg-[#f0f4f8] relative hidden md:flex safe-fade-in" style="animation-delay: 0.1s">
                
                @if($selectedMahasiswa || empty($conversations))
                    @php
                        $currentMahasiswa = $selectedMahasiswa ? \App\Models\Mahasiswa::find($selectedMahasiswa) : null;
                        $displayName = $currentMahasiswa->nama ?? 'Budi Santoso';
                    @endphp
                    <div class="p-4 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between sticky top-0 z-10 shrink-0 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 overflow-hidden border border-blue-200">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($displayName) }}&background=0D8ABC&color=fff" class="w-full h-full object-cover" />
                            </div>
                            <div>
                                <h4 class="font-black text-slate-900 text-sm leading-tight">
                                    {{ $displayName }}
                                </h4>
                                <span class="inline-flex items-center text-[9px] font-bold text-emerald-600 uppercase tracking-widest mt-0.5">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5 animate-pulse"></span> Online
                                </span>
                            </div>
                        </div>
                    </div>

                    <div id="chatBox" class="flex-1 p-6 overflow-y-auto space-y-6 custom-scrollbar">
                        @forelse($chatMessages as $msg)
                            <div id="msg-{{ $msg->id }}" class="safe-fade-in">
                                @if($msg->sender_type === 'dosen')
                                    <div class="flex flex-col items-end ml-auto max-w-[80%] md:max-w-[70%]">
                                        <div class="bg-blue-600 p-4 rounded-2xl rounded-tr-none shadow-md shadow-blue-200">
                                            @if($msg->body)
                                                <p class="text-sm text-white leading-relaxed font-medium">{{ $msg->body }}</p>
                                            @endif
                                            @if($msg->image_path)
                                                <img src="{{ asset('storage/'.$msg->image_path) }}" class="mt-2 rounded-lg max-w-xs object-cover border border-blue-500">
                                            @endif
                                        </div>
                                        <span class="text-[9px] font-bold text-slate-400 mt-1 mr-1">{{ $msg->created_at->format('H:i') }}</span>
                                    </div>
                                @else
                                    <div class="flex flex-col items-start max-w-[80%] md:max-w-[70%]">
                                        <div class="bg-white p-4 rounded-2xl rounded-tl-none shadow-sm border border-slate-200">
                                            @if($msg->body)
                                                <p class="text-sm text-slate-700 leading-relaxed font-medium">{{ $msg->body }}</p>
                                            @endif
                                            @if($msg->image_path)
                                                <img src="{{ asset('storage/'.$msg->image_path) }}" class="mt-2 rounded-lg max-w-xs object-cover border border-slate-100">
                                            @endif
                                        </div>
                                        <span class="text-[9px] font-bold text-slate-400 mt-1 ml-1">{{ $msg->created_at->format('H:i') }}</span>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="flex flex-col items-start max-w-[80%] md:max-w-[70%]">
                                <div class="bg-white p-4 rounded-2xl rounded-tl-none shadow-sm border border-slate-200">
                                    <p class="text-sm text-slate-700 leading-relaxed font-medium">Assalamualaikum Pak, mohon maaf mengganggu waktunya.</p>
                                </div>
                                <span class="text-[9px] font-bold text-slate-400 mt-1 ml-1">10:25 AM</span>
                            </div>

                            <div class="flex flex-col items-start max-w-[80%] md:max-w-[70%] mt-4">
                                <div class="bg-white p-4 rounded-2xl rounded-tl-none shadow-sm border border-slate-200">
                                    <p class="text-sm text-slate-700 leading-relaxed font-medium">Saya mau bertanya soal tugas akhir PBO. Untuk rancangan Use Case Diagramnya apakah dikumpul format PDF atau disatukan ke Word ya Pak?</p>
                                </div>
                                <span class="text-[9px] font-bold text-slate-400 mt-1 ml-1">10:30 AM</span>
                            </div>

                            <div class="flex flex-col items-end ml-auto max-w-[80%] md:max-w-[70%] mt-4">
                                <div class="bg-blue-600 p-4 rounded-2xl rounded-tr-none shadow-md shadow-blue-200">
                                    <p class="text-sm text-white leading-relaxed font-medium">Waalaikumsalam Budi. Silakan disatukan saja ke dalam satu file PDF agar lebih rapi saat saya periksa nanti.</p>
                                </div>
                                <span class="text-[9px] font-bold text-slate-400 mt-1 mr-1">10:45 AM</span>
                            </div>
                        @endforelse
                    </div>

                    <div class="p-4 bg-white border-t border-slate-200 shrink-0">
                        <form id="chatForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $selectedMahasiswa }}">

                            <div class="flex items-center gap-2 bg-slate-50 p-2 rounded-2xl border border-slate-200 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100 transition-all">
                                
                                <button type="button" onclick="document.getElementById('imageInput').click()" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-white rounded-xl transition-all cursor-pointer" title="Kirim Gambar">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                                <input type="file" name="image" id="imageInput" hidden accept="image/*">

                                <input type="text" name="body" id="messageInput" placeholder="Ketik pesan balasan..." class="flex-1 bg-transparent text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none px-2 w-full" autocomplete="off" />

                                <button type="button" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all cursor-pointer" title="Voice Note">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                                    </svg>
                                </button>

                                <button type="submit" class="w-12 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center shadow-md hover:bg-blue-700 transition-all cursor-pointer transform hover:scale-105 active:scale-95">
                                    <svg class="w-5 h-5 transform rotate-90 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>

                @else
                    <div class="flex-1 flex flex-col items-center justify-center text-center p-6 safe-fade-in">
                        <div class="w-20 h-20 bg-blue-50 text-blue-300 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-700">Pesan Inklusi</h3>
                        <p class="text-sm text-slate-500 mt-2 max-w-xs">Silakan pilih kontak mahasiswa di panel sebelah kiri untuk mulai membaca atau mengirim pesan.</p>
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

        document.addEventListener("DOMContentLoaded", function () {

            let form = document.getElementById("chatForm");
            let chatBox = document.getElementById("chatBox");
            let messageInput = document.getElementById("messageInput");
            let imageInput = document.getElementById("imageInput");

            // Auto scroll ke bawah
            function scrollBottom(){
                if(chatBox) {
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            }

            scrollBottom();

            // =========================
            // KIRIM PESAN TANPA RELOAD
            // =========================
            if(form) {
                form.addEventListener("submit", function(e){
                    e.preventDefault();

                    if (!messageInput.value.trim() && !imageInput.files.length) {
                        return;
                    }

                    let formData = new FormData(form);

                    fetch("{{ route('dosen.messages.send') }}", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success){
                            let html = `
                            <div class="flex flex-col items-end ml-auto max-w-[80%] md:max-w-[70%] safe-fade-in mt-4">
                                <div class="bg-blue-600 p-4 rounded-2xl rounded-tr-none shadow-md shadow-blue-100">
                                    ${data.body ? `<p class="text-sm text-white leading-relaxed font-medium">${data.body}</p>` : ''}
                                    ${data.image ? `<img src="/storage/${data.image}" class="mt-2 rounded-lg max-w-xs object-cover border border-blue-500">` : ''}
                                </div>
                                <span class="text-[9px] font-bold text-slate-400 mt-1 mr-1">
                                    ${data.time}
                                </span>
                            </div>
                            `;

                            chatBox.insertAdjacentHTML('beforeend', html);
                            messageInput.value = "";
                            imageInput.value = "";
                            scrollBottom();
                        }
                    }).catch(err => {
                        // Fallback Demo UI jika backend belum aktif
                        let time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) + ' AM';
                        let html = `
                            <div class="flex flex-col items-end ml-auto max-w-[80%] md:max-w-[70%] safe-fade-in mt-4">
                                <div class="bg-blue-600 p-4 rounded-2xl rounded-tr-none shadow-md shadow-blue-100">
                                    <p class="text-sm text-white leading-relaxed font-medium">${messageInput.value}</p>
                                </div>
                                <span class="text-[9px] font-bold text-slate-400 mt-1 mr-1">${time}</span>
                            </div>
                            `;
                        chatBox.insertAdjacentHTML('beforeend', html);
                        messageInput.value = "";
                        scrollBottom();
                    });
                });
            }

            // =========================
            // AUTO REFRESH SETIAP 3 DETIK
            // =========================
            @if($selectedMahasiswa && !empty($conversations))
            setInterval(function(){
                fetch("{{ route('dosen.messages.fetch', $selectedMahasiswa) }}")
                .then(res => res.json())
                .then(data => {
                    if(data.html){
                        chatBox.innerHTML = data.html;
                        scrollBottom();
                    }
                });
            }, 3000);
            @endif
        });
    </script>
</body>
</html>