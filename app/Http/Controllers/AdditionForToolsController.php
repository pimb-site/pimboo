<?php namespace App\Http\Controllers;

use Input;
use Response;
use Auth;
use Session;
use Request;
use DOMDocument;
use Validator;
use File;
use Image;
use App\Post;

class AdditionForToolsController extends Controller {

	public function saveImage() {
		if(Auth::guest()) return Response::json(['success' => false, 'errorText' => ['You are not authorized!'] ]);

		if(Input::hasFile('filedata')) {
			if(Input::file('filedata')->isValid()) {
				$validator = Validator::make(Input::file(), [
					'filedata' => 'dimensions:max_width=4000,max_height=4000|image',
				]);
				if (!$validator->fails()) {
					$destinationPath = public_path('temp/' . Session::getId(). '/');
					$this->makeDirectory($destinationPath);
					$fileName = uniqid('pimboo' , true) . '.jpeg';
					Input::file('filedata')->move($destinationPath, $fileName);
					return Response::json(['success' => true, 'file' => Session::getId() . '/' . $fileName]);
				}
				return Response::json(['success' => false, 'errorText' => $validator->errors()->all()]);
			}
			return Response::json(['success' => false, 'errorText' => ['The file failed validation'] ]);
		}
		return Response::json(['success' => false, 'errorText' => ['It must be a file!'] ]);
	}

	public function saveImageOnURL() {
		if(Auth::guest()) return Response::json(['success' => false, 'errorText' => ['You are not authorized!'] ]);

		$validator = Validator::make(Input::get() , [
			'image_url' => 'required|url',
		]);
		if (!$validator->fails()) {
			$pathinfo = pathinfo(Input::get('image_url'));
			$validator = Validator::make($pathinfo, [
				'extension' => 'required|in:jpeg,jpg,png,bmp',
			]);
			if (!$validator->fails()) {
				$destinationPath = public_path('temp/' . Session::getId(). '/');
				$this->makeDirectory($destinationPath);
				$fileName = uniqid('pimboo', true) . '.jpeg';
				$image = Image::make(Input::get('image_url'));
				$image->save($destinationPath . $fileName);
				return Response::json(['success' => true, 'file' => Session::getId() . '/' . $fileName]);
			}
			return Response::json(['success' => false, 'errorText' => ['Invalid extension for image! List of available extensions for the image: png, jpg, bmp.']]);
		}
		return Response::json(['success' => false, 'errorText' => $validator->errors()->all()]);
	}

	public function getInfoYoutube() {
		if(Auth::guest()) return Response::json(['success' => false, 'errorText' => ['You are not authorized!'] ]);

		$validator = Validator::make(Input::get(), [
			'video_url' => 'required|url'
		]);
		if (!$validator->fails()) {
			$array_information = @file_get_contents('https://www.youtube.com/oembed?url='.Input::get('video_url').'&format=json');
			$array_information = json_decode($array_information, true);
			if(is_array($array_information))
				return Response::json(['success' => true, 'thumbnail_url' => $array_information['thumbnail_url'], 'html' => $array_information['html'] ]);
			else
				return Response::json(['success' => false, 'errorText' => ['Youtube video on this link was not found!'] ]);
		}
		return Response::json(['success' => false, 'errorText' => $validator->errors()->all()]);
	}

	public function successPage($author, $url) {
		if (Auth::guest()) return redirect('auth/login');
		$data = ['author' => $author, 'url' => $url];
		$validator = Validator::make($data, [
			'author' => 'required|min:3|max:255',
			'url'    => 'required|min:3|max:200',
		]);
		if (!$validator->fails()) {
			$count = Post::where(['user_id' => Auth::user()->id, 'author_name' => $author, 'url' => $url])->count();
			if($count != 0) {
				return view('success', ['url' => url($author . '/' . $url)]);
			}
			return redirect('/home');
		}
		return redirect('/home');
    }

    private function makeDirectory($path) {
    	if(!File::exists($path))
    		return File::makeDirectory($path);
    	else
    		return false;
    }

	public static function get_title_site($url) {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
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

	public static function translit($string) {
	    $string = (string) $string;
	    $string = strip_tags($string);
	    $string = str_replace(array("\n", "\r"), " ", $string);
	    $string = trim($string);
	    $string = function_exists('mb_strtolower') ? mb_strtolower($string) : strtolower($string);
	    $string = strtr($string, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
	   	$string = preg_replace("/[^0-9a-z-_ ]/i", "", $string);
	   	$string = preg_replace("/\s+/", ' ', $string);
	   	$string = str_replace(" ", "-", $string);
	   	return $string;
	}
}