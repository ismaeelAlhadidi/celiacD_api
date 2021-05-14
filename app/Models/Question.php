<?php 

namespace App\Models;

use App\Models\Model;
use App\Models\User;
use App\Models\Favourite;
use App\Models\Answer;

class Question extends Model {

    protected $table = 'questions';
    protected $primaryKey = 'QuestionsID';

    public function user() {

        return $this->belongsTo(User::class, 'users', 'UserId', 'UserId');
    }

    public function favourites() {

        return $this->hasMany(Favourite::class, 'favourites', 'QuestionsID', 'QuestionsID');
    }

    public function answers() {

        return $this->hasMany(Answer::class, 'answers', 'QuestionsID', 'QuestionsID');
    }
}