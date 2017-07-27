<?php namespace App\Http\Controllers;

use Validator;
use Response;
use App\Post;
use App\User;
use Input;
use Auth;
use File;
use DB;

class RankedlistController extends Controller {

	public function displayCreatePage() {
        if(Auth::guest()) { 
    		return redirect('/auth/login');
    	}
        return view('ToolsCreate.rankedlist');
	}
	
	public function sendRankedList() {
		if(Auth::guest()) return Response::json(['success' => false, 'errorText' => 'You are not authorized!']);
		if(Input::get('isDraft') !== null) {
			switch (Input::get('isDraft')) {
				case 'preview':
					return $this->preview();
					break;

				case 'save':
					return $this->publish('save');
					break;

				case 'publish':
					return $this->publish('publish');
					break;

				default:
					return Response::json(['success' => false, 'errorText' => 'Invalid data! Try reload page.']);
					break;
			}
		}

		return Response::json(['success' => false, 'errorText' => 'Invalid data! Try reload page.']);
	}

	private function preview() {
		$data = Input::only('rankedlist');
		if(count($data) != 0) {
			// tags recording | max count tags : 22
			$tags = [];
			if(isset($data['tags']) && count($data['tags']) > 0) {
				$data['tags'] = array_slice($data['tags'], 0, 22);
				foreach ($data['tags'] as $key => $value) {
					$tags[] = $value;
				}
			}

			// main content formation for preview
			$content_main = [
				'author' => Auth::user()->name,
				'title' => $data['rankedlist']['data']['rankedlist_title'],
				'description' => $data['rankedlist']['data']['rankedlist_description'],
				'footer' => $data['rankedlist']['data']['rankedlist_footer']
			];

			$content_other = [];
			foreach ($data['rankedlist']['cards'] as $key => $value) {
				if(!in_array($value['type_card'], ['image', 'video']))
					$value['type_card'] = 'image';

				if($value['type_card'] == 'video') { 
					$youtube_content = $value['youtube_clip'];
					$youtube_content = file_get_contents('https://www.youtube.com/oembed?url='.$youtube_content.'&format=json');
					if(!is_array($youtube_content)) {
						$youtube_content = "";
					} else {
						$youtube_content = json_decode($youtube_content, true);
						$youtube_content = $youtube_content['html'];
					}
					$image = "";
				} else {
					$youtube_content = "";
					$image = $value['image_card'];
				}

				// card formation for preview
				$content_other[] = [
					'post_title'   => $value['post_title'],
					'type_card'    => $value['type_card'],
					'youtube_clip' => $youtube_content,
					'caption_card' => $value['caption_card'],
					'image_card'   => $image,
				];

			}
			return Response::json(['success' => 'true', 'content' => $content_main, 'cards' => $content_other, 'tags' => $tags]);
    	}
    	return Response::json(['success' => false, 'errorText' => 'Invalid data! Try reload page.']);
	}
	// не забыть проверить на ../
	private function publish($draft) {
		$data = Input::only('rankedlist');
		if(count($data) != 0) {
			// Validation the Main Data
			$validator = Validator::make($data['rankedlist']['data'], [
	            'photo_main'            => 'required',
	            'photo_facebook'        => 'required',
	            'rankedlist_title'      => 'required|min:3|max:400',
	            'rankedlist_footer'     => 'required|min:3|max:500',
	            'rankedlist_description' => 'required|min:3',
	        ]);
			if ($validator->fails())
				return Response::json(['success' => false, 'errorText' => $validator->errors()->all()]);

			// Validation the Cards
			foreach ($data['rankedlist']['cards'] as $key => $value) {
				$validator = Validator::make($value ,[
					'post_title'   => 'required|min:3',
					'caption_card' => 'required|min:3',
					'type_card'    => 'required',
				]);
				if ($validator->fails()) 
					return Response::json(['success' => false, 'errorText' => $validator->errors()->all()]);
	        }

	        $errors_array = [];
	        // min card 1; max cards = 15; array truncation
	        if(count($data['rankedlist']['cards']) == 0)
	        	$errors_array[] = "Minimum cards in post must be 1!";
	        $data['rankedlist']['cards'] = array_slice($data['rankedlist']['cards'], 0, 15);

	        // Checking if images are loaded ( main and facebook photo )
	        if(!File::exists(public_path()."/temp/".$data['rankedlist']['data']['photo_main']))
	        	$errors_array[] = "The main photo not found. Please, upload a new image!";

	        if(!File::exists(public_path()."/temp/".$data['rankedlist']['data']['photo_main']))
	        	$errors_array[] = "The facebook photo not found. Please, upload a new image!";

	        if(count($errors_array) != 0)
	        	return Response::json(['success' => false, 'errorText' => $errors_array]);

	        // Checking if images are loaded or exist youtube video ( card post )
	        $available_types = ['image', 'video'];
	        foreach ($data['rankedlist']['cards'] as $key => $value) {
	        	if(!in_array($value['type_card'], $available_types))
	        		return Response::json(['success' => false, 'errorText' => ['Unknown card type. Please, try reload page!']]);

	        	if($value['type_card'] == 'image') {
	        		if($value['image_card'] != "") {
	        			if(!File::exists(public_path()."/temp/".$value['image_card'])) {
	        				$errors_array[] = "The card image not found. Please, upload a new image!";
	        			}
	        		} else {
	        			$errors_array[] = "The photo or video must be filled!";
	        		}
	        	} else {
	        		$validator = Validator::make($value, [
	        			'youtube_clip' => 'url',
	        		]);
					if ($validator->fails()) 
						return Response::json(['success' => false, 'errorText' => $validator->errors()->all()]);
        			$youtube_content = file_get_contents('https://www.youtube.com/oembed?url='.$value['youtube_clip'].'&format=json');
        			$youtube_content = json_decode($youtube_content, true);
        			if(!is_array($youtube_content))
        				$errors_array[] = "The Youtube video does not exist. Try use another video!";
	        	} 
	        	if(count($errors_array) != 0)
	        		return Response::json(['success' => false, 'errorText' => $errors_array]);
	        }

	        // Moving main photo/ facebook photo
	        $main_photo     = uniqid().".jpeg";
	        $facebook_photo = uniqid().".jpeg";
	        if(!File::move(public_path()."/temp/".$data['rankedlist']['data']['photo_main'], public_path()."/uploads/".$main_photo))
	        	$errors_array[] = "An error occurred while moving the main photo. Please, upload a new image!";
			if(!File::move(public_path()."/temp/".$data['rankedlist']['data']['photo_facebook'], public_path()."/uploads/".$facebook_photo))
				$errors_array[] = "An error occurred while moving the facebook photo. Please, upload a new image!";
	        if(count($errors_array) != 0)
	        	return Response::json(['success' => false, 'errorText' => $errors_array]);

	        // Content cards creation for rankedlist 
	        $content_rankedlist = [];
	        foreach ($data['rankedlist']['cards'] as $key => $value) {
	        	if($value['type_card'] == 'video') {
					$youtube_content = $value['youtube_clip'];
					$youtube_content = file_get_contents('https://www.youtube.com/oembed?url='.$youtube_content.'&format=json');
					$youtube_content = json_decode($youtube_content, true);
					$youtube_content = $youtube_content['html'];
					$content_rankedlist[] = [
						'post_title'   => $value['post_title'],
						'type_card'    => $value['type_card'],
						'caption_card' => $value['caption_card'],
						'youtube_clip' => $value['youtube_clip'],
					];
	        	} else {
	        		$image_card = uniqid().".jpeg";
					if(!File::move(public_path()."/temp/".$value['image_card'], public_path()."/uploads/".$image_card))
						$errors_array[] = "An error occurred while moving the image card. Please, try reload page!";
			        if(count($errors_array) != 0)
			        	return Response::json(['success' => false, 'errorText' => $errors_array]);

					$content_rankedlist[] = [
						'post_title'   => $value['post_title'],
						'type_card'    => $value['type_card'],
						'image_card'   => $image_card,
						'caption_card' => $value['caption_card'], 
					];
	        	}
	        }

			// tags recording | max count tags : 22
			$tags = [];
			if(isset($data['tags']) && count($data['tags']) > 0) {
				$data['tags'] = array_slice($data['tags'], 0, 22);
				foreach ($data['tags'] as $key => $value) {
					$tags[] = $value;
				}
			}
			$tags = serialize($tags);

			// options recording
			$options = [];
			$options = serialize($options);

			// If there is a postID, then to update post
			$validator = Validator::make($data, [
				'postID' => 'required|integer|min:1',
			]);

			if (!$validator->fails()) {
				$owner = Post::select('user_id', 'url')->where(['id' => $data['postID'], 'type' => 'rankedlist'])->get();
				if(count($owner) != 0 && $owner[0]->user_id == Auth::user()->id) {
					Post::where(['postID' => $data['postID'], 'type' => 'rankedlist'])
						->update(['description_title'  => $data['rankedlist']['data']['rankedlist_title'],  'description_text'  => $data['rankedlist']['data']['rankedlist_description'],
								  'description_footer' => $data['rankedlist']['data']['rankedlist_footer'], 'description_image' => $main_photo,
								  'image_facebook'     => $facebook_photo, 'content' => serialize($content_rankedlist), 'permission' => 'public',
								  'options' => $options, 'tags' => $tags, 'isDraft' => $draft
					]);
					$link = '/'.Auth::user()->name.'/'.$current_owner[0]->url;
					return Response::json(['success' => true, 'link' => $link]);
				}
				return Response::json(['false' => true, 'errorText' => 'Invalid data(postID)']);
			}

			// Transliteration field title for URL
			$title_url = AdditionForToolsController::translit($data['rankedlist']['data']['rankedlist_title']);
			if(strlen($title_url) < 3)
				$title_url = 'rankedlist';
			else if(strlen($title_url) > 180)
				$title_url = substr($title_url, 0, 180); 


			// Insert a new post in DB
			$counter = -1;
			$url  = $title_url;
			while (true) {
				$result = Post::where(['url' => $title_url, 'author_name' => Auth::user()->name])->count();
				if($result == 0) {
					Post::insert(['description_title'  => $data['rankedlist']['data']['rankedlist_title'],  'description_text'  => $data['rankedlist']['data']['rankedlist_description'],
							   	  'description_footer' => $data['rankedlist']['data']['rankedlist_footer'], 'description_image' => $main_photo,
								  'image_facebook'     => $facebook_photo, 'content' => serialize($content_rankedlist), 'type'  => 'rankedlist',
								  'permission'         => 'public', 'options' => $options, 'tags' => $tags, 'isDraft' => $draft, 'url' => $title_url, 'author_name' => Auth::user()->name,
								  'user_id' => Auth::user()->id
					]);
					$link = '/'.Auth::user()->name.'/'.$title_url;
					return Response::json(['success' => true, 'link' => $link]);
				}
				$title_url = $url.$counter;
				$counter--;
			}
    	}
    	return Response::json(['success' => false, 'errorText' => 'Invalid data! Try reload page.']);
	}

