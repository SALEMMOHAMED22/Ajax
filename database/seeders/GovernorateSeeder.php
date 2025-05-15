<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Governorate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $governorate = Governorate::factory(5)->create();

        $governorate->each(function ($governorate) {
            
            City::factory(5)->create(['governorate_id' => $governorate->id]);
        });
    }
}
