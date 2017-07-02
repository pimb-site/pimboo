<?php namespace App\Http\Controllers;

use Input;
use Validator;
use Response;
use Auth;
use DB;

class AdminEditingController extends Controller
{
	public function updateRankedlist() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			$input = Input::all();
			$postID   = $input['post_id'];
			$postType = "rankedlist";

			$validator = Validator::make(
	            array(
	                'Ranked list Title' => $input['form_flip']['form_flip_cards_title'],
	                'Ranked list Description' => $input['form_flip']['form_description'],
	                'Ranked list Footer' => $input['form_flip']['form_footer'],
	                'Ranked list Photo' => $input['form_flip']['form_photo'],
					'Facebook Photo' => $input['form_flip']['form_photo_facebook']
	            ),
	            array(
	                'Ranked list Title' => 'required|min:3',
	                'Ranked list Description' => 'required',
	                'Ranked list Footer' => 'required',
	                'Ranked list Photo' => 'required',
					'Facebook Photo' => 'required'
				)
	        );

	        if ($validator->fails()) return Response::json(['success' => false, 'errors' => $validator->errors()]);

	        foreach ($input['flip_cards'] as $key => $value) {
                $validator_cards = Validator::make(
                    array(
						'Type your text or caption' => $value['caption1'],
						'Post title' => $value['post_title']
                    ),
                    array(
						'Type your text or caption' => 'required',
						'Post title' => 'required'
                    )
                );
                if ($validator_cards->fails()) return Response::json(['success' => false, 'errors' => $validator_cards->errors()]);
	        }

			foreach ($input['flip_cards'] as $key => $value) {
				$errors_array = array();

				if(!isset($value['type_card1'])) $value['type_card1'] = 'image';
				$type_card_front = $value['type_card1'];

				if($type_card_front == 'video' ) {
					$clip_front = $value['youtube_clip1'];
					
					if (strpos($clip_front, '/embed/') !== false) {
						preg_match_all('#<iframe width="480" height="270" src="https://www.youtube.com/embed/(.+)feature=oembed" frameborder="0" allowfullscreen></iframe>#is', $clip_front, $arr_clip);
						$value_clip = $arr_clip[1];
						$value_clip = str_replace("?", "", $value_clip[0]);
						$clip_front = 'https://www.youtube.com/watch?v='.$value_clip;
						$value['youtube_clip1'] = $clip_front;
					}

					if (!filter_var($clip_front, FILTER_VALIDATE_URL) === false) {

						$content = @file_get_contents('https://www.youtube.com/oembed?url='.$clip_front.'&format=json');
						$array_information = json_decode($content, true);
						if(!is_array($array_information)) {
							$errors_array[] = "Youtube clip does not exist";
						}
					} else {
						if($value['img_src1'] != "") {
							// code...
						} else {
							$errors_array[] = "Photo or Video must be filled";
						}
					}
				}
				
                if(count($errors_array) > 0) return Response::json(['success' => false, 'errors' => $errors_array]);
			}

