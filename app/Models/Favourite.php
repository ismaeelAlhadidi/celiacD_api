<?php 

namespace App\Models;

use App\Models\Model;
use App\Models\User;
use App\Models\Question;

class Favourite extends Model {

    protected $table = 'favourites';
    protected $primaryKey = 'FavouriteId';

    public function patient() {

        return $this->belongsTo(User::class, 'users', 'PatientId', 'UserId');
    }

    public function question_publisher() {

        return $this->belongsTo(User::class, 'usres', 'UserId', 'UserId');
    }

    public function question() {

        return $this->belongsTo(Question::class, 'questions', 'QuestionsID', 'QuestionsID');
    }
}