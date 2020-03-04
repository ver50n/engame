<?php

namespace App\Models;

use session;
use Validator;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use \App\Traits\DataProviderTrait;
    public $timestamps = false;

    public $table = 'games';
    public $guarded = [];

    public function filter($filters, $options = [])
    {
        $dp = $this;
        $dp = $dp->filterId($dp, $filters);
        
        if(isset($filters['name']) && $filters['name'] != "")
            $dp = $dp->where($this->table.'.name', 'LIKE', '%'.$filters['name'].'%');
        if(isset($filters['round']) && $filters['round'] != "")
            $dp = $dp->where($this->table.'.round', $filters['round']);
            
        $dp = $this->filterIsActive($dp, $filters);
        $dp = $this->sortBy($dp, $options);
        $dp = $this->retrieve($dp, $options);

        return $dp;
    }

    public function add($data)
    {
        $rules = [
            'name' => 'required',
            'round' => 'required|integer|nullable',
            'description' => 'required'
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
        $rules = [
          'name' => 'required',
          'round' => 'required|integer|nullable',
          'description' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if($validator->fails())
            return $validator;

        $this->fill($data);
        $this->save();

        return true;

    }
}
