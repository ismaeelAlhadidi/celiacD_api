<?php 

namespace App\Models;

use App\Models\Model;
use App\Models\User;

class Following extends Model {

    protected $table = 'followings';
    protected $primaryKey = 'FollowingId';

    public function patient() {

        return $this->belongsTo(User::class, 'users', 'PatientId', 'UserId');
    }

    public function user() {

        return $this->belongsTo(User::class, 'users', 'UserId', 'UserId');
    }

}