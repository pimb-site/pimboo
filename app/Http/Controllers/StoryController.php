<?php namespace App\Http\Controllers;

use Validator;
use Response;
use App\Post;
use App\User;
use Input;
use Auth;
use File;

class StoryController extends Controller {

	public function displayCreatePage() {
		return Auth::guest() ? redirect('auth/login') : view('ToolsCreate.story', ['body_class' => 'tools_create_page']);
	}

	public function sendStory() {
		if(Auth::guest()) return Response::json(['success' => false, 'errorText' => 'You are not authorized!']);
		if(Input::get('isDraft') !== null) {
			switch (Input::get('isDraft')) {
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

	private function publish($draft) {
		$data = Input::only('story');
		if(count($data) != 0) {
			// Validation the Main Data
			$validator = Validator::make($data['story']['data'], [
	            'photo_main'        => 'required',
	            'photo_facebook'    => 'required',
	            'story_title'       => 'required|min:3|max:400',
	            'story_description' => 'required|min:3|max:2000',
	        ]);
			if ($validator->fails())
				return Response::json(['success' => false, 'errorText' => $validator->errors()->all()]);

			// Validation the Cards
			$validator = Validator::make($data['story'], [
				'story_content' => 'required|min:50|max:5000', 
			]);
			if ($validator->fails()) 
				return Response::json(['success' => false, 'errorText' => $validator->errors()->all()]);

			$errors_array = [];

	        // Checking if images are loaded ( main and facebook photo )
	        $data['story']['data']['photo_main'] = str_replace('..', '', $data['story']['data']['photo_main']);
	        if(!File::exists(public_path()."/temp/".$data['story']['data']['photo_main']) && !File::exists(public_path()."/uploads/".$data['story']['data']['photo_main']))
	        	$errors_array[] = "The main photo not found. Please, upload a new image!";

	       	$data['story']['data']['photo_facebook'] = str_replace('..', '', $data['story']['data']['photo_facebook']);
	        if(!File::exists(public_path()."/temp/".$data['story']['data']['photo_facebook']) && !File::exists(public_path()."/uploads/".$data['story']['data']['photo_facebook']))
	        	$errors_array[] = "The facebook photo not found. Please, upload a new image!";

	        if(count($errors_array) != 0)
	        	return Response::json(['success' => false, 'errorText' => $errors_array]);

	        // Moving main photo/ facebook photo
	        if(strpos($data['story']['data']['photo_main'], '/') !== false) {
	        	$main_photo = uniqid().".jpeg";
		        if(!File::move(public_path()."/temp/".$data['story']['data']['photo_main'], public_path()."/uploads/".$main_photo))
		        	$errors_array[] = "An error occurred while moving the main photo. Please, upload a new image!";
		    } else $main_photo = $data['story']['data']['photo_main'];

		    if(strpos($data['story']['data']['photo_facebook'], '/') !== false) {
		    	$facebook_photo = uniqid().".jpeg";
				if(!File::move(public_path()."/temp/".$data['story']['data']['photo_facebook'], public_path()."/uploads/".$facebook_photo))
					$errors_array[] = "An error occurred while moving the facebook photo. Please, upload a new image!";
			} else $facebook_photo = $data['story']['data']['photo_facebook'];
	        if(count($errors_array) != 0)
	        	return Response::json(['success' => false, 'errorText' => $errors_array]);

			// tags recording | max count tags : 22
			$tags = [];
			if(Input::has('tags'))
				$get_tags = Input::get('tags');
			if(isset($get_tags) && count($get_tags > 0)) {
				$get_tags = array_slice($get_tags, 0, 22);
				foreach ($get_tags as $key => $value) {
					$tags[] = $value;
				}
			}
			$tags = serialize($tags);

			// options recording
			$options = [];
			$options = serialize($options);

			// If there is a postID, then to update post
			$validator = Validator::make($data['story']['data'], [
				'postID' => 'required|integer|min:1',
			]);

			if (!$validator->fails()) {
				$owner = Post::select('author_name', 'user_id', 'url')->where(['id' => $data['story']['data']['postID'], 'type' => 'story'])->get();
				if(count($owner) != 0 && ($owner[0]->user_id == Auth::user()->id || Auth::user()->permission == 10)) {
					Post::where(['id' => $data['story']['data']['postID'], 'type' => 'story'])
						->update(['description_title'  => $data['story']['data']['story_title'],  
								  'description_text'   => $data['story']['data']['story_description'],
								  'description_image'  => $main_photo,
								  'image_facebook'     => $facebook_photo, 'content' => $data['story']['story_content'], 'permission' => 'public',
								  'options' => $options, 'tags' => $tags, 'isDraft' => $draft
					]);
					$link = '/'.$owner[0]->author_name.'/'.$owner[0]->url;
					return Response::json(['success' => true, 'link' => $link]);
				}
				return Response::json(['false' => true, 'errorText' => 'Invalid data(postID)']);
			}

			// Transliteration field title for URL
			$title_url = AdditionForToolsController::translit($data['story']['data']['story_title']);
			if(strlen($title_url) < 3)
				$title_url = 'story';
			else if(strlen($title_url) > 180)
				$title_url = substr($title_url, 0, 180); 


			// Insert a new post in DB
			$counter = -1;
			$url  = $title_url;
			while (true) {
				$result = Post::where(['url' => $title_url, 'author_name' => Auth::user()->name])->count();
				if($result == 0) {
					Post::insert(['description_title'  => $data['story']['data']['story_title'], 
								  'description_text'   => $data['story']['data']['story_description'],
							   	  'description_image'  => $main_photo, 'image_facebook' => $facebook_photo, 
							   	  'content' => $data['story']['story_content'], 'type'  => 'story',
								  'permission'  => 'public', 'options' => $options, 'tags' => $tags, 'isDraft' => $draft, 'url' => $title_url, 
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