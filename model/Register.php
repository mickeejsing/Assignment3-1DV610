<?php

namespace model;

class Register {
    
    private static $src = './database/credits.json';
    private static $userKey = "username";

    public function isShortUsername ($userName) {
        if(strlen($userName) < 3) {
            return true;
        }

        return false;
    }

    public function isShortPassword ($passWord) {
        if(strlen($passWord) < 6) {
            return true;
        }

        return false;
    }

    public function isEqual ($x, $y) {
        if($x == $y) {
            return true;
        }

        return false;
    }

    public function saveUser(\model\User $user) : void {

        $obj = new \stdClass();
        $obj->username = htmlentities(trim($user->getUsername()));
        $obj->password = sha1(htmlentities(trim($user->getPassword())));

        $json = file_get_contents(self::$src);
        $data = json_decode($json, true);

        array_push($data, $obj);

        $this->writeUserToFile($data);
    }

    public function writeUserToFile($data) {
        $myfile = fopen(self::$src, "w");
        fwrite($myfile, Json_encode($data));
        fclose($myfile);
    }

    public function userUnique(string $username) : bool {

        $json = file_get_contents(self::$src);
        $json_data = json_decode($json, true);

        foreach($json_data as $user) {
            if($username == $user[self::$userKey]) {
                return false;
            }
        }

        return true;
    }
}