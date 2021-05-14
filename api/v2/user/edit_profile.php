<?php 

header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "POST") BadPracticeResponse::toJson([], 0, "", 404);

$register_request = new App\Requests\EditUserProfileRequest(request()->all());

if($register_request->fail()) {

    BadPracticeResponse::toJson([], 0, "request not valid", 200);
}

if(! auth()->user()->update($register_request->get())) BadPracticeResponse::toJson([], 0, "edit Failed", 200);

BadPracticeResponse::toJson([], true, "edit Successed", 200);
