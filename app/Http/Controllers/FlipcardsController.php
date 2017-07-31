<?php namespace App\Http\Controllers;

use Validator;
use Response;
use App\Post;
use App\User;
use Input;
use Auth;
use File;

class FlipcardsController extends Controller {

	public function displayCreatePage() {
        if(Auth::guest()) { 
    		return redirect('/auth/login');
    	}
        return view('ToolsCreate.flipcards');
	}

	public function sendFlipcards() {
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
		$data = Input::only('flipcards');
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
				'title' => $data['flipcards']['data']['flipcards_title'],
				'description' => $data['flipcards']['data']['flipcards_description'],
				'footer' => $data['flipcards']['data']['flipcards_footer']
			];


			// content other formation for preview
	        $themes = [
	        	'blue'      => '#009cff',
	        	'green'     => '#8dc63f',
	        	'purple'    => '#605ca8',
	        	'turquoise' => '#00a99d',
	        ];
			$content_other = [];
			foreach ($data['flipcards']['cards'] as $key => $value) {
	        	$front_card_text  = isset($value['front_card_text']) ? $value['front_card_text'] : '';
	        	$back_card_text   = isset($value['back_card_text']) ? $value['back_card_text'] : '';
				$front_card_image = isset($value['front_card_image']) ? $value['front_card_image'] : '';
				$back_card_image  = isset($value['back_card_image']) ? $value['back_card_image'] : '';
				$front_card_theme = (isset($value['front_card_theme']) && isset($themes[$value['front_card_theme']])) ? $themes[$value['front_card_theme']]: $themes['blue'];
	        	$back_card_theme  = (isset($value['back_card_theme']) && isset($themes[$value['back_card_theme']])) ? $themes[$value['back_card_theme']] : $themes['blue'];

	        	$content_other[] = [
	        		'card_item_title'  => $value['card_item_title'],
	        		'card_type_front'  => $value['card_type_front'],
	        		'card_type_back'   => $value['card_type_back'],
	        		'front_card_image' => $front_card_image,
	        		'back_card_image'  => $back_card_image,
	        		'front_card_theme' => $front_card_theme,
	        		'back_card_theme'  => $back_card_theme,
	        		'front_card_text'  => $front_card_text,
	        		'back_card_text'   => $back_card_text,
	        	];
			}

