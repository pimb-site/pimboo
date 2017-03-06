<?php namespace App\Http\Controllers;

use Illuminate\View\View;

class RankedlistController extends Controller
{
	
	public function voteRankedList() {
		if(\Auth::guest()) return view('auth/login');
	
        $input = \Input::all();
		
		if(isset($input['id']) && isset($input['id'])) {
			$id = (int)$input['id'];
			$cid = (int)$input['cid'];
			
			if(($id > 0) && ($cid > 0)) {
				$options = \DB::table('posts')
                     ->select('options')
                     ->where('type', '=', 'rankedlist')
					 ->where('id', '=', $cid)
					 ->get();
					 
				if($options != '') {
					$options = unserialize($options[0]->options);
					
					if(isset($options[$id - 1])) {
						$options[$id - 1]['count'] += 1;
						
						$options = serialize($options);
						
						\DB::table('posts')
							->where('id', $cid)
							->update(['options' => $options]);
							
						return \Response::json(['success' => true]);
					}
				}
			}
		}
	}
	
	public function addRankedList() {
        if(\Auth::guest()) return view('auth/login');
        else return view('add_ranked_list');
	}
	
	
	public function saveRankedList() {
		
		
		if(\Auth::guest()) return view('auth/login');
	
        $input = \Input::all();
		
		if(isset($input['isDraft'])) {
			if($input['isDraft'] == 'save') {
				
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
				
				$content = array();
				
				// MAIN PHOTO
				if($input['form_flip']['form_photo_facebook'] == "") $photo_fb = "";
				else $photo_fb = '/temp/'.$input['form_flip']['form_photo_facebook'];
					
				// FB PHOTO
				if($input['form_flip']['form_photo'] == "") $photo = "";
				else $photo = '/temp/'.$input['form_flip']['form_photo'];
				
				
				foreach ($input['flip_cards'] as $key => $value) {
					
					if(!isset($value['type_card1'])) $value['type_card1'] = 'image';
					
					$type_card_front = $value['type_card1'];
					
					// FRONT card
						
					if($type_card_front == 'video')
					{
						$youtube_clip1 = $value['youtube_clip1'];
						$image_front   = '';
					}
					else
					{
						$youtube_clip1 = '';
						$type_card_front = 'image';
						$image_front  = $value['img_src1'];
					}
						
					$content[] = [
						'type_card_front' => $type_card_front,
						'caption1' => $value['caption1'],
                        'front_card' => $image_front,
						'youtube_clip1' => $youtube_clip1,
						'post_title' => $value['post_title']
                    ];
				}
					
				$options = [];
				$options = serialize($options);
					
				if(isset($input['postID'])) {
					$postID = (int)$input['postID'];
					if(is_int($postID) && $postID > 0) {
						$current_owner = \DB::select('select user_id from posts where id = ? and type = ?', [$postID, 'rankedlist']);
							if(count($current_owner != 0)) {
							if($current_owner[0]->user_id == \Auth::user()->id) {
								\DB::table('posts')
									->where('id', $postID)
									->update(['description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
											'description_footer' => $input['form_flip']['form_footer'], 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
											'type' => 'rankedlist', 'isDraft' => 'save', 'tags' => $tags, 'permission' => 'public', 'options' => $options
										]);
								return \Response::json(['success' => true, 'id' => $postID]);
							}
						}
					}
				}
					
				$id = \DB::table('posts')->insertGetId(
					['user_id' => \Auth::user()->id, 'description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
					'description_footer' => $input['form_flip']['form_footer'], 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
					'type' => 'rankedlist', 'isDraft' => 'save', 'tags' => $tags, 'permission' => 'public', 'options' => $options]
				);
				return \Response::json(['success' => true, 'id' => $id]);
			} else if ($input['isDraft'] == 'preview') {
				
				$tags = [];
				if(isset($input['tags'])) {
					if(count($input['tags']) > 0) {
						foreach ($input['tags'] as $key => $value) {
							$tags[] = $value;
						}
					}
				}
				
				$content_main = [
					'author' => \Auth::user()->name,
					'title' => $input['form_flip']['form_flip_cards_title'],
					'description' => $input['form_flip']['form_description'],
					'footer' => $input['form_flip']['form_footer']
				];
				
				$content_other = [];
				
				foreach ($input['flip_cards'] as $key => $value) {
					
					if(!isset($value['type_card1'])) $value['type_card1'] = 'image';
					
					$type_card_front = $value['type_card1'];
					
					// FRONT card
						
					if($type_card_front == 'video')
					{
						$youtube_clip1 = $value['youtube_clip1'];
						$content_youtube = @file_get_contents('https://www.youtube.com/oembed?url='.$youtube_clip1.'&format=json');
						$array_information = json_decode($content_youtube, true);
						$youtube_clip1 = $array_information['html'];
						$image_front   = '';
					}
					else
					{
						$youtube_clip1 = '';
						$type_card_front = 'image';
						$image_front  = $value['img_src1'];
					}
						
					$content_other[] = [
						'type_card_front' => $type_card_front,
						'caption1' => $value['caption1'],
                        'front_card' => $image_front,
						'youtube_clip1' => $youtube_clip1,
						'post_title' => $value['post_title']
                    ];
				}
				
				return \Response::json(['content' => $content_main, 'cards' => $content_other, 'tags' => $tags]);
			}
		}
		
		
		
		$validator = \Validator::make(
            array(
                'Ranked list Title' => $input['form_flip']['form_flip_cards_title'],
                'Ranked list Description' => $input['form_flip']['form_description'],
                'Ranked list Footer' => $input['form_flip']['form_footer'],
                'Ranked list Photo' => $input['form_flip']['form_photo'],
				'Facebook Photo' => $input['form_flip']['form_photo_facebook']
            ),
            array(
                'Ranked list Title' => 'required',
                'Ranked list Description' => 'required',
                'Ranked list Footer' => 'required',
                'Ranked list Photo' => 'required',
				'Facebook Photo' => 'required'
			)
        );
		
		if (!$validator->fails()) {
			
			foreach ($input['flip_cards'] as $key => $value) {
                $validator_cards = \Validator::make(
                    array(
						'Type your text or caption' => $value['caption1'],
						'Post title' => $value['post_title']
                    ),
                    array(
						'Type your text or caption' => 'required',
						'Post title' => 'required'
                    )
                );

                if ($validator_cards->fails()) {
                    return \Response::json(['success' => false, 'errors' => $validator_cards->errors()]);
                }
            }
			
			if(!$validator_cards->fails()) {
				$errors_array = array();
                if(!file_exists('temp/'.$input['form_flip']['form_photo'])) $errors_array[] = 'Wrong photo link';
				if(!file_exists('temp/'.$input['form_flip']['form_photo_facebook'])) $errors_array[] = 'Wrong Facebook photo link';
				
				
				foreach ($input['flip_cards'] as $key => $value) {
					
					if(!isset($value['type_card1'])) $value['type_card1'] = 'image';
					
					$type_card_front = $value['type_card1'];
					
					// FRONT card
					
					if($type_card_front == 'video' )
					{
						$clip_front = $value['youtube_clip1'];
						
						if (!filter_var($clip_front, FILTER_VALIDATE_URL) === false) {
							
							$content = @file_get_contents('https://www.youtube.com/oembed?url='.$clip_front.'&format=json');
							$array_information = json_decode($content, true);
							if(!is_array($array_information)) {
								$errors_array[] = "Youtube clip does not exist";
							}
						} else {
							$errors_array[] = "Invalid youtube clip";
						}
					}
					else 
					{
						if($value['img_src1'] != "") {
							if(!file_exists('temp/'.$value['img_src1'])) $errors_array[] = 'Wrong front image link';
						} else {
							$errors_array[] = "Photo or Video must be filled";
						}
					}
					

                    if(count($errors_array) > 0) return \Response::json(['success' => false, 'errors' => $errors_array]);
                }
				
				if(count($errors_array) == 0) {
					
					// Array for saving cards
                    $content = array();
					
					
					// Uniq ID for photo, photo fb;
                    $uniqid3 = uniqid();
					$uniqid4 = uniqid();
					
					// Saving photo, photo fb
                    copy('temp/'.$input['form_flip']['form_photo'], 'uploads/'.$uniqid3.'.jpeg');
					copy('temp/'.$input['form_flip']['form_photo_facebook'], 'uploads/'.$uniqid4.'.jpeg');
					
					
					// Delete tmp-files: photo, photo fb
		
                    unlink('temp/'.$input['form_flip']['form_photo']);
					unlink('temp/'.$input['form_flip']['form_photo_facebook']);
					
					//  Saving content 
					
					$count_content = 0;
					
                    foreach ($input['flip_cards'] as $key => $value) {
						
						$count_content++;
						
						if(!isset($value['type_card1'])) $value['type_card1'] = 'image';
						
						$type_card_front = $value['type_card1'];
						
						// FRONT card
						
						if($type_card_front == 'video')
						{
							$youtube_clip1 = $value['youtube_clip1'];
							$content_youtube = @file_get_contents('https://www.youtube.com/oembed?url='.$youtube_clip1.'&format=json');
							$array_information = json_decode($content_youtube, true);
							$youtube_clip1 = $array_information['html'];
							$image_front   = '';
						}
						else
						{
							$youtube_clip1 = '';
							$type_card_front = 'image';
							
							// Delete tmp and saving
							$uniqid1 = uniqid();
							$image_front  = $uniqid1.".jpeg";
							
							copy('temp/'.$value['img_src1'], 'uploads/'.$uniqid1.'.jpeg');
							unlink('temp/'.$value['img_src1']);
						}
						
                        $content[] = [
							'type_card_front' => $type_card_front,
							'caption1' => $value['caption1'],
                            'front_card' => $image_front,
							'youtube_clip1' => $youtube_clip1,
							'post_title' => $value['post_title']
                        ];
                    }
					
					
					$photo = $uniqid3.'.jpeg';
					$photo_fb = $uniqid4.'.jpeg';
					
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
					
					
					
					$options = [];
					
					for($i = 0; $i < $count_content; $i++) {
						$options[] = ['count' => 0];
					}
					
					$options = serialize($options);
					
					if(isset($input['postID'])) {
						$postID = (int)$input['postID'];
						if(is_int($postID) && $postID > 0) {
							$current_owner = \DB::select('select user_id from posts where id = ? and type = ?', [$postID, 'rankedlist']);
							if(count($current_owner != 0)) {
								if($current_owner[0]->user_id == \Auth::user()->id) {
									\DB::table('posts')
										->where('id', $postID)
										->update(['description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
												'description_footer' => $input['form_flip']['form_footer'], 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
												'type' => 'rankedlist', 'isDraft' => 'publish', 'tags' => $tags, 'permission' => 'public', 'options' => $options
											]);
									return \Response::json(['success' => true, 'id' => $postID]);
								}
							}
						}
					}
					
				    $id = \DB::table('posts')->insertGetId(
						['user_id' => \Auth::user()->id, 'description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
						'description_footer' => $input['form_flip']['form_footer'], 'content' => serialize($content), 'description_image' => $uniqid3.".jpeg", 'image_facebook' => $uniqid4.".jpeg",
						'type' => 'rankedlist', 'isDraft' => 'publish', 'tags' => $tags, 'permission' => 'public', 'options' => $options]
					 );
                    return \Response::json(['success' => true, 'id' => $id]);
                }
				
			}
		} else return \Response::json(['success' => false, 'errors' => $validator->errors()]);
		
		
	}
	
}