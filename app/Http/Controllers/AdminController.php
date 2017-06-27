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
	public function deletePost() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			$post_id = Input::get('post_id');
			if(is_numeric($post_id)) {
				Post::where('id', $post_id)->delete();
				return Response::json(['success' => true]);
			} else return Response::json(['success' => false]);
		}
	}

	public function updatePost() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			$action  = Input::get('action');
			$post_id = Input::get('post_id');
			$checked = Input::get('checked');
			switch ($action) {
				case 'set_left':
					DB::update("update posts set home_left = ? where id = ?", [$checked, $post_id]);
					break;
				
				case 'set_right':
					DB::update("update posts set home_right = ? where id = ?", [$checked, $post_id]);
					break;

				case 'set_latest':
					DB::update("update posts set home_latest = ? where id = ?", [$checked, $post_id]);
					break;

				default:
					break;
			}
			return Response::json(['success' => true]);
		}
	}

	public function getAdvSnip() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			$snips = DB::select("select * from settings where setting = ?", ['snips']);
			$snips = unserialize($snips['0']->value);
			return view('user.admin.snip', ['body_class' => 'admin', 'snips' => $snips]);
		}
	}


	public function saveAdvSnip() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			DB::delete("delete from settings where setting = 'snips'");
			$tag = serialize(Input::get('tag'));
			$snips = DB::insert("insert into settings (setting,value) values ('snips',?)", [$tag]);
			
			return redirect('/admin/snip');
		}
	}

	public function getHome() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			$posts = Post::latest()->take(100)->get();
			return view('user.admin.home_table', ['body_class' => 'admin', 'posts' => $posts]);
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

	public function updateReport() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			if (Input::get('action') == 'delete_user') {
				DB::update("update users set status = 'deleted' where id = ?", [Input::get('user_id')]);
				DB::update("update reports set status = 'delete user' where id = ?", [Input::get('report_id')]);
				DB::update("update posts set user_id = '1' where user_id = ?", [Input::get('user_id')]);
			} elseif (Input::get('action') == 'delete_posts_and_user') {
				DB::update("update users set status = 'deleted' where id = ?", [Input::get('user_id')]);
				DB::update("update posts set status = 'deleted' where id = ?", [Input::get('post_id')]);
				DB::update("update reports set status = 'delete posts and user' where id = ?", [Input::get('report_id')]);
			} elseif (Input::get('action') == 'delete_post') {
				DB::update("update posts set status = 'deleted' where id = ?", [Input::get('post_id')]);
				DB::update("update reports set status = 'delete post' where id = ?", [Input::get('report_id')]);
			} elseif (Input::get('action') == 'reject') {
				DB::update("update reports set status = 'reject' where id = ?", [Input::get('report_id')]);
			}

			return redirect('/admin/reports');
		}
	}

	public function getAds() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			$links = DB::select("select * from settings where setting = ?", ['ads']);
			$links = unserialize($links['0']->value);
			return view('user.admin.ads', ['body_class' => 'ads', 'links' => $links]);
		}
	}

	public function saveAds() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			DB::delete("delete from settings where setting = 'ads'");
			$ads = serialize(Input::get('links'));
			$links = DB::insert("insert into settings (setting,value) values ('ads',?)", [$ads]);
			
			return redirect('/admin/ads');
		}
	}
}