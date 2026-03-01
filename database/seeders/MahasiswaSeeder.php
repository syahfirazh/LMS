<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswa = [
            [
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
            ],
            [
                'nim' => '2430511039',
                'nama' => 'Ahmad Fauzan',
                'password' => Hash::make('123456'),
                'prodi' => 'Teknik Informatika',
                'fakultas' => 'Fakultas Sains dan Teknologi',
                'semester' => 3,
                'status' => 'Mahasiswa Aktif',
                'tahun_masuk' => 2023,
                'email_kampus' => '2430511039@kampus.ac.id',
                'email_pribadi' => 'ahmad.fauzan@gmail.com',
                'no_hp' => '081234567891',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '2430511040',
                'nama' => 'Siti Nurhaliza',
                'password' => Hash::make('123456'),
                'prodi' => 'Teknik Informatika',
                'fakultas' => 'Fakultas Sains dan Teknologi',
                'semester' => 3,
                'status' => 'Mahasiswa Aktif',
                'tahun_masuk' => 2023,
                'email_kampus' => '2430511040@kampus.ac.id',
                'email_pribadi' => 'siti.nurhaliza@gmail.com',
                'no_hp' => '081234567892',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '2430511041',
                'nama' => 'Budi Santoso',
                'password' => Hash::make('123456'),
                'prodi' => 'Teknik Informatika',
                'fakultas' => 'Fakultas Sains dan Teknologi',
                'semester' => 3,
                'status' => 'Mahasiswa Aktif',
                'tahun_masuk' => 2023,
                'email_kampus' => '2430511041@kampus.ac.id',
                'email_pribadi' => 'budi.santoso@gmail.com',
                'no_hp' => '081234567893',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '2430511042',
                'nama' => 'Dewi Lestari',
                'password' => Hash::make('123456'),
                'prodi' => 'Teknik Informatika',
                'fakultas' => 'Fakultas Sains dan Teknologi',
                'semester' => 3,
                'status' => 'Mahasiswa Aktif',
                'tahun_masuk' => 2023,
                'email_kampus' => '2430511042@kampus.ac.id',
                'email_pribadi' => 'dewi.lestari@gmail.com',
                'no_hp' => '081234567894',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('mahasiswas')->insert($mahasiswa);
    }
}