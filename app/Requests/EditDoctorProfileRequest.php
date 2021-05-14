<?php

namespace App\Requests;

use App\Models\User;

class EditDoctorProfileRequest extends RequestForm {


    protected $excepted_data = [
        /*'key' => 'required',*/
        'UserId' => '',
        'PhoneNo' => '',
        'Email' => '',
        'Specialization' => '',
        'Location' => '',
        'AboutMe' => '',
        'ClinicName' => '',
        'MedicalSchoolName' => '',
    ];
 
    protected $sanitized_keys = [
        /*'excepted__data_key' => 'new_key',*/
    ];
    
    protected function validate() : bool {

        $one_at_least_is_set = false;

        if( isset($this->request['PhoneNo']) ) {
            if(! is_string($this->request['PhoneNo'])) return false;
            if(strlen($this->request['PhoneNo']) > 10) return false;

            $one_at_least_is_set = true;
        }

        if( isset($this->request['Email']) ) {
            if(! is_string($this->request['Email'])) return false;
            if(! filter_var($this->request['Email'], FILTER_VALIDATE_EMAIL) ) return false;
            if(strlen($this->request['Email']) > 255) return false;

            $one_at_least_is_set = true;
        }

        if( isset($this->request['Specialization']) ) {
            if(! is_string($this->request['Specialization'])) return false;
            if(strlen($this->request['Specialization']) > 255) return false;

            $one_at_least_is_set = true;
        }

        if( isset($this->request['Location']) ) {
            if(! is_string($this->request['Location'])) return false;
            $this->request['Location'] = filter_var($this->request['Location'], FILTER_SANITIZE_STRING);
            if(strlen($this->request['Location']) > 255) return false;

            $one_at_least_is_set = true;
        }

        if( isset($this->request['AboutMe']) ) {
            if(! is_string($this->request['AboutMe'])) return false;
            $this->request['AboutMe'] = filter_var($this->request['AboutMe'], FILTER_SANITIZE_STRING);

            $one_at_least_is_set = true;
        }

        if( isset($this->request['ClinicName']) ) {
            if(! is_string($this->request['ClinicName'])) return false;
            $this->request['ClinicName'] = filter_var($this->request['ClinicName'], FILTER_SANITIZE_STRING);

            $one_at_least_is_set = true;
        }

        if( isset($this->request['MedicalSchoolName']) ) {
            if(! is_string($this->request['MedicalSchoolName'])) return false;
            $this->request['MedicalSchoolName'] = filter_var($this->request['MedicalSchoolName'], FILTER_SANITIZE_STRING);

            $one_at_least_is_set = true;
        }

        if(! $one_at_least_is_set) return false;

        if( isset($this->request['PhoneNo']) ) {

            if(
                User::where('UserId', '!=', $this->request['UserId'])
                    ->where('PhoneNo', $this->request['PhoneNo'])->first() != false
                ) {

                return false;
            }
        }

        if( isset($this->request['Email']) ) {

            if(
                User::where('UserId', '!=', $this->request['UserId'])
                    ->where('Email', $this->request['Email'])->first() != false
                    ) {

                    return false;
            }
        }

        $user_keys = ['PhoneNo', 'Email'];
        $this->request['user'] = [];
        foreach($user_keys as $user_key) {

            if(! isset($this->request[$user_key]) ) continue;

            $this->request['user'][$user_key] = $this->request[$user_key];

            unset($this->request[$user_key]);
        }

        $this->request['doctor'] = [];
        foreach($this->request as $key => $value) {

            if($key == 'UserId' || $key == 'doctor' || $key == 'user') continue;

            $this->request['doctor'][$key] = $value;

            unset($this->request[$key]);
        }

        return true;
    }

    protected function authorized() : bool {
        
        if(! auth()->check()) return false;

        if(! isset($this->request['UserId'])) $this->request['UserId'] = auth()->id();

        if(auth()->id() != $this->request['UserId']) return false;

        return auth()->user()->UserType == 2;
    }
}