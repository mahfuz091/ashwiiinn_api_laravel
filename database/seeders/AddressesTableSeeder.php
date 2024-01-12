<?php

namespace Database\Seeders;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Address;



class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i=0; $i < 5 ; $i++) { 
     
            Address::create([
                
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
}
