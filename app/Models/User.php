<?php

namespace App\Models;

use Validator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use \App\Traits\DataProviderTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function filter($filters, $options = [])
    {
        $dp = $this;
        $dp = $dp->filterId($dp, $filters);
        
        if(isset($filters['name']) && $filters['name'] != "")
            $dp = $dp->where($this->table.'.name', 'LIKE', '%'.$filters['name'].'%');
        if(isset($filters['email']) && $filters['email'] != "")
            $dp = $dp->where($this->table.'.email', 'LIKE', '%'.$filters['email'].'%');

        if(isset($filters['gender']) && $filters['gender'] != "")
            $dp = $dp->where($this->table.'.gender', $filters['gender']);
        if(isset($filters['is_subscribed']) && $filters['is_subscribed'] != "")
            $dp = $dp->where($this->table.'.is_subscribed', $filters['is_subscribed']);
        
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
            'email' => 'required|email|unique:users',
            'password' => 'required',
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
            'email' => 'sometimes|required|email|unique:users,id,'.$this->id,
        ];

        $validator = Validator::make($data, $rules);
        if($validator->fails())
            return $validator;
          
        $this->fill($data);
        $this->save();

        return true;
    }
}
