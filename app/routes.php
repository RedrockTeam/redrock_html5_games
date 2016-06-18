<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/{game}', 'HomeController@start');


Route::post('/post', 'HomeController@verify');
Route::post('praise-xi-post', 'HomeController@savexi');
Route::post('praise-xi-telephone-post', 'HomeController@clickTelephone');
Route::post('goodcitizen', 'HomeController@goodcitizen');
Route::post('goodcitizenphone', 'HomeController@goodcitizenTelephone');

// 2048 Index
Route::get("/{game}/2048_main", function(){
	return View::make("2048.main")->with(["arr" => ["url" => "http://202.202.43.41/game/public/2048/2048_main", "path" => "http://202.202.43.41/game/public/pic/2048.png"]]);
});
// 2048 guide
Route::get("/{game}/2048_guide", function(){
	return View::make("2048.guide");
});

Route::get("/{game}/2048_index", 'HomeController@start');

Route::get('/{game}/twolearnonedo', 'HomeController@twolearnonedo');
Route::post('getquestionfortlod', 'HomeController@tlodquestion');
Route::post('recordscorefortlod', 'HomeController@tlodRecord');
Route::post('recordphone', 'HomeController@tlodPhone');


Route::post('getquestionforparty', array( 'as' => 'party', 'uses' => 'HomeController@getPartyQuestion'));
Route::post('partyscore', array( 'as' => 'partyscore', 'uses' => 'HomeController@partyRecord'));
Route::post('partyphone', array( 'as' => 'partyphone', 'uses' => 'HomeController@partyPhone'));


//view rank
//Route::get('/game/rank', 'RankController@index');

Route::post('takephotos', 'HomeController@takephotos');
Route::post('cqupt', array('as' => 'cqupt', 'uses' => 'HomeController@cqupt'));
