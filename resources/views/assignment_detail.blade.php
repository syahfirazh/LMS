<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Detail Tugas - {{ $assignment->judul }} | LMS Inklusi UMMI</title>

        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

        <script src="https://unpkg.com/wavesurfer.js@7"></script>

        <style>
            html { scrollbar-gutter: stable; }
            .scrollbar-hide::-webkit-scrollbar { display: none; }
            .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
            .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background-color: #94a3b8; }

            .fade-in { animation: fadeIn 0.4s ease-in-out forwards; }
            @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
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
        </style>
    </head>
    <body class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-full flex flex-col border-box overflow-x-hidden text-slate-800">
        <main class="flex-1 flex flex-col h-screen overflow-y-scroll custom-scrollbar relative">
            
            <div class="bg-white/90 backdrop-blur-2xl border-b border-slate-200/60 sticky top-0 z-40 px-4 md:px-8 py-4 shadow-sm transition-all w-full">
                <div class="max-w-7xl mx-auto flex items-center justify-between relative h-12">
                    <div class="flex items-center gap-4 relative z-10 w-1/3 shrink-0">
                        <a href="{{ route('course.assignments', $kelas->id) }}" class="w-11 h-11 md:w-12 md:h-12 rounded-full bg-slate-100 hover:bg-blue-600 text-slate-500 hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm group border border-slate-200 hover:border-blue-600 relative cursor-pointer active:scale-95">
                            <svg class="w-5 h-5 md:w-6 md:h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                            <span class="absolute -bottom-1 -right-1 bg-slate-800 text-white text-[9px] font-black px-1.5 py-0.5 rounded-md border border-white shadow-sm">0</span>
                        </a>
                        <a href="{{ route('course.assignments', $kelas->id) }}" class="hidden sm:block text-left cursor-pointer group shrink-0 decoration-transparent">
                            <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest">Navigasi Suara</span>
                            <span class="block text-xs font-black text-slate-700 group-hover:text-blue-600 transition-colors">0 - Kembali</span>
                        </a>
                    </div>

                    <div class="absolute left-1/2 transform -translate-x-1/2 text-center w-1/3 z-0 pointer-events-none">
                        <h1 class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight leading-none truncate pointer-events-auto">{{ $assignment->judul }}</h1>
                        <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1 truncate pointer-events-auto">{{ $kelas->mataKuliah->nama }}</p>
                    </div>

                    <div class="flex items-center justify-end gap-3 relative z-10 w-1/3 shrink-0">
                        <div class="flex items-center gap-[2px] h-4 w-10 justify-center" id="wave-container">
                            <div class="wave-bar w-[2px] bg-blue-500 rounded-full h-1 transition-all"></div>
                            <div class="wave-bar w-[2px] bg-blue-400 rounded-full h-1 transition-all"></div>
                            <div class="wave-bar w-[2px] bg-blue-600 rounded-full h-1 transition-all"></div>
                        </div>
                        <span id="status-desc" class="hidden md:block text-[9px] font-black text-slate-400 uppercase tracking-widest w-20 text-left">SIAP</span>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto w-full px-4 md:px-8 py-6 md:py-8 space-y-6 md:space-y-8 pb-20">
                @php
                    $isSubmittedStatus = isset($submission) && ($submission->file_path || $submission->text_submission || $submission->voice_submission);
                @endphp

                @if(session('success'))
                    <div class="bg-emerald-100 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl relative flex items-center gap-3 fade-in" role="alert">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        <span class="block sm:inline font-bold text-sm">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative flex items-center gap-3 fade-in" role="alert">
                        <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                        <span class="block sm:inline font-bold text-sm">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-orange-50 border border-orange-200 p-6 rounded-[2rem] flex items-center gap-4 shadow-sm" data-aos="fade-up" data-aos-duration="600">
                        <div class="w-12 h-12 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-orange-700 uppercase tracking-wide">Batas Waktu</h3>
                            <p class="text-lg font-bold text-slate-800">{{ \Carbon\Carbon::parse($assignment->deadline)->translatedFormat('d M Y, H:i') }} WIB</p>
                        </div>
                    </div>

                    <div id="status-card" class="bg-white border {{ $isSubmittedStatus ? 'border-emerald-300 bg-emerald-50/40 shadow-emerald-100' : 'border-slate-200 shadow-sm' }} p-6 rounded-[2rem] flex items-center gap-4 transition-all duration-300" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                        <div id="status-icon" class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all shrink-0 {{ $isSubmittedStatus ? 'bg-emerald-500 text-white shadow-md' : 'bg-slate-100 text-slate-500' }}">
                            @if($isSubmittedStatus)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            @endif
                        </div>
                        <div>
                            <h3 id="status-title" class="text-sm font-black uppercase tracking-wide transition-all {{ $isSubmittedStatus ? 'text-emerald-700' : 'text-slate-400' }}">Status</h3>
                            <p id="status-text" class="text-lg font-black transition-all {{ $isSubmittedStatus ? 'text-emerald-600' : 'text-slate-800' }}">{{ $isSubmittedStatus ? 'Sudah Dikumpulkan' : 'Belum Dikirim' }}</p>
                        </div>
                    </div>

                    <div class="bg-white border border-slate-200 p-6 rounded-[2rem] flex items-center gap-4 shadow-sm" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-400 uppercase tracking-wide">Nilai Dosen</h3>
                            <p class="text-lg font-bold text-slate-800">{{ isset($submission) && $submission->nilai !== null ? $submission->nilai : '--' }} / {{ $assignment->poin }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-sm relative overflow-hidden" data-aos="fade-up" data-aos-duration="600">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                        <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Instruksi Tugas</h3>
                        <button onclick="navigasiKe(5)" class="w-fit flex items-center gap-2 bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg text-[9px] font-bold uppercase tracking-widest hover:bg-blue-100 transition-all cursor-pointer active:scale-95 group border border-blue-100">
                            <span class="bg-blue-500 text-white w-4 h-4 rounded-md flex items-center justify-center font-black group-hover:bg-blue-600">5</span> Dengar Soal
                        </button>
                    </div>
                    
                    <div id="soal-text" class="prose prose-slate text-sm text-slate-600 leading-relaxed font-medium max-w-none mb-8 whitespace-pre-wrap">{{ $assignment->deskripsi }}</div>

                    @if($assignment->file_path)
                    <div class="mb-8 p-4 bg-slate-50 border border-slate-200 rounded-2xl">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 block">Lampiran Dosen</p>
                        <a href="{{ asset('storage/'.$assignment->file_path) }}" target="_blank" class="flex items-center gap-3 group">
                            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </div>
                            <span class="text-sm font-bold text-blue-600 group-hover:text-blue-800 underline-offset-2 group-hover:underline">Download Dokumen Tugas</span>
                        </a>
                    </div>
                    @endif

                    <div id="submission-success" class="{{ $isSubmittedStatus ? 'block' : 'hidden' }} fade-in mt-8 border-2 border-emerald-400 bg-emerald-50/50 rounded-3xl p-6 sm:p-8 relative overflow-hidden shadow-sm">
                        <div class="absolute top-0 right-0 bg-emerald-500 text-white px-4 py-1.5 rounded-bl-xl font-bold text-[10px] uppercase tracking-widest shadow-sm">
                            Berhasil Diserahkan
                        </div>

                        <div class="flex items-center gap-3 mb-6 border-b border-emerald-200/60 pb-4">
                            <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-emerald-900 tracking-tight">Jawaban Anda</h3>
                                <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest mt-0.5">Tugas ini telah berhasil dikumpulkan</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @if(isset($submission) && $submission->file_path)
                            <div>
                                <label class="text-[10px] font-bold text-emerald-700 uppercase tracking-widest mb-2 block flex items-center gap-2">File Lampiran Jawaban</label>
                                <div class="flex items-center gap-4 p-4 rounded-2xl border border-emerald-200 bg-white shadow-sm group">
                                    <div class="w-12 h-14 bg-red-50 text-red-500 rounded-xl flex items-center justify-center shrink-0 border border-red-100"><span class="text-[10px] font-black uppercase">FILE</span></div>
                                    <div class="flex-1"><h4 class="text-sm font-bold text-slate-800">Lampiran Jawaban Tersimpan</h4></div>
                                </div>
                            </div>
                            @endif

                            @if(isset($submission) && $submission->text_submission)
                            <div>
                                <label class="text-[10px] font-bold text-emerald-700 uppercase tracking-widest mb-2 block">Teks Jawaban Anda</label>
                                <div class="w-full bg-white border border-emerald-200 rounded-2xl p-5 text-sm font-medium text-slate-700 whitespace-pre-wrap leading-relaxed">{{ $submission->text_submission }}</div>
                            </div>
                            @endif

                            @if(isset($submission) && $submission->voice_submission)
                            <div>
                                <label class="text-[10px] font-bold text-emerald-700 uppercase tracking-widest mb-2 block">Voice Note Jawaban Anda</label>
                                <div class="w-full bg-white border border-emerald-200 rounded-2xl p-4 flex items-center">
                                    <audio controls class="w-full h-10"><source src="{{ asset('storage/'.$submission->voice_submission) }}"></audio>
                                </div>
                            </div>
                            @endif
                        </div>

                        @if(now() <= $assignment->deadline)
                        <div class="mt-8 pt-6 border-t border-emerald-200/60 flex justify-end">
                            <button onclick="navigasiKe(9)" class="bg-white border-2 border-emerald-300 text-emerald-700 font-bold text-xs uppercase tracking-widest hover:bg-emerald-100 transition-all flex items-center gap-2 px-6 py-3 rounded-xl cursor-pointer active:scale-95 group shadow-sm">
                                <span class="bg-emerald-500 text-white w-5 h-5 rounded flex items-center justify-center text-[10px] shadow-sm">9</span> Kirim Ulang Jawaban
                            </button>
                        </div>
                        @endif
                    </div>

                    <div id="submission-form" class="{{ $isSubmittedStatus ? 'hidden' : 'block' }}">
                        <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight mb-6 mt-8 border-t border-slate-100 pt-8">Form Pengumpulan</h3>
                        @if(now() <= $assignment->deadline)
                        <form action="{{ route('mahasiswa.assignment.store', ['kelas' => $kelas->id, 'assignment' => $assignment->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                
                                <div>
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-2">
                                        <span class="bg-slate-200 text-slate-600 w-4 h-4 rounded flex items-center justify-center">6</span> Upload File
                                    </label>
                                    <div onclick="document.getElementById('file-upload').click()" class="border-2 border-dashed border-slate-300 rounded-2xl p-6 text-center cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all group bg-slate-50 active:scale-[0.99] h-32 flex flex-col justify-center">
                                        <input type="file" name="file" id="file-upload" class="hidden" onchange="handleFileSelect(this)" />
                                        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        </div>
                                        <span id="file-label" class="text-xs font-bold text-slate-700 group-hover:text-blue-700 block line-clamp-1">Klik Pilih File</span>
                                    </div>
                                </div>

                                <div class="flex flex-col h-full">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center justify-between">
                                        <span class="flex items-center gap-2"><span class="bg-slate-200 text-slate-600 w-4 h-4 rounded flex items-center justify-center">7</span> Ketik Jawaban</span>
                                        <span id="typing-indicator" class="hidden text-red-500 animate-pulse text-[9px]">Mendengarkan...</span>
                                    </label>
                                    <textarea name="text_submission" id="text-submission" class="flex-1 w-full bg-slate-50 border border-slate-300 rounded-2xl p-4 text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-400 focus:bg-white transition-all resize-none min-h-[8rem]" placeholder="Sebut 7 untuk mendikte..."></textarea>
                                </div>

                                <div class="flex flex-col h-full">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center justify-between">
                                        <span class="flex items-center gap-2"><span class="bg-slate-200 text-slate-600 w-4 h-4 rounded flex items-center justify-center">8</span> Rekam Suara Tugas</span>
                                        <span id="assignment-record-timer" class="hidden text-red-500 font-mono text-[9px] animate-pulse">00:00</span>
                                    </label>
                                    <div class="flex-1 w-full bg-slate-50 border border-slate-300 rounded-2xl p-4 flex flex-col items-center justify-center gap-2 transition-all min-h-[8rem]" id="assignmentVoiceBox">
                                        <input type="file" name="voice_submission" id="assignmentVoiceInput" accept="audio/webm" class="hidden">
                                        <button type="button" id="btnAssignmentRecord" class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 hover:scale-110 transition-all shadow-md">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"></path></svg>
                                        </button>
                                        <span id="assignmentVoiceLabel" class="text-xs font-bold text-slate-500 text-center">Sebut 8 untuk merekam</span>
                                        <button type="button" id="btnCancelAssignmentVoice" class="hidden text-[10px] font-bold text-red-500 hover:underline mt-1">Batal Rekam</button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" id="btnSubmitForm" class="w-full bg-blue-600 text-white rounded-xl py-4 font-black text-xs uppercase tracking-[0.2em] shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all hover:scale-[1.01] active:scale-95 flex items-center justify-center gap-3 relative overflow-hidden">
                                <span class="bg-white/20 text-white w-6 h-6 rounded flex items-center justify-center font-black text-[10px]">9</span>
                                <svg class="w-5 h-5 group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                <span class="text-sm">Kirim Tugas Sekarang</span>
                            </button>
                        </form>
                        @else
                            <div class="bg-red-50 text-red-600 p-4 rounded-xl border border-red-200 text-center text-sm font-bold shadow-sm">Waktu pengumpulan sudah habis.</div>
                        @endif
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-duration="600" data-aos-delay="200" class="bg-white rounded-[2rem] sm:rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden flex flex-col h-[600px] mt-8">
                    <div class="p-5 sm:p-6 md:px-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 z-10">
                        <div>
                            <h3 class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-tight">Diskusi Tugas Privat</h3>
                            <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Tanya jawab terkait tugas ini langsung dengan Dosen</p>
                        </div>
                        <button onclick="navigasiKe(14)" class="text-[9px] font-bold bg-blue-100 text-blue-700 px-3 py-1.5 rounded-full flex items-center gap-1.5 cursor-pointer hover:bg-blue-200 transition-colors">
                            Sebut "14" Baca Chat
                        </button>
                    </div>

                    <div id="chatContainer" class="flex-1 p-4 sm:p-6 flex flex-col gap-6 overflow-y-auto custom-scrollbar bg-slate-50/30">
                        @php
                            $pesanTugas = (isset($submission) && method_exists($submission, 'messages')) ? $submission->messages()->orderBy('created_at', 'asc')->get() : collect();
                        @endphp
                        
                        @forelse($pesanTugas as $diskusi)
                            @php
                                $loggedInId = Auth::guard('mahasiswa')->id() ?? 0;
                                $isMe = ($diskusi->from === 'mahasiswa' || strtolower($diskusi->sender_type ?? '') === 'mahasiswa');
                                $isDosen = ($diskusi->from === 'dosen' || strtolower($diskusi->sender_type ?? '') === 'dosen');
                                
                                $namaDosen = $kelas->dosen->nama ?? 'Dosen';
                                $fotoDosenRaw = $kelas->dosen->foto ?? null; 
                                
                                $namaMahasiswa = Auth::guard('mahasiswa')->user()->nama ?? 'Anda';
                                $fotoMahasiswaRaw = Auth::guard('mahasiswa')->user()->foto_profil ?? Auth::guard('mahasiswa')->user()->foto ?? null; 

                                $labelTeks = $isMe ? 'Anda' : $namaDosen;
                                
                                $fallbackMhs = 'https://ui-avatars.com/api/?name='.urlencode($namaMahasiswa).'&background=2563eb&color=fff';
                                $fallbackDsn = 'https://ui-avatars.com/api/?name='.urlencode($namaDosen).'&background=f59e0b&color=fff';
                                
                                if ($isMe) {
                                    $fotoProfil = $fotoMahasiswaRaw ? asset('storage/' . $fotoMahasiswaRaw) : $fallbackMhs;
                                    $fotoError = $fallbackMhs;
                                } else {
                                    $fotoProfil = $fotoDosenRaw ? asset('storage/' . $fotoDosenRaw) : $fallbackDsn;
                                    $fotoError = $fallbackDsn;
                                }
                                
                                $bgChat = $isMe ? 'bg-blue-600 text-white rounded-tr-none border-blue-700' : 'bg-white text-slate-800 rounded-tl-none border-slate-200';
                            @endphp
                            
                            <div id="msg-{{ $diskusi->id }}" class="flex {{ $isMe ? 'justify-end' : 'justify-start' }} fade-in chat-bubble">
                                <div class="flex gap-2 md:gap-3 items-end max-w-[90%] md:max-w-[70%] {{ $isMe ? 'flex-row-reverse' : '' }}">
                                    <img src="{{ $fotoProfil }}" onerror="this.src='{{ $fotoError }}'" class="w-8 h-8 rounded-full shrink-0 shadow-sm object-cover border border-slate-100" />
                                    
                                    <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }}">
                                        <p class="text-[8px] md:text-[9px] font-bold mb-1 px-1 {{ $isDosen ? 'text-orange-500' : 'text-slate-400' }} sender-name">
                                            {{ $labelTeks }}
                                        </p>
                                        
                                        <div class="p-3 rounded-2xl shadow-sm border text-xs sm:text-[13px] {{ $bgChat }}">
                                            @if($diskusi->body)
                                                <p class="whitespace-pre-wrap break-words leading-relaxed message-text">{{ $diskusi->body }}</p>
                                            @endif
                                            @if(isset($diskusi->image) && $diskusi->image)
                                                <img src="{{ asset('storage/'.$diskusi->image) }}" onerror="this.style.display='none'" class="mt-2 rounded-xl max-w-full border {{ $isMe ? 'border-white/20' : 'border-slate-200' }}">
                                            @endif
                                            @if(isset($diskusi->voice) && $diskusi->voice)
                                                <div class="mt-2 flex items-center gap-2 {{ $isMe ? 'bg-white/20 border-white/30' : 'bg-slate-50 border-slate-200' }} p-1.5 rounded-xl border w-[160px]">
                                                    <button type="button" onclick="togglePlay('wave-{{ $diskusi->id }}')" id="btn-wave-{{ $diskusi->id }}" class="w-6 h-6 shrink-0 flex items-center justify-center rounded-full {{ $isMe ? 'bg-white text-blue-600' : 'bg-blue-600 text-white' }} shadow text-[9px]">▶</button>
                                                    <div id="wave-{{ $diskusi->id }}" class="flex-1 h-4" data-audio="{{ asset('storage/' . $diskusi->voice) }}"></div>
                                                </div>
                                            @endif
                                        </div>
                                        <p class="text-[8px] mt-1.5 px-1 font-bold text-slate-400">{{ $diskusi->created_at->format('H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div id="emptyChat" class="h-full flex flex-col items-center justify-center text-center opacity-70">
                                <div class="w-14 h-14 bg-blue-50 text-blue-400 rounded-full flex items-center justify-center mb-3 border border-blue-100">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                </div>
                                <p class="text-sm text-slate-600 font-bold">Belum ada diskusi.</p>
                                <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">Sebut 10 untuk mendikte pesan ke dosen Anda.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="p-3 sm:p-4 border-t border-slate-100 bg-white shrink-0 relative z-20 shadow-[0_-4px_10px_rgba(0,0,0,0.02)]">
                        <div id="imagePreviewContainer" class="hidden mb-3 relative p-2 bg-slate-50 border border-slate-200 rounded-2xl w-fit">
                            <img id="imagePreviewElement" src="" class="h-20 sm:h-24 w-auto object-cover rounded-xl shadow-sm border border-slate-200">
                            <button type="button" onclick="cancelImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center font-bold text-xs shadow-lg hover:bg-red-600 hover:scale-110 transition-transform">✕</button>
                        </div>

                        <form id="chatForm" action="{{ route('mahasiswa.assignment.message.store', [ 'kelas' => $kelas->id, 'assignment' => $assignment->id ]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="image" id="imageInput" accept="image/*" class="hidden" onchange="previewImage(this)">
                            <input type="file" name="voice" id="voiceInput" accept="audio/webm" class="hidden">

                            <div class="relative flex items-center gap-2 sm:gap-3 bg-slate-50 p-2 sm:p-3 rounded-[1.25rem] sm:rounded-2xl border border-slate-200 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100 transition-all shadow-sm w-full">
                                
                                <div id="uploadImageContainer" class="relative shrink-0 hidden md:block">
                                    <button type="button" onclick="document.getElementById('imageInput').click()" id="btnUploadImage" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-white transition-all cursor-pointer shadow-sm border border-transparent hover:border-blue-100">
                                       <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </button>
                                    <span class="absolute -top-1.5 -right-1.5 bg-slate-900 text-white text-[8px] font-black px-1.5 py-0.5 rounded-md shadow-sm border border-white">11</span>
                                </div>

                                <div id="normalInputWrapper" class="flex-1 min-w-0 relative flex items-center">
                                    <div class="absolute left-2 text-[10px] font-black text-white bg-slate-900 px-1.5 py-0.5 rounded-md shadow-sm hidden md:block z-10">10</div>
                                    <input type="text" name="message" id="messageInput" placeholder="Sebutkan 10 untuk ketik chat..." autocomplete="off" class="w-full bg-transparent text-xs sm:text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none transition-all py-1.5 pl-1 md:pl-8" />
                                    
                                    <button type="button" id="cancelVoiceToTextBtn" onclick="batalKetikSuara()" class="hidden absolute right-1 sm:right-2 text-[10px] font-black uppercase text-white bg-red-500 hover:bg-red-600 px-2.5 py-1.5 rounded-lg shadow-sm transition-all cursor-pointer z-20">Batal Dikte ✕</button>
                                    <button type="button" id="cancelVoiceBtn" onclick="batalRekamChat()" class="hidden absolute right-1 sm:right-2 text-[10px] font-black uppercase text-white bg-red-500 hover:bg-red-600 px-2.5 py-1.5 rounded-lg shadow-sm transition-all cursor-pointer z-20">Batal Suara ✕</button>
                                </div>

                                <div id="recordingWrapper" class="hidden flex-1 items-center justify-between px-2">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 sm:w-2.5 sm:h-2.5 bg-red-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(239,68,68,0.8)]"></span>
                                        <span class="text-[10px] sm:text-xs font-bold text-red-500 font-mono tracking-wider" id="recordTimer">00:00</span>
                                        <div class="recording-wave flex items-center gap-1 h-5 sm:h-6 ml-1 sm:ml-2">
                                            <div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div>
                                        </div>
                                    </div>
                                    <button type="button" id="cancelRecordBtn" onclick="batalRekamChat()" class="text-[9px] sm:text-[10px] font-black uppercase text-slate-400 hover:text-red-500 px-1 sm:px-2 transition-colors cursor-pointer">Batal</button>
                                </div>

                                <div id="recordBtnContainer" class="relative shrink-0">
                                    <button type="button" id="recordBtn" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all cursor-pointer border border-transparent hover:border-red-100 shadow-sm">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"></path></svg>
                                    </button>
                                    <span class="absolute -top-1.5 -right-1.5 bg-slate-900 text-white text-[8px] font-black px-1.5 py-0.5 rounded-md shadow-sm border border-white">12</span>
                                </div>

                                <div class="relative shrink-0">
                                    <button type="submit" id="sendChatBtn" class="w-10 h-9 sm:w-12 sm:h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-transform transform hover:scale-105 active:scale-95 shadow-md shadow-blue-200 cursor-pointer">
                                        <span id="sendIcon"><svg class="w-4 h-4 sm:w-5 sm:h-5 transform rotate-90 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg></span>
                                        <span id="sendLoading" class="hidden"><svg class="w-4 h-4 sm:w-5 sm:h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg></span>
                                    </button>
                                    <span class="absolute -top-1.5 -right-1.5 bg-slate-900 text-white text-[8px] font-black px-1.5 py-0.5 rounded-md shadow-sm border border-white z-10">13</span>
                                </div>
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
            const synth = window.speechSynthesis;
            const SpeechRec = window.webkitSpeechRecognition || window.SpeechRecognition;

            let rec = null; let dikteChatRec = null; let dikteTugasRec = null;
            let isDictatingChat = false; let isDictatingTugas = false; 
            let isSubmitted = {{ $isSubmittedStatus ? 'true' : 'false' }};
            let interval; let jedaKetikTimer = null; let menungguKonfirmasiKirim = false;

            const dbFotoMahasiswa = "{{ Auth::guard('mahasiswa')->user()->foto_profil ?? Auth::guard('mahasiswa')->user()->foto ?? '' }}";
            const myRealName = "{{ Auth::guard('mahasiswa')->user()->nama ?? 'Anda' }}";
            const fallbackAvatar = `https://ui-avatars.com/api/?name=${encodeURIComponent(myRealName)}&background=2563eb&color=fff`;
            const myAvatarAJAX = dbFotoMahasiswa ? `/storage/${dbFotoMahasiswa}` : fallbackAvatar;

            if (SpeechRec) {
                rec = new SpeechRec(); rec.lang = "id-ID"; rec.continuous = true;
                dikteChatRec = new SpeechRec(); dikteChatRec.lang = "id-ID"; dikteChatRec.continuous = false;
                dikteTugasRec = new SpeechRec(); dikteTugasRec.lang = "id-ID"; dikteTugasRec.continuous = false;
            }

            function setWave(active) {
                const waveBars = document.querySelectorAll(".wave-bar");
                if (waveBars.length > 0) {
                    waveBars.forEach((bar) => { bar.style.height = active ? `${Math.floor(Math.random() * 12) + 4}px` : "4px"; });
                }
            }

            function bicara(teks, callback) {
                synth.cancel();
                const utter = new SpeechSynthesisUtterance(teks);
                utter.lang = "id-ID";
                utter.rate = parseFloat(localStorage.getItem("speechRate")) || 1.0;
                utter.onstart = () => { if (statusDesc) statusDesc.innerText = "BERBICARA..."; interval = setInterval(() => setWave(true), 150); };
                utter.onend = () => { if (statusDesc) statusDesc.innerText = "MENDENGARKAN..."; clearInterval(interval); setWave(false); if (callback) callback(); };
                synth.speak(utter);
            }

            function getPanduanUtama() {
                const judul = "{{ $assignment->judul }}";
                const tgl = "{{ \Carbon\Carbon::parse($assignment->deadline)->translatedFormat('d F Y, jam H:i') }}";
                let teks = `Halaman Detail Tugas: ${judul}. Batas waktu pengumpulan: ${tgl}. `;

                if (isSubmitted) {
                    teks += `Status: Sudah dikumpulkan. Jika ingin mengulang pengumpulan tugas, sebutkan angka sembilan. `;
                } else {
                    teks += `Status: Belum dikumpulkan. Sebutkan angka lima untuk membaca instruksi soal. Enam untuk upload file jawaban. Tujuh untuk mengetik jawaban langsung. Delapan untuk merekam jawaban suara. Dan sembilan untuk mengirim tugas. `;
                }

                teks += `Untuk diskusi tugas dengan dosen, sebutkan angka sepuluh untuk ketik pesan. Sebelas upload gambar. Dua belas rekam suara. Tiga belas kirim pesan. Empat belas baca riwayat chat. `;
                teks += `Sebut angka satu sampai empat untuk berpindah menu. Nol untuk kembali. Katakan Ulang, untuk mendengarkan panduan ini lagi.`;
                return teks;
            }

            function kirimUlang() {
                isSubmitted = false;
                document.getElementById("submission-success").classList.add("hidden");
                document.getElementById("submission-form").classList.remove("hidden");
                document.getElementById("status-text").innerText = "Belum Dikirim";
                
                const stCard = document.getElementById("status-card");
                const stIcon = document.getElementById("status-icon");
                const stTitle = document.getElementById("status-title");
                
                stCard.classList.remove('border-emerald-300', 'bg-emerald-50/40', 'shadow-emerald-100');
                stCard.classList.add('border-slate-200', 'shadow-sm');
                
                stIcon.classList.remove('bg-emerald-500', 'text-white', 'shadow-md');
                stIcon.classList.add('bg-slate-100', 'text-slate-500');
                stIcon.innerHTML = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>`;
                
                stTitle.classList.remove('text-emerald-700');
                stTitle.classList.add('text-slate-400');
                
                document.getElementById("status-text").classList.remove('text-emerald-600');
                document.getElementById("status-text").classList.add('text-slate-800');

                bicara("Silakan pilih file, dikte teks, atau rekam suara untuk memperbarui jawaban tugas Anda.");
            }

            function handleFileSelect(input) {
                if (input.files && input.files[0]) {
                    document.getElementById("file-label").innerText = "Terpilih: " + input.files[0].name;
                    document.getElementById("file-label").classList.add('text-blue-600');
                    bicara("File tugas siap dilampirkan. Sebutkan sembilan untuk mengirim tugas.");
                }
            }

            function previewImage(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('imagePreviewElement').src = e.target.result;
                        document.getElementById('imagePreviewContainer').classList.remove('hidden');
                        bicara("Gambar dipilih. Sebut tiga belas untuk mengirim pesan.", () => { rec.start(); });
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Dideklarasikan ke window agar bisa dipanggil dari HTML onclick
            window.cancelImage = function() {
                document.getElementById('imageInput').value = '';
                document.getElementById('imagePreviewContainer').classList.add('hidden');
                document.getElementById('imagePreviewElement').src = '';
            };

            const btnAssignmentRecord = document.getElementById('btnAssignmentRecord');
            const assignmentVoiceInput = document.getElementById('assignmentVoiceInput');
            const assignmentTimer = document.getElementById('assignment-record-timer');
            const assignmentVoiceLabel = document.getElementById('assignmentVoiceLabel');
            const btnCancelAssignmentVoice = document.getElementById('btnCancelAssignmentVoice');

            let tugasMediaRecorder, tugasAudioChunks = [], tugasRecordInterval, tugasRecordSeconds = 0;

            function updateTugasTimer() {
                tugasRecordSeconds++;
                const m = String(Math.floor(tugasRecordSeconds / 60)).padStart(2, '0');
                const s = String(tugasRecordSeconds % 60).padStart(2, '0');
                assignmentTimer.innerText = `${m}:${s}`;
            }

            if(btnAssignmentRecord) {
                btnAssignmentRecord.addEventListener('click', async () => {
                    if (!tugasMediaRecorder || tugasMediaRecorder.state === "inactive") {
                        try {
                            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                            tugasMediaRecorder = new MediaRecorder(stream);
                            tugasMediaRecorder.start();
                            
                            btnAssignmentRecord.classList.remove('bg-blue-100', 'text-blue-600');
                            btnAssignmentRecord.classList.add('bg-red-500', 'text-white', 'animate-pulse');
                            assignmentVoiceLabel.innerText = "Merekam suara...";
                            assignmentVoiceLabel.classList.add('text-red-500');
                            assignmentTimer.classList.remove('hidden');
                            btnCancelAssignmentVoice.classList.add('hidden');
                            
                            tugasRecordSeconds = 0; assignmentTimer.innerText = "00:00";
                            tugasRecordInterval = setInterval(updateTugasTimer, 1000);
                            tugasAudioChunks = []; tugasMediaRecorder.ondataavailable = e => { tugasAudioChunks.push(e.data); };
                        } catch(err) { alert("Mikrofon tidak diizinkan!"); }
                    } else {
                        tugasMediaRecorder.onstop = () => {
                            const file = new File([new Blob(tugasAudioChunks, { type: 'audio/webm' })], "tugas_voice.webm", { type: "audio/webm" });
                            const dt = new DataTransfer(); dt.items.add(file); assignmentVoiceInput.files = dt.files;
                            
                            btnAssignmentRecord.classList.add('bg-blue-100', 'text-blue-600');
                            btnAssignmentRecord.classList.remove('bg-red-500', 'text-white', 'animate-pulse');
                            assignmentTimer.classList.add('hidden');
                            assignmentVoiceLabel.innerText = "▶ ılıılı Voice Note Siap";
                            assignmentVoiceLabel.classList.remove('text-red-500');
                            assignmentVoiceLabel.classList.add('text-blue-600');
                            btnCancelAssignmentVoice.classList.remove('hidden');
                        };
                        tugasMediaRecorder.stop(); clearInterval(tugasRecordInterval);
                    }
                });

                btnCancelAssignmentVoice.addEventListener('click', () => {
                    assignmentVoiceInput.value = '';
                    assignmentVoiceLabel.innerText = "Sebut 8 untuk merekam";
                    assignmentVoiceLabel.classList.remove('text-blue-600');
                    btnCancelAssignmentVoice.classList.add('hidden');
                });
            }

            // Rekam Audio Diskusi
            const recordBtn = document.getElementById('recordBtn');
            const voiceInput = document.getElementById('voiceInput');
            const messageInput = document.getElementById('messageInput');
            const normalInputWrapper = document.getElementById('normalInputWrapper');
            const recordingWrapper = document.getElementById('recordingWrapper');
            const recordTimer = document.getElementById('recordTimer');
            const cancelVoiceBtn = document.getElementById('cancelVoiceBtn');
            let chatMediaRecorder, chatAudioChunks = [], chatRecordInterval, chatRecordSeconds = 0;

            function updateChatTimer() {
                chatRecordSeconds++;
                const m = String(Math.floor(chatRecordSeconds / 60)).padStart(2, '0');
                const s = String(chatRecordSeconds % 60).padStart(2, '0');
                recordTimer.innerText = `${m}:${s}`;
            }

            if(recordBtn) {
                recordBtn.addEventListener('click', async () => {
                    if (!chatMediaRecorder || chatMediaRecorder.state === "inactive") {
                        try {
                            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                            chatMediaRecorder = new MediaRecorder(stream);
                            chatMediaRecorder.start();
                            
                            normalInputWrapper.classList.add('hidden');
                            recordingWrapper.classList.remove('hidden');
                            recordingWrapper.classList.add('flex');
                            
                            chatRecordSeconds = 0; recordTimer.innerText = "00:00";
                            chatRecordInterval = setInterval(updateChatTimer, 1000);
                            chatAudioChunks = []; chatMediaRecorder.ondataavailable = e => { chatAudioChunks.push(e.data); };
                        } catch(err) { alert("Akses mikrofon ditolak!"); }
                    } else {
                        chatMediaRecorder.onstop = () => {
                            const file = new File([new Blob(chatAudioChunks, { type: 'audio/webm' })], "chat_voice.webm", { type: "audio/webm" });
                            const dt = new DataTransfer(); dt.items.add(file); voiceInput.files = dt.files;
                            
                            recordingWrapper.classList.add('hidden');
                            recordingWrapper.classList.remove('flex');
                            normalInputWrapper.classList.remove('hidden');
                            
                            messageInput.value = "Voice note siap dikirim.";
                            messageInput.disabled = true;
                            messageInput.classList.add('text-blue-600', 'font-bold', 'bg-blue-100/50', 'rounded-xl', 'px-4');
                            messageInput.classList.remove('bg-transparent', 'pl-1', 'md:pl-8');
                            
                            cancelVoiceBtn.classList.remove('hidden');
                            document.getElementById('uploadImageContainer').classList.add('hidden');
                            recordBtn.classList.add('hidden');
                        };
                        chatMediaRecorder.stop(); clearInterval(chatRecordInterval);
                    }
                });
            }

            window.batalKetikSuara = function() {
                isDictatingChat = false; menungguKonfirmasiKirim = false; clearTimeout(jedaKetikTimer);
                document.getElementById('normalInputWrapper').classList.remove('dictating-active', 'confirming-active');
                document.getElementById('cancelVoiceToTextBtn').classList.add('hidden');
                document.getElementById("messageInput").value = "";
                document.getElementById("messageInput").placeholder = "Sebutkan 10 untuk ketik chat...";
            }

            window.batalRekamChat = function() {
                if(chatMediaRecorder && chatMediaRecorder.state !== "inactive") {
                    chatMediaRecorder.stop(); clearInterval(chatRecordInterval);
                }
                voiceInput.value = '';
                recordingWrapper.classList.add('hidden');
                recordingWrapper.classList.remove('flex');
                normalInputWrapper.classList.remove('hidden');
                
                messageInput.value = "";
                messageInput.disabled = false;
                messageInput.placeholder = "Sebutkan 10 untuk ketik chat...";
                messageInput.classList.remove('text-blue-600', 'font-bold', 'bg-blue-100/50', 'rounded-xl', 'px-4');
                messageInput.classList.add('bg-transparent', 'pl-1', 'md:pl-8');
                
                cancelVoiceBtn.classList.add('hidden');
                document.getElementById('uploadImageContainer').classList.remove('hidden');
                recordBtn.classList.remove('hidden');
            }

            function batalDikteTugas() {
                if (isDictatingTugas) dikteTugasRec.stop();
                isDictatingTugas = false;
                document.getElementById("typing-indicator").classList.add("hidden");
                document.getElementById("text-submission").placeholder = "Sebut 7 untuk mendikte jawaban...";
                bicara("Dikte teks tugas dibatalkan.", () => rec.start());
            }

            function navigasiKe(nomor) {
                if (isDictatingChat || isDictatingTugas) return;
                let teks = ""; let tujuan = "";

                if (nomor === 0) { tujuan = "{{ route('course.assignments', $kelas->id) }}"; teks = "Kembali ke Daftar Tugas."; }
                else if (nomor === 1) { tujuan = "{{ route('course.detail', $kelas->id) }}"; teks = "Membuka Pembelajaran."; }
                else if (nomor === 2) { tujuan = "{{ route('course.attendance', $kelas->courseSessions->first()->id ?? 0) }}"; teks = "Membuka Presensi."; }
                else if (nomor === 3) { tujuan = "{{ route('course.assignments', $kelas->id) }}"; teks = "Membuka Penugasan."; }
                else if (nomor === 4) { tujuan = "{{ route('course.members', $kelas->id) }}"; teks = "Membuka Anggota."; }
                else if (nomor === 5) { teks = "Instruksi Tugas: " + document.getElementById("soal-text").innerText; }
                else if (nomor === 6) {
                    if (!isSubmitted) { document.getElementById("file-upload").click(); teks = "Membuka file explorer."; }
                    else { teks = "Tugas sudah dikumpulkan. Sebut sembilan untuk kirim ulang."; }
                }
                else if (nomor === 7) {
                    if (!isSubmitted) {
                        rec.stop(); isDictatingTugas = true;
                        document.getElementById("typing-indicator").classList.remove("hidden");
                        document.getElementById("text-submission").placeholder = "Mendengarkan jawaban tugas Anda...";
                        teks = "Silakan ucapkan teks jawaban tugas Anda.";
                        bicara(teks, () => { dikteTugasRec.start(); }); return;
                    } else { teks = "Tugas sudah dikumpulkan. Sebut sembilan untuk kirim ulang."; }
                }
                else if (nomor === 8) {
                    if (!isSubmitted) {
                        if (!tugasMediaRecorder || tugasMediaRecorder.state === "inactive") {
                            teks = "Merekam suara tugas. Bicara setelah bip. Sebut Selesai untuk berhenti.";
                            bicara(teks, () => { btnAssignmentRecord.click(); }); return;
                        } else {
                            btnAssignmentRecord.click(); teks = "Suara disimpan. Sebut sembilan untuk mengirim tugas.";
                        }
                    } else { teks = "Tugas sudah dikumpulkan. Sebut sembilan untuk kirim ulang."; }
                }
                else if (nomor === 9) {
                    if (!isSubmitted) {
                        let f = document.getElementById('file-upload').files.length;
                        let t = document.getElementById('text-submission').value.trim();
                        let v = document.getElementById('assignmentVoiceInput').files.length;
                        if (f > 0 || t !== "" || v > 0) {
                            teks = "Sedang memproses dan mengirim tugas Anda. Mohon tunggu...";
                            bicara(teks, () => { document.getElementById('btnSubmitForm').click(); });
                        } else {
                            teks = "Maaf, tugas masih kosong. Sebut angka 6, 7, atau 8 untuk mengisi tugas terlebih dahulu.";
                        }
                    } else { kirimUlang(); return; }
                }
                else if (nomor === 10) {
                    rec.stop(); isDictatingChat = true; menungguKonfirmasiKirim = false;
                    document.getElementById('normalInputWrapper').classList.add('dictating-active');
                    document.getElementById('cancelVoiceToTextBtn').classList.remove('hidden');
                    document.getElementById('messageInput').value = "";
                    document.getElementById('messageInput').placeholder = "Mendengarkan teks...";
                    teks = "Silakan bicara pesan diskusi untuk dosen.";
                    bicara(teks, () => { dikteChatRec.start(); }); return;
                }
                else if (nomor === 11) {
                    teks = "Membuka galeri. Pilih gambar, lalu sebut tiga belas untuk kirim.";
                    bicara(teks, () => { document.getElementById('imageInput').click(); mulaiMendengar(); }); return;
                }
                else if (nomor === 12) {
                    if (!chatMediaRecorder || chatMediaRecorder.state === "inactive") {
                        teks = "Merekam pesan chat. Bicara setelah bip. Sebut Selesai untuk berhenti.";
                        bicara(teks, () => { document.getElementById('recordBtn').click(); }); return;
                    } else {
                        document.getElementById('recordBtn').click(); teks = "Suara chat disimpan. Sebut tiga belas untuk mengirim pesan.";
                    }
                }
                else if (nomor === 13) {
                    window.batalKetikSuara();
                    
                    const textVal = document.getElementById("messageInput").value.trim();
                    const imgVal = document.getElementById("imageInput").files.length;
                    const voiceVal = document.getElementById("voiceInput").files.length;

                    // Mengirim voice note, biarpun pesannya bilang "Voice note siap dikirim."
                    if (textVal !== "" || imgVal > 0 || voiceVal > 0 || textVal === "Voice note siap dikirim.") {
                        document.getElementById("sendChatBtn").click(); return; 
                    } else { teks = "Pesan chat kosong."; }
                }
                else if (nomor === 14) {
                    let chats = document.querySelectorAll('#chatContainer .chat-bubble-new, #chatContainer .chat-bubble');
                    if(chats.length === 0) { teks = "Belum ada riwayat diskusi."; } 
                    else {
                        let textToRead = "Membacakan riwayat pesan diskusi. ";
                        chats.forEach(chat => {
                            let senderEl = chat.querySelector('.sender-name');
                            let sender = senderEl ? senderEl.innerText.replace('Dosen', '').trim() : "Seseorang";
                            let msgElement = chat.querySelector('.message-text');
                            let msg = msgElement ? msgElement.innerText.trim() : "Mengirim media lampiran";
                            textToRead += sender + " bilang: " + msg + ". ";
                        });
                        teks = textToRead + " Selesai membacakan diskusi.";
                        bicara(teks, () => { mulaiMendengar(); }); return;
                    }
                }

                if (teks !== "") {
                    bicara(teks, () => {
                        if (tujuan !== "" && tujuan !== "#") window.location.href = tujuan;
                        else { try { rec.start(); } catch(e) {} }
                    });
                }
            }

            function mulaiMendengar() {
                if (!rec) return;
                try {
                    rec.start();
                    rec.onresult = (event) => {
                        if (isDictatingChat || isDictatingTugas) return;
                        const hasil = event.results[event.results.length - 1][0].transcript.toLowerCase().trim();
                        
                        if (hasil.includes("ulang") || hasil.includes("panduan") || hasil.includes("bantuan")) {
                            bicara(getPanduanUtama(), () => { mulaiMendengar(); }); return;
                        }

                        const kataAngka = {
                            "nol": 0, "satu": 1, "dua": 2, "tiga": 3, "empat": 4, "lima": 5, 
                            "enam": 6, "tujuh": 7, "delapan": 8, "sembilan": 9, "sepuluh": 10,
                            "sebelas": 11, "dua belas": 12, "tiga belas": 13, "empat belas": 14
                        };

                        let terdeteksiAngka = null;
                        const regexAngka = hasil.match(/\d+/);

                        if (regexAngka) { terdeteksiAngka = parseInt(regexAngka[0]); } 
                        else { for (let kata in kataAngka) { if (hasil.includes(kata)) { terdeteksiAngka = kataAngka[kata]; break; } } }

                        if (terdeteksiAngka !== null) { navigasiKe(terdeteksiAngka); }
                        else if (hasil.includes("selesai")) {
                            if(tugasMediaRecorder && tugasMediaRecorder.state !== "inactive") navigasiKe(10); // Stop tugas record
                            if(chatMediaRecorder && chatMediaRecorder.state !== "inactive") navigasiKe(12); // Stop chat record
                        }
                    };
                    rec.onend = () => { if (!isDictatingChat && !isDictatingTugas) rec.start(); };
                } catch (e) { console.error("Error recognition:", e); }
            }

            // Dictation for Chat
            if(dikteChatRec) {
                dikteChatRec.onresult = (event) => {
                    if (isDictatingChat) {
                        const inputChat = document.getElementById("messageInput");
                        inputChat.value += (inputChat.value === "" ? "" : " ") + event.results[0][0].transcript;
                        clearTimeout(jedaKetikTimer);
                        jedaKetikTimer = setTimeout(() => {
                            isDictatingChat = false; menungguKonfirmasiKirim = true;
                            document.getElementById('normalInputWrapper').classList.remove('dictating-active');
                            document.getElementById('normalInputWrapper').classList.add('confirming-active');
                            bicara(`Pesan: ${inputChat.value}. Sebutkan tiga belas untuk kirim, atau batal.`, () => { rec.start(); });
                        }, 2500); 
                    }
                };
                dikteChatRec.onerror = () => { if (isDictatingChat) { window.batalKetikSuara(); rec.start(); } };
            }

            // Dictation for Tugas
            if(dikteTugasRec) {
                dikteTugasRec.onresult = (event) => {
                    if (isDictatingTugas) {
                        const inputTugas = document.getElementById("text-submission");
                        inputTugas.value += (inputTugas.value === "" ? "" : " ") + event.results[0][0].transcript;
                        document.getElementById("typing-indicator").classList.add("hidden");
                        document.getElementById("text-submission").placeholder = "Sebut 7 untuk mendikte jawaban...";
                        bicara("Jawaban tercatat. Sebut sembilan untuk kirim tugas.", () => {
                            isDictatingTugas = false; rec.start();
                        });
                    }
                };
                dikteTugasRec.onerror = () => { if (isDictatingTugas) batalDikteTugas(); };
            }

            window.onload = () => {
                document.body.addEventListener("click", () => {}, { once: true });
                setTimeout(() => { bicara(getPanduanUtama(), () => { mulaiMendengar(); }); }, 800);
            };

            const wavesurfers = {};
            function initWaveSurfer(id, url, isMe) {
                wavesurfers[id] = WaveSurfer.create({
                    container: '#' + id, waveColor: isMe ? 'rgba(255,255,255,0.4)' : '#cbd5e1', progressColor: isMe ? '#fff' : '#2563eb',
                    height: 16, barWidth: 2, barGap: 2, cursorWidth: 0, url: url
                });
                wavesurfers[id].on('finish', () => document.getElementById('btn-'+id).innerHTML = '▶');
            }
            function togglePlay(id) {
                const ws = wavesurfers[id];
                if(ws) { ws.playPause(); document.getElementById('btn-'+id).innerHTML = ws.isPlaying() ? '⏸' : '▶'; }
            }

            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('[id^="wave-"]').forEach(el => {
                    const isMe = el.parentElement.classList.contains('bg-white/20');
                    initWaveSurfer(el.id, el.getAttribute('data-audio'), isMe);
                });
            });

            // AJAX Chat Form
            const chatForm = document.getElementById('chatForm');
            if (chatForm) {
                chatForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    // Allow text submission OR file submission
                    const msgVal = document.getElementById('messageInput').value.trim();
                    const imgFile = document.getElementById('imageInput').files.length;
                    const voiceFile = document.getElementById('voiceInput').files.length;
                    
                    if(!msgVal && !imgFile && !voiceFile) return;

                    const formData = new FormData(this);
                    
                    // Kalau pesannya cuma placeholder dari voice record, kosongin aja form datanya
                    if(msgVal === "Voice note siap dikirim.") {
                        formData.set("message", "");
                    }

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
                            this.reset(); window.cancelImage();
                            if(document.getElementById("voiceInput")) document.getElementById("voiceInput").value = '';
                            
                            const msgInp = document.getElementById('messageInput');
                            msgInp.disabled = false;
                            msgInp.placeholder = "Sebutkan 10 untuk ketik chat...";
                            msgInp.classList.remove('text-blue-600', 'font-bold', 'bg-blue-100/50', 'rounded-xl', 'px-4');
                            msgInp.classList.add('bg-transparent', 'pl-1', 'md:pl-8');
                            
                            document.getElementById('cancelVoiceBtn').classList.add('hidden');
                            if(document.getElementById('uploadImageContainer')) document.getElementById('uploadImageContainer').classList.remove('hidden');
                            
                            const recBtn = document.getElementById('recordBtn');
                            if(recBtn) {
                                recBtn.classList.remove('hidden', 'text-white', 'bg-red-500', 'animate-pulse', 'border-red-600');
                                recBtn.classList.add('text-slate-400');
                            }
                            if(document.getElementById('recordBtnContainer')) document.getElementById('recordBtnContainer').classList.remove('hidden');

                            const d = data.diskusi; 
                            if(d) {
                                let media = ''; const uid = 'wave-' + Date.now();
                                if(d.image) media += `<img src="/storage/${d.image}" onerror="this.style.display='none'" class="mt-2 rounded-xl max-w-full border border-white/20">`;
                                if(d.voice) media += `<div class="mt-2 flex items-center gap-2 bg-white/20 border-white/30 p-1.5 rounded-xl border w-[160px]"><button type="button" onclick="togglePlay('${uid}')" id="btn-${uid}" class="w-6 h-6 shrink-0 flex items-center justify-center rounded-full bg-white text-blue-600 shadow text-[9px]">▶</button><div id="${uid}" class="flex-1 h-4" data-audio="/storage/${d.voice}"></div></div>`;
                                
                                const html = `<div class="flex justify-end chat-bubble-new chat-bubble"><div class="flex gap-2 md:gap-3 items-end max-w-[90%] md:max-w-[70%] flex-row-reverse"><img src="${myAvatarAJAX}" onerror="this.src='${fallbackAvatar}'" class="w-8 h-8 md:w-9 md:h-9 rounded-full shrink-0 shadow-sm border border-slate-100 object-cover"><div class="flex flex-col items-end"><p class="text-[8px] md:text-[9px] font-bold mb-1 px-1 text-slate-400 sender-name">Anda</p><div class="p-3 md:p-4 rounded-2xl shadow-sm text-xs sm:text-[13px] bg-blue-600 text-white rounded-tr-none border border-blue-700">${d.message ? `<p class="whitespace-pre-wrap break-words leading-relaxed message-text">${d.message}</p>` : ''}${media}</div><p class="text-[8px] md:text-[9px] mt-1.5 px-1 font-bold text-slate-400">${d.time}</p></div></div></div>`;
                                
                                const box = document.getElementById('chatContainer');
                                const empty = document.getElementById('emptyChat');
                                if(empty) empty.remove();
                                
                                box.insertAdjacentHTML('beforeend', html);
                                box.scrollTop = box.scrollHeight;
                                if(d.voice) setTimeout(() => initWaveSurfer(uid, `/storage/${d.voice}`, true), 100);
                            }
                            bicara("Pesan terkirim.", () => { rec.start(); });
                        } else {
                            alert(data.error || "Gagal mengirim pesan.");
                            bicara("Maaf, pesan gagal dikirim.");
                        }
                    } catch(err) { 
                        console.log(err);
                        alert("Terjadi kesalahan sistem saat memproses balasan JSON."); 
                    } 
                    finally {
                        btn.disabled = false;
                        document.getElementById('sendLoading').classList.add('hidden');
                        document.getElementById('sendIcon').classList.remove('hidden');
                    }
                });
            }
        </script>
    </body>
</html>