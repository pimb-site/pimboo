<?php namespace App\Http\Controllers;
use App\Post;
use App\Redirect;
use Illuminate\Http\Request;
use Input;
use Response;

class HomeController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        $home_main_post = Post::where(['home_left' => 1, 'isDraft' => 'publish'])->get();
        $home_top_posts = Post::where(['home_right' => 1, 'isDraft' => 'publish'])->get();
        $latest = Post::where(['home_latest' => 1, 'isDraft' => 'publish'])->take(6)->get();

        return view('home', [
            'body_class' => 'home', 
            'main_post' => $home_main_post, 
            'posts' => $home_top_posts,
            'latest' => $latest,
        ]);
    }

    public function create()
    {
        return view('create', ['body_class' => 'create-page']);
    }

    public function redirects()
    {
        
        $redirect = Redirect::where([ ['from', '=', $_SERVER['REDIRECT_URL']] ])->first();
        if ($redirect) {
            return redirect($redirect->to, 301);
        } else {
            abort(404);
        }
    }

    public function showmore() {
        $multiply = Input::get('multiply');
        $multiply = ($multiply > 0 && $multiply < 1000) ? $multiply : 1;
        $latest = Post::select('author_name', 'url', 'description_title', 'description_image')->where('home_latest', 1)->skip($multiply * 6)->take(6)->get();
        return Response::json(['success' => true, 'posts' => $latest]);
    }

}
