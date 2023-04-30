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
            "tenant_boarding_id"=>14,
            "payment_method_id"=>1,
            "transaction_type_id"=>1,
            "invoice_id"=>"230000001",
            "payment_status"=>1,
            "payment_date"=>Carbon::today(),
            "amount"=>0,
            "repeat_payment"=>False,
            "payment_transferred_status"=>'Pending',
        ]);
    }
}
