<?php
Route::namespace('Game')->group(function() {
  Route::get('/list', ['as' =>'admin.game.question.list', 'uses' => 'QuestionController@list']);
  Route::get('/create', ['as' =>'admin.game.question.create', 'uses' => 'QuestionController@create']);
  Route::post('/add', ['as' =>'admin.game.question.add', 'uses' => 'QuestionController@add']);
  Route::get('/update/{id}', ['as' =>'admin.game.question.update', 'uses' => 'QuestionController@update']);
  Route::post('/edit/{id}', ['as' =>'admin.game.question.edit', 'uses' => 'QuestionController@edit']);
  Route::post('/edit/{id}/addOption', ['as' =>'admin.game.question.addOption', 'uses' => 'QuestionController@addOption']);
});
