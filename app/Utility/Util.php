<?php
namespace App\Utility;
class Util{

    public static function random_alpha($length) {
        $key = '';
        $keys = array_merge(range('A', 'Z'));
    
       for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
    
       return $key;
    }

    private static $instance = null;

    public static function getInstance(){
        if(self::$instance == null){
            return self::$instance = new Util();//if instance is null make it the instance of the class
        }
        return self::$instance;
    }

    /**
    *@params key : string
    *@params value : string
    *@method returns boolean.
    * method create a session.
    */
    public function makeSession($key, $value = null){
        //the serialized function converts the actual session data into a format that is storable in the computer.

        if(!isset($_SESSION[$key])){
            if($key!= null && $value!= null){
                $_SESSION[$key] = serialize($value); // if the value of the session is provided then save the session.

            }elseif($key == null && $value == null && isset($_SESSION[$key])){
                    return unserialize($_SESSION[$key]); // if no value is provided and session is set then get back the session.

            }elseif(isset($_SESSION[$key])){
                return unserialize($_SESSION[$key]);

            }else{
                return false;
            }
        }
    }

    /**
    *@param key: string
    *@param value : string
    *@method returns session_value
    * method starts a session and assigns a value to the session
    */
    public function startSession($key, $value){
        //session_start();
        return $_SESSION[$key] = $value;
    }

    public function isLoggedIn(){
        return $this->makeSession('loggedin');
    }

    public  function destorySession($key, $value){
        unset($_SESSION[$key]);
        $_SESSION[$key] = null;
        session_destroy();
    }

    public function session($key){
         $this->isLoggedIn();
        $value = $_SESSION[$key];
        return unserialize($value);
    }

    public static function generateID(){
        if ( function_exists( 'com_create_guid' ) === true ) {
        return trim( com_create_guid(), '{}' );
        }
    return sprintf( '%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand( 0, 65535 ), mt_rand( 0, 65535 ), mt_rand( 0, 65535 ), mt_rand( 16384, 20479 ), mt_rand( 32768, 49151 ), mt_rand( 0, 65535 ), mt_rand( 0, 65535 ), mt_rand( 0, 65535 ) );

     }


}