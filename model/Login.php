<?php

namespace model;

require_once('model/User.php');

class Login {

    private static $src = './database/credits.json';
    private static $userKey = "username";
    private static $passKey = "password";
    
    private static $sessionUser = 'sessionUser';
    private static $reloadPage = 'reload';
    
    public function isEmpty (string $userName) : bool {
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

    public function validCredits(array $data, string $userName, string $passWord) : bool {

        foreach ($data as $user) {
            if($user[self::$userKey] == $userName && $user[self::$passKey] == sha1(htmlentities(trim($passWord)))) {
                return true;
            }
        }

        return false;
    }

    public function loggedIn() : bool {
        return isset($_SESSION[self::$sessionUser]);
    }

    public function setLogin(\model\User $user) : bool {
        
        $this->setLoginSession();

        if ($user->getKeepLoggedIn() == 'on') {
            return true;
        }

        return false;

    }

    private function setLoginSession() : void {
        $_SESSION[self::$sessionUser] = true;
    }

    public function destroySessions() : void {

        if(isset($_SESSION)) {

            unset($_SESSION[self::$sessionUser]);
            unset($_SESSION[self::$reloadPage]);
        }
        
        else {
            throw new \Exception("No user to log out.");
        }
    }

    public function reload () : bool {
		if(isset($_SESSION[self::$reloadPage])) {
			return true;
		}
		
		$_SESSION[self::$reloadPage] = false;

		return false;
    }
    
    // TODO: MIGHT WANT TO REMOVE
    public function refreshPage() : void {
        header("Refresh:0");
    }
}