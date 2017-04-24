<?php namespace App\Http\Controllers;

use Auth;
use DB;
use Response;
use Input;
use App\PostView;
use App\Post;
use App\User;
use App\Report;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Http\Request;

class AdminController extends Controller
{

	public function getHome() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			return view('user.admin.home', ['body_class' => 'admin']);
		}
	}

	public function getReports() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			$reports = Report::all();
			return view('user.admin.reports', ['body_class' => 'reports', 'reports' => $reports]);
		}
	}

	public function getAds() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			return view('user.admin.ads', ['body_class' => 'ads']);
		}
	}

}