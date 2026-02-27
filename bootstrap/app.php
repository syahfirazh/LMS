<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request; // <-- JANGAN LUPA TAMBAHKAN INI

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // --- KONFIGURASI REDIRECT UNTUK GUEST (BELUM LOGIN) ---
        $middleware->redirectGuestsTo(function (Request $request) {
            
            // Jika user mencoba mengakses rute yang depannya /dosen (Area Dosen)
            if ($request->is('dosen') || $request->is('dosen/*')) {
                return route('login.dosen'); 
            }

            // Jika bukan area dosen, lempar ke halaman pilih role (atau bisa ganti ke 'login' untuk mahasiswa)
            return route('choose_role'); 
        });
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();