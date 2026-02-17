<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
    />
    <title>Login Dosen | LMS Inklusi UMMI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet"
    />
</head>

<body class="m-0 p-4 font-['Plus_Jakarta_Sans'] bg-slate-50 min-h-full flex items-center justify-center overflow-x-hidden">

<div
    class="w-full max-w-6xl bg-white rounded-[2rem] md:rounded-[3.5rem] shadow-2xl overflow-hidden border border-slate-100 grid grid-cols-1 lg:grid-cols-2 h-auto lg:h-[85vh] lg:max-h-[700px]"
>
    <div
        class="hidden lg:block bg-cover bg-center shadow-inner"
        style="background-image: url('{{ asset('images/login.png') }}');"
    ></div>

    <div class="p-6 md:p-10 lg:p-6 flex flex-col justify-center bg-white items-center">
        <div class="w-full max-w-md lg:max-w-[400px] mx-auto">

            <div class="mb-8">
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">
                    Masuk Dosen
                </h2>
                <p class="text-slate-400 text-[10px] font-bold mt-2 uppercase tracking-widest leading-loose">
                    Pusat Pembelajaran Disabilitas
                </p>
            </div>

            <form id="loginForm" class="space-y-4">
                @csrf

                <div class="p-4 rounded-2xl bg-slate-50 border-2 border-blue-600 shadow-md">
                    <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">
                        NIDN Dosen
                    </label>
                    <input
                        type="text"
                        name="nidn"
                        required
                        class="w-full bg-transparent text-lg font-bold text-blue-900 outline-none"
                        placeholder="Masukkan NIDN"
                    />
                </div>

                <div class="p-4 rounded-2xl bg-slate-50 border-2 border-blue-600 shadow-md">
                    <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">
                        Kata Sandi
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full bg-transparent text-lg font-bold text-blue-900 outline-none"
                        placeholder="Masukkan kata sandi"
                    />
                </div>

                <div class="pt-4 space-y-3">
                    <button
                        type="submit"
                        class="w-full py-4 bg-blue-800 text-white rounded-xl font-black text-[10px] tracking-widest uppercase shadow-lg shadow-blue-100"
                    >
                        Login Sekarang
                    </button>

                    <button
                        type="button"
                        class="w-full py-4 bg-white border border-slate-200 rounded-xl flex items-center justify-center gap-3"
                    >
                        <img src="{{ asset('images/gogle.svg') }}" class="w-4 h-4" alt="Google" />
                        <span class="text-[9px] font-black text-slate-600 tracking-widest uppercase italic">
                            Login with Google
                        </span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
document.getElementById("loginForm").addEventListener("submit", async function (e) {
    e.preventDefault();

    const form = e.target;
    const data = {
        nidn: form.nidn.value,
        password: form.password.value
    };

    try {
        const res = await fetch("{{ route('login.dosen.post') }}", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}"
    },
    body: JSON.stringify(data)
});
        if (res.ok) {
    const json = await res.json();
    if (json.redirect) {
        window.location.href = json.redirect; // Pindah ke dashboard
    }
} else {
    const json = await res.json();
    alert(json.message || "Login gagal");
}
    } catch {
        alert("Terjadi kesalahan sistem");
    }
});
</script>

</body>
</html>
