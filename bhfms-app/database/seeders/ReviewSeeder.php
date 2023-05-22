<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Review::create([
            'user_id' => 10,
            'boarding_id' => 1,
            'rating' => 3,
            'review_desc' => 'Good place to live',
        ]);

        Review::create([
            'user_id' => 5,
            'boarding_id' => 1,
            'rating' => 4,
            'review_desc' => 'Relaxing place',
        ]);

        Review::create([
            'user_id' => 6,
            'boarding_id' => 1,
            'rating' => 4,
            'review_desc' => 'clean place',
        ]);
    }
}
