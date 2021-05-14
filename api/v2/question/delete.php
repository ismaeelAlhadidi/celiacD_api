<?php

header("Access-Control-Allow-Methods: DELETE");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "DELETE") BadPracticeResponse::toJson([], 0, "", 404);

if(request()->get('QuestionsID') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if(! filter_var(request()->get('QuestionsID'), FILTER_VALIDATE_INT)) BadPracticeResponse::toJson([], 0, "request not valid", 200);

$question = App\Models\Question::find(request()->get('QuestionsID'));

if(! $question) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if($question->UserId != auth()->id()) BadPracticeResponse::toJson([], 0, "Unauthorized", 200);

if(! $question->delete()) BadPracticeResponse::toJson([], 0, "delete Failed", 200);

BadPracticeResponse::toJson([], true, "delete Successed", 200);