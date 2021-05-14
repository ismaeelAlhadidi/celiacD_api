<?php 

header("Access-Control-Allow-Methods: GET");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "GET") BadPracticeResponse::toJson([], 0, "", 404);

/* we must use paginator or limit */

$users = App\Models\Store::with('user')->get();

if(! $users) BadPracticeResponse::toJson([], true, "", 200);

$response_data = [];

foreach($users as $user) {

    $transformed_user = $user->get();

    $basic_user_data = $transformed_user['user']->get();

    unset($transformed_user['user']);

    $transformed_user = array_merge($transformed_user, $basic_user_data);

    array_push($response_data, $transformed_user);
}

BadPracticeResponse::toJson($response_data, true, "", 200, true);