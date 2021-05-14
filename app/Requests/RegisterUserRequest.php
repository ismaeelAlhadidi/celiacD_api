<?php

namespace App\Requests;

use App\Models\User;

class RegisterUserRequest extends RequestForm {


    protected $excepted_data = [
        /*'key' => 'required',*/

        'fname' => 'required',
        'lname' => 'required',
        'username' => 'required',
        'phone' => 'required',
        'email' => 'required',
        'password' => 'required',
        'UserType' => 'required',
        'ProfilePic' => ''
    ];

    protected $sanitized_keys = [
        /*'excepted__data_key' => 'new_key',*/
        'fname' => 'FName',
        'lname' => 'LName',
        'username' => 'UserName',
        'phone' => 'PhoneNo',
        'email' => 'Email',
        'password' => 'Password'
    ];
 
    protected function validate() : bool {

        if(! is_string($this->request['FName'])) return false;
        $this->request['FName'] = filter_var($this->request['FName'], FILTER_SANITIZE_STRING);
        if(strlen($this->request['FName']) > 25) return false;

        if(! is_string($this->request['LName'])) return false;
        $this->request['LName'] = filter_var($this->request['LName'], FILTER_SANITIZE_STRING);
        if(strlen($this->request['LName']) > 25) return false;

        if(! is_string($this->request['UserName'])) return false;
        $this->request['UserName'] = filter_var($this->request['UserName'], FILTER_SANITIZE_STRING);
        if(strlen($this->request['UserName']) > 25) return false;

        if(! is_string($this->request['PhoneNo'])) return false;
        if(strlen($this->request['PhoneNo']) > 10) return false;

        if(! is_string($this->request['Email'])) return false;
        if(! filter_var($this->request['Email'], FILTER_VALIDATE_EMAIL) ) return false;
        if(strlen($this->request['Email']) > 255) return false;

        $this->request['Password'] = password_hash($this->request['Password'], PASSWORD_DEFAULT);
        
        if(! intval($this->request['UserType']) > 3 || intval($this->request['UserType']) < 1) return false;

        if(
            User::where('Email', $this->request['Email'])->orWhere('PhoneNo', $this->request['PhoneNo'])
                ->orWhere('UserName', $this->request['UserName'])->first() != false
            ) {

            return false;
        }

        return true;
    }

    protected function authorized() : bool {


        return true;
    }
}