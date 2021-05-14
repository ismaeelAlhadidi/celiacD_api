<?php

header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "POST") BadPracticeResponse::toJson([], 0, "", 404);

new App\Middlewares\MustBePatient();

// if(request()->get('UserId') == null) Response::toJson([], 0, "request not valid", 200);

if(request()->get('QuestionsID') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if(! filter_var(request()->get('QuestionsID'), FILTER_VALIDATE_INT)) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if(! $question = App\Models\Question::find(request()->get('QuestionsID'))) BadPracticeResponse::toJson([], 0, "request not valid", 200);

$user_id = $question->UserId;

use App\Models\Favourite;

if(! $favourite = Favourite::where('QuestionsID', request()->get('QuestionsID'))->where('PatientId', auth()->id())->first()) {

    if(Favourite::create( [ 'QuestionsID' => request()->get('QuestionsID'), 'PatientId' => auth()->id(), 'UserId' => $user_id ] ) ) {

        BadPracticeResponse::toJson(['fav' => true], true, "make Favourite Successed", 200);
    }

    BadPracticeResponse::toJson([], 0, "make favourite Failed", 200);
}

if(! $favourite->delete()) BadPracticeResponse::toJson([], 0, "remove Favourite Failed", 200);

BadPracticeResponse::toJson(['fav' => false], true, "remove Favourite Successed", 200);