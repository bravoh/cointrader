<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator, Auth, Redirect, Mail;
use App\{User, FavoritesCoins, BlockfolioCoins, NewsLetter};
use App\Http\Controllers\Web\CryptoCurrenciesController;
use Socialite, Hash, Response;
use Illuminate\Http\Request;
class UserController extends Controller
{
	public function login()
	{			
		if(Auth::user()) {
			return redirect('/');
		}
		return view(getCurrentTemplate() . '.pages.user.login');
	}

	public function doLogin()
	{
		if(Auth::user()) {
			return redirect('/');
		}

		$rules = [
		    'email'    => 'required|email',
		    'password' => 'required|min:3',
		    'g-recaptcha-response' => 'required|recaptcha'
		];
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
		    return Redirect::to(makeUrl('user/login'))
		        ->withErrors($validator) 
		        ->withInput(Input::except('password'));
		} else {
		    $userdata = array(
		        'email'     => Input::get('email'),
		        'password'  => Input::get('password')
		    );
		    if (Auth::attempt($userdata)) {
		    	return redirect('/');
		    } else {
		    	return Redirect::to(makeUrl('user/login'))->withErrors(['wrong_credentials' => __('auth.WRONG_EMAIL_PASS')]);
		    }
		}
	}

	public function register()
	{		
		if(Auth::user()) {
			return redirect('/');
		}	
		return view(getCurrentTemplate() . '.pages.user.register');
	}	

	public function doRegistration()
	{
		if(Auth::user()) {
			return redirect('/');
		}

		$rules = [
		    'name'    => 'required|min:3|max:15',
		    'email'    => 'required|email|unique:users|min:5|max:100',
		    'password' => 'required|min:3|max:20',
		    'g-recaptcha-response' => 'required|recaptcha'
		];

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
		    return Redirect::to(makeUrl('user/register'))
		        ->withErrors($validator) 
		        ->withInput(Input::except('password')); 
		} else {
		    if ($user = User::create(request(['name', 'email', 'role_id', 'newsletter', 'password']))) {

		        if(request('newsletter') == 1) {
		    		NewsLetter::updateOrCreate(request(['email']));
		    	}

		    	$this->sendRegistrationVerificationEmail($user);
		    	Auth::login($user);
        		return redirect(makeUrl('user/profile'));
		    } else {
		    	return Redirect::to(makeUrl('user/register'))
		    			->withErrors(['wrong_credentials' => __('auth.WRONG_CREDENTIALS')]);
		    }
		}

	}

	public function sendRegistrationVerificationEmail($user)
	{
	    try{
            $user->token = md5(time() . '-' . rand(0, 99999));
            $user->save();
            $data = ['user' => $user];

            Mail::send('emails.registration_email', $data, function ($message) use ($user) {
                $message->from(env('MAIL_EMAIL_ADDRESS'), setting('site.site_name'));
                $message->subject(__('user.REGISTRATION_COMPLETED'));
                $message->to($user->email);
            });
        }catch (\Exception $exception){

        }
	}

	public function verify()
	{
		$token = Input::get('token');
		if($token != '') {
			$user = User::where('token', $token)->first();
			$user->status = 1;
			if($user->save()) {
				if(!Auth::user()) {
					Auth::login($user);
				}
				return redirect(makeUrl('user/profile'));
			}
		}
		return redirect(makeUrl('user/login'));
	}

	public function updateProfile(Request $request)
	{
		$rules = array(
		    'name'    => 'required|min:3|max:100',
		    'about' => 'min:15|max:250',
		    'skills' => 'min:5|max:250',
		    'g-recaptcha-response' => 'required|recaptcha'
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
		    return Redirect::to(makeUrl('user/profile'))->withErrors($validator); 
		} else {
			$user = User::findOrFail(Auth::user()->id);
	        $user->name = strip_tags(request('name'));
	        $user->about = strip_tags(trim(request('about')));
	        $user->skills = strip_tags(request('skills'));
	        $user->newsletter = strip_tags(request('newsletter'));
	        if(!isset($user->newsletter) || $user->newsletter == NULL) {
	        	$user->newsletter = 0;
	        	NewsLetter::where('email', '=', $user->email)->delete();
	        } else {
		    	NewsLetter::updateOrCreate(['email' => $user->email]);
	        }
	        $user->save();
	        return Redirect::to(makeUrl('user/profile'))->withErrors(['profile_updated' => __('auth.PROFILE_UPDATED')]);
	    }
	}

	public function profile()
	{
		if(!Auth::user()) {
			return redirect('/');
		}	
		$user = Auth::user();
    	return view(getCurrentTemplate() . '.pages.user.profile', compact('user'));
	}

	public function favorites(CryptoCurrenciesController $coin)
	{
		if(!Auth::user()) {
			return Redirect::to(makeUrl('user/login'))->withErrors(['watchlist_msg' => __('user.WATCHLIST_PERSONALIZED_ERROR')]);
		}
		return $coin->getListOfFavoriteCoins();
	}

	public function ajaxSaveFavoriteCoin($coin)
	{
		if(!Auth::user()) {
			return 'false';
		}
		if(!request()->ajax()) {
			return [':)'];
		}
		if(!FavoritesCoins::where('coin', '=', $coin)->where('user_id', '=', Auth::user()->id)->first()) {
			$favorites = new FavoritesCoins;
	        $favorites->user_id = Auth::user()->id;
	        $favorites->coin = $coin;
	        $favorites->save();
	        return 'true';
	    } else {
	    	FavoritesCoins::where('coin', '=', $coin)->where('user_id', '=', Auth::user()->id)->delete();
	    	return 'false';
	    }
		
	}

	public function forgot()
	{			
		if(Auth::user()) {
			return redirect('/');
		}	
		return view(getCurrentTemplate() . '.pages.user.forgot');
	}

	public function submitForgotPassword()
	{
		if(Auth::user()) {
			return redirect('/');
		}
		$rules = [
		    'email'    => 'required|email',
		    'g-recaptcha-response' => 'required|recaptcha'
		];
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
		    return Redirect::to(makeUrl('user/forgot'))->withErrors($validator); 
		} else {
			$user = User::where('email', '=', Input::get('email'));
		    if ($user->count() > 0) {
		    	$this->sendForgotPasswordEmail();
		    	return Redirect::to(makeUrl('user/forgot'))
		    			->withErrors(['forgot_password_email_sent' => __('auth.RESET_EMAIL_SENT')]);
		    } else {
		    	return Redirect::to(makeUrl('user/forgot'))
		    			->withErrors(['wrong_credentials' => __('auth.EMAIL_NOT_EXIST')]);
		    }
		}
	}

	public function sendForgotPasswordEmail()
	{
		$email = Input::get('email');
		$user = User::where('email', '=', $email)->first();
		$new_password = trim(base64_encode("pas" . rand(0, 999)));
		$user->password = $new_password;
		$user->save();
		$data = ['user' => $user, 'new_password' => $new_password];
    	Mail::send('emails.password_reset_email', $data, function ($message) use ($email) {
		    $message->from(env('MAIL_EMAIL_ADDRESS'), setting('site.site_name'));
		    $message->subject(__('user.RESET_FORGOT_PASSWORD'));
		    $message->to($email);
		});
	}

	public function changePassword()
	{
		if(!Auth::user()) {
			return redirect('/');
		}
		$rules = [
		    'password' => 'required|min:3',
		    'old_password' => 'required',
		];
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
		    return Redirect::to(makeUrl('user/profile'))->withErrors($validator); 
		} else {
			$user = User::where('email', '=', Auth::user()->email)->first();
			if (Hash::check(Input::get('old_password'), $user->password)) {
				$user->password = Input::get('password');
				$user->save();
				return Redirect::to(makeUrl('user/profile'))
		    			->withErrors(['profile_updated' => __('auth.PASSWORD_CHANED')]);
			} else {
		    	return Redirect::to(makeUrl('user/profile'))
		    			->withErrors(['wrong_credentials' => __('auth.WRONG_PASSWORD')]);
		    }
		}
	}

	public function logout()
	{			
		Auth::logout();
    	return Redirect::to(makeUrl('user/login'));
	}

	public function facebookLogin()
    {
    	if(Auth::user()) {
			return redirect(makeUrl('user/profile'));
		}
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookLoginCallback(Request $request)
    {
    	if(Auth::user()) {
			return redirect(makeUrl('user/profile'));
		}
		if (!$request->has('code') || $request->has('denied')) {
	   		return redirect(makeUrl('user/login'));
	   	}
        $user_data = Socialite::driver('facebook')->stateless()->user();
        if(!isset($user_data->email)) {
        	return Redirect::to(makeUrl('user/login'))
		    			->withErrors(['wrong_credentials' => __('auth.FB_WRONG_EMAIL_PASS')]);
        }
        if(User::where('email', '=', $user_data->email)->first()) {
	    	$checkUser = User::where('email', '=', $user_data->email)->first();
	    	Auth::login($checkUser);
	    	return redirect(makeUrl('user/profile'));
	    } 
        $password = trim(base64_encode("pas" . rand(0, 999)));
        $user['email'] = $user_data->user['email'];
        $user['name'] = $user_data->user['name'];
        $user['status'] = 1;
        $user['role_id'] = 3;
        $user['password'] = $password;
        $user_res = User::firstOrCreate(['email' =>  $user['email']], $user);
        $this->sendSocialRegistrationEmail($user_data->user['name'], $user_data->user['email'], $password);
		Auth::login($user_res);
		return redirect(makeUrl('user/profile'));
    }


    public function twitterLogin()
    {
    	if(Auth::user()) {
			return redirect(makeUrl('user/profile'));
		}
        return Socialite::driver('twitter')->redirect();
    }

    public function twitterLoginCallback()
    {
    	if(Auth::user()) {
			return redirect(makeUrl('user/profile'));
		}
		if (isset($_GET['denied']) && $_GET['denied'] != '') {
	   		return redirect(makeUrl('user/login'));
	   	}
        $user_data = Socialite::driver('twitter')->user();
        if(!isset($user_data->email)) {
        	return Redirect::to(makeUrl('user/login'))
		    			->withErrors(['wrong_credentials' => __('auth.TW_WRONG_EMAIL_PASS')]);
        }
        if(User::where('email', '=', $user_data->email)->first()) {
	    	$checkUser = User::where('email', '=', $user_data->email)->first();
	    	Auth::login($checkUser);
	    	return redirect(makeUrl('user/profile'));
	    } 

	    $password = trim(base64_encode("pas" . rand(0, 999)));
	    $user['email'] = $user_data->email;
        $user['name'] = $user_data->name;
        $user['status'] = 1;
        $user['role_id'] = 3;
        $user['password'] = $password;
        $user_res = User::firstOrCreate(['email' =>  $user['email']], $user);
        $this->sendSocialRegistrationEmail($user_data->name, $user_data->email, $password);
		Auth::login($user_res);
		return redirect(makeUrl('user/profile'));
    }

    public function sendSocialRegistrationEmail($username, $email, $password)
	{
		$data = ['username' => $username, 'password' => $password, 'email' => $email];
    	Mail::send('emails.social_registration_email', $data, function ($message) use ($email) {
		    $message->from(env('MAIL_EMAIL_ADDRESS'), setting('site.site_name'));
		    $message->subject(__('user.REGISTRATION_COMPLETED'));
		    $message->to($email);
		});
	}

	/**
	 * GDPR
	 */
	public function deleteAccountForm()
	{
		if(Auth::user()) {
			return view(getCurrentTemplate() . '.pages.user.delete_account');
		}
        return redirect(makeUrl('/'));
	}

	public function deleteAccount()
	{
		if(Auth::user()) {
			if(Auth::user()->role_id == 1 ||  Auth::user()->role_id == 2) {
				return Redirect::to(makeUrl('user/delete-account'))
		    			->withErrors(['wrong_credentials' => __('auth.NO_ADMIN_DELETE')]);
			}
			if(Auth::user()->role_id == 3) {
				$rules = [
				    'password'    => 'required',
				    'g-recaptcha-response' => 'required|recaptcha'
				];
				$validator = Validator::make(Input::all(), $rules);
				if ($validator->fails()) {
				    return Redirect::to(makeUrl('user/delete-account'))->withErrors($validator); 
				} else {
					if (Hash::check(Input::get('password'), Auth::user()->password)) {
						User::where('id', '=', Auth::user()->id)->delete();
						FavoritesCoins::where('user_id', '=', Auth::user()->id)->delete();
						BlockfolioCoins::where('user_id', '=', Auth::user()->id)->delete();
					} else {
						return Redirect::to(makeUrl('user/delete-account'))
		    				->withErrors(['wrong_credentials' => __('auth.WRONG_CURRENT_PASSWORD')]);
					}
				}
			}
			return redirect(makeUrl('/'));
		}
		return redirect(makeUrl('/'));
	}

	public function downloadAccountData()
	{
		$headers = array(
	        "Content-type" => "text/csv",
	        "Content-Disposition" => "attachment; filename=User_Account_Data_" . Auth::user()->id . ".csv",
	        "Pragma" => "no-cache",
	        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
	        "Expires" => "0"
	    );
	    $columns = array('Id', 'Role Id', 'Name', 'E-mail', 'Avatar', 'Newsletter', 'Password', 'Remember token', 'Status', 'About', 'Skills', 'Created At', 'Updated At');
	    $callback = function() use ($columns) {
	    	$user = Auth::user();
	        $file = fopen('php://output', 'w');
	        fputcsv($file, $columns);
	        fputcsv($file, array($user->id, $user->role_id, $user->name, $user->email, $user->avatar, $user->newsletter, $user->password, $user->remember_token, $user->status, $user->about, $user->skills, $user->created_at, $user->updated_at));
	        fclose($file);
	    };
	   	return Response::stream($callback, 200, $headers);
	}

}
