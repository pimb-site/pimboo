<?php namespace App\Http\Controllers;

use Illuminate\View\View;
use Input;
use Response;
use Auth;
use Session;
use DB;

class VideoGifController extends Controller {
	
	public function displayCreatePage() {
		if(Auth::guest()) return view('auth/login');
        else return view('ToolsCreate.gifmaker');
	}

	public function uploadGIF() {
		if(Auth::guest()) return Response::json(['success' => false, 'errorText' => 'You are not authorized.']);
		$input = Input::all();
		$youtube_url   = $input['video_youtube'];
		$caption       = $input['caption'];
		$color         = $input['color'];
		$font_size     = $input['font_size'];
		$font_family   = $input['font_family'];
		$start_time    = $input['start_time'];
		$length        = $input['end_time'];
		$variant       = $input['variant'];
		$filename      = $input['filename_blob'];

		$variant = ($variant >= 1 && $variant <= 2) ? $variant : 1;

		if($length == "" || $start_time == "") {
			return Response::json(['success' => false, 'errorText' => 'Important fields are missing.']);
		}
		$set_url = "http://146.185.164.150/handle.php?youtube_url=".$youtube_url."&length=".$length."&start_time=".$start_time."&caption=".$caption."&color=".$color."&font_size=".$font_size."&font_family=".$font_family."&key=onlyforpimboo&variant=".$variant."&filename=".$filename;
		$data = file_get_contents($set_url);
		if(json_decode($data, true)) {
			$response = json_decode($data, true);
			if($response['success'] == true) {
				$gif = Session::getId()."/".uniqid().".gif";
				$thumbnail_fb_photo = Session::getId()."/".uniqid().".png";
				$thumbnail_main_photo = Session::getId()."/".uniqid().".png";
				if(!file_exists("temp/".Session::getId())) {
	            	mkdir("temp/".Session::getId());
	            }
				file_put_contents("temp/".$gif, file_get_contents($response['gif']));
				file_put_contents("temp/".$thumbnail_fb_photo, file_get_contents($response['facebook_photo']));
				file_put_contents("temp/".$thumbnail_main_photo, file_get_contents($response['main_photo']));
				return Response::json(['success' => true, 'thumbnail_main' => $thumbnail_main_photo, 'thumbnail_fb' => $thumbnail_fb_photo, 'gif' => $gif]);
			} else {
				return Response::json(['success' => false, 'errorText' => $response['errorText']]);
			}
		} else {
			return Response::json(['success' => false, 'errorText' => 'Unknown error. Please reload the page and try again.']);
		}
	}

	public static function translit($s) {
	    $s = (string) $s;
	    $s = strip_tags($s);
	    $s = str_replace(array("\n", "\r"), " ", $s);
	    $s = trim($s);
	    $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s);
	    $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
    	$s = preg_replace("/[^0-9a-z-_ ]/i", "", $s);
    	$s = preg_replace("/\s+/", ' ', $s);
    	$s = str_replace(" ", "-", $s);

