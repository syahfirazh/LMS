<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil Dosen | Portal Dosen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    />
</head>

<body class="m-0 font-['Plus_Jakarta_Sans'] bg-[#f8fafc] min-h-full flex overflow-hidden border-box text-slate-800">

<aside class="hidden lg:flex w-80 bg-white border-r border-slate-200 flex-col h-screen sticky top-0 z-20 flex-shrink-0">
    <div class="p-8 border-b border-slate-100 flex items-center gap-4">
        <img src="{{ asset('images/logo-ummi.png') }}" class="w-12 h-12 object-contain" />
        <div>
            <h1 class="text-xl font-black text-slate-900">LMS Inklusi</h1>
            <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Portal Dosen</p>
        </div>
    </div>

    <nav class="flex-1 p-6 space-y-3 overflow-y-auto">
        <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-4 p-4 text-slate-500 hover:bg-slate-50 rounded-2xl font-bold">Beranda</a>
        <a href="{{ route('dosen.profile') }}" class="flex items-center gap-4 p-4 bg-blue-50 text-blue-700 rounded-2xl font-bold border border-blue-100">Profil Saya</a>
    </nav>

    <div class="p-6 border-t border-slate-100">
        <a href="{{ route('logout') }}" class="w-full p-4 flex items-center text-red-600 font-bold bg-red-50 rounded-2xl border border-red-100">
            Keluar
        </a>
    </div>
</aside>

<main class="flex-1 h-screen overflow-y-auto bg-[#f8fafc]">
<header class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 px-8 py-6 sticky top-0 z-30">
    <h2 class="text-2xl font-black text-slate-900">Profil Pengajar</h2>
    <p class="text-sm font-medium text-slate-500">Data diri dan pengaturan akun</p>
</header>

<div class="p-6 lg:p-10 max-w-5xl mx-auto">
<div class="bg-white rounded-[3rem] shadow-xl overflow-hidden border border-slate-100">

<div class="h-48 bg-gradient-to-r from-blue-700 to-indigo-800"></div>

<div class="px-10 pb-10 relative">
<div class="absolute -top-20 left-10">
    <div class="w-40 h-40 rounded-[2rem] border-8 border-white bg-slate-200 overflow-hidden shadow-2xl">
        <img
            src="{{ $dosen->foto ? asset('storage/'.$dosen->foto) : 'https://ui-avatars.com/api/?name='.urlencode($dosen->nama) }}"
            class="w-full h-full object-cover"
        />
    </div>
</div>

<div class="pt-24 grid grid-cols-1 md:grid-cols-2 gap-10">
<div>
    <h2 class="text-3xl font-black text-slate-900">{{ $dosen->nama }}</h2>
    <span class="inline-block mt-2 px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-xs font-black uppercase">
        {{ $dosen->jabatan }}
    </span>

    <div class="mt-8 space-y-6">
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase">NIDN</label>
            <p class="font-bold text-lg font-mono">{{ $dosen->nidn }}</p>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase">Homebase</label>
            <p class="font-bold text-lg">{{ $dosen->homebase }}</p>
        </div>
    </div>
</div>

<div class="space-y-6">
    <div>
        <label class="block text-[10px] font-black text-slate-400 uppercase">Email Institusi</label>
        <p class="font-bold text-lg">{{ $dosen->email }}</p>
    </div>

    <div>
        <label class="block text-[10px] font-black text-slate-400 uppercase">Bidang Keahlian</label>
        <div class="flex flex-wrap gap-2 mt-2">
            @foreach ($dosen->bidang_keahlian ?? [] as $bidang)
                <span class="px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl text-xs font-bold">
                    {{ $bidang }}
                </span>
            @endforeach
        </div>
    </div>
</div>
</div>

<div class="mt-12 pt-8 border-t border-slate-100 flex justify-end gap-4">
    <a href="{{ route('dosen.profile.edit') }}"
       class="bg-white border border-slate-200 text-slate-600 px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-50">
        Ubah Password
    </a>

    <a href="{{ route('dosen.profile.edit') }}"
       class="bg-slate-900 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-600 shadow-lg">
        Edit Profil
    </a>
</div>

</div>
</div>
</div>
</main>
</body>
</html>
