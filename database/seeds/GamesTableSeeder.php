<?php

use Illuminate\Database\Seeder;

class GamesTableSeeder extends Seeder
{
    public function run()
    {
        $games = [[
            'name' => 'Yes No',
            'round' => 10,
            'max_player' => 5,
            'description' => 'this is a game',
            'is_active' => 1
        ]];
        $maxQuestions = 10;
      
        foreach($games as $game) {
            $objGame = \App\Models\Game::where('name', $game['name'])->first();
            if($objGame)
                continue;
            $objGame = new App\Models\Game();
            $objGame->fill($game);
            $objGame->save();

            for($i = 0; $i < $maxQuestions; $i++) {
                $faker = \Faker\Factory::create('en_US');
                $objQuestion = new \App\Models\Question();
                $objQuestion->game_id = $objGame->id;
                $objQuestion->type = 'selection';
                $objQuestion->question = $faker->realText($maxNbChars = 10, $indexSize = 2);
                $objQuestion->is_active = 1;
                $objQuestion->save();
                
                $answer = rand(0, 6);
                for($j = 0; $j < 6; $j++) {
                    $objQuestionOption = new \App\Models\QuestionOption();
                    $objQuestionOption->question_id = $objQuestion->id;
                    $objQuestionOption->type = 'image';
                    $objQuestionOption->text = $faker->imageUrl($width = 320, $height = 240, $category = 'cats', $randomize = true, $word = null);
                    $objQuestionOption->is_answer = ($answer === $j);
                    $objQuestionOption->is_active = 1;
                    $objQuestionOption->save();
                }

            }
        }
    }
}
