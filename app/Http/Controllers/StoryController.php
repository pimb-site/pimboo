<?php namespace App\Http\Controllers;
use Illuminate\View\View;
use App\PostView;
use Auth;
use Illuminate\Http\Request;
use Input;
use DB;

class StoryController extends Controller
{
	
    public function displayCreatePage() {
        if(Auth::guest()) return view('auth/login');
        else return view('ToolsCreate.story');
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

	public function sendStory() {
        if(Auth::guest()) return Response::json(['success' => false, 'errorText' => 'You are not authorized.']);
        $input = Input::all();
		
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

		if($input['form_story']['form_photo_facebook'] == "") $photo_fb = "";
			else $photo_fb = '/temp/'.$input['form_story']['form_photo_facebook'];
			
		if($input['form_story']['form_photo'] == "") $photo = "";
			else $photo = '/temp/'.$input['form_story']['form_photo'];
		
		$options = [];
		if(isset($input['display_item_numbers'])) {
			if($input['display_item_numbers'] == 'yes') $display_item_numbers = 'yes';
			else $display_item_numbers = 'no';
		} else $display_item_numbers = 'no';
			
		$options = ['display_item_numbers' => $display_item_numbers];
		$options = serialize($options);

        $validator = \Validator::make(
            array(
                'Story Title' => $input['form_story']['form_story_cards_title'],
                'Story Description' => $input['form_story']['form_description'],
                'Story Photo' => $input['form_story']['form_photo'],
				'Story Facebook Photo' => $input['form_story']['form_photo_facebook'],
				'Story Content' => $input['form_story']['content']
            ),
            array(
                'Story Title' => 'required|min:3|max:400',
                'Story Description' => 'required|min:3',
                'Story Photo' => 'required',
				'Story Facebook Photo' => 'required',
				'Story Content' => 'required'
            )
        );
		
        if (!$validator->fails())
        {


    //     	if($input['isDraft'] == 'save') {
				// if(isset($input['postID'])) {
				// 	$postID = (int)$input['postID'];
				// 	if(is_int($postID) && $postID > 0) {
				// 		$current_owner = \DB::select('select user_id from posts where id = ?', [$postID]);
				// 		if(count($current_owner != 0)) {
				// 			if($current_owner[0]->user_id == \Auth::user()->id) {
				// 				\DB::table('posts')
				// 					->where('id', $postID)
				// 					->update(['description_title' => $input['form_story']['form_story_cards_title'], 'description_text' => $input['form_story']['form_description'],
				// 							'description_footer' => $input['form_story']['form_footer'], 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
				// 							'type' => 'story', 'isDraft' => 'save', 'tags' => $tags, 'permission' => 'public', 'options' => $options
				// 						]);
				// 				return \Response::json(['success' => true, 'id' => $postID]);
				// 			}
				// 		}
				// 	}
				// }

				// $string = $input['form_story']['form_story_cards_title'];
				// $string = StoryController::translit($string);
				// if(strlen($string) < 10) $string = 'post-story-'.strtolower(str_random(30));

				// $str2 = $string;
				// $str2 = $str2.'-'.date('Y-d-m');

				// $count = DB::table('posts')->where('author_name', '=', Auth::user()->name)->where('url', '=', $str2)->count();
				// if($count == 0) {
				// 	$id = \DB::table('posts')->insertGetId(
				// 		['user_id' => \Auth::user()->id, 'author_name' => Auth::user()->name, 'url' => $str2, 'description_title' => $input['form_story']['form_story_cards_title'], 'description_text' => $input['form_story']['form_description'],
				// 		'content' => $input['form_story']['content'], 'description_image' => $uniqid3.".jpeg", 'image_facebook' => $uniqid4.".jpeg",
				// 		'type' => 'story', 'isDraft' => 'save', 'tags' => $tags, 'permission' => 'public', 'options' => $options]
				// 	);
	   //              return \Response::json(['success' => true, 'id' => $id]);
				// } else {
				// 	$string = 'post-story-'.strtolower(str_random(30));
				// 	$str2 = $string;
				// 	$str2 = $str2.'-'.date('Y-d-m');
				// 	$id = \DB::table('posts')->insertGetId(
				// 		['user_id' => \Auth::user()->id, 'author_name' => Auth::user()->name, 'url' => $str2, 'description_title' => $input['form_story']['form_story_cards_title'], 'description_text' => $input['form_story']['form_description'],
				// 		'content' => $input['form_story']['content'], 'description_image' => $uniqid3.".jpeg", 'image_facebook' => $uniqid4.".jpeg",
				// 		'type' => 'story', 'isDraft' => 'save', 'tags' => $tags, 'permission' => 'public', 'options' => $options]
				// 	);
				// 	return \Response::json(['success' => true, 'id' => $id]);
				// }

    //     	}

            $errors_array = array();
			
            if(!file_exists('temp/'.$input['form_story']['form_photo'])) $errors_array[] = 'Wrong photo link';
			if(!file_exists('temp/'.$input['form_story']['form_photo_facebook'])) $errors_array[] = 'Wrong Facebook photo link';
			
			
            if(count($errors_array) == 0) {
                $content = array();
                $uniqid3 = uniqid();
				$uniqid4 = uniqid();
				
                copy('temp/'.$input['form_story']['form_photo'], 'uploads/'.$uniqid3.'.jpeg');
				copy('temp/'.$input['form_story']['form_photo_facebook'], 'uploads/'.$uniqid4.'.jpeg');
                unlink('temp/'.$input['form_story']['form_photo']);
				unlink('temp/'.$input['form_story']['form_photo_facebook']);
				
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



				$string = $input['form_story']['form_story_cards_title'];
				$string = StoryController::translit($string);
				if(strlen($string) < 3) {
					$string = 'story';
				} else if(strlen($string) > 180) {
					$string = substr($string, 0, 190);
				}

				$str = $string;

				$first = false;
				$count = -1;

				while(true) {
					$result = DB::table('posts')->where('author_name', '=', Auth::user()->name)->where('url', '=', $string)->count();
					if($result == 0) {
						$id = \DB::table('posts')->insertGetId(
							['user_id' => \Auth::user()->id, 'author_name' => Auth::user()->name, 'url' => $string, 'description_title' => $input['form_story']['form_story_cards_title'], 'description_text' => $input['form_story']['form_description'],
							'content' => $input['form_story']['content'], 'description_image' => $uniqid3.".jpeg", 'image_facebook' => $uniqid4.".jpeg",
							'type' => 'story', 'isDraft' => 'publish', 'tags' => $tags, 'permission' => 'public', 'options' => $options]
						);
						$link = '/'.Auth::user()->name.'/'.$string;
						return \Response::json(['success' => true, 'link' => $link]);
					} else {
						$string = $str.$count;
						$count--;
					}
				}
            }
        } else return \Response::json(['success' => false, 'errors' => $validator->errors()]);
    }
}