<?php 

header("Access-Control-Allow-Methods: GET");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "GET") BadPracticeResponse::toJson([], 0, "", 404);

if(request()->get('UserId') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if(! filter_var(request()->get('UserId'), FILTER_VALIDATE_INT)) BadPracticeResponse::toJson([], 0, "request not valid", 200);

$posts = App\Models\Post::select(['PostContent', 'PostImage', 'PostId'])->where('UserId', request()->get('UserId'))->get();

if(! $posts) BadPracticeResponse::toJson([], 0, "error", 200);

$response_data = [];
foreach($posts as $post) {

    $post->Content = $post->PostContent;

    unset($post['PostContent']);

    array_push($response_data, $post->get());
}

BadPracticeResponse::toJson($response_data, true, "", 200, true);

