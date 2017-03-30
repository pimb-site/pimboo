<?php namespace App\Http\Controllers;

use Illuminate\View\View;

class VideoGifController extends Controller
{
	
	public function getPage() {
		if(\Auth::guest()) return view('auth/login');
        else return view('video_to_gif_test');
	}
	
	public function addGIF() {
		if(\Auth::guest()) return view('auth/login');
        else return view('video_to_gif');
	}
	

	public function youtubeGIF() {
	if(\Auth::guest()) return view('auth/login');

	$input = \Input::all();

	$url = $input['video_url'];
	$main_gif = $input['gif_main'];
	$start_time = $input['start_time'];

	if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
		$content = @file_get_contents('https://www.youtube.com/oembed?url='.$url.'&format=json');
		$array_information = json_decode($content, true);
		if(is_array($array_information)) {
			
			if($start_time < 0) $start_time = 0;
			
			if(!file_exists("temp/".\Session::getId())) {
            			mkdir("temp/".\Session::getId());
        		}
			
			$uniq_name = uniqid();
			$command_line_download = 'youtube-dl -f 134 -o "/var/www/pimboobeta.com/public/uploads/'.$uniq_name.'.%(ext)s" '.$url;
			shell_exec($command_line_download);
			$uniqid = uniqid();
			$command_line_create   = 'ffmpeg -t 2 -ss 00:00:'.$start_time.' -i /var/www/pimboobeta.com/public/uploads/'.$uniq_name.'.mp4 /var/www/pimboobeta.com/public/temp/'.\Session::getId().'/'.$uniqid.'.gif';
			shell_exec($command_line_create);

			$temp_file =  \Session::getId()."/".$uniqid . '.gif';

			if($main_gif != "" && file_exists('temp/'.$main_gif)) {
				$main_path = "/var/www/pimboobeta.com/public/temp/";
				$path_gif = \Session::getId()."/".uniqid() . '.gif';
				$command_line = "convert -loop 0 ".$main_path.$main_gif." ".$main_path.\Session::getId()."/".$uniqid.".gif ".$main_path.$path_gif;
				shell_exec($command_line);

				$temp_file = $path_gif;
			}

			return \Response::json(['success' => true, 'file' => $temp_file]);
		}
	}
	}

	public function uploadGIF() {
		if(\Auth::guest()) return view('auth/login');
		$base64 = \Input::get('gif');
		
		$data = str_replace('data:image/gif;base64,', '', $base64);
		$data = str_replace(' ', '+', $data);

		$data = base64_decode($data); // base64 decoded image data
		$source_img = imagecreatefromstring($data);
		if(!file_exists("temp/".\Session::getId())) {
            mkdir("temp/".\Session::getId());
        }
        $temp_file = \Session::getId()."/".uniqid() . '.gif';
        $gif_path = "temp/".$temp_file;
		$success = file_put_contents($gif_path, $data);
		
		$main_gif = \Input::get('gif_main');
		if($main_gif != "" && file_exists('temp/'.$main_gif)) {
			$main_path = "/var/www/pimboobeta.com/public/temp/";
			$path_gif = \Session::getId()."/".uniqid() . '.gif';
			$command_line = "convert -loop 0 ".$main_path.$main_gif." ".$main_path.$temp_file." ".$main_path.$path_gif;

			shell_exec($command_line);

			
			$temp_file = $path_gif;
		}
		
		if($success) {
            return \Response::json(['success' => true, 'file' => $temp_file]);
        }
	}
	
	public function uploadEndGIF() {
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
				
				$id = \DB::table('posts')->insertGetId(
					['user_id' => \Auth::user()->id, 'description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
					'description_footer' => '', 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
					'type' => 'gif', 'isDraft' => 'save', 'tags' => $tags, 'permission' => 'public', 'options' => $options]
				);
				return \Response::json(['success' => true, 'id' => $id]);
				
			}
		}
		
		$validator = \Validator::make(
            array(
                'Title' => $input['form_flip']['form_flip_cards_title'],
                'Description' => $input['form_flip']['form_description'],
                'Photo' => $input['form_flip']['form_photo'],
				'Facebook Photo' => $input['form_flip']['form_photo_facebook']
            ),
            array(
                'Title' => 'required',
                'Description' => 'required',
                'Photo' => 'required',
				'Facebook Photo' => 'required'
            )
        );
		
		if (!$validator->fails()) {
			    $errors_array = array();
				
                if(!file_exists('temp/'.$input['form_flip']['form_photo'])) $errors_array[] = 'Wrong photo link';
				if(!file_exists('temp/'.$input['form_flip']['form_photo_facebook'])) $errors_array[] = 'Wrong Facebook photo link';
				
				if($input['form_flip']['gif'] == "") $errors_array[] = 'Wrong front image link';
				if(!file_exists('temp/'.$input['form_flip']['gif'])) $errors_array[] = 'Wrong front image link';
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
							$current_owner = \DB::select('select user_id from posts where id = ?', [$postID]);
							if(count($current_owner != 0)) {
								if($current_owner[0]->user_id == \Auth::user()->id) {
									\DB::table('posts')
										->where('id', $postID)
										->update(['description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
												'description_footer' => '', 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
												'type' => 'gif', 'isDraft' => 'publish', 'tags' => $tags, 'permission' => 'public', 'options' => $options
											]);
									return \Response::json(['success' => true, 'id' => $postID]);
								}
							}
						}
					}
					
					$id = \DB::table('posts')->insertGetId(
						['user_id' => \Auth::user()->id, 'description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
						'description_footer' => '', 'content' => serialize($content), 'description_image' => $uniqid2.".jpeg", 'image_facebook' => $uniqid3.".jpeg",
						'type' => 'gif', 'isDraft' => 'publish', 'tags' => $tags, 'permission' => 'public', 'options' => $options]
					);
                    return \Response::json(['success' => true, 'id' => $id]);
				}
		} else return \Response::json(['success' => false, 'errors' => $validator->errors()]);
	}
	
}