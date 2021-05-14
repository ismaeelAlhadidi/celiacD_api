<?php 

header("Access-Control-Allow-Methods: DELETE");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "DELETE") BadPracticeResponse::toJson([], 0, "", 404);

new App\Middlewares\MustBeDoctorOrStore();

if(request()->get('PostID') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if(! filter_var(request()->get('PostID'), FILTER_VALIDATE_INT)) BadPracticeResponse::toJson([], 0, "request not valid", 200);

$post = App\Models\Post::where('PostID', request()->get('PostID'))->first();

if(! $post) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if($post->UserId != auth()->id()) BadPracticeResponse::toJson([], 0, "Unauthorized", 200);

if(! $post->delete()) BadPracticeResponse::toJson([], 0, "delete Failed", 200);

BadPracticeResponse::toJson([], true, "delete Successed", 200);

