<?php namespace App\Http\Controllers;
use Illuminate\View\View;
use App\PostView;
use App\Report;
use Auth;
use Illuminate\Http\Request;
use App\User;

class ReportsController extends Controller
{
	
    public function Add(Request $request) {
        $input = \Input::all();
        if ($input['action'] == 'input') {
            $report = new Report;
            $report->post_id = $input['post_id'];
            if (!Auth::guest()) {
                $report->user_id = Auth::user()->id;
            }
            $report->ip = $request->ip();
            $report->browser_info = $request->header('User-Agent');
            $report->type = $input['type'];
            $report->save();
        }
    }
}