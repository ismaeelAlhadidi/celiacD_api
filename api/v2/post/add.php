<?php 

header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "POST") BadPracticeResponse::toJson([], 0, "", 404);

$add_post_request = new App\Requests\AddPostRequest(request()->all());

if($add_post_request->fail()) {

    BadPracticeResponse::toJson([], 0, "request not valid", 200);
}

if(! $post = App\Models\Post::create($add_post_request->get())) BadPracticeResponse::toJson([], 0, "add Failed", 200);

BadPracticeResponse::toJson([], true, "add Successed", 200);