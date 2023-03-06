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
            $table->string('name');
            $table->string('address');
            $table->string('map_location');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('boarding_house_types');
            $table->integer('rooms');
            $table->boolean('shared_bathroom');
            $table->integer('price');
            $table->string('description');
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
        Schema::dropIfExists('boardings');
    }
}
