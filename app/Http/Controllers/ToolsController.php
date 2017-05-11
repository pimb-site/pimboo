<?php namespace App\Http\Controllers;
use Illuminate\View\View;
use App\PostView;
use Auth;
use Input;
use Illuminate\Http\Request;
use App\User;
use DateTime;

class ToolsController extends Controller
{
	
    public function addStory() {
        if(\Auth::guest()) {
            return view('auth/login');
        } else return view('add_story');
    }

    public function viewStories() {
        $contentflip = \DB::select('select * from posts where type = "story" and isDraft = "publish"');

        return view('view_stories', ['contentflip' => $contentflip]);
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
        $content = $content[0];


        // Date post
        $format = "Y-m-d H:i:s";
        $date   = DateTime::createFromFormat($format, $content->created_at);
        $date   = $date->format('F d, Y');

        $user_model = User::where([ ['id', '=', $content->user_id] ])->first();

        if (isset($user_model->id)) {
            $user_name = $user_model->name;
        } else {
            $user_name = 'Unknown';
        }

        $ads = \DB::select('select * from settings where setting = "ads"');
        $ads = unserialize($ads[0]->value);

        foreach ($ads as &$ad) {
            $ad['href'] = $ad['href'].'&s2='.$content->user_id.'_'.Input::get('sub');
        }

        return view('tools.'.$content->type, ['body_class' => 'view '.$content->type, 'content' => $content, 'name' => $content->type, 'user_name' => $user_name, 'source_link' => '', 'ads' => $ads, 'tags' => unserialize($content->tags) ]);
    }
	
	public function successID($id) {
        return view('success', ['id' => $id]);
    }
}