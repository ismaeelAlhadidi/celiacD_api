<?php

header("Access-Control-Allow-Methods: GET");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "GET") BadPracticeResponse::toJson([], 0, "", 404);

if(request()->get('qId') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if(! filter_var(request()->get('qId'), FILTER_VALIDATE_INT)) BadPracticeResponse::toJson([], 0, "request not valid", 200);

use App\Models\Answer;

$answers = Answer::with('user')->where('QuestionsID', request()->get('qId'))->get();

if(! is_array($answers)) BadPracticeResponse::toJson([], 0, "Failed fetch answers", 200);

$response_data = [];

foreach($answers as $answer) {

    if( ! $answer instanceof Answer ) continue;

    array_push($response_data, BadPracticeResponse::sanitizeAnswer($answer));
}

BadPracticeResponse::toJson($response_data, true, "", 200, true);