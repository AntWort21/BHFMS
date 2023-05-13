<?php

namespace Database\Seeders;

use App\Models\TenantBoarding;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TenantBoardingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        TenantBoarding::create([
            "user_id" => 6,
            "boarding_id" => 1,
            "start_date" => Carbon::today(),
            "end_date" => Carbon::today(),
            "tenant_status" => "declined",
            "declined_reason" => "Too young",
            "start_date" => Carbon::create(2022, 1, 1),
            "end_date" => Carbon::create(2022, 4, 1)
        ]);
        TenantBoarding::create([
            "user_id" => 6,
            "boarding_id" => 2,
            "start_date" => Carbon::today(),
            "end_date" => Carbon::today(),
            "tenant_status" => "pending",
            "declined_reason" => "Too young",
            "start_date" => Carbon::create(2022, 1, 1),
            "end_date" => Carbon::create(2022, 4, 1)
        ]);
        TenantBoarding::create([
            "user_id" => 6,
            "boarding_id" => 3,
            "start_date" => Carbon::today(),
            "end_date" => Carbon::today(),
            "tenant_status" => "pending",
            "declined_reason" => "Too young",
            "start_date" => Carbon::create(2022, 1, 1),
            "end_date" => Carbon::create(2022, 4, 1)
        ]);
        TenantBoarding::create([
            "user_id" => 6,
            "boarding_id" => 4,
            "start_date" => Carbon::today(),
            "end_date" => Carbon::today(),
            "tenant_status" => "pending",
            "declined_reason" => "Too young",
            "start_date" => Carbon::create(2022, 1, 1),
            "end_date" => Carbon::create(2022, 4, 1)
        ]);



    }
}
