<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceLineItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoiceLineItem', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('invoice_id')->unsigned();
			$table->integer('totalHours')->unsigned();
			$table->decimal('totalPrice', 15, 2);

			$table->string('name');
			$table->string('shortDescription');
			$table->decimal('flatRate', 10, 2);
			$table->decimal('hourlyRate', 10, 2);
			$table->string('longDescription');
			
			$table->foreign('invoice_id')->references('id')->on('invoice');
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('invoiceLineItem');
    }
}
