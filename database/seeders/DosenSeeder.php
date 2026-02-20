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
            'password' => Hash::make('12345678'),
        ]);
    }
}
