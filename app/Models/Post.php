<?php 

namespace App\Models;

use App\Models\Model;
use App\Models\User;

class Post extends Model {

    protected $table = 'posts';
    protected $primaryKey = 'PostID';

    public function doctor() {

        return $this->belongsTo(User::class, 'users', 'UserId', 'UserId');
    }
}