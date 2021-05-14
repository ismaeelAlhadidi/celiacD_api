<?php

namespace App\Authentecation;

use App\Models\User;
use App\Models\Doctor;
use App\Exceptions\GuardNotFoundException;
use \Firebase\JWT\JWT;
use App\Config\Database;

class Auth {

    /*
    protected static $guards = [
        // 'guard name' => 'model',
        'doctor' => Doctor::class,
    ];

    protected $guard;

    */
    protected static $key = "your-long-and-hidden-secret-key";

    protected static $token_time_out = ( 7 * 24 * 60 * 60 ); // one week

    protected static $default_guard = User::class;

    protected static $token = null;

    protected static $user = null;

    protected static $authenticated = false;

    protected static $primary_key = 'UserId';
    protected static $handler = 'username';
    protected static $password = 'password';

    public function __construct() {

        //Firebase\JWT\JWT::$leeway = 5;

        $this->set_authorization_token();
    }

    /*
    public function __construct(string $guard) {

        if( ! array_key_exists($guard, static::$guards) ) {

            throw new GuardNotFoundException($guard . ' not found in guards list');
        }

        $this->guard = static::$guards[$guard];

    }

    public function guard(string $guard = null) {

        if($guard == null) {

            throw new \InvalidArgumentException('you must select guard');
        }

        $auth = new static($guard);
        
        return $auth;
    }
    */

    public function get_token() {

        return static::$token;
    }

    public function attempt($request) {

        if(! is_array($request)) return false;
        
        if(! isset($request[static::$handler])) return false;

        if(! isset($request[static::$password])) return false;

        $user = static::$default_guard::attempt($request);
        
        if(! $user) return false;

        return static::login($user);
    }

    public function login(User $user) {

        static::$authenticated = true;

        static::$user = $user;

        static::$token = static::generator_token($user);

        return true;
    }

    public function logout() {

        static::$authenticated = false;

        static::$user = null;

        static::$token = null;
        
    }

    public function check() {

        return static::$authenticated;
    }


    public function user() {

        return static::$user;
    }

    public function id() {
        
        return ( static::check() ? static::$user[static::$primary_key] : null );
    }

    private function set_authorization_token() {

        if(! isset($_SERVER['HTTP_AUTHORIZATION'])) return false;

        $auth_header = $_SERVER['HTTP_AUTHORIZATION'];

        $temp = explode(" ", $auth_header);

        $jwt = $temp[1];

        if(! $jwt) {

            static::$authenticated = false;
            static::$token = null;
            static::$user = null;

            return false;
        }

        try {

            $decoded_token = JWT::decode($jwt, static::$key, array('HS256'));

            $decoded_token = ( array ) $decoded_token;

            if(! isset($decoded_token['id'])) return false;

            $user_id = $decoded_token['id'];

            $user = static::$default_guard::find($user_id);

            if(! $user) return false;

            static::$authenticated = true;
            static::$token = $jwt;
            static::$user = $user;
        
        } catch (Exception $e) {

            return false;
        }

        return true;
    }

    private function generator_token(User $user) {

        $time = time();

        $payload = [
            'iat' => $time,
            'exp' => $time + static::$token_time_out,

            'id' => $user->get()[static::$primary_key]
        ];

        $token = JWT::encode($payload, static::$key);

        return $token;
    }
}