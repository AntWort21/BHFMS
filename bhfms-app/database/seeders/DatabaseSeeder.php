<?php

namespace Database\Seeders;

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
            UserRoleSeeder::class,
            UserSeeder::class,
            BoardingTypeSeeder::class,
            // FacilityDetailSeeder::class,
            // BoardingSeeder::class,
            
            // FacilitySeeder::class,
            // BoardingImageSeeder::class,
            // OwnerBoardingSeeder::class,
            // TenantBoardingSeeder::class,
            PaymentMethodsSeeder::class,
            TransactionTypesSeeder::class,
            // RentTransactionSeeder::class,
            ComplainTypeSeeder::class,
            StartingSeeder::class,
            // ComplainSeeder::class,
            // ReviewSeeder::class,
        ]);

    }
}
