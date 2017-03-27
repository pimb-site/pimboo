<?php namespace App\Http\Controllers;
use Illuminate\View\View;
use App\PostView;
use Auth;
use Illuminate\Http\Request;

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
        return view('tools.'.$content->type, ['body_class' => 'view', 'content' => $content, 'name' => $content->type]);
    }
	
	public function successID($id) {
        return view('success', ['id' => $id]);
    }
}