<?php 

namespace App\Middlewares;

//use App\Config\Response;
use \BadPracticeResponse as Response;
use App\Config\DataBase;

class MustBeDoctorOrStore extends Middleware {

    public function handle() : bool {

        if(! auth()) return false;

        if( ! auth()->check() ) return false;

        if(auth()->user()->UserType != 2 && auth()->user()->UserType != 3) return false;
        
        return true;
    }

    public function response() {

        Response::toJson([], 0, "Unauthorized", 200);
        
    }
}