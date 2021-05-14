<?php

namespace App\Requests;

class AddItemRequest extends RequestForm {
    

    protected $excepted_data = [
        /*'key' => 'required',*/
        'UserId' => 'required',
        'ItemName' => 'required',
        'ItemPrice' => 'required',
        'Description' => '',
        'ItemImg' => '',
    ];

    protected $sanitized_keys = [
        /*'excepted__data_key' => 'new_key',*/
        'UserId' => 'StoretId',
    ];
 
    protected function validate() : bool {

        if(! is_string($this->request['ItemName'])) return false;
        $this->request['ItemName'] = filter_var($this->request['ItemName'], FILTER_SANITIZE_STRING);

        $this->request['ItemPrice'] = floatval($this->request['ItemPrice']);
        if(! filter_var($this->request['ItemPrice'] ,FILTER_VALIDATE_FLOAT)) return false;

        if(isset($this->request['Description'])) {
            if(! is_string($this->request['Description'])) return false;
            $this->request['Description'] = filter_var($this->request['Description'], FILTER_SANITIZE_STRING);
        }

        return true;
    }

    protected function authorized() : bool {

        if(! auth()->check()) return false;

        if(! isset($this->request['StoretId'])) $this->request['StoretId'] = auth()->id();

        if(auth()->id() != $this->request['StoretId']) return false;

        return auth()->user()->UserType == 3;
    }
}
