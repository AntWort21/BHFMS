<?php

namespace Database\Seeders;

use App\Models\Boarding;
use App\Models\BoardingType;
use App\Models\FacilityDetail;
use App\Models\TenantBoarding;
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
            UserSeeder::class,
            BoardingTypeSeeder::class,
            FacilityDetailSeeder::class,
            BoardingSeeder::class,
            FacilitySeeder::class,
            BoardingImageSeeder::class,
            OwnerBoardingSeeder::class,
            TenantBoardingSeeder::class,
            LocationSeeder::class,
            UserRoleSeeder::class,
            UserSeeder::class,
            PaymentTypesSeeder::class,
            RentTransactionHeaderSeeder::class,
            RentTransactionDetailSeeder::class,
        ]);

    }
}
