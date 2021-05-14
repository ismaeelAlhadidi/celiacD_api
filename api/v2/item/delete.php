<?php 

header("Access-Control-Allow-Methods: DELETE");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "DELETE") BadPracticeResponse::toJson([], 0, "", 404);

new App\Middlewares\MustBeStore();

if(request()->get('PostId') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

$post = App\Models\Post::where('PostId', request()->get('PostId'))->first();

if($post->UserId != auth()->id()) BadPracticeResponse::toJson([], 0, "Unauthorized", 401);

if(! $post->delete()) return BadPracticeResponse::toJson([], 0, "delete Failed", 200);

BadPracticeResponses::toJson([], true, "delete Successed", 200);