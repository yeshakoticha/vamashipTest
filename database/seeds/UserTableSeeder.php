<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class UserTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->truncate();

        
		for($i=1; $i<11;$i++){
        	User::create(['name' => 'Yesha','email' => 'foo@bar'.$i.'.com','password' => Hash::make('test123')]);
        }
	}

}
