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

Route::get('/', 'RedirectController@home');

Route::get('/publisher', 'RedirectController@publisher');

//Add New News Publisher
Route::post('/publisher/add', 'NewsController@newNewsPublisher');

//Add Sample News Publisher
Route::get('/publisher/sample/add', 'NewsController@newSamplePublisher');

//Delete News Publisher
Route::delete('/publisher/delete', 'NewsController@deleteNewsPublisher');

//News Publisher Information
Route::get('/publisher/{NewsId}', 'NewsController@PublisherInfo');

//Ajax in homepage calling
Route::post('/news/feature', 'NewsController@showFeatureNews');

//News Parser Preview Phase
Route::post('/news/parser', 'NewsController@parserPreview');

//Add News to Database
Route::post('/news/add', 'NewsController@addNews');
