<?php
// TODO: COOKIES TILL VYN

namespace model;

require_once('model/User.php');

class Login {

    private static $src = './database/credits.json';
    private static $userKey = "username";
    private static $passKey = "password";
    
    private static $sessionUser = 'sessionUser';
    private static $reloadPage = 'reload';
    
    public $loggedIn;


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
        if($this->loggedIn == true) {
            return true;
        }
        
        if (isset($_SESSION[self::$sessionUser])) {
            return true;
        }
        
        return false;
    }

    public function setLogin(\model\User $user) : bool {

        $this->loggedIn = true;
        
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
        unset($_SESSION[self::$sessionUser]);
		unset($_SESSION[self::$reloadPage]);
    }

    public function reload () : bool {
		if(isset($_SESSION[self::$reloadPage])) {
			return true;
		}
		
		$_SESSION[self::$reloadPage] = false;

		return false;
    }
    
    public function setLogoutMessage() : bool {
		return isset($_SESSION[self::$sessionUser]);
    }
    
    // TODO: MIGHT WANT TO REMOVE
    public function refreshPage() : void {
        header("Refresh:0");
    }
}