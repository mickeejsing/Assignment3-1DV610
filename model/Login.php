<?php

namespace model;

require_once('model/User.php');

class Login {

    private static $src = './database/credits.json';
    private static $userKey = "username";
    private static $passKey = "password";
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $sessionUser = 'sessionUser';
    
    public $loggedIn;


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

    public function setCookie ($userName, $passWord) {
        $nameCookie1 = self::$cookieName;
        $valueUser = $userName;

        setcookie($nameCookie1, $valueUser, time() + (86400 * 30), "/");

        $nameCookie2 = self::$cookiePassword;
        $valuePassword = $passWord;

        setcookie($nameCookie2, $valuePassword, time() + (86400 * 30), "/");
    }

    public function loggedIn() {
        if($this->loggedIn == true) {
            return true;
        } else if ($this->loggedInByCookie()) {
            return true;
        }
    }

    public function loggedInByCookie() {
        return isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword]);
    }

    public function setLogin($userName, $passWord, $keepLoggedIn) {

        $this->loggedIn = true;
        
        $this->setLoginSession();

        if ($keepLoggedIn == 'on') {
            $this->setCookie($userName, $passWord);
        }

    }

    private function setLoginSession() {
        $_SESSION[self::$sessionUser] = true;
    }
}