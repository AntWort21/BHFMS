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
            "owner_status"=>3,
            "declined_reason"=>"Too many Cats"
        ]);
        OwnerBoarding::create([
            "user_id"=>2,
            "boarding_id"=>2,
            "owner_status"=>3,
            "declined_reason"=>"Too many Mouse"
        ]);
        OwnerBoarding::create([
            "user_id"=>1,
            "boarding_id"=>3,
            "owner_status"=>3,
            "declined_reason"=>"Will give you Up"
        ]);

        //Accepted
        OwnerBoarding::create([
            "user_id"=>2,
            "boarding_id"=>4,
            "owner_status"=>2,
        ]);
        OwnerBoarding::create([
            "user_id"=>2,
            "boarding_id"=>5,
            "owner_status"=>2,
        ]);
        OwnerBoarding::create([
            "user_id"=>1,
            "boarding_id"=>6,
            "owner_status"=>2,
        ]);
        OwnerBoarding::create([
            "user_id"=>3,
            "boarding_id"=>7,
            "owner_status"=>2,
        ]);
        OwnerBoarding::create([
            "user_id"=>3,
            "boarding_id"=>8,
            "owner_status"=>2,
        ]);
        OwnerBoarding::create([
            "user_id"=>3,
            "boarding_id"=>9,
            "owner_status"=>2,
        ]);
        OwnerBoarding::create([
            "user_id"=>3,
            "boarding_id"=>10,
            "owner_status"=>2,
        ]);
        
        //Pending
        OwnerBoarding::create([
            "user_id"=>3,
            "boarding_id"=>11,
            "owner_status"=>3,
        ]);
        OwnerBoarding::create([
            "user_id"=>3,
            "boarding_id"=>12,
            "owner_status"=>3,
        ]);
        OwnerBoarding::create([
            "user_id"=>4,
            "boarding_id"=>13,
            "owner_status"=>3,
        ]);
        OwnerBoarding::create([
            "user_id"=>4,
            "boarding_id"=>14,
            "owner_status"=>3,
        ]);
    }
}
