<?php

header("Access-Control-Allow-Methods: DELETE");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "DELETE") BadPracticeResponse::toJson([], 0, "", 404);

if(request()->get('AnswerId') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if(! filter_var(request()->get('AnswerId'), FILTER_VALIDATE_INT)) BadPracticeResponse::toJson([], 0, "request not valid", 200);

$answer = App\Models\Answer::find(request()->get('AnswerId'));

if(! $answer) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if($answer->UserId != auth()->id()) BadPracticeResponse::toJson([], 0, "Unauthorized", 200);

if(! $answer->delete()) BadPracticeResponse::toJson([], 0, "delete Failed", 200);

BadPracticeResponse::toJson([], true, "delete Successed", 200);