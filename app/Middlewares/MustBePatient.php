<?php 

namespace App\Middlewares;

//use App\Config\Response;
use \BadPracticeResponse as Response;
use App\Config\DataBase;

class MustBePatient extends Middleware {

    public function handle() : bool {

        if(! auth()) return false;

        if( ! auth()->check() ) return false;

        if(auth()->user()->UserType != 1) return false;
        
        return true;
    }

    public function response() {

        Response::toJson([], 0, "Unauthorized", 200);
        
    }
}