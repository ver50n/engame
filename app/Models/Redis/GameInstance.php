<?php
  namespace App\Models\Redis;

  use Illuminate\Support\Facades\Redis;
  
  class GameInstance
  {
      public function __construct($id, $gameId)
      {
          $this->id = $id;
          $this->gameId = $gameId;
          $this->dUser = null;
          $this->users = json_encode([]);
          $this->createdAt = date('Y-m-d H:i:s');
      }

      public function store()
      {
          Redis::hmset('game_instances:' . $this->id, [
              'id' => $this->id,
              'gameId' => $this->gameId,
              'dUser' => $this->dUser,
              'users' => $this->users,
              'createdAt' => $this->createdAt
          ]);
      }

      public static function find($id)
      {
          $key = 'game_instances:' . $id;
          $stored = Redis::hgetall($key);
          if (!empty($stored)) {
              return new GameInstance($stored['id'], $stored['gameId'], $stored['createdAt']);
          }
          return false;
      }

      public static function getAll()
      {
          $keys = Redis::keys('game_instances:*');
          $gameInstances = [];
          foreach ($keys as $key) {
              $stored = Redis::hgetall($key);
              $gameInstance = new GameInstance($stored['id'], $stored['gameId'], $stored['createdAt']);
              $gameInstances[] = $gameInstance;
          }

          return $gameInstances;
      }

      public function addUser($email)
      {
          $key = 'game_instances:xxx';
          $users = $this->getUsers();
          foreach($users as $user) {
              if($email === $user)
                  return true;
          }

          $this->users[] = $email;
          $result = Redis::hset($key, 'users', json_encode($this->users));

          return true;
      }

      public function getUsers()
      {
          $key = 'game_instances:xxx';
          $users = Redis::hget($key, 'users');
          $users = json_decode($users);

          return $users;
      }

      public function chooseDUser($dUser = null)
      {
          $key = 'game_instances:xxx';
          if($dUser === null) {
              $users = $this->getUsers();
              $dUser = array_rand($users);
          }

          $this->dUser = $dUser;
          $result = Redis::hset($key, 'dUser', $dUser);

          return $result;
      }

      public function getDUser()
      {
          $key = 'game_instances:xxx';
          $dUser = Redis::hget($key, 'dUser');
          
          return $dUser;
      }
  }