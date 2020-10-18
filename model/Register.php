<?php

namespace model;

class Register {
    
    private static $src = './database/credits.json';
    private static $userKey = "username";
    private static $write = "w";

    public function isShortUsername (string $userName) : bool {
        if(strlen($userName) < 3) {
            return true;
        }

        return false;
    }

    public function isShortPassword (string $passWord) : bool {
        if(strlen($passWord) < 6) {
            return true;
        }

        return false;
    }

    public function isEqual (string $x, string $y) : bool {
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

    public function writeUserToFile(array $data) : void {
        $myfile = fopen(self::$src, self::$write);
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