<?php

namespace App\Models;

use session;
use Validator;
use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    use \App\Traits\DataProviderTrait;
    public $timestamps = false;

    public $table = 'question_options';
    public $guarded = [];

    
}
