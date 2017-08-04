<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Auth (and logout)
Auth::routes();
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/login/{provider?}',[
    'uses' => 'AuthController@getSocialAuth',
    'as'   => 'auth.getSocialAuth'
]);
Route::get('/login/callback/{provider?}',[
    'uses' => 'AuthController@getSocialAuthCallback',
    'as'   => 'auth.getSocialAuthCallback'
]);

// Landings
Route::get('/privacy-policy', function () {
    return view('landings.privacy_policy');
});
Route::get('/charity', function () {
    return view('landings.charity');
});
Route::get('/disclaimer', function () {
    return view('landings.disclaimer');
});
Route::get('/terms-of-service', function () {
    return view('landings.tos');
});


// Trivia, Editing required!!!
//Route::get('/success/snip/{id}', 'SnipController@successID');
//Route::get('view_trivia_quiz', 'TriviaController@viewTriviaQuiz');
//Route::get('add_trivia_quiz', 'TriviaController@addTriviaQuiz');
//Route::get('save_trivia_quiz', 'TriviaController@saveTriviaQuiz');
//Route::post('save_trivia_quiz', 'TriviaController@saveTriviaQuiz');

// Page for select tool
Route::get('/create', 'HomeController@create');

// Home page
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::post('/home/showmore/', 'HomeController@showmore');

// Reports
Route::post('report', 'ReportsController@Add');

// Addition for tools
Route::post('/create/addition/getInfoYoutube', 'AdditionForToolsController@getInfoYoutube');
Route::post('/create/addition/saveimageonURL', 'AdditionForToolsController@saveImageOnURL');
Route::post('/create/addition/saveimage',      'AdditionForToolsController@saveImage');
// Success page after publish tool
Route::get('/success/{author}/{link}',         'AdditionForToolsController@successPage');

// Snip
Route::get('/create/snip', 'SnipController@displayCreatePage');
Route::post('/create/snip/send', 'SnipController@sendSnip');

// Flipcards
Route::get('/create/flipcards', 'FlipcardsController@displayCreatePage');
Route::post('/create/flipcards/send', 'FlipcardsController@sendFlipcards');

// Story
Route::get('/create/story', 'StoryController@displayCreatePage');
Route::post('/create/story/send', 'StoryController@sendStory');

// RankedList
Route::get('/create/rankedlist', 'RankedlistController@displayCreatePage');
Route::post('/create/rankedlist/send', 'RankedlistController@sendRankedList');
Route::post('/create/rankedlist/vote', 'RankedlistController@voteRankedList');

// GIFMaker
Route::get('/create/gifmaker', 'GIFMakerController@displayCreatePage');
Route::post('/create/gifmaker/create', 'GIFMakerController@createGIF');
Route::post('/create/gifmaker/send', 'GIFMakerController@sendGIF');

// Register
Route::post('/auth/register', 'Auth\AuthController@postRegister');
Route::get('/auth/activate','Auth\AuthController@activate');

// user photo / cover photo
Route::post('/user/setPhoto', 'UserController@setPhoto');
Route::post('/user/deleteAvatar', 'UserController@deleteAvatar');

//user pages
Route::get('/user/account', 'UserController@getAccount');
Route::post('/user/account', 'UserController@getViewsInfo');
Route::get('/user/profile', 'UserController@getProfile');
Route::post('/user/profile', 'UserController@saveProfile');
Route::get('/user/organization', 'UserController@getOrganization');
Route::get('/user/referrals', 'UserController@getReferrals');

// Admin panel
Route::get('/admin', 'AdminController@getHome');
Route::get('/admin/users', 'AdminController@getUsers');
Route::get('/admin/reports', 'AdminController@getReports');
Route::get('/admin/reports/update', 'AdminController@updateReport');
Route::get('/admin/ads', 'AdminController@getAds');
Route::get('/admin/home', 'AdminController@getHome');
Route::post('/admin/ads/save', 'AdminController@saveAds');
Route::get('/admin/snip', 'AdminController@getAdvSnip');
Route::post('/admin/snip/save', 'AdminController@saveAdvSnip');

// Editing for users
Route::get('/edit/{name}/{title}', 'ToolsController@editTool');

// editing user profile for admins
Route::post('/admin/editing/update/user', 'AdminController@updateUser');
Route::get('/admin/editing/user/{id}', 'AdminController@editUser');
// adm action
Route::post('/admin/action/deleteuser', 'AdminController@deleteUser');
Route::post('/admin/action/deletepost', 'AdminController@deletePost');
Route::post('/admin/action/postposition', 'AdminController@updatePost');
Route::post('/admin/action/sortentries', 'AdminController@sortEntries');
Route::post('/admin/action/deleteuserphoto', 'AdminController@deletePhotoUser');

//Referrals
Route::get('/ref/{name}', 'ReferralController@index');
Route::post('/referrals/mass', 'ReferralController@MassMailing');

// Channel page
Route::get('/{name}', 'ChannelController@viewChannel');
Route::post('/channel/filter', 'ChannelController@filterChannel');

// View tools
Route::get('/{name}/{title}', 'ToolsController@viewTool');

// subscribe/unsubscribe
Route::post('/channel/subscribe', 'ChannelController@subscribe');
Route::post('/channel/unsubscribe', 'ChannelController@unsubscribe');

// Redirects
Route::get('/{url}', 'HomeController@redirects');