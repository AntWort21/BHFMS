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
                //Declined
                TenantBoarding::create([
                    "user_id"=>1,
                    "boarding_id"=>1,
                    "start_date" => Carbon::today(),
                    "end_date" => Carbon::today(),
                    "status"=>3,
                    "declined_reason"=>"Too young"
                ]);
                TenantBoarding::create([
                    "user_id"=>2,
                    "boarding_id"=>2,
                    "start_date" => Carbon::today(),
                    "end_date" => Carbon::today(),
                    "status"=>3,
                    "declined_reason"=>"Too old"
                ]);
                TenantBoarding::create([
                    "user_id"=>1,
                    "boarding_id"=>3,
                    "start_date" => Carbon::today(),
                    "end_date" => Carbon::today(),
                    "status"=>3,
                    "declined_reason"=>"Will give you Up"
                ]);

                //Accepted
                TenantBoarding::create([
                    "user_id"=>2,
                    "boarding_id"=>4,
                    "start_date"=>Carbon::today(),
                    "end_date"=>Carbon::create(2023,5,5),
                    "status"=>2,
                ]);
                TenantBoarding::create([
                    "user_id"=>2,
                    "boarding_id"=>5,
                    "start_date"=>Carbon::today(),
                    "end_date"=>Carbon::create(2023,5,5),
                    "status"=>2,
                ]);
                TenantBoarding::create([
                    "user_id"=>1,
                    "boarding_id"=>6,
                    "start_date"=>Carbon::today(),
                    "end_date"=>Carbon::create(2023,5,5),
                    "status"=>2,
                ]);
                TenantBoarding::create([
                    "user_id"=>3,
                    "boarding_id"=>7,
                    "start_date"=>Carbon::today(),
                    "end_date"=>Carbon::create(2023,5,5),
                    "status"=>2,
                ]);
                TenantBoarding::create([
                    "user_id"=>3,
                    "boarding_id"=>8,
                    "start_date"=>Carbon::today(),
                    "end_date"=>Carbon::create(2023,5,5),
                    "status"=>2,
                ]);
                TenantBoarding::create([
                    "user_id"=>3,
                    "boarding_id"=>9,
                    "start_date"=>Carbon::today(),
                    "end_date"=>Carbon::create(2023,5,5),
                    "status"=>2,
                ]);
                TenantBoarding::create([
                    "user_id"=>3,
                    "boarding_id"=>10,
                    "start_date"=>Carbon::today(),
                    "end_date"=>Carbon::create(2023,5,5),
                    "status"=>2,
                ]);

                //Pending
                TenantBoarding::create([
                    "user_id"=>3,
                    "boarding_id"=>11,
                    "start_date"=>Carbon::today(),
                    "end_date"=>Carbon::create(2023,5,5),
                    "status"=>3,
                ]);
                TenantBoarding::create([
                    "user_id"=>3,
                    "boarding_id"=>12,
                    "start_date"=>Carbon::today(),
                    "end_date"=>Carbon::create(2023,5,5),
                    "status"=>3,
                ]);
                TenantBoarding::create([
                    "user_id"=>4,
                    "boarding_id"=>13,
                    "start_date"=>Carbon::today(),
                    "end_date"=>Carbon::create(2023,5,5),
                    "status"=>3,
                ]);
                TenantBoarding::create([
                    "user_id"=>4,
                    "boarding_id"=>14,
                    "start_date"=>Carbon::today(),
                    "end_date"=>Carbon::create(2023,5,5),
                    "status"=>3,
                ]);
                TenantBoarding::create([
                    "user_id"=>10,
                    "boarding_id"=>1,
                    "start_date"=>Carbon::today(),
                    "end_date"=>Carbon::create(2023,5,5),
                    "status"=>2,
                ]);
    }
}
