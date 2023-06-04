<?php

namespace App\Console\Commands;

use App\Models\RentTransaction;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckLatePayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:late';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scheduler to check late payment and update status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currDate =  Carbon::now()->timezone('Asia/Jakarta')->startOfDay();
        $lateTransactions = RentTransaction::where('payment_date','<',$currDate)
        ->whereIn('payment_status', ['Pending', 'Rejected'])
        ->get();
        foreach ($lateTransactions as $transaction) {
            $transaction->payment_status = 'Late';
            $transaction->save();
        }
    }
}
