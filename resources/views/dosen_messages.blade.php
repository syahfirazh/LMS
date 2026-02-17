<!DOCTYPE html>
@php
$selectedMahasiswa = $selectedMahasiswa ?? null;
$chatMessages = $chatMessages ?? collect();
@endphp

<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Pesan | Portal Dosen</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
            rel="stylesheet"
        />
        <style>
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
            .custom-scrollbar::-webkit-scrollbar {
                width: 4px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f1f5f9;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 4px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }
        </style>
    </head>
    <body
        class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-full flex overflow-hidden border-box text-slate-800"
    >
        <aside
            class="hidden lg:flex w-80 bg-white border-r border-slate-200 flex-col h-screen sticky top-0 z-20 flex-shrink-0"
        >
            <div class="p-8 border-b border-slate-100 flex items-center gap-4">
                <img
                    src="{{ asset('images/logo-ummi.png') }}"
                    class="w-12 h-12 object-contain"
                    alt="Logo UMMI"
                />
                <div>
                    <h1
                        class="text-xl font-black text-slate-900 tracking-tight leading-none"
                    >
                        LMS Inklusi
                    </h1>
                    <p
                        class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1"
                    >
                        Portal Dosen
                    </p>
                </div>
            </div>

            <nav class="flex-1 p-6 space-y-3 overflow-y-auto">
                <a
                    href="{{ route('dosen.dashboard') }}"
                    class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all"
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
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                        ></path>
                    </svg>
                    <span>Beranda</span>
                </a>

                <a
                    href="{{ route('dosen.courses') }}"
                    class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all"
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
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                        ></path>
                    </svg>
                    <span>Mata Kuliah</span>
                </a>

                <a
                    href="{{ route('dosen.schedule') }}"
                    class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all"
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
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                        ></path>
                    </svg>
                    <span>Jadwal Mengajar</span>
                </a>

                <a
                    href="{{ route('dosen.grading') }}"
                    class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all"
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
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                        ></path>
                    </svg>
                    <span>Input Nilai</span>
                </a>

                <a
                    href="{{ route('dosen.exams') }}"
                    class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all"
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
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        ></path>
                    </svg>
                    <span>Kelola Ujian</span>
                </a>

                <a
                    href="{{ route('dosen.messages') }}"
                    class="flex items-center justify-between p-4 bg-blue-50 text-blue-700 rounded-2xl font-bold transition-all shadow-sm border border-blue-100"
                >
                    <div class="flex items-center gap-4">
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
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                            ></path>
                        </svg>
                        <span>Pesan</span>
                    </div>
                    <span
                        class="text-[10px] bg-blue-200 text-blue-800 px-2 py-1 rounded-lg font-black"
                        >3</span
                    >
                </a>

                <a
                    href="{{ route('dosen.profile') }}"
                    class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-2xl font-bold transition-all"
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
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                        ></path>
                    </svg>
                    <span>Profil Saya</span>
                </a>
            </nav>

            <div class="p-6 border-t border-slate-100">
                <a
                    href="{{ route('logout') }}"
                    class="w-full p-4 flex items-center justify-between text-red-600 font-bold bg-red-50 rounded-2xl hover:bg-red-100 transition-all border border-red-100"
                >
                    <div class="flex items-center gap-3">
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
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                            ></path>
                        </svg>
                        <span>Keluar</span>
                    </div>
                </a>
            </div>
        </aside>

        <main
            class="flex-1 h-screen overflow-hidden flex flex-col relative bg-slate-50"
        >
            <header
                class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-8 py-4 sticky top-0 z-30 shrink-0 flex justify-between items-center"
            >
                <div>
                    <h2
                        class="text-xl font-extrabold text-slate-900 tracking-tight"
                    >
                        Pesan Masuk
                    </h2>
                    <span
                        class="text-xs font-bold text-slate-400 uppercase tracking-widest"
                        >Komunikasi Mahasiswa</span
                    >
                </div>
            </header>

            <div class="flex-1 flex overflow-hidden">
                <div
                    class="w-full md:w-80 bg-white border-r border-slate-200 overflow-y-auto z-10 flex flex-col"
                >
                    <div class="p-4 border-b border-slate-100">
                        <input
                            type="text"
                            placeholder="Cari mahasiswa..."
                            class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-slate-400"
                        />
                    </div>
                    @foreach($conversations as $mahasiswa_id => $msgs)
@php
    $last = $msgs->last();
    $mahasiswa = \App\Models\Mahasiswa::find($mahasiswa_id);
@endphp

<a href="{{ route('dosen.messages', ['mahasiswa' => $mahasiswa_id]) }}">
    <div class="p-3 {{ $selectedMahasiswa == $mahasiswa_id ? 'bg-blue-50 border border-blue-100' : 'hover:bg-slate-50 border border-transparent hover:border-slate-100' }} rounded-xl flex gap-3 cursor-pointer relative group transition-all">
        
        <div class="w-10 h-10 rounded-xl bg-slate-200 shrink-0 overflow-hidden">
            <img
                src="https://ui-avatars.com/api/?name={{ urlencode($mahasiswa->nama) }}"
                class="w-full h-full object-cover"
            />
        </div>

        <div class="flex-1 overflow-hidden">
            <div class="flex justify-between items-center mb-0.5">
                <h4 class="font-bold text-slate-900 text-xs truncate">
                    {{ $mahasiswa->nama }}
                </h4>
                <span class="text-[9px] font-bold text-slate-400">
                    {{ $last->created_at->format('H:i') }}
                </span>
            </div>
            <p class="text-[10px] text-slate-500 truncate font-medium">
                {{ $last->body }}
            </p>
        </div>
    </div>
