<?php

namespace App\Models;

use session;
use Validator;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use \App\Traits\DataProviderTrait;
    public $timestamps = false;

    public $table = 'questions';
    public $guarded = [];

    public function options()
    {
        return $this->hasMany(\App\Models\QuestionOption::class);
    }

    public function filter($filters, $options = [])
    {
        $dp = $this;
        $dp = $dp->filterId($dp, $filters);
        
        if(isset($filters['game_id']) && $filters['game_id'] != "")
            $dp = $dp->where($this->table.'.game_id', $filters['game_id']);
        if(isset($filters['type']) && $filters['type'] != "")
            $dp = $dp->where($this->table.'.type', $filters['type']);
        if(isset($filters['question']) && $filters['question'] != "")
            $dp = $dp->where($this->table.'.question', 'LIKE', '%'.$filters['question'].'%');
            
        $dp = $this->filterIsActive($dp, $filters);
        $dp = $this->sortBy($dp, $options);
        $dp = $this->retrieve($dp, $options);

        return $dp;
    }

    public function add($data)
    {
        $data['type'] = 'choice';
        $rules = [
        ];

        $validator = Validator::make($data, $rules);
        if($validator->fails())
            return $validator;

        $this->fill($data);
        $this->save();

        return true;
    }

    public function edit($data)
    {
        $data['type'] = 'choice';
        $rules = [
          'game_id' => 'required',
          'type' => 'required',
          'question' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if($validator->fails())
            return $validator;

        $this->fill($data);
        $this->save();

        return true;
    }

    public function addOptions($data)
    {
        QuestionOption::where('question_id', $this->id)->delete();
        $cnt = count($data['type']);
        for($i = 0; $i < $cnt; $i++) {
            $questionOpt = new QuestionOption();
            $questionOpt->question_id = $this->id;
            $questionOpt->type = $data['type'][$i];
            $questionOpt->text = $data['text'][$i];
            $questionOpt->is_active = $data['is_active'][$i];
            $questionOpt->is_answer = $data['is_answer'][$i];
            $questionOpt->save();
        }

        return true;
    }
}
