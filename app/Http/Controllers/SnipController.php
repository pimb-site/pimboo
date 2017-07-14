<?php namespace App\Http\Controllers;

use Illuminate\View\View;
use Input;
use redirect;
use Response;
use Auth;
use DB;
use DOMDocument;

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

		$title = SnipController::get_title($url);
		// Content(iframe url)
		$content = ['iframe_url' => $url, 'title' => $title];
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

	public static function get_title($url_site) {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url_site);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    // some websites like Facebook need a user agent to be set.
	    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.94 Safari/537.36');
  	    $html = curl_exec($ch);
	    curl_close($ch);

	    $dom  = new DOMDocument;
	    @$dom->loadHTML($html);

	    $title = $dom->getElementsByTagName('title')->item('0')->nodeValue;
	    return $title;
	}
}