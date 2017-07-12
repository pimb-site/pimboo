<?php namespace App\Http\Controllers;

use Illuminate\View\View;
use Input;
use redirect;
use Response;
use Auth;
use DB;

class SnipController extends Controller {

	public function displayCreatePage() {
		return (Auth::guest()) ? view('auth/login') : view('ToolsCreate.snip');
	}

	public function createLink() {
		if (Auth::guest()) return Response::json(['success' => false, 'errorText' => 'auth']);

		$input = Input::all();

		$url = $input['url'];

		if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
			$header = @get_headers($url, 1);
			$header = array_change_key_case($header, CASE_LOWER);
			if (!$header || !stripos($header[0], '200 OK ') === false) {
				return Response::json(['success' => false, 'text' => 'This domain has opted out of the service. Please try another domain.']);
			}
			elseif (isset($header['x-frame-options']) && (stripos($header['x-frame-options'], 'SAMEORIGIN') !== false || stripos($header['x-frame-options'], 'deny') !== false) || isset($header['content-security-policy'])) {
				return Response::json(['success' => false, 'text' => 'This domain has opted out of the service. Please try another domain.']);
			}
		}
		else {
			return Response::json(['success' => false, 'text' => 'Incorrect URL']);
		}

		// Content(iframe url)
		$content = ['iframe_url' => $url];
		$content = serialize($content);

		// TAGS
		$tags = [];
		if(isset($input['tags'])) {
			if(count($input['tags']) > 0) {
				foreach ($input['tags'] as $key => $value) {
					$tags[] = $value;
				}
			}
		}		
		$tags = serialize($tags);

		// OPTIONS
		$options = [];
		$options = serialize($options);

		$url_snip = 'post-snip-'.strtolower(str_random(30)).'-'.date('Y-d-m');

		$id = DB::table('posts')->insertGetId(
			['user_id' => Auth::user()->id, 'author_name' => Auth::user()->name, 'url' => $url_snip, 'description_title' => 'snip', 'description_text' => 'snip',
			'content' => $content, 'description_image' => 'snip.png', 'image_facebook' => 'snip.png',
			'type' => 'snip', 'isDraft' => 'publish', 'tags' => $tags, 'permission' => 'public', 'options' => $options]
		);

		$link = '/'.Auth::user()->name.'/'.$url_snip;

		return Response::json(['success' => true, 'link' => $link]);
	}
}