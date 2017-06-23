<?php namespace App\Http\Controllers;

use Input;
use Response;
use Auth;
use Session;
use Request;

class AdditionForToolsController extends Controller
{

	public function successPage($author, $link, Request $request) {
		if ($author != '' && $link != '') {
			$url = url('/').'/'.$author.'/'.$link;
			return view('success', ['url' => $url]);
		} else redirect('/home');
    }

	public function saveImage() {
		if(Auth::guest()) return Response::json(['success' => false, 'errorText' => 'You are not authorized.']);
		if (Input::file('filedata')->isValid()) {
			$filename = uniqid().".jpeg";
			$file_tmp = 'temp/'.Session::getId()."/";
			Input::file('filedata')->move($file_tmp, $filename);
			return Response::json(['success' => true, 'file' => Session::getId()."/".$filename]);
		}
	}

	public function getInfoYoutube() {
		if(Auth::guest()) return Response::json(['success' => false, 'errorText' => 'You are not authorized.']);

		$url = Input::get('video_url');
		$api_key = "AIzaSyCxldnrnpZKFHg64lO5vum9OaLJfS7ikiM";
		if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
			$content = @file_get_contents('https://www.youtube.com/oembed?url='.$url.'&format=json');
			$array_information = json_decode($content, true);
			if(is_array($array_information)) {
				preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
				$video_id = $matches[1];
				$duration = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id=$video_id&key=$api_key");
				$duration = json_decode($duration, true);
				$duration = $duration['items'][0]['contentDetails']['duration'];
				return Response::json(['success' => true, 'thumbnail_url' => $array_information['thumbnail_url'], 'html' => $array_information['html'], 'duration' => $duration]);
			} else {
				return Response::json(['success' => false, 'errorText' => 'Video not found.']);
			}
		} else {
			return Response::json(['success' => false, 'errorText' => 'Invalid link.']);
		}
	}


	public function saveImageOnURL() {
		if(Auth::guest()) return Response::json(['success' => false, 'errorText' => 'You are not authorized.']);

		$url = Input::get('image_url');
		if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
			$enabled = array( 'png', 'jpeg' );
			$name = uniqid().'.jpg';
			$image = file_get_contents($url);
			if(!file_exists("temp/".\Session::getId())) {
				mkdir("temp/".Session::getId());
			}
			$full_path = Session::getId()."/".$name;
			$success = file_put_contents("temp/".$full_path, $image);
			unset($image);
			if($success) {
				if( $info = getimagesize("temp/".$full_path)) {
					$type = trim( strrchr( $info['mime'], '/' ), '/' );
					if( !in_array( $type, $enabled ) ) {
						unlink("temp/".$full_path);
						return Response::json(['success' => false, 'errorText' => 'Invalid image mimetype.']);
					} else {
						return Response::json(['success' => true, 'file' => $full_path]);
					}
				} else return Response::json(['success' => false, 'errorText' => 'Invalid image.']);
			}
			
		} else {
			return Response::json(['success' => false, 'errorText' => 'Invalid URL.']);
		}
	}
}