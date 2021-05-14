<?php 

header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "POST") BadPracticeResponse::toJson([], 0, "", 404);

$add_item_request = new App\Requests\AddItemRequest(request()->all());

if($add_item_request->fail()) {

    BadPracticeResponse::toJson([], 0, "request not valid", 200);
}

if(! $item = App\Models\Item::create($add_item_request)) BadPracticeResponse::toJson([], 0, "add Failed", 200);

BadPracticeResponse::toJson($item->get(), true, "add Successed", 200);