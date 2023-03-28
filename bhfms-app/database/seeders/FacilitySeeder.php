<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Facility::create([
            "boarding_id"=>1,
            "facility_id" =>1
        ]);
        Facility::create([
            "boarding_id"=>1,
            "facility_id" =>2
        ]);
        Facility::create([
            "boarding_id"=>1,
            "facility_id" =>3
        ]);
        Facility::create([
            "boarding_id"=>1,
            "facility_id" =>4
        ]);

        Facility::create([
            "boarding_id"=>2,
            "facility_id" =>1
        ]);

        Facility::create([
            "boarding_id"=>3,
            "facility_id" =>3
        ]);
        Facility::create([
            "boarding_id"=>4,
            "facility_id" =>2
        ]);
        Facility::create([
            "boarding_id"=>4,
            "facility_id" =>3
        ]);
        Facility::create([
            "boarding_id"=>5,
            "facility_id" =>2
        ]);
        Facility::create([
            "boarding_id"=>6,
            "facility_id" =>3
        ]);
        Facility::create([
            "boarding_id"=>7,
            "facility_id" =>2
        ]);
        Facility::create([
            "boarding_id"=>8,
            "facility_id" =>3
        ]);
    }
}
