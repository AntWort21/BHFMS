<?php

namespace Database\Seeders;

use App\Models\RentTransaction;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RentTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RentTransaction::create([
            "tenant_id"=>1,
            "payment_type_id"=>1,
            "payment_status"=>1,
            "start_date"=>Carbon::today(),
            "end_date"=>Carbon::create(2023,5,5)
        ]);
    }
}
