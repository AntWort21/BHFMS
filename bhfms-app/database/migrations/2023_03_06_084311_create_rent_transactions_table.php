<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tenant_boarding_id');
            $table->foreign('tenant_boarding_id')->references('id')
            ->on('tenant_boardings')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('transaction_type_id');
            $table->foreign('transaction_type_id')->references('id')
            ->on('transaction_types')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('payment_type_id')->nullable();
            $table->foreign('payment_type_id')->references('id')
            ->on('payment_types')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('amount');
            $table->date('payment_date');
            $table->enum('payment_status',['pending','approved','rejected','late'])->default('pending');
            $table->string('declined_reason')->nullable();
            $table->boolean('payment_transferred');
            $table->boolean('repeat_payment')->default(false);
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
        Schema::dropIfExists('rent_transactions');
    }
}
