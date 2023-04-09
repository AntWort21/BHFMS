<?php

namespace Database\Seeders;

use App\Models\Boarding;
use App\Models\BoardingType;
use App\Models\FacilityDetail;
use App\Models\RentTransaction;
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
            UserRoleSeeder::class,
            FacilitySeeder::class,
            BoardingImageSeeder::class,
            OwnerBoardingSeeder::class,
            TenantBoardingSeeder::class,
            PaymentTypesSeeder::class,
            RentTransactionSeeder::class,
        ]);

    }
}
