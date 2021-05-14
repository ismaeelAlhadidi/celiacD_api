<?php

header("Access-Control-Allow-Methods: GET");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "GET") BadPracticeResponse::toJson([], 0, "", 404);

new App\Middlewares\MustBePatient();

// if(request()->get('UserId') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

use App\Models\Following;

$followings = Following::where('PatientId', auth()->id())->with('user')->get();

if(! $followings) BadPracticeResponse::toJson([], 0, "Failed fetch followings", 200);

$list = [
    'doctors' => [],
    'stores' => [],
];

foreach($followings as $following) {

    $user = $following->user;

    if(! $user) continue;

    $user_data = $user->get();

    if($user->UserType == 2) {

        $doctor = $user->doctor;

        if(! $doctor) continue;

        $doctor_data = $doctor->get();

        array_push($list['doctors'], array_merge($user_data, $doctor_data));

        continue;
    }

    $store = $user->store;
    
    if(! $store) continue;

    $store_data = $store->get();
    
    array_push($list['stores'], array_merge($user_data, $store_data));
}

BadPracticeResponse::toJson($list, true, "", 200);