        <!DOCTYPE html>
        <html lang="id" class="h-full">
            <head>
                <meta charset="UTF-8" />
                <meta
                    name="viewport"
                    content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
                />
                <title>Kelola Detail Sesi | Portal Dosen</title>
                @vite(['resources/css/app.css', 'resources/js/app.js'])
                <link
                    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
                    rel="stylesheet"
                />
                <style>
                    .scrollbar-hide::-webkit-scrollbar {
                        display: none;
                    }
                    .scrollbar-hide {
                        -ms-overflow-style: none;
                        scrollbar-width: none;
                    }
                    .custom-scrollbar::-webkit-scrollbar {
                        width: 4px;
                    }
                    .custom-scrollbar::-webkit-scrollbar-track {
                        background: transparent;
                    }
                    .custom-scrollbar::-webkit-scrollbar-thumb {
                        background-color: #cbd5e1;
                        border-radius: 20px;
                    }
                </style>
            </head>
            <body
                class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-full flex flex-col border-box overflow-x-hidden text-slate-800"
            >
                <main class="flex-1 flex flex-col h-screen overflow-y-auto">
                    <div
                        class="bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-30 px-6 py-4"
                    >
                        <div
                            class="max-w-5xl mx-auto flex items-center justify-between"
                        >
                            <div class="flex items-center gap-4">
                                <a
                                    href="{{ route('dosen.course.manage', $kelas->id) }}"
                                    class="w-10 h-10 rounded-full bg-slate-50 hover:bg-blue-50 text-slate-400 hover:text-blue-600 flex items-center justify-center transition-all border border-slate-200 shrink-0"
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
                            </div>
                            <div
                                class="text-center absolute left-1/2 transform -translate-x-1/2"
                            >
                                <h1
                                    class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight"
                                >
                                    Kelola Isi Sesi
                                </h1>
                                <p
                                    class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1"
                                >
                                    Pertemuan {{ $session->pertemuan }} : {{ $session->judul }}
                                </p>
                            </div>
                            <div class="w-10"></div>
                        </div>
                    </div>

                    <div class="max-w-5xl mx-auto w-full p-6 space-y-8 pb-20">
                        <div
                            class="bg-blue-50 border-l-4 border-blue-500 rounded-r-2xl p-6 shadow-sm"
                        >
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-blue-200 flex items-center justify-center shrink-0 text-blue-700"
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
                                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"
                                        ></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <form method="POST" action="{{ route('dosen.session.updateInstruksi', $session->id) }}">
         @csrf
    @method('PUT')

    <div class="flex justify-between items-center mb-3">
        <h3 class="text-[10px] font-black text-blue-800 uppercase tracking-[0.2em]">
            Pesan Instruksi Mahasiswa
        </h3>
        <button type="submit"
            class="bg-blue-600 text-white px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-blue-700 transition-all shadow-sm shadow-blue-200">
            Simpan
        </button>
    </div>

    <textarea name="instruksi"
        class="w-full bg-white/50 border border-blue-100 rounded-xl p-4 text-sm font-medium text-slate-700 leading-relaxed focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all h-24 resize-none">{{ $session->instruksi }}</textarea>
</form>

                                    
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-sm"
                        >
                            <h3
                                class="text-lg font-black text-slate-900 uppercase tracking-tight mb-6"
                            >
                                Materi Sesi
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
<!-- TAMBAH MATERI -->
<button type="button"
    onclick="openMateriModal()"
    class="p-4 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl flex flex-col items-center gap-2 hover:bg-blue-50 hover:border-blue-400 transition-all group text-center">

    <svg class="w-6 h-6 text-slate-400 group-hover:text-blue-600"
        fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
    </svg>

    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">
        + Tambah Materi
    </span>
</button>


<!-- TAMBAH VOICE -->
<button type="button"
    onclick="openVoiceModal()"
    class="p-4 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl flex flex-col items-center gap-2 hover:bg-purple-50 hover:border-purple-400 transition-all group text-center">

    <svg class="w-6 h-6 text-slate-400 group-hover:text-purple-600"
        fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
    </svg>

    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">
        + Tambah Voice
    </span>
</button>


<!-- TAMBAH VIDEO -->
<button type="button"
    onclick="openVideoModal()"
    class="p-4 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl flex flex-col items-center gap-2 hover:bg-red-50 hover:border-red-400 transition-all group text-center">

    <svg class="w-6 h-6 text-slate-400 group-hover:text-red-600"
        fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 00-2 2z"/>
    </svg>

    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">
        + Tambah Video
    </span>