    	return $s;
    }
	
	public function sendGIF() {
		if(\Auth::guest()) return view('auth/login');
	
        $input = \Input::all();
		
		if(isset($input['isDraft'])) {
			if($input['isDraft'] == 'save') {
				
				$validator = \Validator::make(
		            array(
		                'Title' => $input['form_flip']['form_flip_cards_title'],
		                'Description' => $input['form_flip']['form_description']
		            ),
		            array(
		                'Title' => 'required',
		                'Description' => 'required'
		            )
		        );
		
				if ($validator->fails()) return \Response::json(['success' => false, 'errors' => $validator->errors()]);
				
				$tags = [];
				if(isset($input['tags'])) {
					if(count($input['tags']) > 0) {
						foreach ($input['tags'] as $key => $value) {
							$tags[] = $value;
						}
					}
				}
				$tags = serialize($tags);
				
				$content[] = [
					'gif' => $input['form_flip']['gif']
				];
				
				if($input['form_flip']['form_photo_facebook'] == "") $photo_fb = "";
				else $photo_fb = '/temp/'.$input['form_flip']['form_photo_facebook'];
					
				if($input['form_flip']['form_photo'] == "") $photo = "";
				else $photo = '/temp/'.$input['form_flip']['form_photo'];
				
				$options = [];
				$options = serialize($options);
				
				if(isset($input['postID'])) {
					$postID = (int)$input['postID'];
					if(is_int($postID) && $postID > 0) {
						$current_owner = \DB::select('select user_id from posts where id = ?', [$postID]);
						if(count($current_owner != 0)) {
							if($current_owner[0]->user_id == \Auth::user()->id) {
								\DB::table('posts')
									->where('id', $postID)
									->update(['description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
											'description_footer' => '', 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
											'type' => 'gif', 'isDraft' => 'save', 'tags' => $tags, 'permission' => 'public', 'options' => $options
										]);
								return \Response::json(['success' => true, 'id' => $postID]);
							}
						}
					}
				}

				$string = $input['form_flip']['form_flip_cards_title'];
				$string = VideoGifController::translit($string);
				if(strlen($string) < 10) $string = 'post-gif-'.strtolower(str_random(30));
				
				$str2 = $string;
				$str2 = $str2.'-'.date('Y-d-m');
				$count = DB::table('posts')->where('author_name', '=', Auth::user()->name)->where('url', '=', $str2)->count();
				if($count == 0) {
					$id = \DB::table('posts')->insertGetId(
						['user_id' => \Auth::user()->id, 'author_name' => Auth::user()->name, 'url' => $str2, 'description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
						'description_footer' => '', 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
						'type' => 'gif', 'isDraft' => 'save', 'tags' => $tags, 'permission' => 'public', 'options' => $options]
					);
				}else {
					$string = 'post-gif-'.strtolower(str_random(30));
					$str2 = $string;
					$str2 = $str2.'-'.date('Y-d-m');
					$id = \DB::table('posts')->insertGetId(
						['user_id' => \Auth::user()->id, 'author_name' => Auth::user()->name, 'url' => $str2, 'description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
						'description_footer' => '', 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
						'type' => 'gif', 'isDraft' => 'save', 'tags' => $tags, 'permission' => 'public', 'options' => $options]
					);
				}
				return \Response::json(['success' => true, 'id' => $id]);
				
			}
		}
		
		$validator = \Validator::make(
            array(
                'Title' => $input['form_flip']['form_flip_cards_title'],
                'Description' => $input['form_flip']['form_description']
            ),
            array(
                'Title' => 'required',
                'Description' => 'required'
            )
        );
		
		if (!$validator->fails()) {
			    $errors_array = array();
				
                if(!file_exists('temp/'.$input['form_flip']['form_photo'])) $errors_array[] = 'Wrong photo link';
				if(!file_exists('temp/'.$input['form_flip']['form_photo_facebook'])) $errors_array[] = 'Wrong Facebook photo link';
				
				if($input['form_flip']['gif'] == "") $errors_array[] = 'GIF NOT CREATED';
				if(!file_exists('temp/'.$input['form_flip']['gif'])) $errors_array[] = 'GIF NOT CREATED';
				if(count($errors_array) > 0) return \Response::json(['success' => false, 'errors' => $errors_array]);
				
				if(count($errors_array) == 0) {
					
					$content = array();
					$uniqid1 = uniqid();
                    $uniqid2 = uniqid();
					$uniqid3 = uniqid();
					
                    copy('temp/'.$input['form_flip']['form_photo'], 'uploads/'.$uniqid2.'.jpeg');
					copy('temp/'.$input['form_flip']['form_photo_facebook'], 'uploads/'.$uniqid3.'.jpeg');
                    unlink('temp/'.$input['form_flip']['form_photo']);
                    unlink('temp/'.$input['form_flip']['form_photo_facebook']);
					
					copy('temp/'.$input['form_flip']['gif'], 'uploads/'.$uniqid1.'.gif');
					unlink('temp/'.$input['form_flip']['gif']);
					
					$content[] = [
						'gif' => $uniqid1.".gif",
                    ];
					
					$tags = [];
					if(isset($input['tags'])) {
						if(count($input['tags']) > 0) {
							foreach ($input['tags'] as $key => $value) {
								$tags[] = $value;
							}
						}
					}
					$tags = serialize($tags);
					
					
					$options = [];
					$options = serialize($options);
					
					$photo = $uniqid2.'.jpeg';
					$photo_fb = $uniqid3.'.jpeg';
					
					if(isset($input['postID'])) {
						$postID = (int)$input['postID'];
						if(is_int($postID) && $postID > 0) {
							$current_owner = \DB::select('select user_id, url from posts where id = ?', [$postID]);
							if(count($current_owner != 0)) {
								if($current_owner[0]->user_id == \Auth::user()->id) {
									\DB::table('posts')
										->where('id', $postID)
										->update(['description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
												'description_footer' => '', 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
												'type' => 'gif', 'isDraft' => 'publish', 'tags' => $tags, 'permission' => 'public', 'options' => $options
											]);
									$link = '/'.Auth::user()->name.'/'.$current_owner[0]->url;
									return \Response::json(['success' => true, 'link' => $link]);
								}
							}
						}
					}

					$string = $input['form_flip']['form_flip_cards_title'];
					$string = VideoGifController::translit($string);
					if(strlen($string) < 10) $string = 'post-gif-'.strtolower(str_random(30));

					$str2 = $string;
					$str2 = $str2.'-'.date('Y-d-m');
					$count = DB::table('posts')->where('author_name', '=', Auth::user()->name)->where('url', '=', $str2)->count();
					if($count == 0) {
						$id = \DB::table('posts')->insertGetId(
							['user_id' => \Auth::user()->id, 'author_name' => Auth::user()->name, 'url' => $str2, 'description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
							'description_footer' => '', 'content' => serialize($content), 'description_image' => $uniqid2.".jpeg", 'image_facebook' => $uniqid3.".jpeg",
							'type' => 'gif', 'isDraft' => 'publish', 'tags' => $tags, 'permission' => 'public', 'options' => $options]
						);
					} else {
						$string = 'post-gif-'.strtolower(str_random(30));
						$str2 = $string;
						$str2 = $str2.'-'.date('Y-d-m');
						$id = \DB::table('posts')->insertGetId(
							['user_id' => \Auth::user()->id, 'author_name' => Auth::user()->name, 'url' => $str2, 'description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
							'description_footer' => '', 'content' => serialize($content), 'description_image' => $uniqid2.".jpeg", 'image_facebook' => $uniqid3.".jpeg",
							'type' => 'gif', 'isDraft' => 'publish', 'tags' => $tags, 'permission' => 'public', 'options' => $options]
						);
					}
					$link = '/'.Auth::user()->name.'/'.$str2;
                    return \Response::json(['success' => true, 'link' => $link]);
				}
		} else return \Response::json(['success' => false, 'errors' => $validator->errors()]);
	}
	
}