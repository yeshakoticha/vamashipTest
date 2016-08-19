<?php
namespace App\Http\Controllers;
use Request;
use App\Http\Requests;
use App\User;
use Hash;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use DB;
use App\AddressBook;


class APIController extends Controller{
   
    public function authenticate(){

        $credentials = Request::only('email','password');
        $status      = 'ok';

        try {
            // attempt to verify the credentials and create a token for the user
            $email = $credentials['email'];
            $EmailExists = User::where('email',$email)->count();

            if($EmailExists==0){
                $status  = 'fail';
                return response()->json(['status' => $status, 'error' => 'Email does not exist', 'token'=>''], 401);
            }

            if (! $token = JWTAuth::attempt($credentials)) {
                $status  = 'fail';
                return response()->json(['status' => $status, 'error' => 'Invalid credentials', 'token'=>''], 401);
            }

        } catch (JWTException $e) {
            $status = 'fail';
            // something went wrong whilst attempting to encode the token
            return response()->json(['status' => $status,'error' => 'Token could not be created', 'token'=>''], 500);
        }

        return response()->json(['status' => $status,'error'=>'','token' => $token]);
    }


    public function refreshToken(){
        $status = 'ok';
        $token  = JWTAuth::getToken();
        if(!$token){
            $status = 'fail';
            return $this->response()->json(['status' => $status, 'error' =>'Token invalid', 'token'=>'']);
        }

        try{
            $newToken = JWTAuth::refresh($token);

        }catch (TokenExpiredException $e) {

            $status = 'fail';
            return response()->json(['status' => $status,'error' =>'Token expired','token' =>''], $e->getStatusCode());

        }catch (TokenInvalidException $e) {

            $status = 'fail';
            return response()->json(['status' => $status,'error' =>'Token invalid','token' =>''], $e->getStatusCode());

        }catch (TokenBlacklistedException $e) {

            $status = 'fail';
            return response()->json(['status' => $status,'error' =>'Token blacklisted','token' =>''], $e->getStatusCode());

        }catch(JWTException $e){
            $status = 'fail';
            return $this->response()->json(['status' => $status, 'error' =>'Something went wrong', 'token'=>'']);
        }

        return response()->json(['status' => $status, 'error' =>'', 'token'=>$newToken]);
    }

    public function getLogout(){
      JWTAuth::parseToken()->invalidate();
      return response()->json(['token_destroyed']);
    }


    public function getAddressList(){

        $status = 'ok';       
        try {

            if ( !$user = JWTAuth::parseToken()->authenticate() ) {
                $status = 'fail';
                return $this->error(['status' => $status,'error' => 'User not found','addrList' =>''], 204);
            }else{
                $addr = DB::table('address_books')->whereNull('deleted_at')->get();
            }

        } catch (TokenExpiredException $e) {

            $status = 'fail';
            return response()->json(['status' => $status,'error' =>'Token expired','addrList' =>''], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            $status = 'fail';
            return response()->json(['status' => $status,'error' =>'Token invalid','addrList' =>''], $e->getStatusCode());

        } catch (TokenBlacklistedException $e) {

            $status = 'fail';
            return response()->json(['status' => $status,'error' =>'Token blacklisted','addrList' =>''], $e->getStatusCode());

        } catch (JWTException $e) {

            $status = 'fail';
            return response()->json(['status' => $status,'error' =>'Token absent','addrList' =>''], $e->getStatusCode());
        }
        // the token is valid and we have found the user via the sub claim
        return response()->json(['status' => $status,'error' =>'','addrList' =>$addr]);
    }

    public function saveAddress(){
        $status = 'ok';
        try {

            if(!$user = JWTAuth::parseToken()->authenticate()){                
                $status = 'fail';
                return $this->error(['status' => $status,'error' => 'User not found','saved' =>''], 204);
            }else{
                $input = Request::all();

                $addrBook = new AddressBook(); 

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
                $addrBook->uid  = $user['id'];

                $IsDataSaved = $addrBook->save();
                if($IsDataSaved==0){
                   $status = 'fail'; 
                   return response()->json(['status' => $status,'error' =>'Data could not be saved','saved' =>$IsDataSaved]);
                }
            }

        } catch (TokenExpiredException $e) {

            $status = 'fail';
            return response()->json(['status' => $status,'error' =>'Token expired','saved' =>''], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            $status = 'fail';
            return response()->json(['status' => $status,'error' =>'Token invalid','saved' =>''], $e->getStatusCode());

        } catch (TokenBlacklistedException $e) {

            $status = 'fail';
            return response()->json(['status' => $status,'error' =>'Token blacklisted','saved' =>''], $e->getStatusCode());

        } catch (JWTException $e) {

            $status = 'fail';
            return response()->json(['status' => $status,'error' =>'Token absent','saved' =>''], $e->getStatusCode());
        }

        return response()->json(['status' => $status,'error' =>'','saved' =>$IsDataSaved]);
    }




    public function editAddress(){
        $status = 'ok';
        try {

            if(!$user = JWTAuth::parseToken()->authenticate()){                
                $status = 'fail';
                return $this->error(['status' => $status,'error' => 'User not found','saved' =>''], 204);
            }else{
                $input = Request::all();
                $IsDataUpdated = AddressBook::where('id', $input['id'])->update($input);
                if($IsDataUpdated==0){
                   $status = 'fail'; 
                   return response()->json(['status' => $status,'error' =>'Data could not be updated','saved' =>$IsDataUpdated]);
                }
            }

        } catch (TokenExpiredException $e) {

            $status = 'fail';
            return response()->json(['status' => $status,'error' =>'Token expired','saved' =>''], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            $status = 'fail';
            return response()->json(['status' => $status,'error' =>'Token invalid','saved' =>''], $e->getStatusCode());

        } catch (TokenBlacklistedException $e) {

            $status = 'fail';
            return response()->json(['status' => $status,'error' =>'Token blacklisted','saved' =>''], $e->getStatusCode());

        } catch (JWTException $e) {

            $status = 'fail';
            return response()->json(['status' => $status,'error' =>'Token absent','saved' =>''], $e->getStatusCode());
        }

        return response()->json(['status' => $status,'error' =>'','saved' =>$IsDataUpdated]);
    }

    public function deleteAddress(){
        $status = 'ok';
        try {

            if(!$user = JWTAuth::parseToken()->authenticate()){                
                $status = 'fail';
                return $this->error(['status' => $status,'error' => 'User not found','saved' =>''], 204);
            }else{
                $input = Request::all();
                $id = $input['id'];
                
                $IsRecordDeleted = AddressBook::where('id', $id)->delete(); 
                if($IsRecordDeleted==0){
                   $status = 'fail'; 
                   return response()->json(['status' => $status,'error' =>'Data could not be deleted','saved' =>$IsRecordDeleted]);
                }
            }

        } catch (TokenExpiredException $e) {

            $status = 'fail';
            return response()->json(['status' => $status,'error' =>'Token expired','saved' =>''], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            $status = 'fail';
            return response()->json(['status' => $status,'error' =>'Token invalid','saved' =>''], $e->getStatusCode());

        } catch (TokenBlacklistedException $e) {

            $status = 'fail';
            return response()->json(['status' => $status,'error' =>'Token blacklisted','saved' =>''], $e->getStatusCode());

        } catch (JWTException $e) {

            $status = 'fail';
            return response()->json(['status' => $status,'error' =>'Token absent','saved' =>''], $e->getStatusCode());
        }

        return response()->json(['status' => $status,'error' =>'','saved' =>$IsRecordDeleted]);
    }

    
    

}
