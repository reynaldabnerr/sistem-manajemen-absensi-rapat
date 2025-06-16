<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat atau temukan unit kerja Superadmin
        $unitKerja = UnitKerja::firstOrCreate(
            ['nama' => 'Superadmin']
            // Hapus parameter kedua yang berisi deskripsi
        );

        // Buat user superadmin jika belum ada
        User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password123'),  // Ganti dengan password yang lebih aman
                'role' => 'superadmin',
                'unit_kerja_id' => $unitKerja->id,
            ]
        );

        $this->command->info('User Superadmin berhasil dibuat!');
    }
}
