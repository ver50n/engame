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
  Route::get('/games/{gameInstanceId}/board', ['as' => 'games.board', 'uses' => 'GameController@board'])
      ->middleware(['auth']);

  Route::get('/games/{gameInstanceId}/join', ['as' => 'games.join', 'uses' => 'GameController@join']);
  Route::get('/games/{gameInstanceId}/ready', ['as' => 'games.ready', 'uses' => 'GameController@ready']);
  Route::get('/games/{gameInstanceId}/ask', ['as' => 'games.ask', 'uses' => 'GameController@ask']);
  Route::get('/games/{gameInstanceId}/answer', ['as' => 'games.answer', 'uses' => 'GameController@answer']);
  Route::get('/games/{gameInstanceId}/d-hint', ['as' => 'games.d-hint', 'uses' => 'GameController@dHint']);
  // Route::get('/games/{gameInstanceId}/disconnect', ['as' => 'games.ready', 'uses' => 'GameController@disconnect']);

  /* Helper Routes */
  Route::post('/helpers/change-locale',['as' => 'helpers.change-locale', 'uses' => 'HelperController@changeLocale']);
  Route::post('/helpers/change-row-per-page',['as' => 'helpers.change-row-per-page', 'uses' => 'HelperController@changeRowPerPage']);
  Route::get('/helpers/export',['as' => 'helpers.export', 'uses' => 'HelperController@export']);
  Route::post('/helpers/activate/{id}',['as' => 'helpers.activate', 'uses' => 'HelperController@activate']);
  Auth::routes();

  Route::get('/home', 'HomeController@index')->name('home');
  Route::get('/', 'HomeController@index')->name('/');
