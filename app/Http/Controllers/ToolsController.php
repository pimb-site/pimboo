<?php namespace App\Http\Controllers;
use Illuminate\View\View;
use App\PostView;
use Auth;
use Input;
use Illuminate\Http\Request;
use App\User;
use DateTime;
use DB;

class ToolsController extends Controller
{

    public function viewTool($name, $title_url, Request $request) {

        $content = DB::select('select * from posts where author_name = ? and url = ? and isDraft = ?', [$name, $title_url, 'publish']);

        if(count($content) != 0) {
            $content = $content[0];
            $view = new PostView;
            $view->post_id = $content->id;
     
            if (!Auth::guest()) {
                $view->user_id = Auth::user()->id;
            }
            $view->ip = $request->ip();
            $view->browser_info = $request->header('User-Agent');
            $view->save();
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
            $ads = DB::select('select * from settings where setting = "ads"');
            $ads = unserialize($ads[0]->value);
            foreach ($ads as &$ad) {
                $ad['href'] = $ad['href'].'&s2='.$content->user_id.'_'.Input::get('sub');
            }

            if($content->type == 'snip') {
                $tags = unserialize($content->tags);
                $adv = DB::select("select * from settings where setting = ?", ['snips']);
                $adv = unserialize($adv['0']->value);

                if(count($tags) == 0) {
                    $tag_name = "notag";
                } else {
                    $tag_num = rand (0, count($tags) - 1 );
                    $tag_name = strtolower($tags[$tag_num]);
                }

                $adv = [
                    'href' => $adv[$tag_name]['href'],
                    'url'  => $adv[$tag_name]['url'],
                    'text' => $adv[$tag_name]['text']
                ];

                return view('tools.'.$content->type, ['adv' => $adv, 'snip' => unserialize($content->content)]);

            } elseif($content->type == 'rankedlist') {
                $get_votes = DB::table('votes')->select(DB::raw('count(card_id) as count, card_id')) 
                                               ->where(['post_id' => $content->id]) 
                                               ->groupBy('card_id')
                                               ->get();
                $votes = [];
                for($i = 0; $i < count($get_votes); $i++) 
                    $votes[$get_votes[$i]->card_id] = $get_votes[$i]->count;

                $content_cards = unserialize($content->content);
                $element_id = 1;
                foreach($content_cards as $key => $value) {
                    $votes_elem = isset($votes[$element_id]) ? $votes[$element_id] : 0;
                    if($value['type_card'] == 'image') {
                        $data[$votes_elem][] = [
                            'post_title' => $value['post_title'],
                            'caption'    => $value['caption_card'],
                            'type_card'  => $value['type_card'],
                            'image'      => $value['image_card'],
                            'votes'      => $votes_elem,
                            'element_id' => $element_id
                        ];
                    } else {
                        $data[$votes_elem][] = [
                            'post_title' => $value['post_title'],
                            'caption'    => $value['caption_card'],
                            'type_card'  => $value['type_card'],
                            'youtube'    => $value['youtube_clip'],
                            'votes'      => $votes_elem,
                            'element_id' => $element_id
                        ];
                    }
                    $element_id++;
                }
                krsort($data);

                return view('tools.'.$content->type, ['body_class' => 'view '.$content->type, 'content' => $content, 'data' => $data, 'name' => $content->type, 'user_name' => $user_name, 'source_link' => '', 'ads' => $ads, 'tags' => unserialize($content->tags), 'date' => $date]);

            } else {
                return view('tools.'.$content->type, ['body_class' => 'view '.$content->type, 'content' => $content, 'name' => $content->type, 'user_name' => $user_name, 'source_link' => '', 'ads' => $ads, 'tags' => unserialize($content->tags), 'date' => $date]);
            }
        } else {
            return redirect('/home');
        }
    }
}