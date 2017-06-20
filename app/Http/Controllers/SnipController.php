<?php namespace App\Http\Controllers;

use Illuminate\View\View;
use Input;
use redirect;
use Response;
use Auth;
use DB;

class SnipController extends Controller {

	public function createPage() {
		return (Auth::guest()) ? view('auth/login') : view('create_snip');
	}

	public function createLink() {
		if (Auth::guest()) return Response::json(['success' => false, 'text' => 'auth']);

		$input = Input::all();
		$snip_id = uniqid();

		$url = $input['url'];

		if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
			$header = @get_headers($url, 1);
			if (!$header || !stripos($header[0], '200 OK ') === false) {
				return Response::json(['success' => false, 'text' => 'This domain has opted out of the service. Please try another domain.']);
			}
			elseif (isset($header['X-Frame-Options']) && (stripos($header['X-Frame-Options'], 'SAMEORIGIN') !== false || stripos($header['X-Frame-Options'], 'deny') !== false) || isset($header['content-security-policy'])) {
				return Response::json(['success' => false, 'text' => 'This domain has opted out of the service. Please try another domain.']);
			}
		}
		else {
			return Response::json(['success' => false, 'text' => 'Incorrect URL']);
		}

		$tags = [];
		if(isset($input['tags'])) {
			if(count($input['tags']) > 0) {
				foreach ($input['tags'] as $key => $value) {
					$tags[] = $value;
				}
			}
		}
		
		$tags = serialize($tags);

		DB::table('snips')->insert(
		    ['user_id' => Auth::user()->id, 'tags' => $tags, 'iframe_url' => $url, 'snip_id' => $snip_id]
		);


		$link = '/snip/'.$snip_id;

		return Response::json(['success' => true, 'link' => $link]);
	}

	public function viewLink($link) {
		if($link == "") return redirect('/');

		$snips = DB::table('snips')
                    ->select('user_id', 'iframe_url', 'tags')
                    ->where('snip_id', '=', $link)
                    ->get();

        if(count($snips) != 0) {

        	$tags = unserialize($snips[0]->tags);

        	if(count($tags) == 0) {
        		$tag_name = "notag";
        	} else {
        		$tag_num = rand (0, count($tags) - 1 );
        		$tag_name = strtolower($tags[$tag_num]);
        	}

        	$adv = DB::select("select * from settings where setting = ?", ['snips']);
			$adv = unserialize($adv['0']->value);

			$adv = [
				'href' => $adv[$tag_name]['href'],
				'url'  => $adv[$tag_name]['url'],
				'text' => $adv[$tag_name]['text']
			];

        	return view('view_snip', ['snip' => $snips[0],  'adv' => $adv]);
        } else {
        	return redirect('/');
        }
	}

	public function successID($id) {
        return view('success_snip', ['id' => $id]);
	}

}