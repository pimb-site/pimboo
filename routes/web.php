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

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
Route::get('create', 'HomeController@create');

Route::get('viewID/{id}', 'ToolsController@viewID');
// flipcards get
Route::get('add_flip_cards', 'FlipcardsController@addFlipCards');
Route::get('success/{id}', 'FlipcardsController@successID');
Route::get('view_flip_cards', 'FlipcardsController@viewFlipCards');
Route::post('upload/img_url', 'FlipcardsController@imageURL');
// flipcards post
Route::post('test_upload_end', 'FlipcardsController@testUploadEnd');
Route::post('upload_end', 'FlipcardsController@postUploadEnd');
Route::post('upload/image', 'FlipcardsController@postUpload');

//trivia post
Route::post('upload/valid_url', 'TriviaController@validURL');
// trivia get
Route::get('view_trivia_quiz', 'TriviaController@viewTriviaQuiz');
Route::get('add_trivia_quiz', 'TriviaController@addTriviaQuiz');
Route::get('save_trivia_quiz', 'TriviaController@saveTriviaQuiz');

Route::post('save_trivia_quiz', 'TriviaController@saveTriviaQuiz');
// Story
Route::get('add_story', 'StoryController@addStory');
Route::get('view_story/{id}', 'StoryController@viewID');
Route::get('view_stories', 'StoryController@viewStories');
Route::post('report', 'ReportsController@Add');
Route::post('save_story', 'StoryController@postUploadEnd');


Route::get('add_ranked_list', 'RankedlistController@addRankedList');
Route::post('upload_end_rankedlist', 'RankedlistController@saveRankedList');
Route::post('vote_rankedlist', 'RankedlistController@voteRankedList');

Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/activate','Auth\AuthController@activate');

// Video to GIF
Route::post('upload_yb_gif', 'VideoGifController@youtubeGIF');
Route::post('upload_end_gif', 'VideoGifController@uploadEndGIF');
Route::post('upload_gif', 'VideoGifController@uploadGIF');
Route::get('video_to_gif', 'VideoGifController@addGIF');

Route::post('/upload/video', 'VideoGifController@uploadVideo');

// user photo / cover photo
Route::post('user/setPhoto', 'UserController@setPhoto');
Route::post('user/deleteAvatar', 'UserController@deleteAvatar');

//user pages
Route::get('user/account', 'UserController@getAccount');
Route::post('user/account', 'UserController@getViewsInfo');

Route::get('user/profile', 'UserController@getProfile');
Route::post('user/profile', 'UserController@saveProfile');

Route::get('user/organization', 'UserController@getOrganization');

Route::get('user/referrals', 'UserController@getReferrals');

Route::get('admin', 'AdminController@getHome');
Route::get('admin/reports', 'AdminController@getReports');
Route::get('admin/reports/update', 'AdminController@updateReport');
Route::get('admin/ads', 'AdminController@getAds');
Route::post('admin/ads/save', 'AdminController@saveAds');
Route::get('admin/home', 'AdminController@getHome');
Route::post('admin/postposition', 'AdminController@updatePost');


//Referrals
Route::get('ref/{id}', 'ReferralController@index');


Route::get('/home', 'HomeController@index');

// channel
Route::post('/channel-filter', 'ChannelController@filterChannel');
Route::get('/channel/{id}', 'ChannelController@viewChannel');

// Auth
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

//Landings
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