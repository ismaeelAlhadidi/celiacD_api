<?php 

header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "POST") BadPracticeResponse::toJson([], 0, "", 404);

$edit_profile_request = new App\Requests\EditDoctorProfileRequest(request()->all());

if($edit_profile_request->fail()) {

    BadPracticeResponse::toJson([], 0, "request not valid", 200);
}

$validated_request = $edit_profile_request->get();

if(! isset($validated_request['user']) || ! is_array($validated_request['user']) ) {

    BadPracticeResponse::toJson([], 0, "request not valid", 200);
}

if(! isset($validated_request['doctor']) || ! is_array($validated_request['doctor']) ) {
    
    BadPracticeResponse::toJson([], 0, "request not valid", 200);
}

if( count($validated_request['user']) > 0 ) {

    if(! auth()->user()->update($validated_request['user'])) BadPracticeResponse::toJson([], 0, "edit Failed", 200);
}

if( count($validated_request['doctor']) > 0 ) {
    
    if(! auth()->user()->doctor->update($validated_request['doctor'])) BadPracticeResponse::toJson([], 0, "edit Failed", 200);
}

BadPracticeResponse::toJson([], true, "edit Successed", 200);