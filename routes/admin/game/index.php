<?php
  Route::prefix('/game')
    ->middleware([])
    ->group(base_path('routes/admin/game/game.php'));
  Route::prefix('/question/{gameId}')
    ->middleware([])
    ->group(base_path('routes/admin/game/question.php'));
