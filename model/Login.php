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

    public function setCookieFunction (\model\User $user) {

        setcookie(self::$cookieName, $user->getUsername(), time() + 3600, '/');
        setcookie($self::$cookiePassword, $user->getPassword(), time() + 3600, '/');
        
    }

    public function loggedIn() {
        if($this->loggedIn == true) {
            return true;
        } else if ($this->loggedInByCookie()) {
            return true;
        } else if (isset($_SESSION[self::$sessionUser])) {
            return true;
        }   
    }

    public function loggedInByCookie() {
        return isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword]);
    }

    public function setLogin(\model\User $user) {

        $this->loggedIn = true;
        
        $this->setLoginSession();

        if ($user->getKeepLoggedIn() == 'on') {
            $this->setCookie($user);
        }

    }

    private function setLoginSession() {
        $_SESSION[self::$sessionUser] = true;
    }

    public function deleteCookies() {
        
        setcookie(self::$cookieName, "", time() - 3600, '/');
        setcookie(self::$cookiePassword, "", time() - 3600, '/');

        header("Refresh:0");
    }
}