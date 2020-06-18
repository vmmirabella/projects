<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InvoiceTableSeeder extends Seeder
{
	
	private function randomString($length) {
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$result = "".$chars[rand(0 , strlen($chars)-1)];
		for ($i = 1; $i < $length; $i++) 
			$result .= "".$chars[rand(0 , strlen($chars)-1)];
		return $result;
	}
	
    /**
     * Run the database seeds.
     *
     * @return void
     */
	 
    public function run()
    {
		
		
        $testData = array(
		
		array(
		'invoiceNumber' => $this->randomString(12),
		'taxRate' => 10,
		'subtotal' => 760,
		'total' => 760*1.1,
		'sentEmail' => null,
		'paidDate' => null,
		'created_at' => Carbon::now(),
		'dueDate' => Carbon::now()->addDays(5),
		'companyName' => 'Intel',
		'clientName' => 'John Smith',
		'user_id' => 1,
		'email' => 'a1@example.com',
		'phone' => '(111) 123-222',
		'unitNumber' => 11,
		'street' => '10 Fake Street',
		'city' => 'Toronto',
		'province' => 'Ontario',
		'postalCode' => 'M2L 1D4'
		),
    
		array(
		'invoiceNumber' => $this->randomString(12),
		'taxRate' => 40,
		'subtotal' => 1090,
		'total' => 1090*1.4,
		'sentEmail' => null,
		'paidDate' => null,
		'created_at' => Carbon::now(),
		'dueDate' => Carbon::now()->addDays(5),
		'companyName' => 'Intel',
		'clientName' => 'John Smith',
		'user_id' => 1,
		'email' => 'a1@example.com',
		'phone' => '(111) 123-222',
		'unitNumber' => 11,
		'street' => '10 Fake Street',
		'city' => 'Toronto',
		'province' => 'Ontario',
		'postalCode' => 'M2L 1D4'));
		
		DB::table('invoice')->insert($testData);
    }
	
	
							
}
