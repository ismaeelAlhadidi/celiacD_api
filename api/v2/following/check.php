<?php

header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "POST") BadPracticeResponse::toJson([], 0, "", 404);

new App\Middlewares\MustBePatient();

if(request()->get('UserId') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

// if(request()->get('PatientId') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if(! filter_var(request()->get('UserId'), FILTER_VALIDATE_INT)) BadPracticeResponse::toJson([], 0, "request not valid", 200);

// if(! filter_var(request()->get('PatientId'), FILTER_VALIDATE_INT)) BadPracticeResponse::toJson([], 0, "request not valid", 200);

use App\Models\Following;

$follow = Following::where('UserId', request()->get('UserId'))->where('PatientId', auth()->id())->first();

if( ! $follow ) BadPracticeResponse::toJson(['follow' => false], true, "", 200);

BadPracticeResponse::toJson(['follow' => true], true, "", 200);