	public function voteRankedlist() {
		if(Auth::guest()) 
			return Response::json(['success' => false, 'errorText' => 'You are not authorized!']);

		if(!Input::has("pid") || !Input::has('cid'))
			 return Response::json(['success' => false, 'errorText' => 'Invalid data!']);

		$validator = Validator::make(Input::get(), [
			'pid'  => 'required|integer|min:1',
			'cid' => 'required|integer|min:1'
		]);

		if (!$validator->fails()) {
			if(DB::table('votes')->where(['user_id' => Auth::user()->id, 'post_id' => Input::get('pid'), 'card_id' => Input::get('cid')])->count() != 0)
				return Response::json(['success' => false, 'errorText' => 'You already voted!']);
			if(Post::where(['id' => Input::get('pid'), 'type' => 'rankedlist', 'isDraft' => 'publish'])->count() == 0)
				return Response::json(['success' => false, 'errorText' => 'Invalid data!!']);
			DB::table('votes')->insert(['user_id' => Auth::user()->id, 'post_id' => Input::get('pid'), 'card_id' => Input::get('cid')]);
			$all_votes = DB::table('votes')->where(['post_id' => Input::get('pid'), 'card_id' => Input::get('cid')])->count();
			return Response::json(['success' => true, 'votes' => $all_votes]);
		}
		return Response::json(['success' => false, 'errorText' => 'Invalid data!']);
	}
}