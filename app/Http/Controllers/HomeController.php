<?php namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;

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
        $home_main_post = Post::where([ ['status', '=', 'home_main'] ])->first();
        $home_top_posts = Post::where('status', 'LIKE', '%home_post%')->orderBy('status')->get();
        $latest = Post::latest()->take(6)->get();

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

}
