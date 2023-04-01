<?php

namespace Database\Seeders;

use App\Models\BoardingImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BoardingImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = file_get_contents(storage_path('app').'/public/boarding_images.sql');
        DB::statement($sql);
    }
}
