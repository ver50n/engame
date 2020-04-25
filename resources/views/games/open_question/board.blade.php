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
    var channel = "laravel_database_game";
    var dAnswer = null;

    window.Echo.channel(channel)
      .listen('.GameInfo', (e) => {
        gameInfo = JSON.parse(e.gameInfo);
        
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

    window.Echo.channel(channel)
      .listen('.BroadCastWinner', (e) => {
        Swal.fire({
          icon: 'success',
          title: e.winner+' has won the game',
          text: 'Game board will be refreshed',
          showConfirmButton: false,
          timer: 1500
        })
        window.location.reload();
    });
    
    window.Echo.channel(channel)
      .listen('.GameReset', (e) => {
        Swal.fire({
          icon: 'success',
          title: 'Game Reset',
          text: 'Game board will be refreshed',
          showConfirmButton: false,
          timer: 1500
        })
        window.location.reload();
    });

    function updateGameAnswerOptionView() {
      questions = generateOptionsHtml();
      $('#options').html(questions);
    }

    function updateGameAnswerView() {
      var answer = null; 
      var options = gameInfo.curr_round.question.options
      for(i = 0; i < options.length; i++) {
        if(options[i].is_answer) {
          answer = options[i].text;
          break;
        }
      }
      $('#options').html('<div class="option" style="background: url('+answer+')"></div>');
    }

    function toggleAsk() {
      $('.ask').addClass('hide');
      if(gameInfo.curr_round.current_turn == myName)
        $('.ask').removeClass('hide');
    }

    function toggleAnswerQuestion() {
      $('.ask').addClass('hide');
      $('.answer-question').addClass('hide');
      if(gameInfo.curr_round.current_turn == myName)
        $('.answer-question').removeClass('hide');
    }

    function generateOptionsHtml() {
      var optionHtml = "";
      options = gameInfo.curr_round.question.options;
      for(i = 0; i < options.length; i++) {
        optionHtml += '<div class="option selectableAnswer" style="background: url('+options[i].text+')" data-id="'+options[i].id+'"></div>';
      }
      return optionHtml;
    }

    function updateGameInfoView() {
      document.getElementById('totalUser').innerText = gameInfo.players.length;
      document.getElementById('users').innerText = gameInfo.players.join(', ');
      document.getElementById('gameStatus').innerText = gameInfo.status;
      document.getElementById('chat-history').innerText = JSON.stringify(gameInfo.chat_history);
    }

    function updateHistory() {
      historyHtml = '';
      histories = gameInfo.curr_round.turn_history.reverse();
      for(i = 0; i < histories.length; i++) {
        historyHtml += histories[i]+'<br />';
      }
      $('.history-panel').html(historyHtml);
    }

    function join() {
      $.ajax({
        url: "{{ route('games.join', ['gameInstanceId' => 2]) }}",
        method: 'GET',
        success: (ret) => {
        }
      });
    }

    function setGameReady() {
      if(gameInfo.ready_state.includes(myName))
        return true;

      $.ajax({
        url: "{{ route('games.ready', ['gameInstanceId' => 2]) }}",
        method: 'GET',
        success: (ret) => {
        }
      });
    }

    function ask(question) {
      $.ajax({
        url: "{{ route('games.ask', ['gameInstanceId' => 2]) }}",
        data: {question: question},
        method: 'GET',
        success: (ret) => {
        }
      });
    }

    function chat(chatText) {
      $.ajax({
        url: "{{ route('games.chat', ['gameInstanceId' => 2]) }}",
        data: {chat: chatText},
        method: 'GET',
        success: (ret) => {
          $('.chat-text').val("");
        }
      });
    }

    function reset() {
      $.ajax({
        url: "{{ route('games.reset', ['gameInstanceId' => 2]) }}",
        method: 'GET',
        success: (ret) => {
        }
      });
    }

    function answer(id) {
      $.ajax({
        url: "{{ route('games.answer', ['gameInstanceId' => 2]) }}",
        data: {answer: id},
        method: 'GET',
        success: (ret) => {
          ret = JSON.parse(ret);
          if(ret) {
            Swal.fire({
              icon: 'success',
              title: 'Answered',
              text: 'Your answer is correct',
              showConfirmButton: false,
              timer: 1500
            });
            return true;
          }
          Swal.fire({
            icon: 'error',
            title: 'Answered',
            text: 'Your answer is wrong',
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    }

    function answerQuestion(dAnswer) {
      $.ajax({
        url: "{{ route('games.d-hint', ['gameInstanceId' => 2]) }}",
        data: {answer: dAnswer},
        method: 'GET',
        success: (ret) => {
          Swal.fire({
            icon: 'success',
            title: 'Hinted',
            text: 'Your have answered a question from user',
            showConfirmButton: false,
            timer: 1500
          });
          dAnswer = null;
          resetSelectedAnswer();
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

    function resetSelectedAnswer() {
      $('.answer-question').removeClass('selected-answer');
    }

    function selectedAnswer(id) {
      resetSelectedAnswer();
      $('.answer-question').each(function() {
        if($(this).attr('data-id') === id)
          $(this).addClass('selected-answer');
      });
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

      $('body').on('click', '.selectableAnswer', async function() {
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
        if(selected) {
          //if(selected === id)
            // answer(id);
        }
      });

      $('.chat-send').click(function() {
        var chatText = $('.chat-text').val().trim();
        if(chatText)
          chat(chatText);
      });
      
      $('.reset-game').click(function() {
        reset();
      });

      $('body').on('click', '.hint-answer', function() {
        dAnswer = $(this).parent().find('.hint-text').val();
        answerQuestion(dAnswer);
        $(this).parent().find('.hint-text').val('');
      });
    });

  </script>
@endsection
@section('content')
  <div class="wrapper">
    <div class="game">
      <h3 style="text-align: center">{{ $game->name }}</h3>
      <div class="game-arena">
        Hi, {{ \Auth::user()->name }}<button class="reset-game">Reset Game</button>
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

          <div class="wrapper answer-question hide">
            <textarea class="hint-text" style="float: left;">
            </textarea>
            <div class="btn-primary btn-action hint-answer"
              style="width:100px; height: 52px; margin-top: 0; float: left;">
              Answer
            </div>
          </div>
          </div>
        </div>
      </div>
      <div class="chat-history" id="chat-history">
        
      </div>
      <input type="text" class="chat-text" />
      <button type="button" class="chat-send">Send</button>
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
      background-size: contain !important;
      background-position: center !important;
      background-repeat: no-repeat !important;
    }

    .ask {
      width: 100%;
      min-height: 50px;
    }

    .button-wrapper {
      display: flex;
    }
    .answer-question {
      width: 100%;
      height: 100px;
      border-radius: 5px;
      margin-right: 5px;
      text-align: center;
    }
    .answer-question div {
      margin-top: 25%;
    }
    .selected-answer {
      background: red !important;
    }
  </style>