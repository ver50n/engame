<?php

namespace App\Models;

use session;
use Validator;
use Illuminate\Database\Eloquent\Model;

class GameInstance extends Model
{
    use \App\Traits\DataProviderTrait;
    public $timestamps = false;

    public $table = 'game_instances';
    public $guarded = [];

    public static function joinGame($game, $gameInstanceId = null)
    {
        $gameInfo = [
            'players' => [],
            'max_player' => $game->max_player,
            'max_round' => $game->round,
            'curr_round' => [
                'player_order' => [],
                'd_player' => null,
                'current_turn' => null,
                'turn_history' => []
            ],
            'status' => 'waiting',
            'ready_state' => [],
            'history_round' => []
        ];
        $gameInfo = json_encode($gameInfo);
        
        $gameInstance = \App\Models\GameInstance::firstOrCreate(
            ['id' => $gameInstanceId],
            ['game_info' => $gameInfo, 'game_id' => $game->id]
        );
        $gameInfo = json_decode($gameInstance->game_info, true);
        if($gameInfo['status'] !== 'waiting')
            return true;

        if(!in_array(\Auth::user()->name, $gameInfo['players']))
            $gameInfo['players'][] = \Auth::user()->name;

        $gameInfo['status'] = (count($gameInfo['players']) >= $game->max_player) ? 'ready' : 'waiting';

        $gameInfo = json_encode($gameInfo);
        $gameInstance->game_info = $gameInfo;
        $gameInstance->save();
        
        return $gameInstance;
    }

    public function readyGame()
    {
        $gameInfo = json_decode($this->game_info, true);

        if(!in_array(\Auth::user()->name, $gameInfo['ready_state']))
            $gameInfo['ready_state'][] = \Auth::user()->name;

        if(count($gameInfo['ready_state']) == count($gameInfo['players'])) {
            $gameInfo['curr_round'] = self::generateRound();
            $gameInfo['status'] = 'start';
        }
        
        $gameInfo = json_encode($gameInfo);
        $this->game_info = $gameInfo;
        $this->save();
    }

    public function ask($data)
    {
        $gameInfo = json_decode($this->game_info, true);
        $gameInfo['curr_round']['turn_history'][] = (\Auth::user()->name.' asked : '.$data['question']);
        $gameInfo['curr_round']['last_turn'] = $gameInfo['curr_round']['current_turn'];
        $gameInfo['curr_round']['current_turn'] = $gameInfo['curr_round']['d_player'];

        $gameInfo = json_encode($gameInfo);
        $this->game_info = $gameInfo;
        $this->save();
    }

    public function leaveGame()
    {
        $gameInfo = json_decode($this->game_info, true);

        if (($key = array_search(\Auth::user()->name, $gameInfo['ready_state'])) !== false) {
            unset($gameInfo['ready_state'][$key]);
        }

        if (($key = array_search(\Auth::user()->name, $gameInfo['players'])) !== false) {
            unset($gameInfo['players'][$key]);
        }

        if(count($gameInfo['ready_state']) == count($gameInfo['players'])) {
            $gameInfo['curr_round'] = self::generateRound($gameInstance);
            $gameInfo['status'] = 'start';
        }
        
        $gameInfo = json_encode($gameInfo);
        $this->game_info = $gameInfo;
        $this->save();
    }

    public function answer($data)
    {
        $gameInfo = json_decode($this->game_info, true);
        $res = $this->checkAnswer($gameInfo, $data['answer']);
        if($res) {
            $gameInfo['curr_round']['turn_history'][] = \Auth::user()->name.' answered, and CORRECT!!! Game End!';
            // end game
        } else {
            $gameInfo['curr_round']['turn_history'][] = \Auth::user()->name.' answered, but WRONG, '.\Auth::user()->name.' OUT';
            // disable user
        }

        $gameInfo = json_encode($gameInfo);
        $this->game_info = $gameInfo;
        $this->save();

        return $res;
    }

    public function dHint($data)
    {
        $gameInfo = json_decode($this->game_info, true);
        $gameInfo['curr_round']['turn_history'][] = \Auth::user()->name.' hint : '.($data['answer'] ? 'Yes' : 'No');
        $gameInfo['curr_round']['current_turn'] = $this->getNextPlayer($gameInfo);
        $gameInfo = json_encode($gameInfo);
        $this->game_info = $gameInfo;
        $this->save();
    }

    public function checkAnswer($gameInfo, $answer)
    {
        $options = $gameInfo['curr_round']['question']['options'];

        foreach($options as $option) {
            if($option['id'] == $answer && $option['is_answer'])
                return true;
        }

        return false;
    }

    public function getNextPlayer($gameInfo)
    {
        $playerOrder = $gameInfo['curr_round']['player_order'];
        $lastTurn = $gameInfo['curr_round']['last_turn'];
        $next = null;

        $index = array_search($lastTurn, $playerOrder);
        $index = ($index+1 > count($playerOrder)-1) ? 0 : $index+1;
        $next = $playerOrder[$index];

        return $next;
    }

    protected function generateRound()
    {
        $gameInfo = json_decode($this->game_info, true);
        $dPlayer = self::decideDPlayer($gameInfo);
        $playerOrder = self::decidePlayerOrder($gameInfo, $dPlayer);
        $question = self::generateQuestion($this->game_id);

        $currRound = [
            'player_order' => $playerOrder,
            'd_player' => $dPlayer,
            'question' => $question,
            'current_turn' => $playerOrder[0],
            'last_turn' => $playerOrder[0],
            'turn_history' => []
        ];

        return $currRound;
    }

    protected static function generateQuestion($gameId)
    {
	    $question = [];
	    $gameId = rand(1,10);
        $question = Question::find($gameId);
        $question['options'] = QuestionOption::where('question_id', $question->id)->get();

        return $question;
    }

    protected static function decideDPlayer($data)
    {
        $dPlayer = array_rand($data['players']);
        return $data['players'][$dPlayer];
    }

    protected static function decidePlayerOrder($data, $dPlayer)
    {
        $players = $data['players'];
        if (($key = array_search($dPlayer, $players)) !== false) {
            unset($players[$key]);
        }
        shuffle($players);

        return $players;
    }
}
