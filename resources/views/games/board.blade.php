@extends('layouts.app')
@section('js')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="http://{{ Request::getHost() }}:{{env('LARAVEL_ECHO_PORT')}}/socket.io/socket.io.js"></script>
  <script src="{{ url('/js/laravel-echo-setup.js') }}" type="text/javascript"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <!-- Optional: include a polyfill for ES6 Promises for IE11 -->
  <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
  <script>
    window.laravel_echo_port='{{env("LARAVEL_ECHO_PORT")}}';
    var gameInfo = {};
    var myName = '{{ \Auth::user()->name }}';
    
    window.Echo.channel('engame_database_game')
      .listen('.GameInfo', (e) => {
        gameInfo = JSON.parse(e.gameInfo);
        console.log(gameInfo);
        updateGameInfoView();
        if(gameInfo.status === 'ready') {
          setGameReady();
        }

        if(gameInfo.status === 'start') {
          $('#question').html(gameInfo.curr_round.question.question);
          if(gameInfo.curr_round.d_player == myName) {
            updateGameAnswerView();
            toggleAnswerQuestion();
          } else {
            updateGameAnswerOptionView();
            toggleAsk();
          }
        }

        updateHistory();
    });

    window.Echo.channel('engame_database_game')
      .listen('.GameReady', (e) => {
    });

    function updateGameAnswerOptionView() {
      questions = generateOptionsHtml();
      $('#options').html(questions);
    }
    function updateGameAnswerView() {
      $('#options').html('<div class="option" style="background: url('+gameInfo.curr_round.question.options[0].text+')"></div>');
    }

    function toggleAsk() {
      $('.ask').addClass('hide');
      if(gameInfo.curr_round.current_turn == myName)
        $('.ask').removeClass('hide');
    }

    function toggleAnswerQuestion() {
      $('.answer-question').addClass('hide');
      if(gameInfo.curr_round.current_turn == myName)
        $('.answer-question').removeClass('hide');
    }

    function generateOptionsHtml() {
      var optionHtml = "";
      options = gameInfo.curr_round.question.options;
      for(i = 0; i < options.length; i++) {
        optionHtml += '<div class="option" style="background: url('+options[i].text+')" data-id="'+options[i].id+'"></div>';
      }
      return optionHtml;
    }

    function updateGameInfoView() {
      document.getElementById('totalUser').innerText = gameInfo.players.length;
      document.getElementById('users').innerText = gameInfo.players.join(', ');
      document.getElementById('gameStatus').innerText = gameInfo.status;
      document.getElementById('gameRound').innerText = JSON.stringify(gameInfo.curr_round);
      document.getElementById('chat-history').innerText = JSON.stringify(gameInfo.chat_history);
    }

    function updateHistory() {
      historyHtml = '';
      histories = gameInfo.curr_round.turn_history;
      for(i = 0; i < histories.length; i++) {
        historyHtml += histories[i]+'<br />';
      }
      $('.history-panel').html(historyHtml);
    }

    function join() {
      $.ajax({
        url: "{{ route('games.join', ['gameInstanceId' => 1]) }}",
        method: 'GET',
        success: (ret) => {
        }
      });
    }

    function chat() {
      $.ajax({
        url: "{{ route('games.chat', ['gameInstanceId' => 1]) }}",
        method: 'GET',
        success: (ret) => {
        }
      });
    }

    function reset() {
      $.ajax({
        url: "{{ route('games.reset', ['gameInstanceId' => 1]) }}",
        method: 'GET',
        success: (ret) => {
          alert('game refreshed');
        }
      });
    }

    function setGameReady() {
      if(gameInfo.ready_state.includes(myName))
        return true;

      $.ajax({
        url: "{{ route('games.ready', ['gameInstanceId' => 1]) }}",
        method: 'GET',
        success: (ret) => {
        }
      });
    }

    function ask(question) {
      $.ajax({
        url: "{{ route('games.ask', ['gameInstanceId' => 1]) }}",
        data: {question: question},
        method: 'GET',
        success: (ret) => {
        }
      });
    }

    function answer(id) {
      $.ajax({
        url: "{{ route('games.answer', ['gameInstanceId' => 1]) }}",
        data: {answer: id},
        method: 'GET',
        success: (ret) => {
          if(ret) {
            Swal.fire(
              'Answered!',
              'You answer is correct',
              'success'
            );
            return true;
          }

          Swal.fire(
              'Answered!',
              'Your answer a is wrong',
              'error'
            );
        }
      });
    }

    function answerQuestion(id) {
      $.ajax({
        url: "{{ route('games.d-hint', ['gameInstanceId' => 1]) }}",
        data: {answer: id},
        method: 'GET',
        success: (ret) => {

          Swal.fire(
              'Answered!',
              'Your have answered a question from user',
              'success'
            );
        }
      });
    }

    function updateQuestionView() {
      document.getElementById('question').innerText = question.question;
      var optionsTxt = '';
      question.options.forEach(function(option) {
        optionsTxt += '<div class="option" style="background: url('+option.text+');"></div>';
      });
      $('.options').html(optionsTxt); 
    }

    $(document).ready(function() {
      join();
      $('body').on('click', '.ask', async function() {
        const { value: text } = await Swal.fire({
          input: 'textarea',
          inputPlaceholder: 'Input your question',
          inputAttributes: {
            'aria-label': 'Input your question'
          },
          showCancelButton: true
        });

        if (text) {
          ask(text);
        }
      });

      $('body').on('click', '.option', async function() {
        id = $(this).attr('data-id');
        Swal.fire({
          title: 'Are you sure to answer this?',
          text: "You will lose if you choose the wrong answer!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, I commit!'
        }).then((result) => {
          if (result.value) {
            answer(id);
          }
        });
      });

      $('body').on('click', '.answer-question', async function() {
        id = $(this).attr('data-id');
        answerQuestion(id);
      });
    });

  </script>
@endsection
@section('content')
  <div class="wrapper">
    <div class="game">
      <h3 style="text-align: center">{{ $game->name }}</h3>
      <div class="game-arena">
        Hi, {{ \Auth::user()->name }}
        <div class="question" id="question"></div>
        <div class="options" id="options">
        </div>
      </div>
      <div class="history-panel">
      </div>
      <div class="action-panel user-action-panel">
        <div class="button-wrapper">
          <div class="btn-primary btn-action ask hide">
            Ask Question
          </div>

          <div class="btn-primary btn-action answer-question yes hide" data-id="1">
            Yes
          </div>
          <div class="btn-primary btn-action answer-question no hide" data-id="0">
            No
          </div>
          <div class="btn-primary btn-action answer-question no hide" data-id="2">
            Hmmm...
          </div>
        </div>
      </div>
      <div class="chat-history">
      </div>
      <div class="room-info">
        @include('games._game-stat')
      </div>
      
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade"
    id="gameDescriptionModal" tabindex="-1"
    role="dialog"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Game Description</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="gameDescription">{{ $game->description }}</div>
        </div>
      </div>
    </div>
  </div>
@endsection
  <style>
    .hide {
      display: none;
    }
    .wrapper {
      max-width: 1100px;
      margin: auto;
    }
    .history-panel {
      height: 20%;
      border: 1px solid;
      overflow-y: scroll;
    }
    .btn-action {
      width: 100px;
    }
    .game-arena {
      min-height: 55%;
      border: 1px solid;
    }
    .action-panel {
      min-height: 5%;
      border: 1px solid;
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