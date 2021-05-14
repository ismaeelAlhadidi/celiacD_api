<?php

namespace App\Requests;

use App\Models\Doctor;

class RegisterDoctorRequest extends RequestForm {


    protected $excepted_data = [
        /*'key' => 'required',*/
        'DoctorId' => 'required',
        'DoctorIdNo' => 'required',
        'Specialization' => 'required',
    ];

    protected $sanitized_keys = [
        /*'excepted__data_key' => 'new_key',*/
    ];

    protected function validate() : bool {
        
        if(! is_string($this->request['DoctorIdNo'])) return false;
        $this->request['DoctorIdNo'] = filter_var($this->request['DoctorIdNo'], FILTER_SANITIZE_STRING);
        if(strlen($this->request['DoctorIdNo']) > 255) return false;
        
        if(! is_string($this->request['Specialization'])) return false;
        $this->request['Specialization'] = filter_var($this->request['Specialization'], FILTER_SANITIZE_STRING);
        if(strlen($this->request['Specialization']) > 255) return false;
        
        if(Doctor::where('DoctorIdNo', $this->request['DoctorIdNo'])->first() != false) {

            return false;
        }

        return true;
    }

    protected function authorized() : bool {

        if(! auth()->check()) return false;
        
        if(auth()->user()->UserType != 2) return false;

        return auth()->id() == $this->request['DoctorId'];
    }
}