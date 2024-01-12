<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Address;

use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // You can customize the password below
        $password = '123456';

        // Create 10 users with the same password
        User::factory(10)->create([
            'password' => Hash::make($password),
        ]);

        $this->call([
            WorldSeeder::class,
            AddressesTableSeeder::class,
            StoresTableSeeder::class,

        ]);
    }
}
