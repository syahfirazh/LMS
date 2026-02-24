<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation; // <-- 1. Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // 2. Tambahkan pemetaan ini
        Relation::enforceMorphMap([
            'dosen' => 'App\Models\Dosen',
            'mahasiswa' => 'App\Models\Mahasiswa', // Sesuaikan dengan model mahasiswa Anda
        ]);
    }
}