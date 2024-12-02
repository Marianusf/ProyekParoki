<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'nama' => 'Admin Utama',
            'email' => 'admin@gmail.com',
            'nomor_telepon' => '081234567890',
            'password' => Hash::make(env('ADMIN_PASSWORD')), // Mengambil password dari .env
            'role' => 'admin',
        ]);

        Admin::create([
            'nama' => 'Sekretariat Gereja',
            'email' => 'sekretariat@gmail.com',
            'nomor_telepon' => '081234567891',
            'password' => Hash::make(env('SEKRETARIAT_PASSWORD')), // Mengambil password dari .env
            'role' => 'sekretariat',
        ]);
        // Admin::create([
        //     'nama' => 'Admin Paramenta',
        //     'email' => 'sekretariat@gmail.com',
        //     'nomor_telepon' => '081234567891',
        //     'password' => Hash::make(env('PARAMENTA_PASSWORD')), // Mengambil password dari .env
        //     'role' => 'paramenta',
        // ]);
    }
}
