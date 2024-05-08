<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat data admin
        Admin::create([
            'username' => 'Adminvms',
            'password' => Hash::make('admin123'),
        ]);
    }
}
