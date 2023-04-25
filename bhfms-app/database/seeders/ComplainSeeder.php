<?php

namespace Database\Seeders;

use App\Models\Complain;
use Illuminate\Database\Seeder;

class ComplainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Complain::create([
            'user_id' => 10,
            'boarding_id' => 4,
            'complain_type_id' => 4,
            'complain_desc' => "wifinya sangat lemot",
            'complain_image_url' => "/storage/images/images.jpg",
            'complain_status' => 1,
        ]);

        Complain::create([
            'user_id' => 10,
            'boarding_id' => 4,
            'complain_type_id' => 2,
            'complain_desc' => "kunci saya hilang",
            'complain_image_url' => "/storage/images/images.jpg",
            'complain_status' => 2,
        ]);

        Complain::create([
            'user_id' => 10,
            'boarding_id' => 4,
            'complain_type_id' => 3,
            'complain_desc' => "tetangganya berisik",
            'complain_image_url' => "/storage/images/images.jpg",
            'complain_status' => 3,
        ]);
    }
}
