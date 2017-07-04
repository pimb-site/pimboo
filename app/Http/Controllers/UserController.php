<?php namespace App\Http\Controllers;

use Auth;
use DB;
use Response;
use Input;
use App\PostView;
use App\Post;
use App\User;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Http\Request;

class UserController extends Controller
{

	public function setPhoto() {
		if(Auth::guest()) return redirect('/home');

		if (Input::file('filedata')->isValid()) {
			$filename = uniqid().".jpeg";
			Input::file('filedata')->move("uploads/", $filename);

			$user_id = Auth::user()->id;

			$type = Input::get('photo_type');
			if($type == "photo") {
				DB::table('users')
			            ->where('id', $user_id)
			            ->update(['photo' => $filename]);
			}
			else if($type == "cover") {
				DB::table('users')
			            ->where('id', $user_id)
			            ->update(['cover_photo' => $filename]);
			}
			return Response::json(['success' => true, 'file' => $filename]);
		}
	}

	public function deleteAvatar() {
		if(!Auth::guest()) {

			$user_id = Auth::user()->id;

			DB::table('users')
			        ->where('id', $user_id)
			        ->update(['photo' => '']);
			return Response::json(['success' => true]);
		}
	}

	public function getAccount() {
		$my_all_posts = Post::where('user_id', Auth::user()->id)->get();
		$posts = [];
		foreach ($my_all_posts as $post) {
			$posts[] = $post->id;
		}
		$my_all_views = PostView::whereIn('post_id', $posts)->count();
		$my_today_views = PostView::whereIn('post_id', $posts)->whereBetween('created_at', [date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , date("d"), date("Y"))), date('Y-m-d H:i:s')])->count();
		
		$my_org_users_first_level = User::where('refferal', Auth::user()->id)->get();
		$my_org_users = [];
		foreach ($my_org_users_first_level as $user) {
			$my_org_users[] = $user->id;
			$user_first_level_refs = User::where('refferal', $user->id)->get();
			foreach ($user_first_level_refs as $user_ref) {
				$my_org_users[] = $user_ref->id;
			}
		}
		$org_all_posts = Post::whereIn('user_id', $my_org_users)->get();
		$posts = [];
		foreach ($org_all_posts as $post) {
			$posts[] = $post->id;
		}
		$org_all_views = PostView::whereIn('post_id', $posts)->count();
		$org_today_views = PostView::whereIn('post_id', $posts)->whereBetween('created_at', [date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , date("d"), date("Y"))), date('Y-m-d H:i:s')])->count();
		return view('/user/account', [
			'body_class' => 'member-main', 
			'user' => Auth::user(),
			'user_posts' => $my_all_posts,
			'my_all_views' => $my_all_views,
			'my_today_views' => $my_today_views,
			'org_all_views' => $org_all_views,
			'org_today_views' => $org_today_views,
		]);
	}
	public function getViewsInfo(Request $request) {
		
		$post_id = $request->input('post_id', 'all');
		if ($post_id == 'all') {
			$my_all_posts = Post::where('user_id', Auth::user()->id)->get();
			$posts = [];
			foreach ($my_all_posts as $post) {
				$posts[] = $post->id;
			}
		} else {
			$posts = [$post_id];
		}
		$my_custom_views = PostView::whereIn('post_id', $posts)->whereBetween('created_at', [$request->input('start', date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , date("d"), date("Y")))), $request->input('end', date('Y-m-d H:i:s'))])->count();
		

		$my_org_users_first_level = User::where('refferal', Auth::user()->id)->get();
		$my_org_users = [];
		foreach ($my_org_users_first_level as $user) {
			$my_org_users[] = $user->id;
			$user_first_level_refs = User::where('refferal', $user->id)->get();
			foreach ($user_first_level_refs as $user_ref) {
				$my_org_users[] = $user_ref->id;
			}
		}
		$org_all_posts = Post::whereIn('user_id', $my_org_users)->get();
		$posts = [];
		foreach ($org_all_posts as $post) {
			$posts[] = $post->id;
		}
		$org_custom_views = PostView::whereIn('post_id', $posts)->whereBetween('created_at', [$request->input('start', date('Y-m-d H:i:s', mktime(0, 0, 0, date("m")  , date("d"), date("Y")))), $request->input('end', date('Y-m-d H:i:s'))])->count();
		return view('user.accountajax', [
			'my_custom_views' => $my_custom_views,
			'org_custom_views' => $org_custom_views,
			'text' => $request->input('text', 'All time'),
		]);
	}

	public function getProfile() {
		return view('/user/profile', ['body_class' => 'member-profile-settings', 'user' => Auth::user()]);
	}
	public function saveProfile(Request $request) {
		$user = Auth::user();

		if( strlen($request->input('name')) >= 3 && strlen($request->input('name')) <= 255) {
			if(preg_match('|^[A-Z0-9]+$|i', $request->input('name', $user->name))) {
				$info = DB::table('users')->select('name')->where('name', '=', $request->input('name'))->get();
				if(count($info) == 0) {
					DB::table('posts')
				        ->where('user_id', Auth::user()->id)
				        ->where('author_name', Auth::user()->name)
				        ->update(['author_name' => $request->input('name')]);
					$user->name = $request->input('name', $user->name);
				}
			}
		}

		$user->public_info = $request->input('public_info', '');
		$user->website_link = $request->input('website_link', '');
		$user->fb_link = $request->input('fb_link', '');
		$user->show_fb_link = $request->input('show_fb_link', 0);
		$user->twitter_link = $request->input('twitter_link', '');
		$user->show_twitter_link = $request->input('show_twitter_link', 0);
		$user->google_pluse_link = $request->input('google_pluse_link', '');
		$user->email_for_news = $request->input('email_for_news', '');
		$user->weekly_digest = $request->input('weekly_digest', 0);
		$user->new_subs_update = $request->input('new_subs_update', 0);
		$user->save();

		return view('/user/profile', ['body_class' => 'member-profile-settings', 'user' => $user]);
	}

	public function getOrganization() {
		$my_org_users_first_level = User::where('refferal', Auth::user()->id)->get();
		$my_org_users_second_level = [];
		$i = 0;
		foreach ($my_org_users_first_level as $user) {
			$user_first_level_refs = User::where('refferal', $user->id)->get();
			$my_org_users_second_level[$user->id] = [];
			$i = $i + 1;
			$flag = 1;
			foreach ($user_first_level_refs as $user_ref) {
				$my_org_users_second_level[$user->id][] = $user_ref;
				if ($flag) {
					$flag = 0;
				} else {
					$i = $i + 1;
				}
			}
		}
		return view('/user/organization', [
			'body_class' => 'member-my-org',
			'user' => Auth::user(),
			'my_org_users_first_level' => $my_org_users_first_level,
			'my_org_users_second_level' => $my_org_users_second_level,
			'i' => $i,
		]);
	}
	public function getReferrals() {
		return view('/user/referrals', ['body_class' => 'member-referral-program', 'user' => Auth::user()]);
	}

}