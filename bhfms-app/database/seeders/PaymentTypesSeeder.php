<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentType::create([
            "payment_type_name"=>"QRIS",
            "status" =>"disable"
        ]);
        PaymentType::create([
            "payment_type_name"=>"BCA",
            "status" =>"available"
        ]);
        PaymentType::create([
            "payment_type_name"=>"Mandiri",
            "status" =>"available"
        ]);
    }
}
