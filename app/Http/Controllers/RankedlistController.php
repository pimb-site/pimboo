<?php namespace App\Http\Controllers;

use Validator;
use Response;
use Input;
use Auth;
use File;
use Post;
use DB;

class RankedlistController extends Controller {

	public function displayCreatePage() {
        if(Auth::guest()) {
        	return redirect('/auth/login');
        } else {
        	return view('ToolsCreate.rankedlist');
        }
	}
	
	public function sendRankedList() {
		if(Auth::guest()) return Response::json(['success' => false, 'errorText' => 'You are not authorized!']);
		if(Input::get('isDraft') !== null) {
			switch (Input::get('isDraft')) {
				case 'save':
					return $this->save();
					break;
				
				case 'preview':
					return $this->preview();
					break;

				case 'publish':
					return $this->publish();
					break;

				default:
					return Response::json(['success' => false, 'errorText' => 'Invalid data! Try reload page.']);
					break;
			}
		} else {
		    return Response::json(['success' => false, 'errorText' => 'Invalid data! Try reload page.']);
		}
	}

	private function save() {
		$data = Input::only('rankedlist');
		if(count($data) != 0) {

    	}
    }

	private function preview() {
		$data = Input::only('rankedlist');
		if(count($data) != 0) {
			
    	}
	}
	// не забыть проверить на ../
	private function publish() {
		$data = Input::only('rankedlist');
		if(count($data) != 0) {
			// Validation the Main Data
			$validator = Validator::make($data['rankedlist']['data'], [
	            'photo_main'            => 'required',
	            'photo_facebook'        => 'required',
	            'rankedlist_title'      => 'required|min:3|max:400',
	            'rankedlist_footer'     => 'required|min:3|max:500',
	            'rankelist_description' => 'required|min:3',
	        ]);
			if ($validator->fails()) 
				return Response::json(['success' => false, 'errorText' => $validator->errors()->all()]);

			// Validation the Cards
			foreach ($data['rankedlist']['cards'] as $key => $value) {
				$validator = Validator::make($value ,[
					'post_title'   => 'required|min:3',
					'caption_card' => 'required|min:3',
					'type_card'    => 'required',
				]);
				if ($validator->fails()) 
					return Response::json(['success' => false, 'errorText' => $validator->errors()->all()]);
	        }

	        // Checking if images are loaded ( main and facebook photo )
	        $errors_array = [];
	        if(!File::exists(public_path()."/temp/".$data['rankedlist']['data']['photo_main']))
	        	$errors_array[] = "The main photo not found. Please, upload a new image!";

	        if(!File::exists(public_path()."/temp/".$data['rankedlist']['data']['photo_main']))
	        	$errors_array[] = "The facebook photo not found. Please, upload a new image!";

	        if(count($errors_array) != 0)
	        	return Response::json(['success' => false, 'errorText' => $errors_array]);

	        // max cards = 15; array truncation
	        $data['rankedlist']['cards'] = array_slice($data['rankedlist']['cards'], 0, 15);

	        // Checking if images are loaded or exist youtube video ( card post )
	        $available_types = ['image', 'youtube'];
	        foreach ($data['rankedlist']['cards'] as $key => $value) {
	        	if(in_array($value['type_card'], $available_types))
	        		return Response::json(['success' => false, 'errorText' => ['Unknown card type. Please, try reload page!']]);

	        	if($value['type_card'] == 'image') {
	        		if($value['image_card'] != '') 
	        			if(!File::exists(public_path()."/temp/".$value['image_card']))
	        				$errors_array[] = "The card image not found. Please, upload a new image!";
	        		else
	        			$errors_array[] = "The photo or video must be filled!";
	        	} else {
	        		if (!filter_var($value['youtube_clip'], FILTER_VALIDATE_URL) === false) {
	        			$youtube_content = file_get_contents('https://www.youtube.com/oembed?url='.$value['youtube_clip'].'&format=json');
	        			$youtube_content = json_decode($youtube_content, true);
	        			if(!is_array($youtube_content))
	        				$errors_array[] = "The Youtube video does not exist. Try use another video!";
	        		} else {
	        			$errors_array[] = "The link to YouTube video is invalid. Try use another video!";
	        		}
	        	}
	        	if(count($errors_array) != 0)
	        		return Response::json(['success' => false, 'errorText' => $errors_array]);
	        }

	        // Moving main photo/ facebook photo
	        $main_photo     = uniqid().".jpeg";
	        $facebook_photo = uniqid().".jpeg";
	        if(!File::move(public_path()."/temp/".$data['rankedlist']['data']['photo_main'], public_path()."/uploads/".$main_photo))
	        	$errors_array[] = "An error occurred while moving the main photo. Please, upload a new image!";
			if(!File::move(public_path()."/temp/".$data['rankedlist']['data']['photo_facebook'], public_path()."/uploads/".$facebook_photo))
				$errors_array[] = "An error occurred while moving the facebook photo. Please, upload a new image!";
	        if(count($errors_array) != 0)
	        	return Response::json(['success' => false, 'errorText' => $errors_array]);

	        // Content cards creation for rankedlist 
	        $content_rankedlist = [];
	        foreach ($data['rankedlist']['cards'] as $key => $value) {
	        	if($value['type_card'] == 'video') {
					$youtube_content = $value['youtube_clip'];
					$youtube_content = file_get_contents('https://www.youtube.com/oembed?url='.$youtube_content.'&format=json');
					$youtube_content = json_decode($youtube_content, true);
					$youtube_content = $youtube_content['html'];
					$content_rankedlist[] = [
						'post_title'   => $value['post_title'];
						'type_card'    => $value['type_card'];
						'caption_card' => $value['caption_card'];
						'youtube_clip' => $value['youtube_clip'];
					];
	        	} else {
	        		$image_card = uniqid().".jpeg";
					if(!File::move(public_path()."/temp/".$value['image_card'], public_path()."/uploads/".$image_card))
						$errors_array[] = "An error occurred while moving the image card. Please, try reload page!";
			        if(count($errors_array) != 0)
			        	return Response::json(['success' => false, 'errorText' => $errors_array]);

					$content_rankedlist[] = [
						'post_title'   => $value['post_title'];
						'type_card'    => $value['type_card'];
						'image_card'   => $value['image_card'];
						'caption_card' => $value['caption_card']; 
					];
	        	}
	        }

			// tags recording | max count tags : 22
			$tags = [];
			if(isset($data['tags']) && count($data['tags']) > 0) {
				$data['tags'] = array_slice($data['tags'], 0, 22)
				foreach ($data['tags'] as $key => $value) {
					$tags[] = $value;
				}
			}
			$tags = serialize($tags);

			// options recording
			$options = [];
			$options = serialize($options);

			// If there is a postID, then to update post
			$validator = Validator::make($data, [
				'postID' => 'required|integer|min:1',
			]);

			if (!$validator->fails()) {
				$owner = Post::select('user_id', 'url')->where(['id' => $data['postID'], 'type' => 'rankedlist'])->get();
				if(count($owner) != 0 && $owner[0]->user_id == Auth::user()->id) {
					Post::where(['postID' => $data['postID'], 'type' => 'rankedlist'])
						->update('description_title'  => $data['rankedlist']['data']['rankedlist_title'],  'description_text'  => $data['rankedlist']['data']['rankedlist_description']
								 'description_footer' => $data['rankedlist']['data']['rankedlist_footer'], 'description_image' => $main_photo,
								 'image_facebook'     => $facebook_photo, 'content' => serialize($content_rankedlist), 'type'  => 'rankedlist',
								 'permission'         => 'public', 'options' => $options, 'tags' => $tags, 'isDraft' => 'publish');
				} else
					
			} 


	// 				if(isset($input['postID'])) {
	// 					if(is_int($postID) && $postID > 0) {
	// 						$current_owner = \DB::select('select user_id, url from posts where id = ? and type = ?', [$postID, 'rankedlist']);
	// 						if(count($current_owner != 0)) {
	// 							if($current_owner[0]->user_id == \Auth::user()->id) {
	// 								\DB::table('posts')
	// 									->where('id', $postID)
	// 									->update(['description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
	// 											'description_footer' => $input['form_flip']['form_footer'], 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
	// 											'type' => 'rankedlist', 'isDraft' => 'publish', 'tags' => $tags, 'permission' => 'public', 'options' => $options
	// 										]);
	// 								$link = '/'.Auth::user()->name.'/'.$current_owner[0]->url;
	// 								return \Response::json(['success' => true, 'link' => $link]);
	// 							}
	// 						}
	// 					}
	// 				}
    	}
	}

