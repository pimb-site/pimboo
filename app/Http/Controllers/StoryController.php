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
        } else return view('add_story');
    }

    public function viewStories() {

        $contentflip = \DB::select('select * from posts where type = "story" and isDraft = "publish"');
        return view('tool_list', ['contentflip' => $contentflip, 'name' => 'Stories']);
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
		
		
		if(isset($input['postID'])) {
			$postID = (int)$input['postID'];
			if(is_int($postID) && $postID > 0) {
				$current_owner = \DB::select('select user_id from posts where id = ?', [$postID]);
				if(count($current_owner != 0)) {
					if($current_owner[0]->user_id == \Auth::user()->id) {
						\DB::table('posts')
							->where('id', $postID)
							->update(['description_title' => $input['form_story']['form_story_cards_title'], 'description_text' => $input['form_story']['form_description'],
									'description_footer' => $input['form_story']['form_footer'], 'content' => serialize($content), 'description_image' => $photo, 'image_facebook' => $photo_fb,
									'type' => 'story', 'isDraft' => 'save', 'tags' => $tags, 'permission' => 'public', 'options' => $options
								]);
						return \Response::json(['success' => true, 'id' => $postID]);
					}
				}
			}
		}
		


        $validator = \Validator::make(
            array(
                'Story Title' => $input['form_story']['form_story_cards_title'],
                'Story Description' => $input['form_story']['form_description'],
                'Story Photo' => $input['form_story']['form_photo'],
				'Story Facebook Photo' => $input['form_story']['form_photo_facebook'],
				'Story Content' => $input['form_story']['content']
            ),
            array(
                'Story Title' => 'required',
                'Story Description' => 'required',
                'Story Photo' => 'required',
				'Story Facebook Photo' => 'required',
				'Story Content' => 'required'
            )
        );
		
        if (!$validator->fails())
        {
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
				
				$id = \DB::table('posts')->insertGetId(
					['user_id' => \Auth::user()->id, 'description_title' => $input['form_story']['form_story_cards_title'], 'description_text' => $input['form_story']['form_description'],
					'content' => $input['form_story']['content'], 'description_image' => $uniqid3.".jpeg", 'image_facebook' => $uniqid4.".jpeg",
					'type' => 'story', 'isDraft' => 'publish', 'tags' => $tags, 'permission' => 'public', 'options' => $options]
				);
                return \Response::json(['success' => true, 'id' => $id]);
            }
        } else return \Response::json(['success' => false, 'errors' => $validator->errors()]);
    }
}