</button>

<!-- MODAL MATERI -->
<div id="materiModal"
     class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl p-6 w-[400px] shadow-xl">

        <h3 class="text-sm font-bold mb-4">Tambah Materi</h3>

        <div class="flex gap-2 mb-4">
            <button onclick="showFileForm()"
                class="flex-1 bg-blue-100 text-blue-700 py-2 rounded-lg text-xs font-bold">
                Upload File
            </button>

            <button onclick="showLinkForm()"
                class="flex-1 bg-purple-100 text-purple-700 py-2 rounded-lg text-xs font-bold">
                Tambah Link
            </button>
        </div>

        <!-- FORM FILE -->
        <form id="fileForm"
              method="POST"
              action="{{ route('dosen.materi.store', $session->id) }}"
              enctype="multipart/form-data"
              class="space-y-3 hidden">

            @csrf
            <input type="hidden" name="type" value="file">

            <input type="text" name="judul" placeholder="Judul"
                class="w-full border rounded-lg px-3 py-2 text-xs" required>

            <input type="file" name="file"
                class="w-full text-xs" required>

            <button class="w-full bg-blue-600 text-white py-2 rounded-lg text-xs font-bold">
                Simpan File
            </button>
        </form>

        <!-- FORM LINK -->
        <form id="linkForm"
              method="POST"
              action="{{ route('dosen.materi.store', $session->id) }}"
              class="space-y-3 hidden">

            @csrf
            <input type="hidden" name="type" value="link">

            <input type="text" name="judul" placeholder="Judul"
                class="w-full border rounded-lg px-3 py-2 text-xs" required>

            <input type="url" name="link" placeholder="https://..."
                class="w-full border rounded-lg px-3 py-2 text-xs" required>

            <button class="w-full bg-purple-600 text-white py-2 rounded-lg text-xs font-bold">
                Simpan Link
            </button>
        </form>

        <button onclick="closeMateriModal()"
            class="mt-4 text-xs text-slate-400">
            Tutup
        </button>

    </div>
</div>

<!-- MODAL VOICE -->
<div id="voiceModal"
     class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl p-6 w-[400px] shadow-xl">

        <h3 class="text-sm font-bold mb-4">Tambah Voice</h3>

        <form method="POST"
              action="{{ route('dosen.materi.store', $session->id) }}"
              enctype="multipart/form-data"
              class="space-y-3">

            @csrf
            <input type="hidden" name="type" value="voice">

            <input type="text" name="judul" placeholder="Judul"
                class="w-full border rounded-lg px-3 py-2 text-xs" required>

            <input type="file" name="file" accept="audio/*"
                class="w-full text-xs" required>

            <button class="w-full bg-purple-600 text-white py-2 rounded-lg text-xs font-bold">
                Simpan Voice
            </button>
        </form>

        <button onclick="closeVoiceModal()"
            class="mt-4 text-xs text-slate-400">
            Tutup
        </button>

    </div>
</div>

<!-- MODAL VIDEO -->
<div id="videoModal"
     class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl p-6 w-[400px] shadow-xl">

        <h3 class="text-sm font-bold mb-4">Tambah Video</h3>

        <div class="flex gap-2 mb-4">
            <button onclick="showVideoFileForm()"
                class="flex-1 bg-red-100 text-red-700 py-2 rounded-lg text-xs font-bold">
                Upload Video
            </button>

            <button onclick="showVideoLinkForm()"
                class="flex-1 bg-purple-100 text-purple-700 py-2 rounded-lg text-xs font-bold">
                Tambah Link
            </button>
        </div>

        <!-- FORM VIDEO FILE -->
        <form id="videoFileForm"
              method="POST"
              action="{{ route('dosen.materi.store', $session->id) }}"
              enctype="multipart/form-data"
              class="space-y-3 hidden">

            @csrf
            <input type="hidden" name="type" value="video">

            <input type="text" name="judul" placeholder="Judul"
                class="w-full border rounded-lg px-3 py-2 text-xs" required>

            <input type="file" name="file"
                class="w-full text-xs" accept="video/*" required>

            <button class="w-full bg-red-600 text-white py-2 rounded-lg text-xs font-bold">
                Simpan Video
            </button>
        </form>

        <!-- FORM VIDEO LINK -->
        <form id="videoLinkForm"
              method="POST"
              action="{{ route('dosen.materi.store', $session->id) }}"
              class="space-y-3 hidden">

            @csrf
            <input type="hidden" name="type" value="link">

            <input type="text" name="judul" placeholder="Judul"
                class="w-full border rounded-lg px-3 py-2 text-xs" required>

            <input type="url" name="link" placeholder="https://..."
                class="w-full border rounded-lg px-3 py-2 text-xs" required>

            <button class="w-full bg-purple-600 text-white py-2 rounded-lg text-xs font-bold">
                Simpan Link
            </button>
        </form>

        <button onclick="closeVideoModal()"
            class="mt-4 text-xs text-slate-400">
            Tutup
        </button>

    </div>
