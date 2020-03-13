<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function prototype()
    {
        $players = ['A', 'B'];
        $initial = $players;
        $d = null;
        $round = 10;
        echo "max round = $round <br />";
        echo "<pre>";
        for($i = 1; $i <= $round; $i++){
            echo 'Round : '.$i.'<br />';
            $d = $this->decideD($players, $d);
            $initial = $this->makeTurn($initial, $d);
            $turn = $initial;
            if (($key = array_search($d, $turn)) !== false) {
                unset($turn[$key]);
            }
            echo 'D : '.$d.'<br />';
            echo 'Player\'s turn : <br />';
            print_r($turn);
            echo "<br />";
        }
        echo "</pre>";
        exit;
    }

    private function makeTurn($initial)
    {
        $removed = array_shift($initial);
        $initial[] = $removed;

        return $initial;
    }

    private function decideD($players, $d)
    {
        if(!$d)
            return $players[0];
        
        $dIndex = array_search($d, $players);
        $dIndex = ($dIndex+1 > count($players)-1) ? 0 : $dIndex+1;
        return $players[$dIndex];
    }
}
