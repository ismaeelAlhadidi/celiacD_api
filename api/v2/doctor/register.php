<?php 

header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "POST") BadPracticeResponse::toJson([], 0, "", 404);

$register_request = new App\Requests\RegisterDoctorRequest(request()->all());

if($register_request->fail()) {
    
    BadPracticeResponse::toJson([], 0, "request not valid", 200);
}

$doctor = App\Models\Doctor::create($register_request->get());

if(! $doctor) BadPracticeResponse::toJson([], 0, "error in register", 200);


BadPracticeResponse::toJson([ 'id' => $doctor->DoctorId ], true, "register Successed", 200);
