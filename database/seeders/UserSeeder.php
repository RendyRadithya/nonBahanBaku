<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus semua user (opsional, hati-hati jika production)
        // User::truncate(); // Truncate might fail with foreign keys in some DBs without disabling checks

        $users = [
            [
                'name' => 'Manager Stock',
                'email' => 'manager@mcorder.com',
                'password' => 'password123',
                'role' => 'manager_stock',
                'phone' => '081234567890',
                'store_name' => 'McDonald\'s Citra Garden',
            ],
            [
                'name' => 'Vendor Sadikun',
                'email' => 'vendor@mcorder.com',
                'password' => 'password123',
                'role' => 'vendor',
                'phone' => '081234567891',
                'store_name' => 'PT Sadikun Gas',
            ],
            [
                'name' => 'Admin McOrder',
                'email' => 'admin@mcorder.com',
                'password' => 'password123',
                'role' => 'admin',
                'phone' => '081234567892',
                'store_name' => 'McOrder HQ',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']], // Check by email
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'role' => $userData['role'],
                    'phone' => $userData['phone'],
                    'store_name' => $userData['store_name'],
                ]
            );
        }
    }
}
