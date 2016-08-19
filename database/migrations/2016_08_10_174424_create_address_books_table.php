<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressBooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('address_books', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('uid');
			$table->string('title');
			$table->string('name');
			$table->string('contact');
			$table->string('add1');
			$table->string('add2');
			$table->string('add3');
			$table->string('pincode');
			$table->string('city');
			$table->string('state');
			$table->string('country');
			$table->tinyInteger('default_from');
			$table->tinyInteger('default_to');
			$table->softDeletes();
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
		Schema::drop('address_books');
	}

}
