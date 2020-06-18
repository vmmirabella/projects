<?php

use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $testData = array(
		
		array('companyName' => 'Intel',
		'clientName' => 'John Smith',
		'address_id' => 1,
		'user_id' => 1,
		'email' => 'a1@example.com',
		'phone' => '(111) 123-222'),
    
		array('companyName' => 'Intel Building B',
		'clientName' => 'Jane Doe',
		'address_id' => 2,
		'user_id' => 1,
		'email' => 'a2@example.com',
		'phone' => '(111) 123-222'));
		
		DB::table('client')->insert($testData);
    }
}
