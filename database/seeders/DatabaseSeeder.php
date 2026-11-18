<?php

namespace Database\Seeders;

use App\Models\Poli;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([1 => 'Poli Umum', 2 => 'Poli Gigi', 3 => 'Poli Anak', 4 => 'Poli Penyakit Dalam'] as $id => $nama) {
            Poli::updateOrCreate(['id_poli' => $id], ['nama_poli' => $nama]);
        }

        $this->call(DokterSeeder::class);

        // Akun contoh (password: password). Ganti setelah selesai demo.
        User::forceCreate([
            'name' => 'Admin Klinik', 'email' => 'admin@klinik.test',
            'password' => 'password', 'role' => 'admin',
        ]);
        User::forceCreate([
            'name' => 'User Biasa', 'email' => 'user@klinik.test',
            'password' => 'password', 'role' => 'user',
        ]);
    }
}
