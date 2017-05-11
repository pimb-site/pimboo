<?php 

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use Input;
use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\Factory as Socialite;

class MoneycallbackController extends Controller
{

    public function __construct(Socialite $socialite){
        try {
            $this->socialite = $socialite;
        } catch (Exception $e) {
            return redirect('home');
        }
    }


    public function maxbounty(Request $request)
    {
        $callback = new Callback;
        $callback->value = serialize(array(
            '' => , 
        ));
    }

}