<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\AddressBook;

class AddressTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('address_books')->truncate();
        
		for($i=1; $i<11;$i++){
        	AddressBook::create([ 'title'=>'Work','uid'=>$i ,'name' => 'Tia Maheshwari','contact' => '9967524841','add1'=>'Line 1','add2'=>'Line 2','add3'=>'Line 3','pincode'=>'400065','city'=>'Mumbai','state'=>'Maharashtra','country'=>'India' ]);
        }
	}

}