	// public function voteRankedList() {
	// 	if(Auth::guest()) {
	// 		return Response::json(['success' => false, 'error' => 'You are not authorized']);
	// 	}
	
 //        $input = Input::all();
		
	// 	if(isset($input['id']) && isset($input['id'])) {
	// 		$id = (int)$input['id'];
	// 		$cid = (int)$input['cid'];
			
	// 		$session_vote = Session::get('rankedlist_votes');
	// 		if(isset($session_vote[$cid][$id])) return Response::json(['success' => false, 'error' => 'You already voted']);
			
	// 		if(($id > 0) && ($cid > 0)) {
	// 			$content = DB::table('posts')
 //                     ->select('content')
 //                     ->where('type', '=', 'rankedlist')
	// 				 ->where('id', '=', $cid)
	// 				 ->get();
					 
				
	// 			$content = unserialize($content[0]->content);
				
	// 			if(isset($content[$id - 1])) {
					
	// 				$session_vote[$cid][$id] = 'true';
	// 				Session::put('rankedlist_votes', $session_vote);
					
	// 				$current_vote = ++$content[$id - 1]['votes'];

	// 				$content = serialize($content);
					
	// 				DB::table('posts')
	// 					->where('id', $cid)
	// 					->where('type', 'rankedlist')
	// 					->update(['content' => $content]);
						
