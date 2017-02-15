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
Route::get('upload/getForm/{id}', 'FlipcardsController@getNewForm');
// flipcards post
Route::post('test_upload_end', 'FlipcardsController@testUploadEnd');
Route::post('upload_end', 'FlipcardsController@postUploadEnd');
Route::post('upload/image', 'FlipcardsController@postUpload');
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
