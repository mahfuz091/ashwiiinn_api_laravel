<?php

namespace Database\Seeders;
use Faker\Factory as Faker;
use App\Models\Store;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        Store::create([
            'user_id'=> 1,
            'address_line'=> $faker->address(),
            'street' => '123 Main St',
            'city_id' => 129448,
            'state_id' => 4748,
            'postal_code' => '12345',
            'phone' => $faker->phoneNumber(),
            'country_id' => 236,
            
        ]);
    }
}
