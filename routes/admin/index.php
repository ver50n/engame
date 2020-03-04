<?php
Route::namespace('Admin')->group(function()
{
  Route::redirect('/','./admin/login');
  Route::get('/dashboard',['as' => 'admin.dashboard', 'uses' => 'AdminController@dashboard'])
    ->middleware(['AdminAuthentication']);
  Route::get('/login',['as' => 'admin.login', 'uses' => 'Auth\LoginController@login'])
    ->middleware([]);
  Route::post('/authenticate',['as' => 'admin.authenticate', 'uses' => 'Auth\LoginController@authenticate']);
  Route::post('/logout',['as' => 'admin.logout', 'uses' => 'Auth\LoginController@logout'])
    ->middleware(['AdminAuthentication']);
  Route::get('/forgot-password',['as' => 'admin.forgot-password', 'uses' => 'Auth\ForgotPasswordController@index'])
    ->middleware([]);

  /* Master Group*/
  // Admin
  Route::prefix('/master/admin')
    ->middleware(['AdminAuthentication'])
    ->group(base_path('routes/admin/master/admin.php'));

  // User
  Route::prefix('/master/user')
    ->middleware(['AdminAuthentication'])
    ->group(base_path('routes/admin/master/user.php'));

  /* Game Group */
  // Game
  Route::prefix('/game')
    ->middleware(['AdminAuthentication'])
    ->group(base_path('routes/admin/game/index.php'));
});
