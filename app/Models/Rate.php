<?php 

namespace App\Models;

use App\Models\Model;
use App\Models\User;

class Rate extends Model {

    protected $table = 'rates';
    protected $primaryKey = 'RateId';

    public function patient() {

        return $this->belongsTo(User::class, 'users', 'PatientId', 'UserId');
    }

    public function user() {

        return $this->belongsTo(User::class, 'usres', 'UserId', 'UserId');
    }
}