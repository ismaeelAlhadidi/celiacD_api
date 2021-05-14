<?php 

namespace App\Models;

use App\Models\Model;
use App\Models\User;
use App\Models\Item;

class Store extends Model {

    protected $table = 'stores';
    protected $primaryKey = 'StoretId';

    public function user() {

        return $this->belongsTo(User::class, 'users', 'UserId', 'StoretId');
    }

    public function items() {

        return $this->hasMany(Item::class, 'items', 'StoredId', 'StoredId');
    }

}