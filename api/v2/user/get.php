<?php

header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../../../core/bootstrap.php';

if(request()->method() != "POST") BadPracticeResponse::toJson([], 0, "", 404);

if(request()->get('id') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

if(request()->get('UserType') == null) BadPracticeResponse::toJson([], 0, "request not valid", 200);

switch(request()->get('UserType')) {
    case '2':
        $selects = ['Location', 'MedicalSchoolName', 'Specialization', 'ClinicName', 'AboutMe'];
        $id_name = 'DoctorId';
        $model = App\Models\Doctor::class;
        break;
    case '3':
        $selects = ['Location', 'WorkingHours', 'AboutMe'];
        $id_name = 'StoretId';
        $model = App\Models\Store::class;
        break;
    default:
        BadPracticeResponse::toJson([], 0, "request not valid", 200);
        break;
}

$profile_data = $model::select($selects)->where($id_name, request()->get('id'))->first();

if(! $profile_data ) BadPracticeResponse::toJson([], 0, "request not valid", 200);

BadPracticeResponse::toJson($profile_data->get(), true, "", 200);