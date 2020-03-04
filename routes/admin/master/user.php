<?php
Route::namespace('Master')->group(function()
{
  Route::get('/list', ['as' =>'admin.master.user.list', 'uses' => 'UserController@list']);
  Route::get('/create', ['as' =>'admin.master.user.create', 'uses' => 'UserController@create']);
  Route::post('/add', ['as' =>'admin.master.user.add', 'uses' => 'UserController@add']);
  Route::get('/update/{id}', ['as' =>'admin.master.user.update', 'uses' => 'UserController@update']);
  Route::post('/edit/{id}', ['as' =>'admin.master.user.edit', 'uses' => 'UserController@edit']);
  Route::post('/delete/{id}', ['as' =>'admin.master.user.delete', 'uses' => 'UserController@delete']);
  Route::get('/view/{id}', ['as' =>'admin.master.user.view', 'uses' => 'UserController@view']);
});
