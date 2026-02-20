<!DOCTYPE html>
<html lang="id" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <title>Login Dosen | LMS Inklusi UMMI</title>

        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
            rel="stylesheet"
        />
    </head>

    <body class="m-0 p-4 font-['Plus_Jakarta_Sans'] bg-slate-50 min-h-full flex items-center justify-center overflow-x-hidden">

        @if(view()->exists('components.page_transition'))
            @include('components.page_transition')
        @endif

        <div
            class="w-full max-w-6xl bg-white rounded-[2rem] md:rounded-[3.5rem] shadow-2xl overflow-hidden border border-slate-100 grid grid-cols-1 lg:grid-cols-2 h-auto lg:h-[85vh] lg:max-h-[700px]"
        >
            <div data-aos="fade-right" data-aos-duration="1000"
                class="hidden lg:block bg-cover bg-center shadow-inner"
                style="background-image: url('{{ asset('images/login.png') }}');"
            ></div>

            <div class="p-6 md:p-10 lg:p-6 flex flex-col justify-center bg-white items-center relative">
                <div class="w-full max-w-md lg:max-w-[400px] mx-auto">

                    <div class="mb-8">
                        <h2 data-aos="fade-up" data-aos-delay="100"
                            class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tighter uppercase leading-none">
                            Masuk Dosen
                        </h2>
                        <p data-aos="fade-up" data-aos-delay="200"
                            class="text-slate-400 text-[10px] font-bold mt-2 uppercase tracking-widest leading-loose">
                            Pusat Pembelajaran Disabilitas
                        </p>
                    </div>

                    <form id="loginForm" class="space-y-4">
                        @csrf

                        <div data-aos="fade-up" data-aos-delay="300"
                            class="p-4 rounded-2xl bg-slate-50 border-2 border-slate-100 focus-within:border-blue-600 transition-colors duration-300">
                            <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">
                                NIDN Dosen
                            </label>
                            <input
                                type="text"
                                name="nidn"
                                required
                                value=""
                                class="w-full bg-transparent text-sm font-semibold text-slate-700 outline-none placeholder:text-slate-300"
                                placeholder="Masukkan NIDN"
                            />
                        </div>

                        <div data-aos="fade-up" data-aos-delay="400"
                            class="p-4 rounded-2xl bg-slate-50 border-2 border-slate-100 focus-within:border-blue-600 transition-colors duration-300 relative">
                            <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">
                                Kata Sandi
                            </label>
                            <div class="flex items-center">
                                <input
                                    type="password"
                                    id="passwordInput"
                                    name="password"
                                    required
                                    value=""
                                    class="w-full bg-transparent text-sm font-semibold text-slate-700 outline-none placeholder:text-slate-300"
                                    placeholder="Masukkan kata sandi"
                                />
                                <button type="button" onclick="togglePassword()" class="text-slate-400 hover:text-blue-600 transition-colors focus:outline-none">
                                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.644C3.67 8.5 7.652 6 12 6c4.348 0 8.332 2.5 9.964 5.678a1.012 1.012 0 0 1 0 .644C20.33 15.5 16.348 18 12 18c-4.348 0-8.332-2.5-9.964-5.678Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="pt-4 space-y-3">
                            <button
                                type="submit"
                                data-aos="fade-up" data-aos-delay="500"
                                class="w-full py-4 bg-blue-800 text-white rounded-xl font-black text-[10px] tracking-widest uppercase shadow-lg shadow-blue-100 hover:bg-blue-900 hover:-translate-y-0.5 transition-all cursor-pointer"
                            >
                                Login Sekarang
                            </button>

                            <button
                                type="button"
                                data-aos="fade-up" data-aos-delay="600"
                                class="w-full py-4 bg-white border border-slate-200 rounded-xl flex items-center justify-center gap-3 hover:bg-slate-50 transition-all cursor-pointer"
                            >
                                <img src="{{ asset('images/gogle.svg') }}" class="w-4 h-4" alt="Google" />
                                <span class="text-[9px] font-black text-slate-600 tracking-widest uppercase">
                                    Login with Google
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({ once: true, easing: 'ease-out-cubic' });

            // Fungsi Toggle Password
            function togglePassword() {
                const passwordInput = document.getElementById('passwordInput');
                const eyeIcon = document.getElementById('eyeIcon');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    // Ubah ikon ke mata tertutup (slash)
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    `;
                } else {
                    passwordInput.type = 'password';
                    // Kembalikan ke ikon mata terbuka
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.644C3.67 8.5 7.652 6 12 6c4.348 0 8.332 2.5 9.964 5.678a1.012 1.012 0 0 1 0 .644C20.33 15.5 16.348 18 12 18c-4.348 0-8.332-2.5-9.964-5.678Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    `;
                }
            }

            document.getElementById("loginForm").addEventListener("submit", async function (e) {
                e.preventDefault();
                const form = e.target;
                const submitBtn = form.querySelector('button[type="submit"]');
                
                submitBtn.innerText = "MEMPROSES...";
                submitBtn.disabled = true;

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

                    const json = await res.json();

                    if (res.ok && json.success) {
                        window.location.href = json.redirect;
                    } else {
                        alert(json.message || "Login gagal");
                        submitBtn.innerText = "LOGIN SEKARANG";
                        submitBtn.disabled = false;
                    }
                } catch (error) {
                    alert("Terjadi kesalahan sistem");
                    submitBtn.innerText = "LOGIN SEKARANG";
                    submitBtn.disabled = false;
                }
            });
        </script>
    </body>
</html>