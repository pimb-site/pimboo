<?php namespace App\Http\Controllers;

use Illuminate\View\View;
use Imagick;
use ImagickDraw;
use Input;

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
	

	public function uploadVideo() {
		$video = Input::file('file');
		
		if( ($video->getMimeType() == "video/mp4") && ($video->getClientSize() <= 10000000) ) {

			$filename = uniqid().".mp4";

			$video->move("uploads/", $filename);

			return \Response::json(['success' => true, 'file' => $filename]);
		}
	}

	public function youtubeGIF() {

		if(\Auth::guest()) return view('auth/login');

		$input = \Input::all();

		$video_youtube = $input['video_youtube'];
		$video_site    = $input['video_site'];
		$main_gif = $input['gif_main'];
		$caption  = $input['caption'];


		// Color
		$available_colors = [
			0 => '#fff',
			1 => '#000000',
			2 => '#ff6666',
			3 => '#fff35c',
			4 => '#9933ff',
			5 => '#00ff99',
			6 => '#e646b6',
			7 => '#00ccff'
		];
		$color = $input['color'];
		$color = (isset($available_colors[$color])) ? $available_colors[$color] : '#fff';

		// Font size
		$avaible_font_sizes = [
			'0' => 40,
			'1' => 60,
			'2' => 80
		];
		$font_size = $input['font_size'];
		$font_size = (isset($avaible_font_sizes[$font_size])) ? $avaible_font_sizes[$font_size] : 40;

		// Font path
		$avaible_font_path = [
			'0' => '/var/www/pimboobeta.com/public/fonts/nexablack.ttf',
			'1' => '/var/www/pimboobeta.com/public/fonts/impact.ttf',
			'2' => '/var/www/pimboobeta.com/public/fonts/arial.ttf'
		];
		$font_family = $input['font_family'];
		$font_path = (isset($avaible_font_path[$font_family])) ? $avaible_font_path[$font_family] : '/var/www/pimboobeta.com/public/fonts/nexablack.ttf';
		// ...

		if (!filter_var($video_youtube, FILTER_VALIDATE_URL) === false) {

			$content = @file_get_contents('https://www.youtube.com/oembed?url='.$video_youtube.'&format=json');
			$array_information = json_decode($content, true);
			if(is_array($array_information)) {
				// If directory does not exist
				if(!file_exists("temp/".\Session::getId())) {
	            	mkdir("temp/".\Session::getId());
	        	}


				// upload youtube video
				$uniq_name = uniqid();
				$command_line_download = 'youtube-dl -f 134 -o "/var/www/pimboobeta.com/public/uploads/'.$uniq_name.'.%(ext)s" '.$video_youtube;
				shell_exec($command_line_download);


				// Create gifs from video/ And their gluing
				foreach ($input['options'] as $key => $value) {
					$start_time = (int)abs($value['start_time']);
					$end_time   = (int)abs($value['end_time']);

					$start_time = date("H:i:s", mktime(0, 0, $start_time));

					$length = $end_time - $start_time;

					if($length <= 0) continue;

					$uniqid = uniqid();
					$command_line_create   = 'ffmpeg -t '.$length.' -ss '.$start_time.' -r 15 -y -i /var/www/pimboobeta.com/public/uploads/'.$uniq_name.'.mp4 -s 410x240 /var/www/pimboobeta.com/public/temp/'.\Session::getId().'/'.$uniqid.'.gif';
					shell_exec($command_line_create);


					$path_filename = '/var/www/pimboobeta.com/public/temp/'.\Session::getId().'/'.$uniqid.'.gif';

					if($caption != "") {
						$im = new Imagick($path_filename); // Берем исходный файл
						$draw = new ImagickDraw();
						$draw->setFont($font_path); // выбираем шрифт
						$draw->setFontSize($font_size);
						$draw->setFillColor($color);
						$draw->setGravity(Imagick::GRAVITY_CENTER);
						 
						foreach ($im as $frame) {
						    $frame->annotateImage( $draw, 0, 50, 0, $caption ); // Наносим текст
						}

						$filehandle = fopen('temp/'.\Session::getId().'/'.$uniqid.'.gif', 'w');
						$im->writeImagesFile($filehandle); // Сохраняем анимацию
						fclose($filehandle);
					}

					if(isset($cycle_gif) && $cycle_gif != "") {
						$new_gif = uniqid().".gif";
						$path_gif = $new_gif = \Session::getId()."/".$new_gif;
						$main_path = "/var/www/pimboobeta.com/public/temp/";
						$command_line = "convert -loop 0 ".$main_path.$cycle_gif." ".$main_path.\Session::getId()."/".$uniqid.".gif ".$main_path.$path_gif;
						shell_exec($command_line);
						$cycle_gif = $path_gif;
					}
					else {
						$cycle_gif = \Session::getId()."/".$uniqid . '.gif';
					}
				}

				$temp_file =  $cycle_gif;

				if($main_gif != "" && file_exists('temp/'.$main_gif)) {
					$main_path = "/var/www/pimboobeta.com/public/temp/";
					$path_gif = \Session::getId()."/".uniqid() . '.gif';
					$command_line = "convert -loop 0 ".$main_path.$main_gif." ".$main_path.\Session::getId()."/".$uniqid.".gif ".$main_path.$path_gif;
					shell_exec($command_line);

					$temp_file = $path_gif;
				}

				$main_path = "/var/www/pimboobeta.com/public/temp/";

				$thumbnail_name = uniqid().".png";
				$thumbnail = imagecreatefromgif("temp/".$temp_file);
				$thumbnail = imagegif($thumbnail, "temp/".\Session::getId()."/".$thumbnail_name);

				$image = new Imagick();
				$image->readImage($main_path.\Session::getId()."/".$thumbnail_name);

				// Open the watermark
				$watermark = new Imagick();
				$watermark->readImage("/var/www/pimboobeta.com/public/img/watermark.png");

				// Overlay the watermark on the original image
				$image->compositeImage($watermark, imagick::COMPOSITE_OVER, 300, 0);
				$image->writeImage($main_path.\Session::getId()."/".$thumbnail_name);

				return \Response::json(['success' => true, 'thumbnail' => \Session::getId()."/".$thumbnail_name, 'gif' => $temp_file]);
			}
		} else if ($video_site != "" && file_exists("uploads/".$video_site)) { 

			if(!file_exists("temp/".\Session::getId())) {
	           	mkdir("temp/".\Session::getId());
	        }

			foreach ($input['options'] as $key => $value) {
				$start_time = (int)abs($value['start_time']);
				$end_time   = (int)abs($value['end_time']);

				$start_time = date("H:i:s", mktime(0, 0, $start_time));

				$length = $end_time - $start_time;

				if($length <= 0) continue;

				$uniqid = uniqid();
				$command_line_create   = 'ffmpeg -t '.$length.' -ss '.$start_time.' -r 15 -y -i /var/www/pimboobeta.com/public/uploads/'.$video_site.' -s 410x240 /var/www/pimboobeta.com/public/temp/'.\Session::getId().'/'.$uniqid.'.gif';
				shell_exec($command_line_create);


				$path_filename = '/var/www/pimboobeta.com/public/temp/'.\Session::getId().'/'.$uniqid.'.gif';

				if($caption != "") {
					$im = new Imagick($path_filename); // Берем исходный файл
					$draw = new ImagickDraw();
					$draw->setFont($font_path); // выбираем шрифт
					$draw->setFontSize($font_size);
					$draw->setFillColor($color);
					$draw->setGravity(Imagick::GRAVITY_CENTER);
					 
					foreach ($im as $frame) {
					    $frame->annotateImage( $draw, 0, 50, 0, $caption ); // Наносим текст
					}

					$filehandle = fopen('temp/'.\Session::getId().'/'.$uniqid.'.gif', 'w');
					$im->writeImagesFile($filehandle); // Сохраняем анимацию
					fclose($filehandle);
				}

				if(isset($cycle_gif) && $cycle_gif != "") {
					$new_gif = uniqid().".gif";
					$path_gif = $new_gif = \Session::getId()."/".$new_gif;
					$main_path = "/var/www/pimboobeta.com/public/temp/";
					$command_line = "convert -loop 0 ".$main_path.$cycle_gif." ".$main_path.\Session::getId()."/".$uniqid.".gif ".$main_path.$path_gif;
					shell_exec($command_line);
					$cycle_gif = $path_gif;
				}
				else {
					$cycle_gif = \Session::getId()."/".$uniqid . '.gif';
				}
			}

			$temp_file =  $cycle_gif;

			if($main_gif != "" && file_exists('temp/'.$main_gif)) {
				$main_path = "/var/www/pimboobeta.com/public/temp/";
				$path_gif = \Session::getId()."/".uniqid() . '.gif';
				$command_line = "convert -loop 0 ".$main_path.$main_gif." ".$main_path.\Session::getId()."/".$uniqid.".gif ".$main_path.$path_gif;
				shell_exec($command_line);

				$temp_file = $path_gif;
			}

			$main_path = "/var/www/pimboobeta.com/public/temp/";

			$thumbnail_name = uniqid().".png";
			$thumbnail = imagecreatefromgif("temp/".$temp_file);
			$thumbnail = imagegif($thumbnail, "temp/".\Session::getId()."/".$thumbnail_name);

			$image = new Imagick();
			$image->readImage($main_path.\Session::getId()."/".$thumbnail_name);

			// Open the watermark
			$watermark = new Imagick();
			$watermark->readImage("/var/www/pimboobeta.com/public/img/watermark.png");

			// Overlay the watermark on the original image
			$image->compositeImage($watermark, imagick::COMPOSITE_OVER, 300, 0);
			$image->writeImage($main_path.\Session::getId()."/".$thumbnail_name);

			return \Response::json(['success' => true, 'thumbnail' => \Session::getId()."/".$thumbnail_name, 'gif' => $temp_file]);
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