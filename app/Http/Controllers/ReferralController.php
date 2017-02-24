<?php 
namespace App\Http\Controllers;

class ReferralController extends Controller
{
	public function index($id) {
		SetCookie("ref",$id,time()+36000000000000000000, '/');
		return redirect('home');
	}
}