<?php

namespace App\Config;

class Request {

    protected $request = [];

    protected $method = null;

    public function __construct () {

        $this->fetch_request();
    }

    private function fetch_request() {
        
        $this->method = $_SERVER['REQUEST_METHOD'];

        $this->request = $_REQUEST;

        unset($_REQUEST);
    }

    public function get($key) {

        return isset($this->request[$key]) ? $this->request[$key] : null;
    }

    public function only(array $keys) {

        $temp = [];

        foreach($keys as $key) {
            
            if(! isset($this->request[$key])) continue;
            $temp[$key] = $this->request[$key];
        }

        return $temp;
    }

    public function method() {

        return $this->method;
    }

    public function all() {

        return $this->request;
    }
}