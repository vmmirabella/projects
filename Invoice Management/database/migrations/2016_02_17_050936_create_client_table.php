<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client', function (Blueprint $table) {
            $table->increments('id');
			$table->string('companyName');
			$table->string('clientName');
			$table->integer('address_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->string('email')->unique();
			$table->string('phone');
			
			$table->foreign('address_id')->references('id')->on('address')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users');
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('client');
    }
}
