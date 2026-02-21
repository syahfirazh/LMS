<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mahasiswas')->insert([
    'nim' => '2430511038',
    'nama' => 'Muhammad Ridwan',
    'password' => Hash::make('123456'),
    'prodi' => 'Teknik Informatika',
    'fakultas' => 'Fakultas Sains dan Teknologi',
    'semester' => 3,
    'status' => 'Mahasiswa Aktif',
    'tahun_masuk' => 2023,
    'email_kampus' => '2430511038@kampus.ac.id',
    'email_pribadi' => 'mahasiswa@gmail.com',
    'no_hp' => '085723074662',
    'created_at' => now(),
    'updated_at' => now(),
]);
    }
}
