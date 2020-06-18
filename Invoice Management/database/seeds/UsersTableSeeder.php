<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        'name' => 'test',
        'email' => 'test@domain.com',
        'password' => Hash::make('test')
      ]);
	  
	  User::create([
        'name' => 'test2',
        'email' => 'test2@domain.com',
        'password' => Hash::make('test2')
      ]);
    }
}
