<?php

namespace Database\Seeders;

use App\Models\Boarding;
use App\Models\BoardingType;
use App\Models\FacilityDetail;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            BoardingTypeSeeder::class,
            FacilityDetailSeeder::class,
            BoardingSeeder::class,
            FacilitySeeder::class,
            BoardingImageSeeder::class,
        ]);
        
    }
}
