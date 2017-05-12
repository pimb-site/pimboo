<?php namespace App\Http\Controllers;

use Input;

class ReferralController extends Controller
{
	public function index($id) {
		SetCookie("ref",$id,(int)time()+3600000, '/');
		return redirect('home');
	}


	public function MassMailing() {

	}
}