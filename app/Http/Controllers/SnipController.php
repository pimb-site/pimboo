<?php namespace App\Http\Controllers;

use Validator;
use Response;
use App\Post;
use App\User;
use Input;
use Auth;

class SnipController extends Controller {

	public function displayCreatePage() {
		return Auth::guest() ? redirect('auth/login') : view('ToolsCreate.snip', ['body_class' => 'tools_create_page']);
	}

	public function sendSnip() {
		if(Auth::guest()) return Response::json(['success' => false, 'errorText' => 'You are not authorized!']);

		$data = Input::only('snip');
		if(count($data) != 0) {
			$validator = Validator::make($data['snip']['data'], [
				'url' => 'required|url',
			]);
			if ($validator->fails())
				return Response::json(['success' => false, 'errorText' => $validator->errors()->all()]);

			// checking headers of the site
			$headers = @get_headers($data['snip']['data']['url'], 1);
			$headers = array_change_key_case($headers);

			if(!$headers || !stripos($headers[0], '200 OK ') === false)
				return Response::json(['success' => false, 'errorText' => 'This domain has opted out of the service. Please try another domain.']);
			elseif (isset($headers['x-frame-options']) && (stripos($headers['x-frame-options'], 'SAMEORIGIN') !== false || stripos($headers['x-frame-options'], 'deny') !== false) || isset($headers['content-security-policy'])) {
				return Response::json(['success' => false, 'errorText' => 'This domain has opted out of the service. Please try another domain.']);
			}

			// taking the title of the page
			$title = AdditionForToolsController::get_title_site($data['snip']['data']['url']);
			if($title == '') $title = 'Snip of '.$data['snip']['data']['url'];

			$title_url = AdditionForToolsController::translit($title);
			if(strlen($title_url) < 3)
				$title_url = 'snip';
			else if(strlen($title_url) > 180)
				$title_url = substr($title_url, 0, 180); 
			
			// content creation
			$content = [
				'iframe_url' => $data['snip']['data']['url'],
				'title'      => $title,
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
			$validator = Validator::make($data['snip']['data'], [
				'postID' => 'required|integer|min:1',
			]);

			if (!$validator->fails()) {
				$owner = Post::select('author_name', 'user_id', 'url')->where(['id' => $data['snip']['data']['postID'], 'type' => 'snip'])->first();
				if(count($owner) != 0 && ($owner->user_id == Auth::user()->id || Auth::user()->permission == 10)) {
					Post::where(['id' => $data['snip']['data']['postID'], 'type' => 'gif'])
						->update([ 'description_title' => $title, 'description_text' => $title, 'content' => $content, 'tags' => $tags, 'options' => $options
					]);
					$link = '/'.$owner->author_name.'/'.$owner->url;
					return Response::json(['success' => true, 'link' => $link]);
				}
				return Response::json(['false' => true, 'errorText' => 'Invalid data(postID)']);
			}

			// Insert a new post in DB
			$counter = -1;
			$url  = $title_url;
			while (true) {
				$result = Post::where(['url' => $title_url, 'author_name' => Auth::user()->name])->count();
				if($result == 0) {
					Post::insert(['description_title' => $title, 'description_text' => $title, 'description_image' => 'snip.png', 'type' => 'snip',
								  'permission' => 'public', 'options' => $options, 'isDraft' => 'publish', 'content' => $content, 'tags' => $tags,
								  'image_facebook' => 'snip.png', 'author_name' => Auth::user()->name, 'user_id' => Auth::user()->id, 'url' => $title_url
					]);
					$link = '/'.Auth::user()->name.'/'.$title_url;
					return Response::json(['success' => true, 'link' => $link]);
				}
				$title_url = $url.$counter;
				$counter--;
			}
		}
	}
}