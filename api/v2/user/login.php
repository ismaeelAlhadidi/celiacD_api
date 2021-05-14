<?php

header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "POST") BadPracticeResponse::toJson([], 0, "", 404);

if(request()->get('username') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if(request()->get('password') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if( ! auth()->attempt( request()->only(['username', 'password']) )) {

    BadPracticeResponse::toJson([], 0, "check your username and password", 200);
}

$response = auth()->user()->get();

$response['jwt'] = auth()->get_token();

BadPracticeResponse::toJson($response, true, "login Successed", 200);