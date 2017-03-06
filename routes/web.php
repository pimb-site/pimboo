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
// flipcards get
Route::get('add_flip_cards', 'FlipcardsController@addFlipCards');
Route::get('viewID/{id}', 'FlipcardsController@viewID');
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

Route::post('upload_end_trivia', 'TriviaController@saveTriviaQuiz');
// Story
Route::get('add_story', 'StoryController@addStory');
Route::get('view_story/{id}', 'StoryController@viewID');
Route::get('view_stories', 'StoryController@viewStories');
Route::post('save_story', 'StoryController@postUploadEnd');


Route::get('add_ranked_list', 'RankedlistController@addRankedList');
Route::post('upload_end_rankedlist', 'RankedlistController@saveRankedList');
Route::post('vote_rankedlist', 'RankedlistController@voteRankedList');

Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/activate','Auth\AuthController@activate');


//user pages
Route::get('user/account', 'UserController@getAccount');
Route::post('user/account', 'UserController@getViewsInfo');

Route::get('user/profile', 'UserController@getProfile');
Route::post('user/profile', 'UserController@saveProfile');

Route::get('user/organization', 'UserController@getOrganization');

Route::get('user/referrals', 'UserController@getReferrals');

//Referrals
Route::get('ref/{id}', 'ReferralController@index');


Route::get('/home', 'HomeController@index');
Auth::routes();
Route::get('logout', 'Auth\LoginController@logout')->name('logout');