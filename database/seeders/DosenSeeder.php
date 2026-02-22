<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dosen;
use Illuminate\Support\Facades\Hash;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        Dosen::create([
            'nidn' => '12345678',
            'nama' => 'Elgar Ahmadal',
            'email' => 'elgar@ummi.ac.id', // TAMBAHKAN EMAIL INI
            'password' => Hash::make('12345678'),
            'no_hp' => '081234567890', // Opsional, boleh ditambah
            'homebase' => 'Teknik Informatika', // Opsional
        ]);
    }
}