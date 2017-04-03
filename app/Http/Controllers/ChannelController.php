<?php namespace App\Http\Controllers;

use Illuminate\View\View;
use Input;
use DB;
use Response;
use DateTime;

class ChannelController extends Controller
{
	public function viewChannel($channel_id) {
		$channel_id = (int)$channel_id;

		if($channel_id != null && $channel_id > 0) {
			$user_info = DB::select('select id, name, photo, public_info from users where id = ?', [$channel_id]);
			if(count($user_info) != 0) {
				$types = ['trivia', 'story', 'flipcards', 'rankedlist'];
				$channel_content = DB::table('posts')
									->where('user_id', $channel_id)
									->where('isDraft', 'publish')
									->whereIn('type', $types)
									->orderBy('created_at', 'desc')
									->skip(0)->take(10)
									->get(['id', 'description_title', 'description_text', 'description_image', 'type', 'created_at']);

				$show_more = (count($channel_content) == 10) ? true : false;

				return view('channel_page', ['user_info' => $user_info[0], 'channel_content' => $channel_content, 'show_more' => $show_more]);
			}
			else {
				return view('home');
			}
		}
		else {
			return view('home');
		}
	}

	public function filterChannel() {
		$types = Input::get('types');
		$multiplier = (int)Input::get('multiplier');
		$channel_id = (int)Input::get('channel_id');

		$channel_id = ($channel_id <= 0) ? 1 : $channel_id;
		$multiplier = ($multiplier <= 0) ? 1 : $multiplier;

		$skip = ($multiplier == 1) ? 0 : $multiplier * 10 - 10;

		$correct_names = ['flipcards', 'trivia', 'rankedlist', 'story']; 

		if(is_array($types) && count($types) != 0) {
			foreach ($types as $key => $value) {
				if(!isset($correct_names[$value])) {
					unset($types[$value]);
					sort($types);
				}
			}

			if(count($types) != 0) {
				$records = DB::table('posts')
							->where('user_id', $channel_id)
							->where('isDraft', 'publish')
							->whereIn('type', $types)
							->orderBy('created_at', 'desc')
							->skip($skip)->take(10)
							->get(['id', 'description_title', 'description_text', 'description_image', 'type', 'created_at']);
				
				if(count($records) != 0) {

					$aType = 
					[
						'rankedlist' => 'RANKED LIST',
						'story'      => 'STORY',
						'flipcards'  => 'FLIP CARD',
						'trivia'     => 'TRIVIA CARD'
					];

					$current_date = new DateTime();

					foreach ($records as $key => $value) {

						$post_date = new DateTime($value->created_at);
						$days = $current_date->format("d") - $post_date->format("d");
						$month = $current_date->format("m") - $post_date->format("m");
						
						if($month == 0) {
							if($days == 0) $posted = "Posted Today";
							else $posted = "Posted $days days ago";
						} else $posted = "Posted $month month ago";

						$json[] = 
						[
							'id' => $value->id,
							'description_title' => $value->description_title,
							'description_text' => $value->description_text,
							'description_image' => $value->description_image,
							'type' => $aType[$value->type],
							'posted' => $posted
						];
					}
					$show_more = (count($json) == 10) ? true : false;

					$json_response = json_encode($json);
					return Response::json(['success' => true, 'posts' => $json_response, 'show_more' => $show_more]);
				}
			}
		}
		return Response::json(['success' => false]);
	}
}