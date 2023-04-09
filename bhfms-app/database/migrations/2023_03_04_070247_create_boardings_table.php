<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boardings', function (Blueprint $table) {
            $table->id();
            $table->string('boarding_name');
            $table->string('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('boarding_types');
            $table->integer('rooms');
            $table->boolean('shared_bathroom');
            $table->integer('price');
            $table->string('boarding_desc');
            $table->string('declined_reason')->nullable();
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
        Schema::dropIfExists('boardings');
    }
}
