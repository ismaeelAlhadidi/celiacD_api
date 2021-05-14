<?php 

header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "POST") BadPracticeResponse::toJson([], 0, "", 404);

$register_request = new App\Requests\RegisterStoreRequest(request()->all());

if($register_request->fail()) {

    BadPracticeResponse::toJson([], 0, "request not valid", 200);
}

$store = App\Models\Store::create($register_request->get());

if(! $store) BadPracticeResponse::toJson([], 0, "error in register", 200);


BadPracticeResponse::toJson([ 'id' => $store->StoretId ], true, "register Successed", 200);