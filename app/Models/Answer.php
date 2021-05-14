<?php 

namespace App\Models;

use App\Models\Model;
use App\Models\User;
use App\Models\Question;

class Answer extends Model {

    protected $table = 'answers';
    protected $primaryKey = 'AnswerId';

    public function user() {

        return $this->belongsTo(User::class, 'users', 'UserId', 'UserId');
    }

    public function question() {

        return $this->belongsTo(Question::class, 'questions', 'QuestionsID', 'QuestionsID');
    }
}