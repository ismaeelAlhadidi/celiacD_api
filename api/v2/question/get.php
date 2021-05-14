<?php

header("Access-Control-Allow-Methods: GET");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "GET") BadPracticeResponse::toJson([], 0, "", 404);

$questions = App\Models\Question::with('user')->orderBy(['Time', 'DESC'])->paginate(10);

if(! $questions) BadPracticeResponse::toJson([], 0, "Failed", 200);

BadPracticeResponse::toJsonWithSanitizeQuestions($questions->items(), true, "", 200, true);