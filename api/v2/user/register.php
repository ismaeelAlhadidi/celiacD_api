<?php 

header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "POST") BadPracticeResponse::toJson([], 0, "", 404);

$register_request = new App\Requests\RegisterUserRequest(request()->all());

if($register_request->fail()) {

    BadPracticeResponse::toJson([], 0, "request not valid", 200);
}

$user = App\Models\User::create($register_request->get());

if(! $user) BadPracticeResponse::toJson([], 0, "error in register", 200);

BadPracticeResponse::toJson([ 'id' => $user->UserId ], true, "register Successed", 200);