</div>


                            </div>

                            <div class="space-y-3">
        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">
            File Aktif
        </h4>

        @forelse($session->materis as $materi)
<div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100 group">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center font-black text-[10px] border border-red-100">
            {{ strtoupper($materi->type) }}
        </div>
        <span class="text-xs font-bold text-slate-700">
            {{ $materi->judul }}
        </span>
    </div>

    <div class="flex items-center gap-3">

        {{-- Tombol Lihat --}}
        @if($materi->file)
            <a href="{{ asset('storage/'.$materi->file) }}"
               target="_blank"
               class="text-blue-600 text-xs font-bold">
                Lihat
            </a>
        @elseif($materi->link)
            <a href="{{ $materi->link }}"
               target="_blank"
               class="text-purple-600 text-xs font-bold">
                Buka Link
            </a>
        @endif

        {{-- Tombol Hapus --}}
        <form method="POST"
              action="{{ route('dosen.materi.destroy', $materi->id) }}"
              onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
            @csrf
            @method('DELETE')

            <button class="text-red-600 text-xs font-bold">
                Hapus
            </button>
        </form>

    </div>
</div>
@empty
<p class="text-sm text-slate-400">Belum ada materi.</p>
@endforelse


    </div>

<br>
                            <div
        class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-sm"
    >
        <div class="flex justify-between items-center mb-6">
            <h3
                class="text-lg font-black text-slate-900 uppercase tracking-tight"
            >
                Diskusi Sesi
            </h3>
            <span
                class="text-[9px] font-bold bg-green-100 text-green-700 px-3 py-1.5 rounded-full flex items-center gap-1.5"
            >
                <span
                    class="w-2 h-2 bg-green-500 rounded-full animate-pulse"
                ></span>
                @if($onlineUsers > 0)
        {{ $onlineUsers }} Online
    @else
        Tidak ada yang online
    @endif

            </span>
        </div>
        
        <div
            class="flex flex-col gap-6 mb-8 max-h-[400px] overflow-y-auto pr-3 custom-scrollbar"
        >
            @foreach($session->discussions->sortBy('created_at') as $diskusi)

@php
    $sender = $diskusi->sender;
    $isMe = $sender && $sender->id === auth('dosen')->id();
@endphp

<div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">

    <div class="flex gap-3 items-start max-w-[75%] {{ $isMe ? 'flex-row-reverse' : '' }}">

        <!-- AVATAR -->
        <img
            src="https://ui-avatars.com/api/?name={{ urlencode($sender->name ?? 'User') }}&background=random"
            class="w-9 h-9 rounded-full shrink-0 shadow-sm"
        />

        <!-- BUBBLE -->
        <div class="
            p-4 rounded-2xl shadow-sm
            {{ $isMe 
                ? 'bg-blue-600 text-white rounded-tr-none' 
                : 'bg-slate-100 text-slate-800 rounded-tl-none' 
            }}
        ">

            <!-- NAMA -->
            <p class="text-xs font-bold mb-1 opacity-80">
                {{ $sender->name ?? 'Unknown User' }}
            </p>

            <!-- MESSAGE -->
            @if($diskusi->message)
                <p class="text-sm leading-relaxed">
                    {{ $diskusi->message }}
                </p>
            @endif

            <!-- IMAGE -->
            @if($diskusi->image)
                <img 
                    src="{{ asset('storage/' . $diskusi->image) }}"
                    class="mt-3 rounded-xl max-w-full"
                >
            @endif

            <!-- VOICE -->
            @if($diskusi->voice)
                <div class="mt-3">
                    <audio controls class="w-full">
                        <source src="{{ asset('storage/' . $diskusi->voice) }}">
                    </audio>
                </div>
            @endif

            <!-- WAKTU -->
            <p class="text-[10px] mt-2 opacity-60">
                {{ $diskusi->created_at->format('H:i') }}
            </p>

        </div>
    </div>
