<?php

namespace Database\Seeders;

use App\Models\BoardingType;
use Illuminate\Database\Seeder;

class BoardingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BoardingType::create([
            "name" =>'Mansion'
        ]);
        BoardingType::create([
            "name" =>'House'
        ]);
        BoardingType::create([
            "name" =>'Apartment'
        ]);
        BoardingType::create([
            "name" =>'Not a Mansion'
        ]);
        BoardingType::create([
            "name" =>'Condo'
        ]);
        BoardingType::create([
            "name" =>'Trailer'
        ]);
        BoardingType::create([
            "name" =>'CyberSpace'
        ]);
    }
}