			if(count($errors_array) == 0) {

				$uniqid_photo = uniqid().'.jpeg';
				$uniqid_facebook = uniqid().'.jpeg';

				if(file_exists('temp/'.$input['form_flip']['form_photo'])) {
					copy('temp/'.$input['form_flip']['form_photo'], 'uploads/'.$uniqid_photo);
					unlink('temp/'.$input['form_flip']['form_photo']);
				} else $uniqid_photo = $input['form_flip']['form_photo'];

				if(file_exists('temp/'.$input['form_flip']['form_photo_facebook'])) {
					copy('temp/'.$input['form_flip']['form_photo_facebook'], 'uploads/'.$uniqid_facebook);
					unlink('temp/'.$input['form_flip']['form_photo_facebook']);
				} else $uniqid_facebook = $input['form_flip']['form_photo_facebook'];

				$count_content = 0;

				$content = [];

				foreach ($input['flip_cards'] as $key => $value) {
					$count_content++;
					if(!isset($value['type_card1'])) $value['type_card1'] = 'image';
					$type_card_front = $value['type_card1'];

					if($type_card_front == 'video')
					{
						$youtube_clip1 = $value['youtube_clip1'];
						if (strpos($youtube_clip1, '/embed/') !== false) {
							preg_match_all('#<iframe width="480" height="270" src="https://www.youtube.com/embed/(.+)feature=oembed" frameborder="0" allowfullscreen></iframe>#is', $youtube_clip1, $arr_clip);
							$value_clip = $arr_clip[1];
							$value_clip = str_replace("?", "", $value_clip[0]);
							$youtube_clip1 = 'https://www.youtube.com/watch?v='.$value_clip;
							
						}

						$content_youtube = @file_get_contents('https://www.youtube.com/oembed?url='.$youtube_clip1.'&format=json');
						$array_information = json_decode($content_youtube, true);
						$youtube_clip1 = $array_information['html'];
						$image_front   = '';
					}
					else {
						$youtube_clip1 = '';
						$type_card_front = 'image';
						
						// Delete tmp and saving
						$image_front = uniqid().".jpeg";
						
						if(file_exists('temp/'.$value['img_src1'])) {
							copy('temp/'.$value['img_src1'], 'uploads/'.$image_front);
							unlink('temp/'.$value['img_src1']);
						} else $image_front = $value['img_src1'];
					}
					
					if(isset($value['votes'])) {
						$votes = $value['votes'];
					} else $votes = 0;

                    $content[] = [
						'type_card_front' => $type_card_front,
						'caption1' => $value['caption1'],
                        'front_card' => $image_front,
						'youtube_clip1' => $youtube_clip1,
						'post_title' => $value['post_title'],
						'votes' => $votes
                    ];
				}

				$content = serialize($content);

				$tags = [];
				if(isset($input['tags'])) {
					if(count($input['tags']) > 0) {
						foreach ($input['tags'] as $key => $value) {
							$tags[] = $value;
						}
					}
				}
				$tags = serialize($tags);

				DB::table('posts')->where(['id' => $postID, 'type' => $postType])->update(['content' => $content, 'tags' => $tags, 'description_image' => $uniqid_photo, 'image_facebook' => $uniqid_facebook, 'description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'], 'description_footer' => $input['form_flip']['form_footer']]);
				$info = DB::table('posts')->select('author_name', 'url')->where(['id' => $postID, 'type' => $postType])->get();
				$link = '/'.$info[0]->author_name.'/'.$info[0]->url;
				return Response::json(['success' => true, 'link' => $link]);
			}
		}
	}

	public function updateFlipcards() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			$input = Input::all();
			$postID   = $input['post_id'];
			$postType = "flipcards";

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
			if(isset($input['display_item_numbers'])) {
				if($input['display_item_numbers'] == 'yes') $display_item_numbers = 'yes';
				else $display_item_numbers = 'no';
			} else $display_item_numbers = 'no';
			$options = ['display_item_numbers' => $display_item_numbers];
			$options = serialize($options);

	        $validator = Validator::make(
	            array(
	                'Flip Cards Title' => $input['form_flip']['form_flip_cards_title'],
	                'Flip Cards Description' => $input['form_flip']['form_description'],
	                'Flip Cards Footer' => $input['form_flip']['form_footer'],
	                'Flip Cards Photo' => $input['form_flip']['form_photo'],
					'Flip Cards Facebook Photo' => $input['form_flip']['form_photo_facebook']
	            ),
	            array(
	                'Flip Cards Title' => 'required|min:3',
	                'Flip Cards Description' => 'required',
	                'Flip Cards Footer' => 'required',
	                'Flip Cards Photo' => 'required',
					'Flip Cards Facebook Photo' => 'required'
	            )
	        );
			if ($validator->fails()) return Response::json(['success' => false, 'errors' => $validator->errors()]);

			foreach ($input['flip_cards'] as $key => $value) {
				$errors_array = array();

                $validator_cards = Validator::make(
                    array(
                        'Item Title' => $value['form_item_title'],
                    ),
                    array(
                        'Item Title' => 'required'
                    )
                );

				if($value['img_src1'] == "") {
					if(isset($value['text_front'])) {
						if($value['text_front'] == "") $errors_array[] = 'The field "Write something awesome" must be filled';
					} else $errors_array[] = 'The field "front card or text" must be filled';	
				}

				if($value['img_src2'] == "") {
					if(isset($value['text_back'])) {
						if($value['text_back'] == "") $errors_array[] = 'The field "Write something awesome" must be filled';
					} else $errors_array[] = 'The field "back card or text" must be filled';	
				} 

                if ($validator_cards->fails()) return Response::json(['success' => false, 'errors' => $validator_cards->errors()]);
				if(count($errors_array) > 0) return Response::json(['success' => false, 'errors' => $errors_array]);
			}

			if(!$validator_cards->fails() && (count($errors_array) == 0)) {
                $errors_array = array();
				
				$uniqid_photo = uniqid().'.jpeg';
				$uniqid_facebook = uniqid().'.jpeg';

				if(file_exists('temp/'.$input['form_flip']['form_photo'])) {
					copy('temp/'.$input['form_flip']['form_photo'], 'uploads/'.$uniqid_photo);
					unlink('temp/'.$input['form_flip']['form_photo']);
				} else $uniqid_photo = $input['form_flip']['form_photo'];

				if(file_exists('temp/'.$input['form_flip']['form_photo_facebook'])) {
					copy('temp/'.$input['form_flip']['form_photo_facebook'], 'uploads/'.$uniqid_facebook);
					unlink('temp/'.$input['form_flip']['form_photo_facebook']);
				} else $uniqid_facebook = $input['form_flip']['form_photo_facebook'];
				
				
				$content = [];

                foreach ($input['flip_cards'] as $key => $value) {
					$image_front = uniqid().'.jpeg';
					$image_back  = uniqid().'.jpeg';

					if($value['img_src1'] != "") {
						if(file_exists('temp/'.$value['img_src1'])) {
							copy('temp/'.$value['img_src1'], 'uploads/'.$image_front);
							unlink('temp/'.$value['img_src1']);
						} else $image_front = $value['img_src1'];
					}

					if($value['img_src2'] != "") {
						if(file_exists('temp/'.$value['img_src2'])) {
							copy('temp/'.$value['img_src2'], 'uploads/'.$image_back);
							unlink('temp/'.$value['img_src2']);
						} else $image_back = $value['img_src2'];
					}

					$rules_colors = array('blue', 'green', 'turquoise', 'purple');
					if(isset($value['theme1'])) {
						if(in_array($value['theme1'], $rules_colors)) {
							$theme_front = $value['theme1'];
						} else $theme_front = 'blue';
					} else {
						$theme_front = 'blue';
					}
					
					if(isset($value['theme2'])) {
						if(in_array($value['theme2'], $rules_colors)) {
							$theme_back = $value['theme2'];
						} else $theme_back = 'blue';
					} else {
						$theme_back = 'blue';
					}

					$text_back = $text_front = '';
					if(isset($value['text_back'])) $text_back = $value['text_back'];
					if(isset($value['text_front'])) $text_front = $value['text_front'];

                    $content[] = [
                        'item_title' => $value['form_item_title'],
                        'front_card' => $image_front,
                        'back_card' => $image_back,
						'text_back' => $text_back,
						'text_front' => $text_front,
						'theme_front' => $theme_front,
						'theme_back'  => $theme_back
                    ];
                }

                $content = serialize($content);

				DB::table('posts')->where(['id' => $postID, 'type' => $postType])->update(['content' => $content, 'tags' => $tags, 'options' => $options, 'description_image' => $uniqid_photo, 'image_facebook' => $uniqid_facebook, 'description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description']]);
				$info = DB::table('posts')->select('author_name', 'url')->where(['id' => $postID, 'type' => $postType])->get();
				$link = '/'.$info[0]->author_name.'/'.$info[0]->url;
				return Response::json(['success' => true, 'link' => $link]);
			}
		}
	}

	public function updateStory() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			$input = Input::all();
			$postID   = $input['post_id'];
			$postType = "story";

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
			if(isset($input['display_item_numbers'])) {
				if($input['display_item_numbers'] == 'yes') $display_item_numbers = 'yes';
				else $display_item_numbers = 'no';
			} else $display_item_numbers = 'no';
			$options = ['display_item_numbers' => $display_item_numbers];
			$options = serialize($options);

	        $validator = Validator::make(
	            array(
	                'Story Title' => $input['form_story']['form_story_cards_title'],
	                'Story Description' => $input['form_story']['form_description'],
	                'Story Photo' => $input['form_story']['form_photo'],
					'Story Facebook Photo' => $input['form_story']['form_photo_facebook'],
					'Story Content' => $input['form_story']['content']
	            ),
	            array(
	                'Story Title' => 'required|min:3',
	                'Story Description' => 'required',
	                'Story Photo' => 'required',
					'Story Facebook Photo' => 'required',
					'Story Content' => 'required'
	            )
	        );

	        if ($validator->fails()) return Response::json(['success' => false, 'errors' => $validator->errors()]);

	        $content = $input['form_story']['content'];

			$uniqid_photo = uniqid().'.jpeg';
			$uniqid_facebook = uniqid().'.jpeg';

			if(file_exists('temp/'.$input['form_story']['form_photo'])) {
				copy('temp/'.$input['form_story']['form_photo'], 'uploads/'.$uniqid_photo);
				unlink('temp/'.$input['form_story']['form_photo']);
			} else $uniqid_photo = $input['form_story']['form_photo'];

			if(file_exists('temp/'.$input['form_story']['form_photo_facebook'])) {
				copy('temp/'.$input['form_story']['form_photo_facebook'], 'uploads/'.$uniqid_facebook);
				unlink('temp/'.$input['form_story']['form_photo_facebook']);
			} else $uniqid_facebook = $input['form_story']['form_photo_facebook'];

			DB::table('posts')->where(['id' => $postID, 'type' => $postType])->update(['content' => $content, 'tags' => $tags, 'options' => $options, 'description_image' => $uniqid_photo, 'image_facebook' => $uniqid_facebook, 'description_title' => $input['form_story']['form_story_cards_title'], 'description_text' => $input['form_story']['form_description']]);
			$info = DB::table('posts')->select('author_name', 'url')->where(['id' => $postID, 'type' => $postType])->get();
			$link = '/'.$info[0]->author_name.'/'.$info[0]->url;
			return Response::json(['success' => true, 'link' => $link]);
		}
	}

	public function updateSnip() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			$input = Input::all();

			$postID   = $input['post_id'];
			$postType = "snip";
			$url      = $input['url'];

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

			$content = ['iframe_url' => $url];
			$content = serialize($content);

			$tags = [];
			if(isset($input['tags'])) {
				if(count($input['tags']) > 0) {
					foreach ($input['tags'] as $key => $value) {
						$tags[] = $value;
					}
				}
			}		
			$tags = serialize($tags);

			DB::table('posts')->where(['id' => $postID, 'type' => $postType])->update(['content' => $content, 'tags' => $tags]);
			$info = DB::table('posts')->select('author_name', 'url')->where(['id' => $postID, 'type' => $postType])->get();
			$link = '/'.$info[0]->author_name.'/'.$info[0]->url;
			return Response::json(['success' => true, 'link' => $link]);
		}
	}

	public function updateGif() {
		if(Auth::guest()) return redirect('/');
		if(Auth::user()->permission == 1) return redirect('/');
		if(Auth::user()->permission == 10) {
			$input = Input::all();

			// ...
			$postID   = $input['post_id'];
			$postType = "gif";

			$validator = Validator::make(
	            array(
	                'Title' => $input['form_flip']['form_flip_cards_title'],
	                'Description' => $input['form_flip']['form_description']
	            ),
	            array(
	                'Title' => 'required|min:3',
	                'Description' => 'required'
	            )
	        );

	        if ($validator->fails()) return Response::json(['success' => false, 'errors' => $validator->errors()]);

			$tags = [];
			if(isset($input['tags'])) {
				if(count($input['tags']) > 0) {
					foreach ($input['tags'] as $key => $value) {
						$tags[] = $value;
					}
				}
			}
			$tags = serialize($tags);

			$uniqid_photo = uniqid().'.jpeg';
			$uniqid_facebook = uniqid().'.jpeg';

			if(file_exists('temp/'.$input['form_flip']['form_photo'])) {
				copy('temp/'.$input['form_flip']['form_photo'], 'uploads/'.$uniqid_photo);
				unlink('temp/'.$input['form_flip']['form_photo']);
			} else $uniqid_photo = $input['form_flip']['form_photo'];

			if(file_exists('temp/'.$input['form_flip']['form_photo_facebook'])) {
				copy('temp/'.$input['form_flip']['form_photo_facebook'], 'uploads/'.$uniqid_facebook);
				unlink('temp/'.$input['form_flip']['form_photo_facebook']);
			} else $uniqid_facebook = $input['form_flip']['form_photo_facebook'];

			DB::table('posts')->where(['id' => $postID, 'type' => $postType])->update(['description_image' => $uniqid_photo, 'image_facebook' => $uniqid_facebook, 'tags' => $tags, 'description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description']]);

			$info = DB::table('posts')->select('author_name', 'url')->where(['id' => $postID, 'type' => $postType])->get();
			$link = '/'.$info[0]->author_name.'/'.$info[0]->url;
			return Response::json(['success' => true, 'link' => $link]);
		}
	}
}