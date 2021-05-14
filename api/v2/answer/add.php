<?php

header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "POST") BadPracticeResponse::toJson([], 0, "", 404);

$add_answer_request = new App\Requests\AddAnswerRequest(request()->all());

if($add_answer_request->fail()) {
    
    BadPracticeResponse::toJson([], 0, "request not valid", 200);
}

if(! $answer = App\Models\Answer::create($add_answer_request->get())) BadPracticeResponse::toJson([], 0, "add Failed", 200);

$response_data = BadPracticeResponse::sanitizeAnswer($answer);

BadPracticeResponse::toJson(['answer' => $response_data], true, "Add Successed", 200);