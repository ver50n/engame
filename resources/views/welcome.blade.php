<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <script src="http://{{ Request::getHost() }}:{{env('LARAVEL_ECHO_PORT')}}/socket.io/socket.io.js"></script>
    <script src="{{ url('/js/laravel-echo-setup.js') }}" type="text/javascript"></script>
    <script>
      window.laravel_echo_port='{{env("LARAVEL_ECHO_PORT")}}';

      window.Echo.channel('engame_database_testing')
        .listen('.testing', function (e) {
          showNotification('someone');
      });
      
      function showNotification(msg) {
        if (!("Notification" in window)) {
          alert("This browser does not support desktop notification");
        }

        else if (Notification.permission === "granted") {
          // If it's okay let's create a notification
          var notification = new Notification(msg);
        }

        else if (Notification.permission !== "denied") {
          Notification.requestPermission().then(function (permission) {
            // If the user accepts, let's create a notification
            if (permission === "granted") {
              var notification = new Notification(msg);
            }
          });
        }
      }
    </script>
  </head>
  <body>
    <div class="flex-center position-ref full-height">
      @if (Route::has('login'))
        <div class="top-right links">
          @auth
            <a href="{{ url('/home') }}">Home</a>
          @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
              <a href="{{ route('register') }}">Register</a>
            @endif
          @endauth
        </div>
      @endif

      <div class="content">
        <div class="room-info">
          <div class="user-total">
          </div>
          <div id="user-msg">
          </div>
        </div>
        <button type="button btn btn-primary"
          class="send-something">Send</button>
      </div>
    </div>
  </body>

</html>
