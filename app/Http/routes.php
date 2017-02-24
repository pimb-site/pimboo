<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
// flipcards get
Route::get('test_upload', 'FlipcardsController@testUpload');
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
Route::get('upload/getTriviaForm/{id}', 'TriviaController@getNewForm');

Route::post('upload_end_trivia', 'TriviaController@saveTriviaQuiz');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/activate','Auth\AuthController@activate');
Route::post('auth/login','Auth\AuthController@postLogin');

//user pages
Route::get('user/account', 'UserController@getAccount');
Route::post('user/account', 'UserController@getViewsInfo');

Route::get('user/profile', 'UserController@getProfile');
Route::post('user/profile', 'UserController@saveProfile');

Route::get('user/organization', 'UserController@getOrganization');

Route::get('user/referrals', 'UserController@getReferrals');

//Referrals
Route::get('ref/{id}', 'ReferralController@index');