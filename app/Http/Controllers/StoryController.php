<?php namespace App\Http\Controllers;
use Illuminate\View\View;
use App\PostView;
use Auth;
use Illuminate\Http\Request;

class StoryController extends Controller
{
	
    public function addStory() {
        if(\Auth::guest()) {
            return view('auth/login');
        } else return view('add_flip_cards');
    }

    public function viewStories() {

        $contentflip = \DB::select('select * from posts where type = "story" and isDraft = "publish"');
        return view('view_flip_cards', ['contentflip' => $contentflip]);
    }


    public function viewID($id, Request $request) {
    	$view = new PostView;
    	$view->post_id = $id;
    	if (!Auth::guest()) {
    		$view->user_id = Auth::user()->id;
    	}
    	$view->ip = $request->ip();
    	$view->browser_info = $request->header('User-Agent');
    	$view->save();
        $content = \DB::select('select * from posts where id = ? and isDraft = ?', [$id, 'publish']);
        return view('view_story', ['content' => $content[0]]);
    }
	
	public function successID($id) {
        return view('success', ['id' => $id]);
    }
	
	public function postUploadEnd() {
        if(\Auth::guest()) return view('auth/login');

        $input = \Input::all();
		
		
		if(isset($input['isDraft'])) {
			if($input['isDraft'] == 'preview') {
				
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
				
				$rules_colors = array('blue', 'green', 'turquoise', 'purple');
				
				foreach ($input['flip_cards'] as $key => $value) {
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
					
					if(isset($value['type_front'])) {
						if($value['type_front'] == 'text') $type_front = 'text';
						else $type_front = 'image';
					} else {
						$type_front = 'image';
					}
					
					if(isset($value['type_back'])) {
						if($value['type_back'] == 'text') $type_back = 'text';
						else $type_back = 'image'; 
					} else {
						$type_back = 'image';
					}
					
					
					$content_other[] = [
                        'item_title' => $value['form_item_title'],
                        'front_card' => $value['img_src1'],
                        'back_card' => $value['img_src2'],
						'text_back' => $text_back,
						'text_front' => $text_front,
						'theme_front' => $theme_front,
						'theme_back'  => $theme_back,
						'type_front'  => $type_front,
						'type_back'   => $type_back
                    ];
				}
				return \Response::json(['content' => $content_main, 'cards' => $content_other, 'tags' => $tags]);
			} else if($input['isDraft'] == 'save') {
				
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
				foreach ($input['flip_cards'] as $key => $value) {
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
                        'front_card' => '/temp/'.$value['img_src1'],
                        'back_card' => '/temp/'.$value['img_src2'],
						'text_back' => $text_back,
						'text_front' => $text_front,
						'theme_front' => $theme_front,
						'theme_back'  => $theme_back
                    ];
					
					if($input['form_flip']['form_photo_facebook'] == "") $photo_fb = "";
					else $photo_fb = '/temp/'.$input['form_flip']['form_photo_facebook'];
					
					if($input['form_flip']['form_photo'] == "") $photo = "";
					else $photo = '/temp/'.$input['form_flip']['form_photo'];
				}
				
				
				$options = [];
				if(isset($input['display_item_numbers'])) {
					if($input['display_item_numbers'] == 'yes') $display_item_numbers = 'yes';
					else $display_item_numbers = 'no';
				} else $display_item_numbers = 'no';
					
				$options = ['display_item_numbers' => $display_item_numbers];
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
											'description_footer' => $input['form_flip']['form_footer'], 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
											'type' => 'flipcards', 'isDraft' => 'save', 'tags' => $tags, 'permission' => 'public', 'options' => $options
										]);
								return \Response::json(['success' => true, 'id' => $postID]);
							}
						}
					}
				}
				
				$id = \DB::table('posts')->insertGetId(
					['user_id' => \Auth::user()->id, 'description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
					'description_footer' => $input['form_flip']['form_footer'], 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
					'type' => 'flipcards', 'isDraft' => 'save', 'tags' => $tags, 'permission' => 'public', 'options' => $options]
				);
				return \Response::json(['success' => true, 'id' => $id]);
			}
		}
		

        $validator = \Validator::make(
            array(
                'Flip Cards Title' => $input['form_flip']['form_flip_cards_title'],
                'Flip Cards Description' => $input['form_flip']['form_description'],
                'Flip Cards Footer' => $input['form_flip']['form_footer'],
                'Flip Cards Photo' => $input['form_flip']['form_photo'],
				'Flip Cards Facebook Photo' => $input['form_flip']['form_photo_facebook']
            ),
            array(
                'Flip Cards Title' => 'required',
                'Flip Cards Description' => 'required',
                'Flip Cards Footer' => 'required',
                'Flip Cards Photo' => 'required',
				'Flip Cards Facebook Photo' => 'required'
            )
        );
		
        if (!$validator->fails())
        {
            foreach ($input['flip_cards'] as $key => $value) {
				
				$errors_array = array();
				
                $validator_cards = \Validator::make(
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

                if ($validator_cards->fails()) {
                    return \Response::json(['success' => false, 'errors' => $validator_cards->errors()]);
                }
				
				if(count($errors_array) > 0) return \Response::json(['success' => false, 'errors' => $errors_array]);
            }

            if(!$validator_cards->fails() && (count($errors_array) == 0)) {
                $errors_array = array();
				
                if(!file_exists('temp/'.$input['form_flip']['form_photo'])) $errors_array[] = 'Wrong photo link';
				if(!file_exists('temp/'.$input['form_flip']['form_photo_facebook'])) $errors_array[] = 'Wrong Facebook photo link';
				
				
                foreach ($input['flip_cards'] as $key => $value) {
					
					if(isset($value['text_front'])) {
						// code...
					} else {
						if(!file_exists('temp/'.$value['img_src1'])) $errors_array[] = 'Wrong front image link';
					}
					
					if(isset($value['text_back'])) {
						// code...
					} else {
						if(!file_exists('temp/'.$value['img_src2'])) $errors_array[] = 'Wrong back image link';
					}

                    if(count($errors_array) > 0) return \Response::json(['success' => false, 'errors' => $errors_array]);
                }

                if(count($errors_array) == 0) {
                    $content = array();
                    $uniqid3 = uniqid();
					$uniqid4 = uniqid();
					
                    copy('temp/'.$input['form_flip']['form_photo'], 'uploads/'.$uniqid3.'.jpeg');
					copy('temp/'.$input['form_flip']['form_photo_facebook'], 'uploads/'.$uniqid4.'.jpeg');
                    unlink('temp/'.$input['form_flip']['form_photo']);
					unlink('temp/'.$input['form_flip']['form_photo_facebook']);
                    foreach ($input['flip_cards'] as $key => $value) {
                        $uniqid1 = uniqid();
                        $uniqid2 = uniqid();
						
						if($value['img_src1'] != "") {
							copy('temp/'.$value['img_src1'], 'uploads/'.$uniqid1.'.jpeg');
							unlink('temp/'.$value['img_src1']);
						}
						if($value['img_src2'] != "") {
							copy('temp/'.$value['img_src2'], 'uploads/'.$uniqid2.'.jpeg');
							unlink('temp/'.$value['img_src2']);
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
                            'front_card' => $uniqid1.".jpeg",
                            'back_card' => $uniqid2.".jpeg",
							'text_back' => $text_back,
							'text_front' => $text_front,
							'theme_front' => $theme_front,
							'theme_back'  => $theme_back
                        ];
                    }
					
					$photo = $uniqid3.'.jpeg';
					$photo_fb = $uniqid4.'.jpeg';
					
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
					
					if(isset($input['postID'])) {
						$postID = (int)$input['postID'];
						if(is_int($postID) && $postID > 0) {
							$current_owner = \DB::select('select user_id from posts where id = ?', [$postID]);
							if(count($current_owner != 0)) {
								if($current_owner[0]->user_id == \Auth::user()->id) {
									\DB::table('posts')
										->where('id', $postID)
										->update(['description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
												'description_footer' => $input['form_flip']['form_footer'], 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
												'type' => 'flipcards', 'isDraft' => 'publish', 'tags' => $tags, 'permission' => 'public', 'options' => $options
											]);
									return \Response::json(['success' => true, 'id' => $postID]);
								}
							}
						}
					}
					
					$id = \DB::table('posts')->insertGetId(
						['user_id' => \Auth::user()->id, 'description_title' => $input['form_flip']['form_flip_cards_title'], 'description_text' => $input['form_flip']['form_description'],
						'description_footer' => $input['form_flip']['form_footer'], 'content' => serialize($content), 'description_image' => $uniqid3.".jpeg", 'image_facebook' => $uniqid4.".jpeg",
						'type' => 'flipcards', 'isDraft' => 'publish', 'tags' => $tags, 'permission' => 'public', 'options' => $options]
					);
                    return \Response::json(['success' => true, 'id' => $id]);
                }
            }
        } else return \Response::json(['success' => false, 'errors' => $validator->errors()]);
    }
}