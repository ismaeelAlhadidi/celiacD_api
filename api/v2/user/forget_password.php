<?php

header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "POST") BadPracticeResponse::toJson([], 0, "", 404);

if(request()->get('UserName') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

$user = App\Models\User::select(['Email'])->where('UserName', request()->get('UserName'))->first();

if(! $user)  BadPracticeResponse::toJson([], 0, "username not found", 200);

BadPracticeResponse::toJson($user->get(), true, "", 200);