	// 				return Response::json(['success' => true, 'votes' => $current_vote]);
	// 			}
	// 		}
	// 	}
	// }
	
	// public static function translit($s) {
	//     $s = (string) $s;
	//     $s = strip_tags($s);
	//     $s = str_replace(array("\n", "\r"), " ", $s);
	//     $s = trim($s);
	//     $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s);
	//     $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
 //    	$s = preg_replace("/[^0-9a-z-_ ]/i", "", $s);
 //    	$s = preg_replace("/\s+/", ' ', $s);
 //    	$s = str_replace(" ", "-", $s);

 //    	return $s;
 //    }

	// public function sendRankedList() {
		
		
	// 	if(\Auth::guest()) return view('auth/login');
	
 //        $input = \Input::all();
		
	// 	if(isset($input['isDraft'])) {
	// 		if($input['isDraft'] == 'save') {
				

	// 			$validator = \Validator::make(
	// 	            array(
	// 	                'Ranked list Title' => $input['form_flip']['form_flip_cards_title'],
	// 	                'Ranked list Description' => $input['form_flip']['form_description'],
	// 	                'Ranked list Footer' => $input['form_flip']['form_footer']
	// 	            ),
	// 	            array(
	// 	                'Ranked list Title' => 'required|min:3|max:400',
	// 	                'Ranked list Description' => 'required|min:3',
	// 	                'Ranked list Footer' => 'required|min:3|max:500'
	// 				)
	// 	        );
				
	// 			if ($validator->fails()) return \Response::json(['success' => false, 'errors' => $validator->errors()]);

	// 			// TAGS
	// 			$tags = [];
	// 			if(isset($input['tags'])) {
	// 				if(count($input['tags']) > 0) {
	// 					foreach ($input['tags'] as $key => $value) {
	// 						$tags[] = $value;
	// 					}
	// 				}
	// 			}
	// 			$tags = serialize($tags);
				
	// 			$content = array();
				
	// 			// MAIN PHOTO
	// 			if($input['form_flip']['form_photo_facebook'] == "") $photo_fb = "";
	// 			else $photo_fb = '/temp/'.$input['form_flip']['form_photo_facebook'];
					
	// 			// FB PHOTO
	// 			if($input['form_flip']['form_photo'] == "") $photo = "";
	// 			else $photo = '/temp/'.$input['form_flip']['form_photo'];
				
				
	// 			foreach ($input['flip_cards'] as $key => $value) {
					
	// 				if(!isset($value['type_card1'])) $value['type_card1'] = 'image';
					
	// 				$type_card_front = $value['type_card1'];
					
	// 				// FRONT card
						
	// 				if($type_card_front == 'video')
	// 				{
	// 					$youtube_clip1 = $value['youtube_clip1'];
	// 					$image_front   = '';
	// 				}
	// 				else
	// 				{
	// 					$youtube_clip1 = '';
	// 					$type_card_front = 'image';
	// 					$image_front  = $value['img_src1'];
	// 				}
						
