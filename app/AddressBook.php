<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AddressBook extends Model {

	use SoftDeletes;

	protected $table = 'address_books';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['title','uid','name', 'contact', 'add1','add2','add3','pincode','city','state','country'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];

}
