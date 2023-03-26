<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentTransactionDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_transaction_detail', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('transaction_header_id');
            $table->foreign('transaction_header_id')->references('id')
            ->on('rent_transaction_header')->cascadeOnUpdate()->cascadeOnDelete();

            $table->unsignedBigInteger('payment_type_id');
            $table->foreign('payment_type_id')->references('id')
            ->on('payment_types')->cascadeOnUpdate()->cascadeOnDelete();

            $table->unsignedBigInteger('boarding_id');
            $table->foreign('boarding_id')->references('id')
            ->on('boardings')->cascadeOnUpdate()->cascadeOnDelete();
            
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('payment_status');
            $table->string('declined_reason');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rent_transaction_detail');
    }
}
