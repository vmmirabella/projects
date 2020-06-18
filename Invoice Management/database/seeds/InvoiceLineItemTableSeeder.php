<?php

use Illuminate\Database\Seeder;

class InvoiceLineItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $testData = array(
		
		array(
		'invoice_id' => 1,
		'totalHours' => 33,
		'totalPrice' => 100 + (20*33),
		'name' => 'Duct Cleaning',
		'shortDescription' => 'Duct cleaning services',
		'flatRate' => 100.00,
		'hourlyRate' => 20.00,
		'longDescription' => 'Duct cleaning services for your entire block'),
    
		array(
		'invoice_id' => 2,
		'totalHours' => 33,
		'totalPrice' => 100 + (30*33),
		'name' => 'Roof Cleaning',
		'shortDescription' => 'Roof cleaning services',
		'flatRate' => 100.00,
		'hourlyRate' => 30.00,
		'longDescription' => 'Roof cleaning services for your entire block'));
		
		DB::table('invoiceLineItem')->insert($testData);
    }
}
