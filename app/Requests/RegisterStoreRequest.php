<?php

namespace App\Requests;

use App\Models\Store;

class RegisterStoreRequest extends RequestForm {


    protected $excepted_data = [
        /*'key' => 'required',*/
        'UserId' => 'required',
        'StoreName' => 'required',
        'CommercialRegistrationNo' => 'required',
        'StoreType' => 'required'
    ];

    protected $sanitized_keys = [
        /*'excepted__data_key' => 'new_key',*/
        'UserId' => 'StoretId'
    ];

    protected function validate() : bool {

        if(! is_string($this->request['StoreName'])) return false;
        $this->request['StoreName'] = filter_var($this->request['StoreName'], FILTER_SANITIZE_STRING);

        if(! is_string($this->request['StoreType'])) return false;
        $this->request['StoreType'] = filter_var($this->request['StoreType'], FILTER_SANITIZE_STRING);

        if(! is_string($this->request['CommercialRegistrationNo'])) return false;
        $this->request['CommercialRegistrationNo'] = filter_var($this->request['CommercialRegistrationNo'], FILTER_SANITIZE_STRING);
        if(strlen($this->request['CommercialRegistrationNo']) > 255) return false;

        if(Store::where('CommercialRegistrationNo', $this->request['CommercialRegistrationNo'])->first() != false) {

            return false;
        }

        
        return true;
    }

    protected function authorized() : bool {

        if(! auth()->check()) return false;

        if(auth()->user()->UserType != 3) return false;

        return auth()->id() == $this->request['StoretId'];
    }
}