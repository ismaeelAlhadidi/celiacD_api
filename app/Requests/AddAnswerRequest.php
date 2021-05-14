<?php

namespace App\Requests;

use App\Models\Question;

class AddAnswerRequest extends RequestForm {


    protected $excepted_data = [
        /*'key' => 'required',*/
        'content' => 'required',
        'qId' => 'required',
        'UserId' => '',
    ];

    protected $sanitized_keys = [
        /*'excepted__data_key' => 'new_key',*/
        'content' => 'Content',
        'qId' => 'QuestionsID',
    ];
 
    protected function validate() : bool {
        
        if(! is_string($this->request['Content'])) return false;
        $this->request['Content'] = filter_var($this->request['Content'], FILTER_SANITIZE_STRING);
        if(strlen($this->request['Content']) > 5000) return false;

        if(! filter_var($this->request['QuestionsID'], FILTER_VALIDATE_INT)) return false;

        if(Question::find($this->request['QuestionsID']) == false) return false;

        return true;
    }

    protected function authorized() : bool {
        
        if(! auth()->check()) return false;

        if(! isset($this->request['UserId'])) $this->request['UserId'] = auth()->id();

        if(auth()->id() != $this->request['UserId']) return false;

        return auth()->user()->UserType == 1 || auth()->user()->UserType == 2;
    }
}