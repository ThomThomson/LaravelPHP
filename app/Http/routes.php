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
Route::get('/', 'frontEndController@findIndex');
//Routes for Auth without Register
Route::get('login', 'Auth\AuthController@showLoginForm');
Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout');

//Routes for the frontend and backend
Route::get('/manage', 'frontEndController@enterBackend');
//Route::get('/home', 'HomeController@index');

//Route Resources for backend C R U D
Route::resource('manage/pages', 'pageController');
Route::resource('manage/articles', 'articleController');
Route::resource('manage/areas', 'contentAreaController');
Route::resource('manage/templates', 'cssTemplateController');
Route::resource('manage/users', 'userController');
Route::get('getUserInfo/{id}', 'ajaxController@getUserInfo');
Route::get('getArticleInfo/{id}', 'ajaxController@getArticleInfo');
Route::get('getPageInfo/{id}', 'ajaxController@getPageInfo');
Route::get('getContentAreaInfo/{id}', 'ajaxController@getContentAreaInfo');
Route::get('getCssTemplateInfo/{id}', 'ajaxController@getCssTemplateInfo');

//Route for front end pages
Route::get('{alias}', 'frontEndController@showPage');