	// 				$content[] = [
	// 					'type_card_front' => $type_card_front,
	// 					'caption1' => $value['caption1'],
 //                        'front_card' => $image_front,
	// 					'youtube_clip1' => $youtube_clip1,
	// 					'post_title' => $value['post_title']
 //                    ];
	// 			}
					
	// 			$options = [];
	// 			$options = serialize($options);
					
	// 			if(isset($input['postID'])) {
	// 				$postID = (int)$input['postID'];
	// 				if(is_int($postID) && $postID > 0) {
	// 					$current_owner = \DB::select('select user_id from posts where id = ? and type = ?', [$postID, 'rankedlist']);
	// 						if(count($current_owner != 0)) {
	// 						if($current_owner[0]->user_id == \Auth::user()->id) {
	// 							\DB::table('posts')
	// 								->where('id', $postID)
	// 								->update(['description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
	// 										'description_footer' => $input['form_flip']['form_footer'], 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
	// 										'type' => 'rankedlist', 'isDraft' => 'save', 'tags' => $tags, 'permission' => 'public', 'options' => $options
	// 									]);
	// 							return \Response::json(['success' => true, 'id' => $postID]);
	// 						}
	// 					}
	// 				}
	// 			}

	// 			$string = $input['form_flip']['form_flip_cards_title'];
	// 			$string = RankedlistController::translit($string);
	// 			if(strlen($string) < 3) {
	// 				$string = 'rankedlist';
	// 			} else if(strlen($string) > 180) {
	// 				$string = substr($string, 0, 190);
	// 			}

	// 			$str = $string;

	// 			$first = false;
	// 			$count = -1;

	// 			while(true) {
	// 				$result = DB::table('posts')->where('author_name', '=', Auth::user()->name)->where('url', '=', $string)->count();
	// 				if($result == 0) {
	// 					$id = \DB::table('posts')->insertGetId(
	// 						['user_id' => \Auth::user()->id, 'author_name' => Auth::user()->name, 'url' => $string, 'description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
	// 						'description_footer' => $input['form_flip']['form_footer'], 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
	// 						'type' => 'rankedlist', 'isDraft' => 'save', 'tags' => $tags, 'permission' => 'public', 'options' => $options]
	// 					);
	// 					return \Response::json(['success' => true, 'id' => $id]);
	// 				} else {
	// 					$string = $str.$count;
	// 					$count--;
	// 				}
	// 			}
	// 		} else if ($input['isDraft'] == 'preview') {
				
	// 			$tags = [];
	// 			if(isset($input['tags'])) {
	// 				if(count($input['tags']) > 0) {
	// 					foreach ($input['tags'] as $key => $value) {
	// 						$tags[] = $value;
	// 					}
	// 				}
	// 			}
				
	// 			$content_main = [
	// 				'author' => \Auth::user()->name,
	// 				'title' => $input['form_flip']['form_flip_cards_title'],
	// 				'description' => $input['form_flip']['form_description'],
	// 				'footer' => $input['form_flip']['form_footer']
	// 			];
				
	// 			$content_other = [];
				
	// 			foreach ($input['flip_cards'] as $key => $value) {
					
	// 				if(!isset($value['type_card1'])) $value['type_card1'] = 'image';
					
	// 				$type_card_front = $value['type_card1'];
					
	// 				// FRONT card
						
	// 				if($type_card_front == 'video')
	// 				{
	// 					$youtube_clip1 = $value['youtube_clip1'];
	// 					$content_youtube = @file_get_contents('https://www.youtube.com/oembed?url='.$youtube_clip1.'&format=json');
	// 					$array_information = json_decode($content_youtube, true);
	// 					$youtube_clip1 = $array_information['html'];
	// 					$image_front   = '';
	// 				}
	// 				else
	// 				{
	// 					$youtube_clip1 = '';
	// 					$type_card_front = 'image';
	// 					$image_front  = $value['img_src1'];
	// 				}
						
	// 				$content_other[] = [
	// 					'type_card_front' => $type_card_front,
	// 					'caption1' => $value['caption1'],
 //                        'front_card' => $image_front,
	// 					'youtube_clip1' => $youtube_clip1,
	// 					'post_title' => $value['post_title']
 //                    ];
	// 			}
				
