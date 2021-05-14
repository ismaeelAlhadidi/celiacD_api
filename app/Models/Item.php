<?php 

namespace App\Models;

use App\Models\Model;
use App\Models\Store;

class Item extends Model {

    protected $table = 'items';
    protected $primaryKey = 'ItemId';

    public function store() {

        return $this->belongsTo(Store::class, 'stores', 'StoretId', 'StoretId');
    }
}