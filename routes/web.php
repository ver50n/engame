<?php

  /* Admin Group */
  Route::prefix('/admin')
    ->group(base_path('routes/admin/index.php'));

  Route::get('/welcome', ['as' => 'games.list', 'uses' => 'GameController@welcome'])
    ->middleware([]);
  Route::get('/games', ['as' => 'games.list', 'uses' => 'GameController@selection'])
    ->middleware([]);
  Route::get('/games/{id}', ['as' => 'games.view', 'uses' => 'GameController@view'])
    ->middleware(['']);
  Route::get('/games/{id}/board', ['as' => 'games.board', 'uses' => 'GameController@board'])
      ->middleware(['auth']);

  Route::get('/games/{id}/info', ['as' => 'games.info', 'uses' => 'GameController@info']);
  Route::get('/games/{id}/getQuestion', ['as' => 'games.getQuestion', 'uses' => 'GameController@getQuestion']);

  /* Helper Routes */
  Route::post('/helpers/change-locale',['as' => 'helpers.change-locale', 'uses' => 'HelperController@changeLocale']);
  Route::post('/helpers/change-row-per-page',['as' => 'helpers.change-row-per-page', 'uses' => 'HelperController@changeRowPerPage']);
  Route::get('/helpers/export',['as' => 'helpers.export', 'uses' => 'HelperController@export']);
  Route::post('/helpers/activate/{id}',['as' => 'helpers.activate', 'uses' => 'HelperController@activate']);
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
