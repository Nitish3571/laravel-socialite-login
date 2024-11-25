<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    protected static ?string $password;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->createMany([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => static::$password ??= Hash::make('admin'),
                'phone_no' => '7070603571',
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => static::$password ??= Hash::make('password'),
                'phone_no' => '7070603572',
            ]
        ]);

    User::factory(2)->create();

    }
}
