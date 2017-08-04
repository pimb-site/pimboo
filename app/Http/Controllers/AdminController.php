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
use Validator;

class AdminController extends Controller
{

	public function deletePhotoUser() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			$user_id = Input::get('user_id');
			$type = Input::get('type');

			switch ($type) {
				case 'photo':
					User::where('id', $user_id)->update(['photo' => '']);
					break;
				case 'cover':
					User::where('id', $user_id)->update(['cover_photo' => '']);
					break;

				default:
					# code...
					break;
			}
			return Response::json(['success' => true]);
		}
	}

	public function updateUser() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {

			$input = Input::get();

			$validator = Validator::make($input, [
	            'name' => 'required|min:3|max:255|unique:users|alpha_num|regex:/^[a-zA-Z0-9]+$/u|not_in:admin,create,upload,success,report,auth,user,ref,referrals,home,logout,login,charity,disclaimer,channel,edit',
	        ]);
			if(!$validator->fails()) {
				$info = User::select('name')->where('name', $input['name'])->get();
				if(count($info) == 0) {
					Post::where(['user_id' => $input['user_id'], 'author_name' => $input['user_name']])->update(['author_name' => $input['name']]);
					User::where('id', $input['user_id'])->update(['name' => $input['name']]);
				}
			}

			$input['show_fb_link'] = (isset($input['show_fb_link'])) ? 1 : 0;
			$input['show_twitter_link'] = (isset($input['show_twitter_link'])) ? 1 : 0;
			$input['weekly_digest'] = (isset($input['weekly_digest'])) ? 1 : 0;
			$input['new_subs_update'] = (isset($input['new_subs_update'])) ? 1 : 0;

			User::where('id', $input['user_id'])
				->update(['public_info' => $input['public_info'], 'website_link' => $input['website_link'],
						  'fb_link' => $input['fb_link'], 'show_fb_link' => $input['show_fb_link'],
						  'twitter_link' => $input['twitter_link'], 'show_twitter_link' => $input['show_twitter_link'],
						  'google_pluse_link' => $input['google_pluse_link'], 'email_for_news' => $input['email_for_news'],
						  'weekly_digest' => $input['weekly_digest'], 'new_subs_update' => $input['new_subs_update']]);

			$user = User::where('id', $input['user_id'])->get();

			if(count($user) != 0) {
				return view('user.admin.editing.user', ['body_class' => 'member-profile-settings', 'user' => $user[0], 'errors' => $validator->messages()]);
			} else return redirect('/admin/');
		}
	}

	public function editUser($user_id) {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			$user_id = (int) $user_id;
			$user = User::where([ ['id', $user_id] ])->get();
			if(count($user) != 0) {
				return view('user.admin.editing.user', ['body_class' => 'member-profile-settings', 'user' => $user[0]]);
			} else return redirect('/admin/');
		}
	}

	public function deleteUser() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			$user_id = Input::get('user_id');
			User::where('id', $user_id)->delete();
			Post::where('user_id', $user_id)->delete();
			return Response::json(['success' => true]); 
		}
	}

	public function getUsers() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			$users = User::select('id', 'name', 'email', 'photo', 'permission')->get();
			$count_posts = [];
			foreach ($users as $key => $value) {
				$count = Post::where('user_id', $value['id'])->count();
				$count_posts[$value['id']] = $count;
			}
			return view('user.admin.users_list', ['body_class' => 'admin', 'users' => $users, 'count_posts' => $count_posts]);
		}
	}

	public function sortEntries() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			$input = Input::get();

			$name     = $input['name'];
			$type     = $input['type'];
			$right    = $input['right'];
			$entries  = $input['entries'];
			$multiply = $input['multiply'];

			$end_time   = $input['endtime'];
			$start_time = $input['starttime'];

			$operator_name  = ($name == '') ? '<>' : '=';
			$operator_type  = ($type == 'all') ? '<>' : '=';
			$operator_right = ($right == -1) ? '<>' : '=';

			if ($right != 1)  
				$posts = Post::select('id', 'author_name', 'url', 'description_image', 'description_title', 'home_left', 'home_right', 'home_latest', 'type', 'created_at')
							 ->whereDate('created_at', '>=', $start_time)->whereDate('created_at', '<=', $end_time)
							 ->where([ ['author_name', $operator_name, $name], ['type', $operator_type, $type], ['home_left', $operator_right, $right], 
						 		       ['home_right', $operator_right, $right], ['home_latest', $operator_right, $right] ])
							 ->skip($multiply * $entries)
							 ->take($entries)
							 ->latest()
							 ->get();
			else
				$posts = Post::select('id', 'author_name', 'url', 'description_image', 'description_title', 'home_left', 'home_right', 'home_latest', 'type', 'created_at')
							 ->whereDate('created_at', '>=', $start_time)->whereDate('created_at', '<=', $end_time)
							 ->where([ ['author_name', $operator_name, $name], ['type', $operator_type, $type] ])
							 ->orWhere('home_left', '=', $right)
							 ->orWhere('home_right', '=', $right)
							 ->orWhere('home_latest', '=', $right)
							 ->skip($multiply * $entries)
							 ->take($entries)
							 ->latest()
							 ->get();

			return Response::json(['success' => true, 'posts' => $posts]);
		}
	}

	public function editPost($type, $id) {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			$id = (int) $id;
			$post = Post::where([ ['id', $id], ['type', $type] ])->get();
			if(count($post) != 0) {
				return view('user.admin.editing.'.$type, ['post' => $post[0]]);
			} else return redirect('/admin/');
		}
	}

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
			print_r($reports);
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