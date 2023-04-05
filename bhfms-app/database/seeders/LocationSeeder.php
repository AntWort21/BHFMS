<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Country
        // $sql_1 = file_get_contents(storage_path('app/public/Location_Database/countries.sql'));
        $sql_1 = "INSERT INTO countries (id, country_name, lat, lng) VALUES ('62', 'Indonesia', '-2.46534253', '118.0150932');";
        DB::statement($sql_1);

        // Province
        $sql_2 = file_get_contents(storage_path('app/public/Location_Database/provinces.sql'));
        DB::statement($sql_2);

        // City
        $sql_3 = file_get_contents(storage_path('app/public/Location_Database/cities.sql'));
        DB::statement($sql_3);

        // District
        $sql_4 = file_get_contents(storage_path('app/public/Location_Database/districts.sql'));
        DB::statement($sql_4);

    }
}
