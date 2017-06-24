<?php namespace App\Http\Controllers;
use App\Post;
use App\Redirect;
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
        $latest = Post::latest()->where('type', '<>', 'snip')->take(6)->get();

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

}
