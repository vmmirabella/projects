<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name')->unique();
			$table->string('shortDescription', 80);
			$table->decimal('flatRate', 10, 2);
			$table->decimal('hourlyRate', 10, 2);
			$table->string('longDescription');
			$table->integer('user_id')->unsigned();
			
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
        Schema::drop('service');
    }
}
