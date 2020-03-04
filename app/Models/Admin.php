<?php

namespace App\Models;

use session;
use Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use \App\Traits\DataProviderTrait;

    public $table = 'admins';
    public $fillable = [
      'id',
      'admin_type',
      'name',
      'email',
      'password',
      'is_active'
    ];

    public function filter($filters, $options = [])
    {
        $dp = $this;
        $dp = $dp->filterId($dp, $filters);
        
        if(isset($filters['admin_type']) && $filters['admin_type'] != "")
            $dp = $dp->where($this->table.'.admin_type', $filters['admin_type']);
        if(isset($filters['name']) && $filters['name'] != "")
            $dp = $dp->where($this->table.'.name', 'LIKE', '%'.$filters['name'].'%');
        if(isset($filters['email']) && $filters['email'] != "")
            $dp = $dp->where($this->table.'.email', 'LIKE', '%'.$filters['email'].'%');
            
        $dp = $this->filterIsActive($dp, $filters);
        $dp = $this->filterCreatedAt($dp, $filters);
        $dp = $this->filterUpdatedAt($dp, $filters);
        $dp = $this->sortBy($dp, $options);
        $dp = $this->retrieve($dp, $options);

        return $dp;
    }

    public function add($data)
    {
        $rules = [
            'name' => 'required',
            'admin_type' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if($validator->fails())
            return $validator;

        $data['password'] = bcrypt($data['password']);
        $this->fill($data);
        $this->save();

        return true;
    }

    public function edit($data)
    {
        $rules = [
            'name' => 'required',
            'admin_type' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if($validator->fails())
            return $validator;
        if($data['password'] != $this->password)
            $data['password'] = bcrypt($data['password']);

        $this->fill($data);
        $this->save();

        return true;

    }
}
