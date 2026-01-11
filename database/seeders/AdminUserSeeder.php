<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'], // Search by username
            [
                'name' => 'The Dictionary Lord',
                'email' => 'admin@admin.com',
                'password' => Hash::make('11111111'),
                'is_admin' => true,
            ]
        );
    }
}
