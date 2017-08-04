<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user/referrals';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|min:3|max:255|unique:users|alpha_num|regex:/^[a-zA-Z0-9]+$/u|not_in:admin,create,upload,success,report,auth,user,ref,referrals,home,logout,login,charity,disclaimer,channel,edit',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        if (isset($_COOKIE['ref']) and !empty($_COOKIE['ref'])) {
            $ref = $_COOKIE['ref'];
            $check_users = User::select('id')->where('name', $ref)->get();
            $ref = (count($check_users) != 0) ? $check_users[0]->id : 0;
        } else {
            $ref = 0;
        }
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'refferal' => $ref,
            'password' => bcrypt($data['password']),
        ]);
    }
}
