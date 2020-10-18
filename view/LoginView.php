<?php

namespace view;

require_once('model/User.php');


class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $savedLoginName = 'SaveUser';

	public $loginMessage = '';
	public $saveUserAferSubmit = '';

	public $loginModel;

	public function __construct (\model\Login $loginModel) {
		$this->loginModel = $loginModel;
	}

	public function userWantsToLogin() : bool {
		return isset($_POST[self::$name]);
	}

	public function getRequestCredits() : \model\User {

		$user = new \model\User();

		$user->setUsername(trim($_POST[self::$name]));
		$user->setPassword(trim($_POST[self::$password]));

		if (isset( $_POST[self::$keep])) { 

			$user->SetKeepLoggedIn(true);

		} else {
			$user->SetKeepLoggedIn(false);
		}

		return $user;
	}

	public function isUserNameValid(\model\User $user) : void {

		if ($this->loginModel->isEmpty($user->getUsername())) {
			throw new \Exception("Username is missing");
		}

	}

	public function isPassWordValid(\model\User $user) : void {

		$this->saveUserAferSubmit();

		if ($this->loginModel->isEmpty($user->getPassword())) {
			throw new \Exception("Password is missing");
		} 
	}

	public function userAuthorized(\model\User $user) : void {

		$data = $this->loginModel->readFromJSON();

		if(!$this->loginModel->validCredits($data, $user->getUserName(), $user->getPassword())) {
			throw new \Exception("Wrong name or password");
		} 
	}

	// Keep logged in by cookie if true;
	public function loginUser(\model\User $user) : void {
		if($this->loginModel->setLogin($user)) {
			$this->setCookie($user);
		}
	}

	public function setCookie (\model\User $user) : void {

        setcookie(self::$cookieName, $user->getUsername(), time() + 3600, '/');
        setcookie(self::$cookiePassword, $user->getPassword(), time() + 3600, '/');
        
	}
	
	public function setLoginMessage(string $msg) : void {

		$this->loginMessage.= $msg;
	}

	// Returns HTML response.
	public function response() : string {

		if (!$this->loginModel->loggedIn() || $this->loggedInByCookie()) {

			$message = $this->loginMessage;
			$saveUserAferSubmit = $this->saveUserAferSubmit;
			
			$response = $this->generateLoginFormHTML($message);
			
		} else {

			if($this->loginModel->reload()) {
				$message = "";
			} else {
				$message = "Welcome";
			}

			$response = $this->generateLogoutButtonHTML($message);
			
		}

		return $response;
	}

	private function generateLogoutButtonHTML(string $message) : string {

		return '
			<form  method="post" >
				<p class="msg" id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="Logout" id="logout"/>
			</form>
		';
	}
	
	private function generateLoginFormHTML(string $message) : string {
		
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->renderUsernameInput() . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input  class="btn" type="submit" name="' . self::$login . '" value="Login"/>
				</fieldset>
			</form>
		';
	}

	private function renderUsernameInput() {
		
		if(strlen($this->saveUserAferSubmit) > 0) {
			return $this->saveUserAferSubmit;
		}

		return $this->renderSavedUser();
	}

	private function renderSavedUser(): string {
		if (isset($_COOKIE[self::$savedLoginName])) {
			return $_COOKIE[self::$savedLoginName];
		}

		return "";
	}
	
	public function userWantsToLogout() : bool {	
		return isset($_POST[self::$logout]);
	}
	
	public function loggedIn() : bool {
		return $this->loginModel->loggedIn();
	}
	
	public function destroySessions () : void {
		
		$this->loginModel->destroySessions();

		// If user has clicked keep logged in.
		if (isset($_COOKIE[self::$cookieName])) {
			$this->deleteCookies();
		}
	}
	
	public function generateLogoutMessage () : void {
		$this->setLoginMessage("Bye bye!");
	}

	private function saveUserAferSubmit() : void {
		$this->saveUserAferSubmit = $_POST[self::$name];
	}

	private function loggedInByCookie() : bool {
        return isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword]);
	}
	
	private function deleteCookies() : void {
        
        setcookie(self::$cookieName, "", time() - 3600, '/');
        setcookie(self::$cookiePassword, "", time() - 3600, '/');

        $this->loginModel->refreshPage();
    }
}