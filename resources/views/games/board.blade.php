@extends('layouts.app')
@section('js')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="http://{{ Request::getHost() }}:{{env('LARAVEL_ECHO_PORT')}}/socket.io/socket.io.js"></script>
  <script src="{{ url('/js/laravel-echo-setup.js') }}" type="text/javascript"></script>
  <script>
    window.laravel_echo_port='{{env("LARAVEL_ECHO_PORT")}}';
    var roomInfo = {
      gameId: null,
      gameName: 'No Game',
      gameDescription: 'No Description',
      totalUser: 0,
      dUser: ''
    }
    var question = {
      questionId: null,
      question: '',
      options: [],
    }

    window.Echo.channel('engame_database_game')
      .listen('.GameInfo', function (e) {
        roomInfo = {
          gameId: e.data.gameId,
          gameName: e.data.gameName,
          gameDescription: e.data.gameDescription,
          totalUser: e.data.totalUser,
          dUser: e.data.dUser
        }
        updateGameInfoView();
    });

    window.Echo.channel('engame_database_game')
      .listen('.GetQuestion', function (e) {
        question = {
          questionId: e.data.questionId,
          question: e.data.question,
          options: e.data.options,
        }
        updateQuestionView();
    });

    function updateGameInfoView() {
      document.getElementById('gameName').innerText = roomInfo.gameName;
      document.getElementById('gameDescription').innerText = roomInfo.gameDescription;
      document.getElementById('totalUser').innerText = roomInfo.totalUser;
      document.getElementById('dUser').innerText = roomInfo.dUser;
    }

    function updateQuestionView() {
      document.getElementById('question').innerText = question.question;
      var optionsTxt = '';
      question.options.forEach(function(option) {
        optionsTxt += '<div class="option" style="background: url('+option.text+');"></div>';
      });
      $('.options').html(optionsTxt); 
    }

    function updateData() {
      $.ajax({
        url: '{{ route('games.info', ['id' => 1]) }}',
        type: 'get'
      });
    }

    function getQuestion() {
      $.ajax({
        url: '{{ route('games.getQuestion', ['id' => 1]) }}',
        type: 'get'
      });
    }

    function startGame() {
      getQuestion();
    }
    

    $(document).ready(function() {
      updateData();

      $('.update-question').click(function() {
        getQuestion();
      })

      $('.start-game').click(function() {
        startGame();
      })
    });
  </script>
@endsection
@section('content')
  <div class="wrapper">
    <div class="game">
      <h3 style="text-align: center" id="gameName">{{ $game->name }}</h3>
      <div class="room-info">
        <div class="user-info">
          Total User Connected : 
          <span id="totalUser">
          </span>
          <br />
          D User : 
          <span id="dUser"></span>
        </div>
      </div>
      
      <br />

      <div class="game-board">
        <div class="game-panel">
          <button type="button"
            class="btn btn-primary"
            data-toggle="modal"
            data-target="#gameDescriptionModal">Game Description
          </button>
          <button type="button"
            class="btn btn-primary start-game">Start Game
          </button>
          <button type="button"
            class="btn btn-primary update-question">Update Question
          </button>
          <button type="button"
            class="btn btn-primary quit">Quit
          </button>
        </div>

        <br />

        <div class="game-arena">
          <div class="question" id="question"></div>
          <div class="options">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade"
    id="gameDescriptionModal" tabindex="-1"
    role="dialog"
    aria-labelledby="gameDescriptionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Game Description</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="gameDescription"></div>
        </div>
      </div>
    </div>
  </div>
@endsection
  <style>
    .wrapper {
      max-width: 1100px;
      margin: auto;
    }
    .game-info {
      border: 1px solid black;
      border-radius: 10px;
      padding: 5px;
    }
    .question {
      font-size: 1.2rem;
      font-weight: 700;
    }

    .options {
      display: flex;
      flex-wrap: wrap;
    }
    .option {
      flex-grow: 1;
      flex-basis: 33%;
      min-height: 200px;
      border: 1px solid;
      background-size: cover !important;
      background-position: center !important;
    }
  </style>