<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                // Check if the admin user already exists to avoid duplicate entries
                $adminExists = DB::table('users')->where('email', 'admin@admin.com')->exists();

                if (!$adminExists) {
                    DB::table('users')->insert([
                        'name' => 'Admin User', // You can customize the name here
                        'email' => 'admin@admin.com',
                        'password' => Hash::make('password'), // Always hash passwords!
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
        
                }
    }
}