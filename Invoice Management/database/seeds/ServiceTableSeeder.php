<?php

use Illuminate\Database\Seeder;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		
		$testData = array(
		
		array('name' => 'Duct Cleaning',
		'user_id' => 1,
		'shortDescription' => 'Duct cleaning services',
		'flatRate' => 100.00,
		'hourlyRate' => 20.00,
		'longDescription' => 'Duct cleaning services for your entire block'),
    
		array('name' => 'Roof Cleaning',
		'user_id' => 1,
		'shortDescription' => 'Roof cleaning services',
		'flatRate' => 100.00,
		'hourlyRate' => 30.00,
		'longDescription' => 'Roof cleaning services for your entire block'));
		
		DB::table('service')->insert($testData);
		
    }
}
