<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PostView;
Use Validator;
use App\Post;
use App\User;
use DateTime;
use Input;
use Auth;
use DB;

class ToolsController extends Controller {
    public function editTool($author, $url) {
        if(Auth::guest()) return redirect('auth/login');
        $data = ['author' => $author, 'url' => $url];
        $validator = validator::make($data, [
            'author' => 'required|min:3|max:255',
            'url'   =>  'required|min:3|max:200',
        ]);
        if (!$validator->fails()) {
            if(Auth::user()->permission == 10) { // if user - it's admin, then
                $post = Post::where(['author_name' => $author, 'url' => $url])->first();
                $isAdmin = true;
            } else {
                $post = Post::where(['author_name' => $author, 'url' => $url, 'user_id' => Auth::user()->id])->first();
                $isAdmin = false;
            }
            return (count($post) != 0) ? view('ToolsEdit.'.$post->type, ['body_class' => 'tools_create_page', 'post' => $post, 'isAdmin' => $isAdmin]) : redirect('/home');
        }
        return redirect('/home');
    }

    public function viewTool($author, $url, Request $request) {
        $data = ['author' => $author, 'url' => $url];
        $validator = validator::make($data, [
            'author' => 'required|min:3|max:255',
            'url'   =>  'required|min:3|max:200',
        ]);
        if (!$validator->fails()) {
            $post = Post::where(['author_name' => $author, 'url' => $url, 'isDraft' => 'publish'])->first();
            if(count($post) != 0) {
                // Adding a entry about the viewing of post
                $this->addEntry($post->id, $request);
                // getting current date
                $format = "Y-m-d H:i:s";
                $date = $this->getDate($format, $post->created_at);
                // getting ads for user
                $ads = $this->getAds($post->user_id);
                // Depending on the type of post, forming content of post
                switch ($post->type) {
                    case 'rankedlist':
                        $data =  $this->isRankedlist($post, $date);
                        return view('tools.'.$post->type, ['body_class' => 'view '.$post->type, 'content' => $post, 'data' => $data, 'name' => $post->type, 
                                    'user_name' => $post->author_name, 'tags' => unserialize($post->tags), 'date' => $date]);
                        break;
                    
                    case 'snip':
                        $adv = $this->isSnip($post);
                        return view('tools.'.$post->type, ['adv' => $adv, 'snip' => unserialize($post->content)]);
                        break;

                    default:
                        return view('tools.'.$post->type, ['body_class' => 'view '.$post->type, 'content' => $post, 'name' => $post->type, 'user_name' => $post->author_name,
                                    'tags' => unserialize($post->tags), 'date' => $date, 'ads' => $ads]);
                        break;
                }
            }
            return redirect('/home');
        }
        return redirect('/home');
    }

    private function isSnip($post) {
        // Choosing one random tag from this post and form advertising
        $tags = unserialize($post->tags);
        if(count($tags) != 0) {
            $tag_num = rand (0, count($tags) - 1 );
            $tag_name = strtolower($tags[$tag_num]);
        } else $tag_name = "notag";
        // Getting advertising specified in the settings (set by the administrator )
        $adv = DB::table('settings')->where(['setting' => 'snips'])->first();
        $adv = unserialize($adv->value);
        $adv = [
            'href' => $adv[$tag_name]['href'],
            'url'  => $adv[$tag_name]['url'],
            'text' => $adv[$tag_name]['text']
        ];
        return $adv;
    }

    private function isRankedlist($post, $date) {
        // Getting the value of the number of votes from each card in the current post
        $post_votes = DB::table('votes')->select(DB::raw('count(card_id) as count, card_id'))->where(['post_id' => $post->id])->groupBy('card_id')->get();
        $votes = [];
        $element_id = 1;
        for($i = 0; $i < count($post_votes); $i++) $votes[$post_votes[$i]->card_id] = $post_votes[$i]->count;
        $content_cards = unserialize($post->content);
        // Forming the position of cards depending on the votes
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
        // Cards sorting in decreasing order
        krsort($data);
        return $data;
    }

    private function getAds($user_id) {
        $user_model = User::where(['id' => $user_id])->first();
        $user_name = $user_model->name ?? 'Unknown';
        $ads = DB::table('settings')->where([ 'setting' => 'ads'])->first();
        $ads = unserialize($ads->value);
        foreach ($ads as &$ad) {
            $ad['href'] = $ad['href'].'&s2='.$user_id.'_'.Input::get('sub');
        }
        return $ads;
    }

    private function addEntry($post_id, $request) {
        $view = new PostView;
        $view->post_id = $post_id;
        $view->ip = $request->ip();
        $view->browser_info = $request->header('User-Agent');
        $view->user_id = Auth::guest() ? 0 : Auth::user()->id;
        $view->save();
    }

    private function getDate($format, $post_created) {
        $date = DateTime::createFromFormat($format, $post_created);
        $date = $date->format('F d, Y');
        return $date;
    }
}