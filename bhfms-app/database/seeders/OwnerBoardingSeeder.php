<?php

namespace Database\Seeders;

use App\Models\OwnerBoarding;
use Illuminate\Database\Seeder;

class OwnerBoardingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Declined
        OwnerBoarding::create([
            "user_id"=>1,
            "boarding_id"=>1,
            "status"=>3,
            "declined_reason"=>"Too many Cats"
        ]);
        OwnerBoarding::create([
            "user_id"=>2,
            "boarding_id"=>2,
            "status"=>3,
            "declined_reason"=>"Too many Mouse"
        ]);
        OwnerBoarding::create([
            "user_id"=>1,
            "boarding_id"=>3,
            "status"=>3,
            "declined_reason"=>"Will give you Up"
        ]);

        //Accepted
        OwnerBoarding::create([
            "user_id"=>2,
            "boarding_id"=>4,
            "status"=>2,
        ]);
        OwnerBoarding::create([
            "user_id"=>2,
            "boarding_id"=>5,
            "status"=>2,
        ]);
        OwnerBoarding::create([
            "user_id"=>1,
            "boarding_id"=>6,
            "status"=>2,
        ]);
        OwnerBoarding::create([
            "user_id"=>3,
            "boarding_id"=>7,
            "status"=>2,
        ]);
        OwnerBoarding::create([
            "user_id"=>3,
            "boarding_id"=>8,
            "status"=>2,
        ]);
        OwnerBoarding::create([
            "user_id"=>3,
            "boarding_id"=>9,
            "status"=>2,
        ]);
        OwnerBoarding::create([
            "user_id"=>3,
            "boarding_id"=>10,
            "status"=>2,
        ]);
        
        //Pending
        OwnerBoarding::create([
            "user_id"=>3,
            "boarding_id"=>11,
            "status"=>3,
        ]);
        OwnerBoarding::create([
            "user_id"=>3,
            "boarding_id"=>12,
            "status"=>3,
        ]);
        OwnerBoarding::create([
            "user_id"=>4,
            "boarding_id"=>13,
            "status"=>3,
        ]);
        OwnerBoarding::create([
            "user_id"=>4,
            "boarding_id"=>14,
            "status"=>3,
        ]);
    }
}
