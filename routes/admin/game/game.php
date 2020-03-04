<?php
Route::namespace('Game')->group(function()
{
  Route::get('/list', ['as' =>'admin.game.game.list', 'uses' => 'GameController@list']);
  Route::get('/create', ['as' =>'admin.game.game.create', 'uses' => 'GameController@create']);
  Route::post('/add', ['as' =>'admin.game.game.add', 'uses' => 'GameController@add']);
  Route::get('/update/{id}', ['as' =>'admin.game.game.update', 'uses' => 'GameController@update']);
  Route::post('/edit/{id}', ['as' =>'admin.game.game.edit', 'uses' => 'GameController@edit']);
});
