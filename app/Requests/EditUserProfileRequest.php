<?php

namespace App\Requests;

use App\Models\User;

class EditUserProfileRequest extends RequestForm {


    protected $excepted_data = [
        /*'key' => 'required',*/
        'UserId' => '',
        'PhoneNo' => '',
        'Email' => '',
    ];
 
    protected $sanitized_keys = [
        /*'excepted__data_key' => 'new_key',*/
    ];
    
    protected function validate() : bool {
        
        if( isset($this->request['PhoneNo']) ) {
            if(! is_string($this->request['PhoneNo'])) return false;
            if(strlen($this->request['PhoneNo']) > 10) return false;
        }

        if( isset($this->request['Email']) ) {
            if(! is_string($this->request['Email'])) return false;
            if(! filter_var($this->request['Email'], FILTER_VALIDATE_EMAIL) ) return false;
            if(strlen($this->request['Email']) > 255) return false;
        }

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

        return isset($this->request['PhoneNo']) || isset($this->request['Email']);
    }

    protected function authorized() : bool {

        if(! auth()->check()) return false;

        if(! isset($this->request['UserId'])) $this->request['UserId'] = auth()->id();

        return auth()->id() == $this->request['UserId'];
    }
}