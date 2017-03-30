<?php namespace App\Http\Controllers;

use Illuminate\View\View;

class TriviaController extends Controller
{

	public function validURL() {
		
		$url = \Input::get('video_url');
		
		if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
			$content = @file_get_contents('https://www.youtube.com/oembed?url='.$url.'&format=json');
			$array_information = json_decode($content, true);
			if(is_array($array_information)) {
				return \Response::json(['success' => true, 'thumbnail_url' => $array_information['thumbnail_url'], 'html' => $array_information['html']]);
			}
		}
	
	}

    public function addTriviaQuiz()
    {
        if(\Auth::guest()) return view('auth/login');
        else return view('trivia_new');
    }

    public function viewTriviaQuiz()
    {
		$contentflip = \DB::select('select * from posts where type = "trivia"');
        return view('viewID', ['contentflip' => $contentflip, 'name' => 'trivia']);
    }

    public function saveTriviaQuiz()
    {
		
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
					if(!isset($value['type_card2'])) $value['type_card2'] = 'image';
					
					$type_card_front = $value['type_card1'];
					$type_card_back  = $value['type_card2'];
					
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
						
						
					// BACK card
					if($type_card_back == 'video')
					{
						$youtube_clip2 = $value['youtube_clip2'];
						$image_back   = '';
					}
					else
					{
						$youtube_clip2 = '';
						$type_card_back = 'image';
						$image_back = $value['img_src2'];
					}
					
					
					// Checkbox click 'true'
					$type1 = $type2 = 'false';
					if(isset($value['answer_check1'])) $type1 = 'true';
					if(isset($value['answer_check2'])) $type2 = 'true';
					
					
					$uniqid_img1 = $uniqid_img2 = '';
					
					if(!isset($value['answers_type'])) $value['answers_type'] == 'text';
					
					if($value['answers_type'] == 'multi') {
						if($value['answer_img1'] != '' && file_exists('temp/'.$value['answer_img1'])) {
							$uniqid_img1 = $value['answer_img1'];
						} else $uniqid_img1 = '';
						
						if($value['answer_img2'] != '' && file_exists('temp/'.$value['answer_img2'])) {
							$uniqid_img2 = $value['answer_img2'];
						} else $uniqid_img2 = '';
					} else $value['answers_type'] == 'text';
					
					
					if(isset($value['result_photo_img'])) {
						if($value['result_photo_img'] != '' && file_exists('temp/'.$value['result_photo_img'])) {
							$uniqid_result_photo = $value['result_photo_img'];
						} else $uniqid_result_photo = '';
					} else $uniqid_result_photo = '';
					
					if(isset($value['result_photo_title'])) {
							
						if($value['result_photo_title'] != '') $result_photo_title = $value['result_photo_title'];
						else $result_photo_title = '';
					} else $result_photo_title = '';
						
					$content[] = [
						'type_card_front' => $type_card_front,
						'type_card_back' => $type_card_back,
						'caption1' => $value['caption1'],
						'caption2' => $value['caption2'],
						'answer1' => $value['answer1'],
						'answer2' => $value['answer2'],
                        'front_card' => $image_front,
						'back_card'  =>  $image_back,
						'answer_check1' => $type1,
						'answer_check2' => $type2,
						'answer_img1' => $uniqid_img1,
						'answer_img2' => $uniqid_img2,
						'youtube_clip1' => $youtube_clip1,
						'youtube_clip2' => $youtube_clip2,
						'answers_type'  => $value['answers_type'],
						'result_photo_img' => $uniqid_result_photo,
						'result_photo_title' => $result_photo_title
                    ];
					
					$options = [];
					if(isset($input['question_order'])) {
						if($input['question_order'] == 'random') $question_order = 'random';
						else $question_order = 'norandom';
					} else $question_order = 'random';
					
					if(isset($input['answer_order'])) {
						if($input['answer_order'] == 'random') $answer_order = 'random';
						else $answer_order = 'norandom';
					} else $answer_order = 'random';
					
					$options = ['question_order' => $question_order, 'answer_order' => $answer_order];
					$options = serialize($options);
					
					if(isset($input['postID'])) {
						$postID = (int)$input['postID'];
						if(is_int($postID) && $postID > 0) {
							$current_owner = \DB::select('select user_id from posts where id = ? and type = ?', [$postID, 'trivia']);
							if(count($current_owner != 0)) {
								if($current_owner[0]->user_id == \Auth::user()->id) {
									\DB::table('posts')
										->where('id', $postID)
										->update(['description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
												'description_footer' => $input['form_flip']['form_footer'], 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
												'type' => 'trivia', 'isDraft' => 'save', 'tags' => $tags, 'permission' => 'public', 'options' => $options
											]);
									return \Response::json(['success' => true, 'id' => $postID]);
								}
							}
						}
					}
					
					$id = \DB::table('posts')->insertGetId(
						['user_id' => \Auth::user()->id, 'description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
						'description_footer' => $input['form_flip']['form_footer'], 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
						'type' => 'trivia', 'isDraft' => 'save', 'tags' => $tags, 'permission' => 'public', 'options' => $options]
					);
					return \Response::json(['success' => true, 'id' => $id]);
				}
				
			} else if($input['isDraft'] == 'preview') {
				
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
					if(!isset($value['type_card2'])) $value['type_card2'] = 'image';
					
					$type_card_front = $value['type_card1'];
					$type_card_back  = $value['type_card2'];
					
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
						
						
					// BACK card
					if($type_card_back == 'video')
					{
						$youtube_clip2 = $value['youtube_clip2'];
						$content_youtube = @file_get_contents('https://www.youtube.com/oembed?url='.$youtube_clip2.'&format=json');
						$array_information = json_decode($content_youtube, true);
						$youtube_clip2 = $array_information['html'];
						$image_back   = '';
					}
					else
					{
						$youtube_clip2 = '';
						$type_card_back = 'image';
						$image_back = $value['img_src2'];
					}
					
					
					// Checkbox click 'true'
					$type1 = $type2 = 'false';
					if(isset($value['answer_check1'])) $type1 = 'true';
					if(isset($value['answer_check2'])) $type2 = 'true';
					
					
					$uniqid_img1 = $uniqid_img2 = '';
					
					if(!isset($value['answers_type'])) $value['answers_type'] == 'text';
					
					if($value['answers_type'] == 'multi') {
						if($value['answer_img1'] != '' && file_exists('temp/'.$value['answer_img1'])) {
							$uniqid_img1 = $value['answer_img1'];
						} else $uniqid_img1 = '';
						
						if($value['answer_img2'] != '' && file_exists('temp/'.$value['answer_img2'])) {
							$uniqid_img2 = $value['answer_img2'];
						} else $uniqid_img2 = '';
					} else $value['answers_type'] == 'text';
					
					
					if(isset($value['result_photo_img'])) {
						if($value['result_photo_img'] != '' && file_exists('temp/'.$value['result_photo_img'])) {
							$uniqid_result_photo = $value['result_photo_img'];
						} else $uniqid_result_photo = '';
					} else $uniqid_result_photo = '';
					
					if(isset($value['result_photo_title'])) {
						
						if($value['result_photo_title'] != '') $result_photo_title = $value['result_photo_title'];
						else $result_photo_title = '';
						
					} else $result_photo_title = '';
					
					$content_other[] = [
						'type_card_front' => $type_card_front,
						'type_card_back' => $type_card_back,
						'caption1' => $value['caption1'],
						'caption2' => $value['caption2'],
						'answer1' => $value['answer1'],
						'answer2' => $value['answer2'],
                        'front_card' => $image_front,
						'back_card'  =>  $image_back,
						'answer_check1' => $type1,
						'answer_check2' => $type2,
						'answer_img1' => $uniqid_img1,
						'answer_img2' => $uniqid_img2,
						'youtube_clip1' => $youtube_clip1,
						'youtube_clip2' => $youtube_clip2,
						'answers_type'  => $value['answers_type'],
						'result_photo_img' => $uniqid_result_photo,
						'result_photo_title' => $result_photo_title
                    ];
				}
				
				return \Response::json(['content' => $content_main, 'cards' => $content_other, 'tags' => $tags]);
			}
		}
		
        $validator = \Validator::make(
            array(
                'Trivia Title' => $input['form_flip']['form_flip_cards_title'],
                'Trivia Description' => $input['form_flip']['form_description'],
                'Trivia Footer' => $input['form_flip']['form_footer'],
                'Trivia Photo' => $input['form_flip']['form_photo'],
				'Trivia Facebook Photo' => $input['form_flip']['form_photo_facebook']
            ),
            array(
                'Trivia Title' => 'required',
                'Trivia Description' => 'required',
                'Trivia Footer' => 'required',
                'Trivia Photo' => 'required',
				'Trivia Facebook Photo' => 'required'
            )
        );
		

        if (!$validator->fails())
        {
            foreach ($input['flip_cards'] as $key => $value) {
                $validator_cards = \Validator::make(
                    array(
						'Answer text #1' => $value['answer1'],
						'Answer text #2' => $value['answer2'],
						'Type your caption [Question ]' => $value['caption1'],
						'Type your caption [Result ]' => $value['caption2']
                    ),
                    array(
						'Answer text #1'   => 'required',
						'Answer text #2'   => 'required',
						'Type your caption [Question ]' => 'required',
						'Type your caption [Result ]' => 'required'
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
					if(!isset($value['type_card2'])) $value['type_card2'] = 'image';
					
					$type_card_front = $value['type_card1'];
					$type_card_back  = $value['type_card2'];
					
					// FRONT card
					
					if($type_card_front == 'video' )
					{
						$clip_front = $value['youtube_clip1'];
						
						if (!filter_var($clip_front, FILTER_VALIDATE_URL) === false) {
							
							$content = @file_get_contents('https://www.youtube.com/oembed?url='.$clip_front.'&format=json');
							$array_information = json_decode($content, true);
							if(!is_array($array_information)) {
								$errors_array[] = "Youtube clip #1 does not exist";
							}
						} else {
							$errors_array[] = "Invalid youtube clip #1";
						}
					}
					else 
					{
						if($value['img_src1'] != "") {
							if(!file_exists('temp/'.$value['img_src1'])) $errors_array[] = 'Wrong front image link';
						} else {
							$errors_array[] = "Photo or Video [question] must be filled";
						}
					}
					
					// BACK card
					
					if($type_card_back == 'video' )
					{
						$clip_back = $value['youtube_clip2'];
						
						if (!filter_var($clip_back, FILTER_VALIDATE_URL) === false) {
							
							$content = @file_get_contents('https://www.youtube.com/oembed?url='.$clip_back.'&format=json');
							$array_information = json_decode($content, true);
							if(!is_array($array_information)) {
								$errors_array[] = "Youtube clip #2 does not exist";
							}
						} else {
							$errors_array[] = "Invalid youtube clip #2";
						}
					}
					else 
					{
						if($value['img_src2'] != "") {
							if(!file_exists('temp/'.$value['img_src2'])) $errors_array[] = 'Wrong front image link';
						} else {
							$errors_array[] = "Photo or Video [result] must be filled";
						}
					}

					// END
					
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
					
                    foreach ($input['flip_cards'] as $key => $value) {
						
						if(!isset($value['type_card1'])) $value['type_card1'] = 'image';
						if(!isset($value['type_card2'])) $value['type_card2'] = 'image';
						
						$type_card_front = $value['type_card1'];
						$type_card_back  = $value['type_card2'];
						
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
						
						
						// BACK card
						if($type_card_back == 'video')
						{
							$youtube_clip2 = $value['youtube_clip2'];
							$content_youtube = @file_get_contents('https://www.youtube.com/oembed?url='.$youtube_clip2.'&format=json');
							$array_information = json_decode($content_youtube, true);
							$youtube_clip2 = $array_information['html'];
							$image_back    = '';
						}
						else
						{
							$youtube_clip2 = '';
							$type_card_back = 'image';
							
							// Delete tmp and saving
							$uniqid2 = uniqid();
							$image_back = $uniqid2.".jpeg";
							
							copy('temp/'.$value['img_src2'], 'uploads/'.$uniqid2.'.jpeg');
							unlink('temp/'.$value['img_src2']);
						}
						
						
						// Checkbox click 'true'
						$type1 = $type2 = 'false';
						if(isset($value['answer_check1'])) $type1 = 'true';
						if(isset($value['answer_check2'])) $type2 = 'true';
						
						
						$uniqid_img1 = $uniqid_img2 = '';
						
						if(!isset($value['answers_type'])) $value['answers_type'] == 'text';
						
						if($value['answers_type'] == 'multi') {
							if($value['answer_img1'] != '' && file_exists('temp/'.$value['answer_img1'])) {
								$uniqid_img1 = uniqid();
								copy('temp/'.$value['answer_img1'], 'uploads/'.$uniqid_img1.'.jpeg');
								unlink('temp/'.$value['answer_img1']);
								$uniqid_img1 = $uniqid_img1.".jpeg";
							} else $uniqid_img1 = '';
							
							if($value['answer_img2'] != '' && file_exists('temp/'.$value['answer_img2'])) {
								$uniqid_img2 = uniqid();
								copy('temp/'.$value['answer_img2'], 'uploads/'.$uniqid_img2.'.jpeg');
								unlink('temp/'.$value['answer_img2']);
								$uniqid_img2 = $uniqid_img2.".jpeg";
							} else $uniqid_img2 = '';
						} else $value['answers_type'] == 'text';
						
						if(isset($value['result_photo_img'])) {
							if($value['result_photo_img'] != '' && file_exists('temp/'.$value['result_photo_img'])) {
								$uniqid_result_photo = uniqid();
								copy('temp/'.$value['result_photo_img'], 'uploads/'.$uniqid_result_photo.'.jpeg');
								$uniqid_result_photo = $uniqid_result_photo.".jpeg";
							} else $uniqid_result_photo = '';
						} else $uniqid_result_photo = '';
						
						if(isset($value['result_photo_title'])) {
							
							if($value['result_photo_title'] != '') $result_photo_title = $value['result_photo_title'];
							else $result_photo_title = '';
						} else $result_photo_title = '';
						
                        $content[] = [
							'type_card_front' => $type_card_front,
							'type_card_back' => $type_card_back,
							'caption1' => $value['caption1'],
							'caption2' => $value['caption2'],
							'answer1' => $value['answer1'],
							'answer2' => $value['answer2'],
                            'front_card' => $image_front,
							'back_card'  =>  $image_back,
							'answer_check1' => $type1,
							'answer_check2' => $type2,
							'answer_img1' => $uniqid_img1,
							'answer_img2' => $uniqid_img2,
							'youtube_clip1' => $youtube_clip1,
							'youtube_clip2' => $youtube_clip2,
							'answers_type'  => $value['answers_type'],
							'result_photo_img' => $uniqid_result_photo,
							'result_photo_title' => $result_photo_title
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
					if(isset($input['question_order'])) {
						if($input['question_order'] == 'random') $question_order = 'random';
						else $question_order = 'norandom';
					} else $question_order = 'random';
					
					if(isset($input['answer_order'])) {
						if($input['answer_order'] == 'random') $answer_order = 'random';
						else $answer_order = 'norandom';
					} else $answer_order = 'random';
					
					$options = ['question_order' => $question_order, 'answer_order' => $answer_order];
					$options = serialize($options);
					
					if(isset($input['postID'])) {
						$postID = (int)$input['postID'];
						if(is_int($postID) && $postID > 0) {
							$current_owner = \DB::select('select user_id from posts where id = ? and type = ?', [$postID, 'trivia']);
							if(count($current_owner != 0)) {
								if($current_owner[0]->user_id == \Auth::user()->id) {
									\DB::table('posts')
										->where('id', $postID)
										->update(['description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
												'description_footer' => $input['form_flip']['form_footer'], 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
												'type' => 'trivia', 'isDraft' => 'publish', 'tags' => $tags, 'permission' => 'public', 'options' => $options
											]);
									return \Response::json(['success' => true, 'id' => $postID]);
								}
							}
						}
					}
					
				    $id = \DB::table('posts')->insertGetId(
						['user_id' => \Auth::user()->id, 'description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
						'description_footer' => $input['form_flip']['form_footer'], 'content' => serialize($content), 'description_image' => $uniqid3.".jpeg", 'image_facebook' => $uniqid4.".jpeg",
						'type' => 'trivia', 'isDraft' => 'publish', 'tags' => $tags, 'permission' => 'public', 'options' => $options]
					 );
                    return \Response::json(['success' => true, 'id' => $id]);
                }
            }
        } else return \Response::json(['success' => false, 'errors' => $validator->errors()]);
		
    }
}