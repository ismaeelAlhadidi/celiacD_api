<?php

header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "POST") BadPracticeResponse::toJson([], 0, "", 404);

new App\Middlewares\MustBePatient();

if(request()->get('UserId') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if(request()->get('PatientId') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if(request()->get('RateValue') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if(! filter_var(request()->get('UserId'), FILTER_VALIDATE_INT)) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if(! filter_var(request()->get('PatientId'), FILTER_VALIDATE_INT)) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if(! filter_var(request()->get('RateValue'), FILTER_VALIDATE_FLOAT)) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if(auth()->id() != request()->get('PatientId') || auth()->user()->UserType != 1) BadPracticeResponse::toJson([], 0, "Unauthorized", 200);

$user = App\Models\User::find(request()->get('UserId'));

if(! $user) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if(! $user->UserType == 2 && ! $user->UserType == 3) BadPracticeResponse::toJson([], 0, "request not valid", 200);

use App\Models\Rate;

$rate = Rate::where('UserId', request()->get('UserId'))->where('PatientId', request()->get('PatientId'))->first();

if(! $rate) {

    $rate = Rate::create( request()->only(['UserId', 'PatientId', 'RateValue']) );

    BadPracticeResponse::toJson([], true, "rate added", 200);
}

if( $rate->update([ 'RateValue' => request()->get('RateValue') ]) ) BadPracticeResponse::toJson([], true, "rate added", 200);


BadPracticeResponse::toJson([], 0, "add rate Failed", 200);