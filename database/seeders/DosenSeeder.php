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
            'nidn' => '2430511033',
            'nama' => 'Elgar Ahmadal',
            'password' => Hash::make('elgar123'),
        ]);
    }
}
