<?php

header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "POST") BadPracticeResponse::toJson([], 0, "", 404);

$add_question_request = new App\Requests\AddQuestionRequest(request()->all());

if($add_question_request->fail()) {

    BadPracticeResponse::toJson([], 0, "request not valid", 200);
}

if(! $question = App\Models\Question::create($add_question_request->get())) BadPracticeResponse::toJson([], 0, "add Failed", 200);

$user = $question->user;

if(! $user) BadPracticeResponse::toJson([], 0, "we have error", 200);

$response_data = BadPracticeResponse::sanitizeQuestion($question, $user);

BadPracticeResponse::toJson([ 'Q' => $response_data ], true, "Add OK", 200);