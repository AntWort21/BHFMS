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
            "facility_detail_name" =>'Electric Shower'
        ]);
        FacilityDetail::create([
            "facility_detail_name" =>'Shower'
        ]);
        FacilityDetail::create([
            "facility_detail_name" =>'Electric Lock'
        ]);
        FacilityDetail::create([
            "facility_detail_name" =>'Pool'
        ]);
        FacilityDetail::create([
            "facility_detail_name" =>'Free Parking'
        ]);
        FacilityDetail::create([
            "facility_detail_name" =>'Pets Allowed'
        ]);
    }
}
