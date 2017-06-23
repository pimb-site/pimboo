<?php 

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use Input;
use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\Factory as Socialite;

class AuthController extends Controller
{

    public function __construct(Socialite $socialite){
        try {
            $this->socialite = $socialite;
        } catch (Exception $e) {
            return redirect('home');
        }
    }


    public function getSocialAuth($provider=null)
    {
        try {
            if(!config("services.$provider")) abort('404'); //just to handle providers that doesn't exist

            return $this->socialite->with($provider)->redirect();
        } catch (Exception $e) {
            return redirect('home');
        }
    }


    public function getSocialAuthCallback($provider=null, Request $request)
    {
        if ($request->input('error', '') == 'access_denied') {
            return redirect('/');  
        }

        if($user = $this->socialite->with($provider)->user()){
            if (empty($user->email)) {
                return redirect('/');     
            } else {
                $user_model = User::where([ ['social_type', '=', $provider], ['social_id', '=', $user->id ] ])->first();
                if (isset($user_model->id)) {
                    Auth::loginUsingId($user_model->id, true);
                    return redirect('/');
                } else {
                    if (isset($_COOKIE['ref']) and !empty($_COOKIE['ref'])) {
                        $ref = $_COOKIE['ref'];
                    } else {
                        $ref = 0;
                    }

                    $name = str_random(20);

                    $User = new User;

                    $User->name = $name;
                    $User->email = $user->id.$provider;
                    $User->refferal = $ref;
                    $User->social_type = $provider;
                    $User->social_id = $user->id;
                    $User->email_for_news = $user->email;
                    $User->save();
                    Auth::loginUsingId($User->id, true);
                    return redirect('/user/referrals');
                }
            }
        }else{
            return 'something went wrong';
        }
    }

}