	// 			return \Response::json(['content' => $content_main, 'cards' => $content_other, 'tags' => $tags]);
	// 		}
	// 	}
		
		
		
	// 	$validator = \Validator::make(
 //            array(
 //                'Ranked list Title' => $input['form_flip']['form_flip_cards_title'],
 //                'Ranked list Description' => $input['form_flip']['form_description'],
 //                'Ranked list Footer' => $input['form_flip']['form_footer'],
 //                'Ranked list Photo' => $input['form_flip']['form_photo'],
	// 			'Facebook Photo' => $input['form_flip']['form_photo_facebook']
 //            ),
 //            array(
 //                'Ranked list Title' => 'required|min:3|max:400',
 //                'Ranked list Description' => 'required|min:3',
 //                'Ranked list Footer' => 'required|min:3|max:500',
 //                'Ranked list Photo' => 'required',
	// 			'Facebook Photo' => 'required'
	// 		)
 //        );
		
	// 	if (!$validator->fails()) {
			
	// 		foreach ($input['flip_cards'] as $key => $value) {
 //                $validator_cards = \Validator::make(
 //                    array(
	// 					'Type your text or caption' => $value['caption1'],
	// 					'Post title' => $value['post_title']
 //                    ),
 //                    array(
	// 					'Type your text or caption' => 'required',
	// 					'Post title' => 'required'
 //                    )
 //                );

 //                if ($validator_cards->fails()) {
 //                    return \Response::json(['success' => false, 'errors' => $validator_cards->errors()]);
 //                }
 //            }
			
	// 		if(!$validator_cards->fails()) {
	// 			$errors_array = array();
 //                if(!file_exists('temp/'.$input['form_flip']['form_photo'])) $errors_array[] = 'Wrong photo link';
	// 			if(!file_exists('temp/'.$input['form_flip']['form_photo_facebook'])) $errors_array[] = 'Wrong Facebook photo link';
				
				
	// 			foreach ($input['flip_cards'] as $key => $value) {
					
	// 				if(!isset($value['type_card1'])) $value['type_card1'] = 'image';
					
	// 				$type_card_front = $value['type_card1'];
					
	// 				// FRONT card
					
	// 				if($type_card_front == 'video' )
	// 				{
	// 					$clip_front = $value['youtube_clip1'];
						
	// 					if (!filter_var($clip_front, FILTER_VALIDATE_URL) === false) {
							
	// 						$content = @file_get_contents('https://www.youtube.com/oembed?url='.$clip_front.'&format=json');
	// 						$array_information = json_decode($content, true);
	// 						if(!is_array($array_information)) {
	// 							$errors_array[] = "Youtube clip does not exist";
	// 						}
	// 					} else {
	// 						$errors_array[] = "Invalid youtube clip";
	// 					}
	// 				}
	// 				else 
	// 				{
	// 					if($value['img_src1'] != "") {
	// 						if(!file_exists('temp/'.$value['img_src1'])) $errors_array[] = 'Wrong front image link';
	// 					} else {
	// 						$errors_array[] = "Photo or Video must be filled";
	// 					}
	// 				}
					
 //                    if(count($errors_array) > 0) return \Response::json(['success' => false, 'errors' => $errors_array]);
 //                }
				
	// 			if(count($errors_array) == 0) {
					
	// 				// Array for saving cards
 //                    $content = array();
					
					
	// 				// Uniq ID for photo, photo fb;
 //                    $uniqid3 = uniqid();
	// 				$uniqid4 = uniqid();
					
	// 				// Saving photo, photo fb
 //                    copy('temp/'.$input['form_flip']['form_photo'], 'uploads/'.$uniqid3.'.jpeg');
	// 				copy('temp/'.$input['form_flip']['form_photo_facebook'], 'uploads/'.$uniqid4.'.jpeg');
					
					
	// 				// Delete tmp-files: photo, photo fb
		
 //                    unlink('temp/'.$input['form_flip']['form_photo']);
	// 				unlink('temp/'.$input['form_flip']['form_photo_facebook']);
					
	// 				//  Saving content 
					
	// 				$count_content = 0;
					
 //                    foreach ($input['flip_cards'] as $key => $value) {
						
	// 					$count_content++;
						
	// 					if(!isset($value['type_card1'])) $value['type_card1'] = 'image';
						