</a>
@endforeach

                </div>

                <div
                    class="flex-1 flex flex-col bg-[#f0f4f8] relative hidden md:flex"
                >
                    <div
                        class="p-4 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between sticky top-0 z-10"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-blue-100 overflow-hidden shadow-sm"
                            >
                                <img
                                    src="https://ui-avatars.com/api/?name=Ridwan+Firdaus&background=0D8ABC&color=fff"
                                    class="w-full h-full object-cover"
                                />
                            </div>
                            <div>
                                @php
$currentMahasiswa = $selectedMahasiswa ? \App\Models\Mahasiswa::find($selectedMahasiswa) : null;
@endphp

<h4 class="font-black text-slate-900 text-sm leading-tight">
    {{ $currentMahasiswa->nama ?? 'Pilih Mahasiswa' }}
</h4>

                                <span
                                    class="inline-flex items-center text-[9px] font-bold text-emerald-600 uppercase tracking-widest"
                                >
                                    <span
                                        class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5 animate-pulse"
                                    ></span>
                                    Online
                                </span>
                            </div>
                        </div>
                    </div>

                    <div id="chatBox" class="flex-1 p-6 overflow-y-auto space-y-6 custom-scrollbar">

                       @foreach($chatMessages as $msg)

<div id="msg-{{ $msg->id }}">
@if($msg->sender_type === 'dosen')

<div class="flex flex-col items-end ml-auto max-w-[80%]">
    <div class="bg-blue-600 p-4 rounded-2xl rounded-tr-none shadow-md shadow-blue-100">

        @if($msg->body)
        <p class="text-sm text-white leading-relaxed font-medium">
            {{ $msg->body }}
        </p>
        @endif

        @if($msg->image_path)
        <img src="{{ asset('storage/'.$msg->image_path) }}"
             class="mt-2 rounded-lg max-w-xs">
        @endif

    </div>
    <span class="text-[9px] font-bold text-slate-400 mt-1 mr-1">
        {{ $msg->created_at->format('H:i') }}
    </span>
</div>

@else

<div class="flex flex-col items-start max-w-[80%]">
    <div class="bg-white p-4 rounded-2xl rounded-tl-none shadow-sm border border-slate-100">

        @if($msg->body)
        <p class="text-sm text-slate-700 leading-relaxed font-medium">
            {{ $msg->body }}
        </p>
        @endif

        @if($msg->image_path)
        <img src="{{ asset('storage/'.$msg->image_path) }}"
             class="mt-2 rounded-lg max-w-xs">
        @endif

    </div>
    <span class="text-[9px] font-bold text-slate-400 mt-1 ml-1">
        {{ $msg->created_at->format('H:i') }}
    </span>
</div>

@endif
</div>

@endforeach


                    </div>

                    <div class="p-4 bg-white border-t border-slate-200">

<form id="chatForm" method="POST" enctype="multipart/form-data">
@csrf

@if($selectedMahasiswa)
    <input type="hidden" name="receiver_id" value="{{ $selectedMahasiswa }}">
@endif

<div class="flex items-center gap-2 bg-slate-50 p-2 rounded-2xl border border-slate-200 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100 transition-all">

    <!-- Tombol Upload (tidak ubah tampilan) -->
    <button type="button"
        onclick="document.getElementById('imageInput').click()"
        class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-white rounded-xl transition-all">
        ...
    </button>

    <!-- Input File (hidden) -->
    <input type="file" name="image" id="imageInput" hidden>

    <!-- Input Pesan -->
    <input
        type="text"
        name="body"
        id="messageInput"
        placeholder="Ketik pesan..."
        {{ !$selectedMahasiswa ? 'disabled' : '' }}
        class="flex-1 bg-transparent text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none px-2"
    />

    <!-- Tombol Kirim -->
    <button
        type="submit"
        {{ !$selectedMahasiswa ? 'disabled' : '' }}
        class="w-12 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center shadow-md hover:bg-blue-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
    >
        <svg class="w-5 h-5 transform rotate-90 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8">
            </path>
        </svg>
    </button>

</div>
</form>

</div>

                        </div>
                    </div>
                </div>
            </div>
        </main>
        <script>
document.addEventListener("DOMContentLoaded", function () {

    let form = document.getElementById("chatForm");
    let chatBox = document.getElementById("chatBox");
    let messageInput = document.getElementById("messageInput");
    let imageInput = document.getElementById("imageInput");

    // Auto scroll ke bawah
    function scrollBottom(){
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    scrollBottom();

    // =========================
    // KIRIM PESAN TANPA RELOAD
    // =========================
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
                <div class="flex flex-col items-end ml-auto max-w-[80%]">
                    <div class="bg-blue-600 p-4 rounded-2xl rounded-tr-none shadow-md shadow-blue-100">
                        ${data.body ? `<p class="text-sm text-white">${data.body}</p>` : ''}
                        ${data.image ? `<img src="/storage/${data.image}" class="mt-2 rounded-lg max-w-xs">` : ''}
                    </div>
                    <span class="text-[9px] font-bold text-slate-400 mt-1 mr-1">
                        ${data.time}
                    </span>
                </div>
                `;

                chatBox.innerHTML += html;

                messageInput.value = "";
                imageInput.value = "";

                scrollBottom();
            }
        });

    });

    // =========================
    // AUTO REFRESH SETIAP 3 DETIK
    // =========================
    @if($selectedMahasiswa)
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
