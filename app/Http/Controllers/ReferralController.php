<?php 
namespace App\Http\Controllers;

class ReferralController extends Controller
{
	public function index($id) {
		SetCookie("ref",$id,(int)time()+3600000, '/');
		return redirect('home');
	}
}