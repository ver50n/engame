<?php
Route::namespace('Master')->group(function()
{
  Route::get('/list', ['as' =>'admin.master.admin.list', 'uses' => 'AdminController@list']);
  Route::get('/create', ['as' =>'admin.master.admin.create', 'uses' => 'AdminController@create']);
  Route::post('/add', ['as' =>'admin.master.admin.add', 'uses' => 'AdminController@add']);
  Route::get('/update/{id}', ['as' =>'admin.master.admin.update', 'uses' => 'AdminController@update']);
  Route::post('/edit/{id}', ['as' =>'admin.master.admin.edit', 'uses' => 'AdminController@edit']);
  Route::post('/delete/{id}', ['as' =>'admin.master.admin.delete', 'uses' => 'AdminController@delete']);
  Route::get('/view/{id}', ['as' =>'admin.master.admin.view', 'uses' => 'AdminController@view']);
});
