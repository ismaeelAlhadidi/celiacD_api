<?php

header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "POST") BadPracticeResponse::toJson([], 0, "", 404);

if(request()->get('Email') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if(request()->get('Password') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

// if(request()->get('Key') == null) Response::toJson([], 0, "request not valid", 200);

use App\Models\User;

$user = User::where('Email', request()->get('Email'))->first();

if(! $user) BadPracticeResponse::toJson([], 0, "email not registered", 200);

if(! $user)  BadPracticeResponse::toJson([], 0, "user not found", 200);

// check key from limited session || check if current user is auth || ( both )

if( ! $user->change_password( request()->get('Password') ) ) BadPracticeResponse::toJson([], 0, "change password failed", 200);

BadPracticeResponse::toJson([], true, "change password Successed", 200);