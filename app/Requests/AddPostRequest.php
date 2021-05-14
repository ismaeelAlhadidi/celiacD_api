<?php

namespace App\Requests;

class AddPostRequest extends RequestForm {


    protected $excepted_data = [
        /*'key' => 'required',*/
        'UserId' => '',
        'PostContent' => 'required',
        'PostDate' => 'required',
        'PostType' => 'required',
        'PostImage' => ''
    ];

    protected $sanitized_keys = [
        /*'excepted__data_key' => 'new_key',*/

    ];
 
    protected function validate() : bool {

        if(! is_string($this->request['PostContent'])) return false;
        $this->request['PostContent'] = filter_var($this->request['PostContent'], FILTER_SANITIZE_STRING);
        if(strlen($this->request['PostContent']) > 255) return false;

        if(! is_string($this->request['PostType'])) return false;
        $this->request['PostType'] = filter_var($this->request['PostType'], FILTER_SANITIZE_STRING);

        if(! is_string($this->request['PostDate'])) return false;
        
        return true;
    }

    protected function authorized() : bool {
        
        if(! auth()->check()) return false;

        if(! isset($this->request['UserId'])) $this->request['UserId'] = auth()->id();

        if(auth()->id() != $this->request['UserId']) return false;

        return auth()->user()->UserType == 2 || auth()->user()->UserType == 3;
    }
}