<?php

header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "POST") BadPracticeResponse::toJson([], 0, "", 404);

new App\Middlewares\MustBePatient();

if(request()->get('UserId') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

// if(request()->get('PatientId') == null) Response::toJson([], 0, "request not valid", 200);

if(! filter_var(request()->get('UserId'), FILTER_VALIDATE_INT)) BadPracticeResponse::toJson([], 0, "request not valid", 200);

$user = App\Models\User::select(['UserType'])->where('UserId', request()->get('UserId'))->first();

if(! $user) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if($user->UserType != 2 && $user->UserType != 3) BadPracticeResponse::toJson([], 0, "request not valid", 200);

use App\Models\Following;

if(! $follow = Following::where('UserId', request()->get('UserId'))->where('PatientId', auth()->id())->first()) {

    if( Following::create( [ 'UserId' => request()->get('UserId'), 'PatientId' => auth()->id() ] ) ) {

        BadPracticeResponse::toJson(['follow' => true], true, "make follow Successed", 200);
    }

    BadPracticeResponse::toJson([], 0, "make follow Failed", 200);
}

if(! $follow->delete()) BadPracticeResponse::toJson([], 0, "remove follow Failed", 200);

BadPracticeResponse::toJson(['follow' => false], true, "remove follow Successed", 200);