			return Response::json(['success' => 'true', 'content' => $content_main, 'cards' => $content_other, 'tags' => $tags]);
    	}
    	return Response::json(['success' => false, 'errorText' => 'Invalid data! Try reload page.']);
	}

	private function publish($draft) {
		$data = Input::only('flipcards');
		if(count($data) != 0) {
			// Validation the Main Data
			$validator = Validator::make($data['flipcards']['data'], [
	            'photo_main'            => 'required',
	            'photo_facebook'        => 'required',
	            'flipcards_title'       => 'required|min:3|max:400',
	            'flipcards_footer'      => 'required|min:3|max:500',
	            'flipcards_description' => 'required|min:3|max:2000',
	        ]);
			if ($validator->fails())
				return Response::json(['success' => false, 'errorText' => $validator->errors()->all()]);

			// Validation the Cards
			foreach ($data['flipcards']['cards'] as $key => $value) {
				$validator = Validator::make($value ,[
					'card_item_title' => 'required|min:3|max:45',
					'card_type_front' => 'required',
					'card_type_back'  => 'required',
				]);
				if ($validator->fails()) 
					return Response::json(['success' => false, 'errorText' => $validator->errors()->all()]);
	        }

	        $errors_array = [];
	        // min card 1; max cards = 15; array truncation
	        if(count($data['flipcards']['cards']) == 0)
	        	$errors_array[] = "Minimum cards in post must be 1!";
	        $data['flipcards']['cards'] = array_slice($data['flipcards']['cards'], 0, 15);

	        // Checking if images are loaded ( main and facebook photo )
	        $data['flipcards']['data']['photo_main'] = str_replace('..', '', $data['flipcards']['data']['photo_main']);
	        if(!File::exists(public_path()."/temp/".$data['flipcards']['data']['photo_main']))
	        	$errors_array[] = "The main photo not found. Please, upload a new image!";

	       	$data['flipcards']['data']['photo_facebook'] = str_replace('..', '', $data['flipcards']['data']['photo_facebook']);
	        if(!File::exists(public_path()."/temp/".$data['flipcards']['data']['photo_facebook']))
	        	$errors_array[] = "The facebook photo not found. Please, upload a new image!";

	        if(count($errors_array) != 0)
	        	return Response::json(['success' => false, 'errorText' => $errors_array]);

	        // Checking if images are loaded or exist youtube video ( card post )
	        $available_types = ['image', 'text'];
	        foreach ($data['flipcards']['cards'] as $key => &$value) {
	        	if(!in_array($value['card_type_front'], $available_types))
	        		return Response::json(['success' => false, 'errorText' => ['Unknown card type. Please, try reload page!']]);
	        	if(!in_array($value['card_type_back'], $available_types))
	        		return Response::json(['success' => false, 'errorText' => ['Unknown card type. Please, try reload page!']]);

	        	// check front card
	        	if($value['card_type_front'] == "image") {
	        		$value['front_card_image'] = str_replace('..', '', $value['front_card_image']);
	        		if($value['front_card_image'] != "") {
	        			if(!File::exists(public_path()."/temp/".$value['front_card_image'])) {
	        				$errors_array[] = "The front card image not found. Please, upload a new image!";
	        			}
	        		} else {
	        			$errors_array[] = "The photo or text on front card must be filled!";
	        		}
	        	} else {
	        		$validator = Validator::make($value, [
	        			'front_card_text' => 'required|min:3|max:100'
	        		]);
					if ($validator->fails()) 
						return Response::json(['success' => false, 'errorText' => $validator->errors()->all()]);
	        	}

	        	// check back card
	        	if($value['card_type_back'] == "image") {
	        		$value['back_card_image'] = str_replace('..', '', $value['back_card_image']);
	        		if($value['back_card_image'] != "") {
	        			if(!File::exists(public_path()."/temp/".$value['back_card_image'])) {
	        				$errors_array[] = "The back card image not found. Please, upload a new image!";
	        			}
	        		} else {
	        			$errors_array[] = "The photo or text on back card must be filled!";
	        		}
	        	} else {
	        		$validator = Validator::make($value, [
	        			'back_card_text' => 'required|min:3|max:100'
	        		]);
					if ($validator->fails()) 
						return Response::json(['success' => false, 'errorText' => $validator->errors()->all()]);
	        	}

	        	if(count($errors_array) != 0)
	        		return Response::json(['success' => false, 'errorText' => $errors_array]);
	        }

	        // Moving main photo/ facebook photo
	        $main_photo     = uniqid().".jpeg";
	        $facebook_photo = uniqid().".jpeg";
	        if(!File::move(public_path()."/temp/".$data['flipcards']['data']['photo_main'], public_path()."/uploads/".$main_photo))
	        	$errors_array[] = "An error occurred while moving the main photo. Please, upload a new image!";
			if(!File::move(public_path()."/temp/".$data['flipcards']['data']['photo_facebook'], public_path()."/uploads/".$facebook_photo))
				$errors_array[] = "An error occurred while moving the facebook photo. Please, upload a new image!";
	        if(count($errors_array) != 0)
	        	return Response::json(['success' => false, 'errorText' => $errors_array]);

	        $themes = [
	        	'blue'      => '#009cff',
	        	'green'     => '#8dc63f',
	        	'purple'    => '#605ca8',
	        	'turquoise' => '#00a99d',
	        ];
	        // Content cards creation for flipcards
	        $content_flipcards = [];
	        foreach ($data['flipcards']['cards'] as $key => $value) {
	        	if($value['card_type_front'] == "image") {
	        		$front_card_image = uniqid().".jpeg";
					if(!File::move(public_path()."/temp/".$value['front_card_image'], public_path()."/uploads/".$front_card_image))
						$errors_array[] = "An error occurred while moving the image card. Please, try reload page!";
				}

	        	if($value['card_type_back'] == "image") {
	        		$back_card_image = uniqid().".jpeg";
					if(!File::move(public_path()."/temp/".$value['back_card_image'], public_path()."/uploads/".$back_card_image))
						$errors_array[] = "An error occurred while moving the image card. Please, try reload page!";
				}

	        	$front_card_text  = isset($value['front_card_text']) ? $value['front_card_text'] : '';
	        	$back_card_text   = isset($value['back_card_text']) ? $value['back_card_text'] : '';
				$front_card_image = isset($value['front_card_image']) ? $front_card_image : '';
				$back_card_image  = isset($value['back_card_image']) ? $back_card_image : '';
				$front_card_theme = (isset($value['front_card_theme']) && isset($themes[$value['front_card_theme']])) ? $themes[$value['front_card_theme']]: $themes['blue'];
	        	$back_card_theme  = (isset($value['back_card_theme']) && isset($themes[$value['back_card_theme']])) ? $themes[$value['back_card_theme']] : $themes['blue'];

	        	$content_flipcards[] = [
	        		'card_item_title'  => $value['card_item_title'],
	        		'card_type_front'  => $value['card_type_front'],
	        		'card_type_back'   => $value['card_type_back'],
	        		'front_card_image' => $front_card_image,
	        		'back_card_image'  => $back_card_image,
	        		'front_card_theme' => $front_card_theme,
	        		'back_card_theme'  => $back_card_theme,
	        		'front_card_text'  => $front_card_text,
	        		'back_card_text'   => $back_card_text,
	        	];
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
			if(isset($input['display_item_numbers'])) {
				if($input['display_item_numbers'] == 'yes') $display_item_numbers = 'yes';
				else $display_item_numbers = 'no';
			} else $display_item_numbers = 'no';
				
			$options = ['display_item_numbers' => $display_item_numbers];
			$options = serialize($options);

			// If there is a postID, then to update post
			$validator = Validator::make($data, [
				'postID' => 'required|integer|min:1',
			]);

			if (!$validator->fails()) {
				$owner = Post::select('user_id', 'url')->where(['id' => $data['postID'], 'type' => 'flipcards'])->get();
				if(count($owner) != 0 && $owner[0]->user_id == Auth::user()->id) {
					Post::where(['postID' => $data['postID'], 'type' => 'flipcards'])
						->update(['description_title'  => $data['flipcards']['data']['flipcards_title'],  
								  'description_text'  => $data['flipcards']['data']['flipcards_description'],
								  'description_footer' => $data['flipcards']['data']['flipcards_footer'], 'description_image' => $main_photo,
								  'image_facebook'     => $facebook_photo, 'content' => serialize($content_flipcards), 'permission' => 'public',
								  'options' => $options, 'tags' => $tags, 'isDraft' => $draft
					]);
					$link = '/'.Auth::user()->name.'/'.$current_owner[0]->url;
					return Response::json(['success' => true, 'link' => $link]);
				}
				return Response::json(['false' => true, 'errorText' => 'Invalid data(postID)']);
			}

			// Transliteration field title for URL
			$title_url = AdditionForToolsController::translit($data['flipcards']['data']['flipcards_title']);
			if(strlen($title_url) < 3)
				$title_url = 'flipcards';
			else if(strlen($title_url) > 180)
				$title_url = substr($title_url, 0, 180); 


			// Insert a new post in DB
			$counter = -1;
			$url  = $title_url;
			while (true) {
				$result = Post::where(['url' => $title_url, 'author_name' => Auth::user()->name])->count();
				if($result == 0) {
					Post::insert(['description_title'  => $data['flipcards']['data']['flipcards_title'], 
								  'description_text'   => $data['flipcards']['data']['flipcards_description'],
							   	  'description_footer' => $data['flipcards']['data']['flipcards_footer'], 'description_image' => $main_photo,
								  'image_facebook'     => $facebook_photo, 'content' => serialize($content_flipcards), 'type'  => 'flipcards',
								  'permission'         => 'public', 'options' => $options, 'tags' => $tags, 'isDraft' => $draft, 'url' => $title_url, 
								  'author_name' => Auth::user()->name, 'user_id' => Auth::user()->id
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
}