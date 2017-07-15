<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('pets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('breed');
            $table->integer('age');
            $table->string('name')->nullable();
            $table->float('price');
            $table->dateTime('list_date');
            $table->dateTime('sale_date')->nullable();
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
        Schema::drop('pets');
    }
}
