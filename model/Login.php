<?php

namespace model;

// Start session.
session_start();

class Login {

    private static $src = './database/credits.json';
    private static $userKey = "username";
    private static $passKey = "password";


    public function isEmpty ($userName) {
        if(strlen($userName) == 0) {
            return true;
        }

        return false;
    }

    public function readFromJSON() : array {
        $json = file_get_contents(self::$src);
        $json_data = json_decode($json, true);
        
        return $json_data;
    }

    public function validCredits($data, $userName, $passWord) {

        foreach ($data as $user) {
            if($user[self::$userKey] == $userName && $user[self::$passKey] == $passWord) {
                return true;
            }
        }

        return false;
    }

    public function setSession () {
        echo "Då vart du inloggad!";
        // $_SESSION["online"] = "YES";
    }
}