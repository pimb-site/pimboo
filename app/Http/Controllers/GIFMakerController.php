<?php namespace App\Http\Controllers;

use Validator;
use Response;
use App\Post;
use App\User;
use Input;
use Auth;
use Image;
use Session;
use File;

class GIFMakerController extends Controller {
	
	public function displayCreatePage() {
		return Auth::guest() ? redirect('auth/login') : view('ToolsCreate.gifmaker', ['body_class' => 'tools_create_page']);
	}

	public function sendGIF() {
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
		$data = Input::only('gifmaker');
		if(count($data) != 0) {
			// Validation the Main Data
			$validator = Validator::make($data['gifmaker']['data'], [
	            'photo_main'           => 'required',
	            'photo_facebook'       => 'required',
	            'gifmaker_title'       => 'required|min:3|max:400',
	            'gifmaker_description' => 'required|min:3|max:2000',
	        ]);
			if ($validator->fails())
				return Response::json(['success' => false, 'errorText' => $validator->errors()->all()]);

			// Validation the Cards
			$validator = Validator::make($data['gifmaker'], [
				'gif' => 'required', 
			]);
			if ($validator->fails()) 
				return Response::json(['success' => false, 'errorText' => $validator->errors()->all()]);

			$errors_array = [];

	        // Checking if images are loaded ( main and facebook photo )
	        $data['gifmaker']['data']['photo_main'] = str_replace('..', '', $data['gifmaker']['data']['photo_main']);
	        if(!File::exists(public_path()."/temp/".$data['gifmaker']['data']['photo_main']) && !File::exists(public_path()."/uploads/".$data['gifmaker']['data']['photo_main']))
	        	$errors_array[] = "The main photo not found. Please, upload a new image!";

	       	$data['gifmaker']['data']['photo_facebook'] = str_replace('..', '', $data['gifmaker']['data']['photo_facebook']);
	        if(!File::exists(public_path()."/temp/".$data['gifmaker']['data']['photo_facebook']) && !File::exists(public_path()."/uploads/".$data['gifmaker']['data']['photo_facebook']))
	        	$errors_array[] = "The facebook photo not found. Please, upload a new image!";

	        $data['gifmaker']['gif'] = str_replace('..', '', $data['gifmaker']['gif']);
	        if(!File::exists(public_path()."/temp/".$data['gifmaker']['gif']) && !File::exists(public_path()."/uploads/".$data['gifmaker']['gif']))
	        	$errors_array[] = "The GIF-image not found. Please, create a new GIF-image!";

	        if(count($errors_array) != 0)
	        	return Response::json(['success' => false, 'errorText' => $errors_array]);

	        // Moving main photo/ facebook photo / main gif
	        if(strpos($data['gifmaker']['gif'], '/') !== false) {
	        	 $main_gif  = uniqid().".gif";
		        if(!File::move(public_path()."/temp/".$data['gifmaker']['gif'], public_path()."/uploads/".$main_gif))
		        	$errors_array[] = "An error occurred while moving the GIF-image. Please, create a new GIF-image!";
		    } else  $main_gif = $data['gifmaker']['gif'];
		    if(strpos($data['gifmaker']['data']['photo_main'], '/') !== false) {
		    	$main_photo = uniqid().".jpeg";
		        if(!File::move(public_path()."/temp/".$data['gifmaker']['data']['photo_main'], public_path()."/uploads/".$main_photo))
		        	$errors_array[] = "An error occurred while moving the main photo. Please, upload a new image!";
		    } else $main_photo = $data['gifmaker']['data']['photo_main'];
		    if(strpos($data['gifmaker']['data']['photo_facebook'], '/') !== false) {
		    	$facebook_photo = uniqid().".jpeg";
				if(!File::move(public_path()."/temp/".$data['gifmaker']['data']['photo_facebook'], public_path()."/uploads/".$facebook_photo))
					$errors_array[] = "An error occurred while moving the facebook photo. Please, upload a new image!";
			} else $facebook_photo = $data['gifmaker']['data']['photo_facebook'];
	        if(count($errors_array) != 0)
	        	return Response::json(['success' => false, 'errorText' => $errors_array]);

			$content[] = [
				'gif' => $main_gif,
			];
			$content = serialize($content); 

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
			$validator = Validator::make($data['gifmaker']['data'], [
				'postID' => 'required|integer|min:1',
			]);

			if (!$validator->fails()) {
				$owner = Post::select('author_name', 'user_id', 'url')->where(['id' => $data['gifmaker']['data']['postID'], 'type' => 'gif'])->get();
				if(count($owner) != 0 && ($owner[0]->user_id == Auth::user()->id || Auth::user()->permission == 10)) {
					Post::where(['id' => $data['gifmaker']['data']['postID'], 'type' => 'gif'])
						->update(['description_title'  => $data['gifmaker']['data']['gifmaker_title'],  
								  'description_text'   => $data['gifmaker']['data']['gifmaker_description'],
								  'description_image'  => $main_photo,
								  'image_facebook'     => $facebook_photo, 'content' => $content, 'permission' => 'public',
								  'options' => $options, 'tags' => $tags, 'isDraft' => $draft
					]);
					$link = '/'.$owner[0]->author_name.'/'.$owner[0]->url;
					return Response::json(['success' => true, 'link' => $link]);
				}
				return Response::json(['false' => true, 'errorText' => 'Invalid data(postID)']);
			}

			// Transliteration field title for URL
			$title_url = AdditionForToolsController::translit($data['gifmaker']['data']['gifmaker_title']);
			if(strlen($title_url) < 3)
				$title_url = 'gifmaker';
			else if(strlen($title_url) > 180)
				$title_url = substr($title_url, 0, 180); 


			// Insert a new post in DB
			$counter = -1;
			$url  = $title_url;
			while (true) {
				$result = Post::where(['url' => $title_url, 'author_name' => Auth::user()->name])->count();
				if($result == 0) {
					Post::insert(['description_title'  => $data['gifmaker']['data']['gifmaker_title'], 
								  'description_text'   => $data['gifmaker']['data']['gifmaker_description'],
							   	  'description_image'  => $main_photo, 'image_facebook' => $facebook_photo, 
							   	  'content' => $content, 'type'  => 'gif',
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

	public function createGIF() {
		if(Auth::guest()) return Response::json(['success' => false, 'errorText' => 'You are not authorized!']);
		
		$data = Input::only('gifmaker');
		if(count($data) != 0) {
			$validator = Validator::make($data['gifmaker']['create'], [
				'start_time'  => 'required|integer',
				'end_time'    => 'required|integer|in:1,2,3,4,5',
				'color'       => 'required|integer|in:0,1,2,3,4,5,6,7',
				'variant'     => 'required|integer|in:1,2',
				'font_family' => 'required|integer|in:0,1,2',
				'font_size'   => 'required|integer|in:0,1,2',
				'caption'     => 'max:12'
			]);

			if ($validator->fails())
				return Response::json(['success' => false, 'errorText' => $validator->errors()->all()]);

			$data = $data['gifmaker']['create'];
			$set_url = "http://146.185.164.150/handle.php?youtube_url=".$data['video_youtube']."&length=".$data['end_time']."&start_time=".$data['start_time']."&caption=".$data['caption']."&color=".$data['color']."&font_size=".$data['font_size']."&font_family=".$data['font_family']."&key=onlyforpimboo&variant=".$data['variant']."&filename=".$data['filename_blob'];
			$response = file_get_contents($set_url);
			if(json_decode($response, true)) {
				$response = json_decode($response, true);
				if($response['success'] == true) {
					// if folder not found then create
					$main_path = public_path('temp/'.Session::getId());
					if(!File::exists($main_path)) 
						File::makeDirectory($main_path);

					// generation of unique names for files
					$gif = uniqid().'.gif';
					$thumbnail_fb_photo = uniqid().'.jpeg';
					$thumbnail_main_photo = uniqid().'.jpeg';

					// saving images from response
					Image::make($response['facebook_photo'])->save($main_path . '/' . $thumbnail_fb_photo);
					Image::make($response['main_photo'])->save($main_path . '/' . $thumbnail_main_photo);
					copy($response['gif'], $main_path . '/' . $gif);

					$gif = Session::getId() . '/' . $gif;
					$thumbnail_fb_photo = Session::getId() . '/' . $thumbnail_fb_photo;
					$thumbnail_main_photo = Session::getId() . '/' . $thumbnail_main_photo;

					return Response::json(['success' => true, 'thumbnail_main' => $thumbnail_main_photo, 'thumbnail_fb' => $thumbnail_fb_photo, 'gif' => $gif]);
				}
				return Response::json(['success' => false, 'errorText' => $response['errorText']]);
			}
			return Response::json(['success' => false, 'errorText' => 'Unknown error. Please reload the page and try again.']);
		}
		return Response::json(['success' => false, 'errorText' => 'Invalid data! Try reload page.']);
	}
}
