<?php 

namespace App\Models;

use App\Authentecation\AuthModel;
use App\Models\Doctor;
use App\Models\Store;
use App\Models\Following;
use App\Models\Rate;
use App\Models\Question;
use App\Models\Favourite;
use App\Models\Answer;

class User extends AuthModel {

    protected $table = 'users';
    protected $primaryKey = 'UserId';

    protected $hidden = ['Password'];

    protected static $handler = 'username';
    protected static $password = 'password';
    protected static $password_column_name = 'Password';

    public function doctor() {

        return $this->hasOne(Doctor::class, 'doctors', 'UserId', 'DoctorId');
    }

    public function store() {

        return $this->hasOne(Store::class, 'stores', 'UserId', 'StoretId');
    }

    public function followings() {
        
        return $this->hasMany(Following::class, 'followings', 'PatientId', 'UserId');
    }

    public function followers() {

        return $this->hasMany(Following::class, 'followings', 'UserId', 'UserId');
    }

    public function rating() {
        
        return $this->hasMany(Rate::class, 'rates', 'PatientId', 'UserId');
    }

    public function rates() {

        return $this->hasMany(Rate::class, 'rates', 'UserId', 'UserId');
    }

    public function questions() {

        return $this->hasMany(Question::class, 'questions', 'UserId', 'UserId');
    }

    public function favourites() {

        return $this->hasMany(Favourite::class, 'favourites', 'PatientId', 'UserId');
    }

    public function answers() {

        return $this->hasMany(Answer::class, 'answers', 'UserId', 'UserId');
    }

    // for copy
    public function likes() {

        return $this->morphTo(Like::class, 'likes_for_test_relationships', 'component_id', 'component_type', 'id');
    }


}