<?php
  /** Admin **/
  // Dashboard
  Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push(trans('common.dashboard'), route('admin.dashboard'));
  });

  // admin
  Breadcrumbs::for('admin.master.admin.list', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(trans('common.list'),
      route('admin.master.admin.list'));
  });
  Breadcrumbs::for('admin.master.admin.create', function ($trail) {
    $trail->parent('admin.master.admin.list');
    $trail->push(trans('common.create'),
      route('admin.master.admin.create'));
  });
  Breadcrumbs::for('admin.master.admin.update', function ($trail, $id) {
    $trail->parent('admin.master.admin.list');
    $trail->push(trans('common.update').' (#'.$id.')',
      route('admin.master.admin.update', ['id' => $id]));
  });

  // user
  Breadcrumbs::for('admin.master.user.list', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(trans('common.list'),
      route('admin.master.user.list'));
  });
  Breadcrumbs::for('admin.master.user.create', function ($trail) {
    $trail->parent('admin.master.user.list');
    $trail->push(trans('common.create'),
      route('admin.master.user.create'));
  });
  Breadcrumbs::for('admin.master.user.update', function ($trail, $id) {
    $trail->parent('admin.master.user.list');
    $trail->push(trans('common.update').' (#'.$id.')',
      route('admin.master.user.update', ['id' => $id]));
  });

  // game
  Breadcrumbs::for('admin.game.game.list', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(trans('common.list'),
      route('admin.game.game.list'));
  });
  Breadcrumbs::for('admin.game.game.create', function ($trail) {
    $trail->parent('admin.game.game.list');
    $trail->push(trans('common.create'),
      route('admin.game.game.create'));
  });
  Breadcrumbs::for('admin.game.game.update', function ($trail, $id) {
    $trail->parent('admin.game.game.list');
    $trail->push(trans('common.update').' (#'.$id.')',
      route('admin.game.game.update', ['id' => $id]));
  });

  // question
  Breadcrumbs::for('admin.game.question.list', function ($trail, $gameId) {
    $trail->parent('admin.dashboard');
    $trail->push(trans('common.list'),
      route('admin.game.question.list', ['gameId' => $gameId]));
  });
  Breadcrumbs::for('admin.game.question.create', function ($trail, $gameId) {
    $trail->parent('admin.game.question.list', $gameId);
    $trail->push(trans('common.create'),
      route('admin.game.question.create', ['gameId' => $gameId]));
  });
  Breadcrumbs::for('admin.game.question.update', function ($trail, $gameId, $id) {
    $trail->parent('admin.game.question.list', $gameId);
    $trail->push(trans('common.update').' (#'.$id.')',
      route('admin.game.question.update', ['gameId' => $gameId, 'id' => $id]));
  });
