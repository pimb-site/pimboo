<?php namespace App\Http\Controllers;

use Illuminate\View\View;
use Input;
use redirect;
use Response;
use Auth;
use DB;

class SnipController extends Controller {

	public function createPage() {
		return (Auth::guest()) ? view('auth/login') : view('create_snip');
	}

	public function createLink() {
		if (Auth::guest()) return false;

		$input = Input::all();

		$message  = ($input['message'] == '') ? 'Add your message...' : $input['message'];
		$main_url = ($input['main_url'] == '') ? 'http://example.com' : $input['main_url'];
		$btn_text = ($input['btn_text'] == '') ? 'Click here' : $input['btn_text'];
		$btn_url  = ($input['btn_url'] == '') ? 'http://example.com' : $input['btn_url'];

		$uniq_link = uniqid();

		DB::table('snips')->insert(
		    ['user_id' => Auth::user()->id, 'message' => $message, 'btn_text' => $btn_text, 
		     'btn_url' => $btn_url, 'main_url' => $main_url, 'uniq_link' => $uniq_link]
		);


		$link = '/snip/'.$uniq_link;

		return Response::json(['success' => true, 'link' => $link]);
	}

	public function viewLink($link) {
		if($link == "") return redirect('/');

		$snips = DB::table('snips')
                    ->select('user_id', 'main_url', 'btn_text', 'btn_url', 'message')
                    ->where('uniq_link', '=', $link)
                    ->get();

        if(count($snips) != 0) {

        $user_info = DB::table('users')
                    ->select('name', 'photo')
                    ->where('id', '=', $snips[0]->user_id)
                    ->get();	

        	return view('view_snip', ['snip' => $snips[0], 'user_info' => $user_info[0]]);
        } else {
        	return redirect('/');
        }
	}

}