<?php
namespace App\Http\Controllers\Api\Mobile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Web\UserController;
use App\User;
use Validator, Auth;
class UsersController extends Controller
{

	public function getUser($user_id = '')
	{
		if($user_id != '') {
			return User::where('id', '=', $user_id)->first();
		}
		return [
			'status' => false,
			'error' => 'Please provide user id.'
		];
	}

	public function login()
	{
		$rules = array(
		    'email'    => 'required|email', 
		    'password' => 'required|min:3'
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
		    return [
				'status' => false,
		    	'error' => $validator->errors()
			];
		} else {
		    $userdata = [
		        'email'     => Input::get('email'),
		        'password'  => Input::get('password')
		    ];
		    if ($user = Auth::attempt($userdata)) {
		    	return ['status' => true, 'user' => Auth::user()];
		    } else {
		    	return [
		    		'status' => false,
		    		'error' => 'Password or email is wrong.'
		    	];
		    }
		}
	}

	public function register()
	{
		$rules = [
		    'name'    => 'required|min:3',
		    'email'    => 'required|email|unique:users',
		    'password' => 'required|min:3'
		];
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
		    return [
				'status' => false,
		    	'error' => $validator->errors()
			];
		} else {
		    if ($user = User::create(request(['name', 'email', 'role_id', 'password']))) {
		        return ['status' => true];
		    } else {
		    	return ['error' => 'Sorry! Something went wrong. Please try again.'];
		    }
		}
	}

	public function update($user_id)
	{
		if($user_id == '') {
			return [
				'status' => false,
				'error' => 'Please provide user_id.'
			];
		}
		$rules = [
		    'name'    => 'required|min:3',
		    'password' => 'required|min:3'
		];
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
		    return [
				'status' => false,
		    	'error' => $validator->errors()
			];
		} else {
			$user = User::findOrFail($user_id);
	        $user->name = request('name');
	        $user->password = request('password');
	        $user->newsletter = request('newsletter');
	        if(!isset($user->newsletter) || $user->newsletter == NULL) {
	        	$user->newsletter = 0;
	        }
	        if($user->save()) {
	        	return ['status' => true];
	        } 
	        return ['error' => 'Sorry! Something went wrong. Please try again.'];
	    }
	}

}