</div>

@endforeach

        </div>

        <div class="pt-4 border-t border-slate-100">
            <form method="POST" action="{{ route('session.diskusi.store', $session->id) }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="image" id="imageInput" hidden>
            <input type="file" name="voice" id="voiceInput" hidden>



            <input type="hidden" name="session_id" value="{{ $session->id }}">

            <div
                class="relative flex items-center gap-3 bg-slate-50 p-3 rounded-2xl border border-slate-200 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100 transition-all"
            >
                <button
        type="button"
        onclick="document.getElementById('imageInput').click()"
        class="w-10 h-10 rounded-xl flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-white transition-all"
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
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                        ></path>
                    </svg>
                </button>

                <input
                    type="text"
                    name="message"
                    placeholder="Tulis balasan anda..."
                    class="flex-1 bg-transparent text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none"
                />

                <button
        type="button"
        id="recordBtn"
        class="w-10 h-10 rounded-xl flex items-center justify-center text-red-500 bg-red-50 hover:bg-red-100 transition-all"
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
                            d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"
                        ></path>
                    </svg>
                </button>

                <button
                    type="submit"
                    class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-all shadow-md shadow-blue-200"
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
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
                        />
                    </svg>
                </button>
            </div>
            </form>
        </div>
    </div>


                <script>
                    function simpanPesan() {
                        alert("Pesan instruksi berhasil diperbarui!");
                    }
                    
function openMateriModal() {
    document.getElementById('materiModal').classList.remove('hidden');
    document.getElementById('materiModal').classList.add('flex');
}

function closeMateriModal() {
    document.getElementById('materiModal').classList.add('hidden');
}

function showFileForm() {
    document.getElementById('fileForm').classList.remove('hidden');
    document.getElementById('linkForm').classList.add('hidden');
}

function showLinkForm() {
    document.getElementById('linkForm').classList.remove('hidden');
    document.getElementById('fileForm').classList.add('hidden');
}

function openVoiceModal() {
    document.getElementById('voiceModal').classList.remove('hidden');
    document.getElementById('voiceModal').classList.add('flex');
}

function closeVoiceModal() {
    document.getElementById('voiceModal').classList.add('hidden');
}

function openVideoModal() {
    document.getElementById('videoModal').classList.remove('hidden');
    document.getElementById('videoModal').classList.add('flex');
}

function closeVideoModal() {
    document.getElementById('videoModal').classList.add('hidden');
}
function openVideoModal() {
    document.getElementById('videoModal').classList.remove('hidden');
    document.getElementById('videoModal').classList.add('flex');
}

function closeVideoModal() {
    document.getElementById('videoModal').classList.add('hidden');
    document.getElementById('videoModal').classList.remove('flex');
}

function showVideoFileForm() {
    document.getElementById('videoFileForm').classList.remove('hidden');
    document.getElementById('videoLinkForm').classList.add('hidden');
}

function showVideoLinkForm() {
    document.getElementById('videoLinkForm').classList.remove('hidden');
    document.getElementById('videoFileForm').classList.add('hidden');
}

let mediaRecorder;
let audioChunks = [];
let isRecording = false;

const recordBtn = document.getElementById('recordBtn');
const voiceInput = document.getElementById('voiceInput');

recordBtn.addEventListener('click', async () => {

    if (!isRecording) {

        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });

        mediaRecorder = new MediaRecorder(stream);
        mediaRecorder.start();

        isRecording = true;
        recordBtn.classList.remove('bg-red-50');
        recordBtn.classList.add('bg-red-200');

        audioChunks = [];

        mediaRecorder.ondataavailable = event => {
            audioChunks.push(event.data);
        };

        mediaRecorder.onstop = () => {

            const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });

            const file = new File([audioBlob], "voice.webm", {
                type: "audio/webm"
            });

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);

            voiceInput.files = dataTransfer.files;

            audioChunks = [];
        };

    } else {

        mediaRecorder.stop();
        isRecording = false;

        recordBtn.classList.remove('bg-red-200');
        recordBtn.classList.add('bg-red-50');
    }
});
                </script>
            </body>
        </html>
