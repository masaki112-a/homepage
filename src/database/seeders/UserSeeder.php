<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 管理者ユーザーの作成
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 特別ユーザーの作成
        User::create([
            'name' => 'Special User',
            'email' => 'special@example.com',
            'password' => Hash::make('password'),
            'role' => 'special',
        ]);

        // 一般ユーザーの作成
        User::create([
            'name' => 'General User',
            'email' => 'general@example.com',
            'password' => Hash::make('password'),
            'role' => 'general',
        ]);
    }
}
