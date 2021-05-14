<?php 

namespace App\Models;

use App\Models\Model;
use App\Models\User;
use App\Models\Post;

class Doctor extends Model {

    protected $table = 'doctors';
    protected $primaryKey = 'DoctorId';

    public function user() {

        return $this->belongsTo(User::class, 'users', 'UserId', 'DoctorId');
    }

    public function posts() {

        return $this->hasMany(Post::class, 'posts', 'DoctorId', 'DoctorId');
    }
}