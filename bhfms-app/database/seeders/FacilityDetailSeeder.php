<?php

namespace Database\Seeders;

use App\Models\FacilityDetail;
use Illuminate\Database\Seeder;

class FacilityDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FacilityDetail::create([
            "name" =>'Electric Shower'
        ]);
        FacilityDetail::create([
            "name" =>'Shower'
        ]);
        FacilityDetail::create([
            "name" =>'Electric Lock'
        ]);
        FacilityDetail::create([
            "name" =>'Pool'
        ]);
        FacilityDetail::create([
            "name" =>'Free Parking'
        ]);
        FacilityDetail::create([
            "name" =>'Pets Allowed'
        ]);
    }
}
