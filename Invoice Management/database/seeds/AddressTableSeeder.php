<?php

use Illuminate\Database\Seeder;

class AddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $testData = array(
		
		array('unitNumber' => 11,
		'street' => '10 Fake Street',
		'city' => 'Toronto',
		'province' => 'Ontario',
		'postalCode' => 'M2L 1D4',
		'client_id' => 1),
    
		array('unitNumber' => 321,
		'street' => '111 Fake Street',
		'city' => 'Toronto',
		'province' => 'Ontario',
		'postalCode' => 'A2A 1D4',
		'client_id' => 2));
		
		DB::table('address')->insert($testData);
    }
}
