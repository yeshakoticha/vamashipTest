<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\AddressBook;
use DB;
use Request;
use Auth;
use App\User;


//use Illuminate\Http\Request;

class AddressBookController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function __construct(){
		$this->middleware('auth');
	}

	public function lists(){
		$uid = Auth::user()->id;

		$addr = DB::table('address_books')->where('uid',$uid)->whereNull('deleted_at')->get();
		return view('listAddressBook')->with('addr',$addr);	
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('createAddr');	
	}

	public function saveAddr($uid=null){

		$input = Request::all(); 
		$addrBook = new AddressBook(); 

		$uid = Auth::user()->id;

		$addrBook->title = $input['title'];
		$addrBook->name  = $input['name'];
		$addrBook->contact  = $input['contact'];
		$addrBook->add1  = $input['add1'];
		$addrBook->add2  = $input['add2'];
		$addrBook->add3  = $input['add3'];
		$addrBook->pincode  = $input['pincode'];
		$addrBook->city  = $input['city'];
		$addrBook->state  = $input['state'];
		$addrBook->country  = $input['country'];
		$addrBook->uid  = $uid;

		$IsDataSaved = $addrBook->save();

		if($IsDataSaved==1){

			\Session::flash('flash_message','Your address is added!');
			return redirect()->back();

		}else{

			$error = "Data not saved, please try again."; 
			return redirect()->back()->withErrors($error);
		}
	}

	public function show($id){
		$input  = AddressBook::findOrFail($id); 
        return \View::make('editAddr')->with('input', $input);  
	}

	public function profile(){
		$id = Auth::user()->id;
		$input  = User::findOrFail($id); 
        return \View::make('auth.editRegister')->with('input', $input);  
	}

	
	public function updateProfile()
	{
		$input = Request::except('_token');
		$id = Auth::user()->id;

		$IsDataUpdated = User::where('id', $id)->update($input);
		if($IsDataUpdated==1){

			\Session::flash('flash_message','Your address is updated!');
			return redirect()->back();

		}else{

			$error = "Your data could not be updated, please try again!"; 
			return redirect()->back()->withErrors($error);
		}
	}

	public function edit()
	{
		$input = Request::except('_token');
		$IsDataUpdated = AddressBook::where('id', $input['id'])->update($input);
		if($IsDataUpdated==1){

			\Session::flash('flash_message','Your address is updated!');
			return redirect()->back();

		}else{

			$error = "Your data could not be updated, please try again!"; 
			return redirect()->back()->withErrors($error);
		}
	}
	
	public function delete($id)
	{
		$IsRecordDeleted = AddressBook::where('id', $id)->delete();	
		if($IsRecordDeleted==1){

			\Session::flash('flash_message','Your record is deleted!');
			return redirect()->back();

		}else{

			$error = "Your record could not be deleted, please try again!"; 
			return redirect()->back()->withErrors($error);
		}
	}

	public function defaultFrom($id){
		$uid = Auth::user()->id;
		$AddressBook = new AddressBook();
		$AreRecordsUpdated = $AddressBook->where('uid', $uid)->where('uid', $uid)->update(['default_from'=>0]);

		if($AreRecordsUpdated>=1){
			$IsRecordUpdated = AddressBook::where('id', $id)->where('uid', $uid)->update(['default_from'=>1]);	

			if($IsRecordUpdated==1){
				\Session::flash('flash_message','Your record is updated!');
				return redirect()->back();
			}else{

				$error = "Your record could not be updated, please try again!"; 
				return redirect()->back()->withErrors($error);
			}
		}else{
			$error = "Your record could not be updated, please try again!"; 
			return redirect()->back()->withErrors($error);
		}		
	}

	public function defaultTo($id){
		$uid = Auth::user()->id;		
		$AddressBook = new AddressBook();
		$AreRecordsUpdated = $AddressBook->where('uid', $uid)->update(['default_to'=>0]);

		if($AreRecordsUpdated>=1){
			$IsRecordUpdated = AddressBook::where('id', $id)->where('uid', $uid)->update(['default_to'=>1]);	

			if($IsRecordUpdated==1){
				\Session::flash('flash_message','Your record is updated!');
				return redirect()->back();
			}else{

				$error = "Your record could not be updated, please try again!"; 
				return redirect()->back()->withErrors($error);
			}
		}else{
			$error = "Your record could not be updated, please try again!"; 
			return redirect()->back()->withErrors($error);
		}		
	}

}
