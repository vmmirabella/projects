<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->increments('id');

			//invoice
			$table->string('invoiceNumber')->unique();
			$table->dateTime('sentEmail')->nullable()->default(null);
			$table->dateTime('paidDate')->nullable()->default(null);
			$table->dateTime('dueDate');
			$table->decimal('taxRate', 15, 2);
			$table->decimal('subtotal', 15, 2);
			$table->decimal('total', 15, 2);
			
			//client
			$table->string('companyName');
			$table->string('clientName');
			$table->integer('user_id')->unsigned();
			$table->string('email');
			$table->string('phone');
			
			//address
			$table->integer('unitNumber');
			$table->string('street');
			$table->string('city');
			$table->string('province');
			$table->string('postalCode');
			
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
        Schema::drop('invoice');
    }
}
