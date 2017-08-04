<?php namespace App\Http\Controllers;

use Illuminate\View\View;
use Input;
use DB;
use Response;
use DateTime;
use Auth;
use Validator;
use App\Post;
use App\User;

class ChannelController extends Controller
{
	public function viewChannel($channel_name) {
		if( strlen($channel_name) >= 3 && strlen($channel_name) <= 255) {
			if(!preg_match('|^[A-Z0-9]+$|i', $channel_name)) {
				return redirect('/home');
			}
			$user_info = DB::select('select id, name, photo, cover_photo, public_info from users where name = ?', [$channel_name]);
			if(count($user_info) != 0) {
				if(Auth::user()->permission == 10 || $channel_name == Auth::user()->name) {
					$isDraft = ['publish', 'save'];
				} else $isDraft = ['publish'];
				$types = ['trivia', 'story', 'flipcards', 'rankedlist', 'gif', 'snip'];
				$channel_content = DB::table('posts')
									->where('user_id', $user_info[0]->id)
									->whereIn('isDraft', $isDraft)
									->whereIn('type', $types)
									->orderBy('created_at', 'desc')
									->skip(0)->take(10)
									->get(['id', 'author_name', 'url', 'description_title', 'description_text', 'description_image', 'type', 'created_at', 'isDraft']);

				$show_more = (count($channel_content) == 10) ? true : false;


				if(Auth::guest()) {
					$user_id = 0;
				} else {
					$user_id = Auth::user()->id;
				}

				// is subscribe? 
				if($user_info[0]->id!= $user_id) {
					$checkSubscribes = DB::table('subscribes')
                     ->select('user_id', 'channel_id')
                     ->where('user_id', '=', $user_id)
                     ->where('channel_id', '=', $user_info[0]->id)
                     ->get();

                    $isSubscribe = (count($checkSubscribes) == 0) ? false : true;

				} else {
					$isSubscribe = false;
				}

				// count subscribers
				$subscribers = DB::table('subscribes')->where('channel_id', '=', $user_info[0]->id)->count();
				$isAdmin  = Auth::user()->permission == 10 ? true : false;
				$isRights = $channel_name == Auth::user()->name ? true : false;
				return view('channel_page', ['body_class' => 'channel-page', 'isAdmin' => $isAdmin, 'isRights' => $isRights, 'user_info' => $user_info[0], 'channel_content' => $channel_content, 'show_more' => $show_more, 
											 'isSubscribe' => $isSubscribe, 'subscribers' => $subscribers]);
			}
			else {
				return redirect('/home');
			}
		}
		else {
			return redirect('/home');
		}
	}

	public function filterChannel() {
		$types = Input::get('types');
		$multiplier = (int)Input::get('multiplier');
		$channel_id = (int)Input::get('channel_id');

		$channel_id = ($channel_id <= 0) ? 1 : $channel_id;
		$multiplier = ($multiplier <= 0) ? 1 : $multiplier;

		$skip = ($multiplier == 1) ? 0 : $multiplier * 10 - 10;

		$correct_names = ['flipcards', 'trivia', 'rankedlist', 'story', 'gif', 'snip']; 

		if(is_array($types) && count($types) != 0) {
			foreach ($types as $key => $value) {
				if(!isset($correct_names[$value])) {
					unset($types[$value]);
					sort($types);
				}
			}

			if(count($types) != 0) {
				if($channel_id == Auth::user()->id)
					$isDraft = ['publish', 'save'];
				else
					$isDraft = ['publish'];

				$records = DB::table('posts')
							->where('user_id', $channel_id)
							->whereIn('isDraft', $isDraft)
							->whereIn('type', $types)
							->orderBy('created_at', 'desc')
							->skip($skip)->take(10)
							->get(['id', 'author_name', 'url', 'description_title', 'description_text', 'description_image', 'type', 'created_at', 'isDraft']);
				
				if(count($records) != 0) {

					$aType = 
					[
						'rankedlist' => 'RANKED LIST',
						'story'      => 'STORY',
						'flipcards'  => 'FLIP CARD',
						'trivia'     => 'TRIVIA CARD',
						'gif'        => 'GIF',
						'snip'       => 'SNIP'
					];

					$current_date = new DateTime();

					$isAdmin  = Auth::user()->permission == 10 ? true : false;
					$isRights = $channel_id == Auth::user()->id ? true : false;
					foreach ($records as $key => $value) {

						$post_date = new DateTime($value->created_at);
						$days = $current_date->format("d") - $post_date->format("d");
						$month = $current_date->format("m") - $post_date->format("m");
						
						$status = $value->isDraft == 'save' ? 'Saved' : 'Posted';
						if($month == 0) {
							if($days == 0) $posted = "$status Today";
							else $posted = "$status $days days ago";
						} else $posted = "$status $month month ago";

						$json[] = 
						[
							'id' => $value->id,
							'author_name' => $value->author_name,
							'url'         => $value->url,
							'description_title' => $value->description_title,
							'description_text' => $value->description_text,
							'description_image' => $value->description_image,
							'type' => $aType[$value->type],
							'posted' => $posted,
							'isDraft' => $value->isDraft
						];
					}
					$show_more = (count($json) == 10) ? true : false;

					$json_response = json_encode($json);
					return Response::json(['success' => true, 'posts' => $json_response, 'show_more' => $show_more, 'isAdmin' => $isAdmin, 'isRights' => $isRights]);
				}
			}
		}
		return Response::json(['success' => false]);
	}

	public function subscribe() {
		if(Auth::guest()) return Response::json(['success' => false, 'data' => 'You are not authorized']);

		$user_id = Auth::user()->id;
		$channel_id = (int)Input::get('channel_id');

		if(($channel_id > 0) && ($channel_id != $user_id)) {

			$isSubscribe = DB::table('subscribes')
                     ->select('user_id', 'channel_id')
                     ->where('user_id', '=', $user_id)
                     ->where('channel_id', '=', $channel_id)
                     ->get();

            if(count($isSubscribe) == 0) { 
            	DB::table('subscribes')->insert(
				    ['user_id' => $user_id, 'channel_id' => $channel_id]
				);
				return Response::json(['success' => true, 'data' => 'You have successfully subscribed']);
            } else {
            	return Response::json(['success' => false, 'data' => 'You are already subscribed to this channel']);
            }
		} else {
			return Response::json(['success' => false, 'data' => 'Invalid data']);
		}
	}

	public function unsubscribe() {
		if(Auth::guest()) return Response::json(['success' => false, 'data' => 'You are not authorized']);

		$user_id = Auth::user()->id;
		$channel_id = (int)Input::get('channel_id');

		if(($channel_id > 0) && ($channel_id != $user_id)) {
			DB::table('subscribes')
				->where('user_id', '=', $user_id)
				->where('channel_id', '=', $channel_id)
				->delete();

			return Response::json(['success' => true, 'data' => 'You have successfully unsubscribed from this channel']);
		} else {
			return Response::json(['success' => false, 'data' => 'Invalid data']);
		}
	}

	public function deletePost() {
		if(Auth::guest()) return Response::json(['success' => false, 'data' => 'You are not authorized']);

		$validator = Validator::make(Input::get(), [
			'post_id' => 'required|integer|min:1'
		]);

		if ($validator->fails())
			return Response::json(['success' => false, 'errorText' => $validator->errors()->all()]);

		if(Auth::user()->permission == 10) 
			Post::where(['id' => Input::get('post_id')])->delete();
		else 
			Post::where(['id' => Input::get('post_id'), 'user_id' => Auth::user()->id])->delete();
		return Response::json(['success' => true]);

	}
}