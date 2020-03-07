@extends('layouts.app')

@section('content')

  <div class="wrapper">
    <div class="game-list">
    @foreach($games as $game)
      <div class="game">
        <a href="{{ route('games.board', ['gameInstanceId' => $game->id]) }}">
          {{ $game->name }}
        </a>
      </div>
    @endforeach
    </div>
  </div>

@endsection
  <style>
    .wrapper {
      max-width: 1100px;
      margin: auto;
    }
  </style>