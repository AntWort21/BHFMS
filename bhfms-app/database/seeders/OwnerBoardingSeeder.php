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
        OwnerBoarding::create([
            "user_id" => "1",
            "boarding_id" => "1",
        ]);
    }
}
