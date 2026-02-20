<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Portal LMS Inklusi UMMI</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap"
            rel="stylesheet"
        />
    </head>
    <body
        class="bg-slate-50 font-['Plus_Jakarta_Sans'] min-h-screen flex flex-col items-center justify-center p-6"
    >
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-blue-900 mb-4">
                LMS Inklusi UMMI
            </h1>
            <p class="text-slate-600 text-lg">
                Selamat datang di Platform Pembelajaran Inklusif. <br />Silakan
                pilih peran Anda untuk melanjutkan.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-4xl">
            <a
                href="{{ route('login.dosen') }}"
                class="group relative bg-white p-8 rounded-3xl shadow-sm border border-slate-200 hover:shadow-xl hover:border-blue-500 transition-all duration-300 transform hover:-translate-y-2 text-center"
            >
                <div
                    class="w-20 h-20 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-blue-600 transition-colors duration-300"
                >
                    <svg
                        class="w-10 h-10 text-blue-600 group-hover:text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="User-Group-Icon-SVG-Path-Here... (Atau icon Dosen)"
                        >
                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path
                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"
                            />
                        </path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-slate-800 mb-2">Dosen</h2>
                <p class="text-slate-500">
                    Kelola perkuliahan, materi, dan berikan bimbingan kepada
                    mahasiswa.
                </p>
                <div
                    class="mt-6 text-blue-600 font-semibold inline-flex items-center group-hover:translate-x-2 transition-transform"
                >
                    Masuk sebagai Dosen <span class="ml-2">→</span>
                </div>
            </a>

            <a
                href="{{ route('setup.voice') }}"
                class="group relative bg-white p-8 rounded-3xl shadow-sm border border-slate-200 hover:shadow-xl hover:border-indigo-500 transition-all duration-300 transform hover:-translate-y-2 text-center"
            >
                <div
                    class="w-20 h-20 bg-indigo-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-indigo-600 transition-colors duration-300"
                >
                    <svg
                        class="w-10 h-10 text-indigo-600 group-hover:text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                        />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-slate-800 mb-2">
                    Mahasiswa
                </h2>
                <p class="text-slate-500">
                    Akses materi kuliah, kumpulkan tugas, dan pantau
                    perkembangan belajar Anda.
                </p>
                <div
                    class="mt-6 text-indigo-600 font-semibold inline-flex items-center group-hover:translate-x-2 transition-transform"
                >
                    Masuk sebagai Mahasiswa <span class="ml-2">→</span>
                </div>
            </a>
        </div>

        <footer class="mt-16 text-slate-400 text-sm italic">
            &copy; 2026 Universitas Muhammadiyah Sukabumi - Kampus Inklusi
        </footer>
    </body>
</html>