	// 					$type_card_front = $value['type_card1'];
						
	// 					// FRONT card
						
	// 					if($type_card_front == 'video')
	// 					{
	// 						$youtube_clip1 = $value['youtube_clip1'];
	// 						$content_youtube = @file_get_contents('https://www.youtube.com/oembed?url='.$youtube_clip1.'&format=json');
	// 						$array_information = json_decode($content_youtube, true);
	// 						$youtube_clip1 = $array_information['html'];
	// 						$image_front   = '';
	// 					}
	// 					else
	// 					{
	// 						$youtube_clip1 = '';
	// 						$type_card_front = 'image';
							
	// 						// Delete tmp and saving
	// 						$uniqid1 = uniqid();
	// 						$image_front  = $uniqid1.".jpeg";
							
	// 						copy('temp/'.$value['img_src1'], 'uploads/'.$uniqid1.'.jpeg');
	// 						unlink('temp/'.$value['img_src1']);
	// 					}
						
 //                        $content[] = [
	// 						'type_card_front' => $type_card_front,
	// 						'caption1' => $value['caption1'],
 //                            'front_card' => $image_front,
	// 						'youtube_clip1' => $youtube_clip1,
	// 						'post_title' => $value['post_title'],
	// 						'votes' => 0
 //                        ];
 //                    }
					
					
	// 				$photo = $uniqid3.'.jpeg';
	// 				$photo_fb = $uniqid4.'.jpeg';
					
	// 				// TAGS
	// 				$tags = [];
	// 				if(isset($input['tags'])) {
	// 					if(count($input['tags']) > 0) {
	// 						foreach ($input['tags'] as $key => $value) {
	// 							$tags[] = $value;
	// 						}
	// 					}
	// 				}
	// 				$tags = serialize($tags);
					
					
					
	// 				$options = [];
	// 				$options = serialize($options);


					
	// 				if(isset($input['postID'])) {
	// 					$postID = (int)$input['postID'];
	// 					if(is_int($postID) && $postID > 0) {
	// 						$current_owner = \DB::select('select user_id, url from posts where id = ? and type = ?', [$postID, 'rankedlist']);
	// 						if(count($current_owner != 0)) {
	// 							if($current_owner[0]->user_id == \Auth::user()->id) {
	// 								\DB::table('posts')
	// 									->where('id', $postID)
	// 									->update(['description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
	// 											'description_footer' => $input['form_flip']['form_footer'], 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
	// 											'type' => 'rankedlist', 'isDraft' => 'publish', 'tags' => $tags, 'permission' => 'public', 'options' => $options
	// 										]);
	// 								$link = '/'.Auth::user()->name.'/'.$current_owner[0]->url;
	// 								return \Response::json(['success' => true, 'link' => $link]);
	// 							}
	// 						}
	// 					}
	// 				}

	// 				$string = $input['form_flip']['form_flip_cards_title'];
	// 				$string = RankedlistController::translit($string);
	// 				if(strlen($string) < 3) {
	// 					$string = 'rankedlist';
	// 				} else if(strlen($string) > 180) {
	// 					$string = substr($string, 0, 190);
	// 				}

	// 				$str = $string;

	// 				$first = false;
	// 				$count = -1;

	// 				while(true) {
	// 					$result = DB::table('posts')->where('author_name', '=', Auth::user()->name)->where('url', '=', $string)->count();
	// 					if($result == 0) {
	// 					    $id = DB::table('posts')->insertGetId(
	// 							['user_id' => \Auth::user()->id, 'author_name' => Auth::user()->name, 'url' => $string, 'description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
	// 							'description_footer' => $input['form_flip']['form_footer'], 'content' => serialize($content), 'description_image' => $uniqid3.".jpeg", 'image_facebook' => $uniqid4.".jpeg",
	// 							'type' => 'rankedlist', 'isDraft' => 'publish', 'tags' => $tags, 'permission' => 'public', 'options' => $options]
	// 						 );
	// 						$link = '/'.Auth::user()->name.'/'.$string;
	// 						return \Response::json(['success' => true, 'link' => $link]);
	// 					} else {
	// 						$string = $str.$count;
	// 						$count--;
	// 					}
	// 				}
 //                }
				
	// 		}
	// 	} else return \Response::json(['success' => false, 'errors' => $validator->errors()]);
		
		
	// }
	
}