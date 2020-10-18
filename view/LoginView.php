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

	private static $sessionUser = 'sessionUser';
	private static $reloadPage = 'reload';

	public $loginMessage = '';
	public $saveUserAferSubmit = '';

	public $loginModel;

	public function __construct (\model\Login $loginModel) {
		$this->loginModel = $loginModel;
	}

	// Returns HTML response.
	public function response() : string {

		if (!$this->loginModel->loggedIn()) {

			$message = $this->loginMessage;
			$saveUserAferSubmit = $this->saveUserAferSubmit;
			
			$response = $this->generateLoginFormHTML($message);
			
		} else {

			if($this->reload()) {
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
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->saveUserAferSubmit . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="Login" id="btn"/>
				</fieldset>
			</form>
		';
	}
	
	public function getRequestCredits() : \model\User {

		$user = new \model\User();

		$user->setUsername(trim($_POST[self::$name]));
		$user->setPassword(trim($_POST[self::$password]));

		if (isset( $_POST[self::$keep])) { 

			$user->SetKeepLoggedIn($_POST[self::$keep]);

		} else {
			$user->SetKeepLoggedIn(false);
		}

		return $user;
	}

	public function isUserNameValid(string $userName) : bool {

		if ($this->loginModel->isEmpty($userName)) {

			$this->setLoginMessage("Username is missing");

			return false;

		}

		return true;
	}

	public function isPassWordValid(string $password) : bool {

		$this->saveUserAferSubmit();

		if ($this->loginModel->isEmpty($password)) {

			$this->setLoginMessage("Password is missing");

			return false;

		} 

		return true;
	}

	public function userWantsToLogin() : bool {
		return isset($_POST[self::$name]);
	}

	public function userWantsToLogout() : bool {
		return isset($_POST[self::$logout]);
	}
	
	public function setLoginMessage(string $msg) : void {

		$this->loginMessage.= $msg;
	}

	private function saveUserAferSubmit() : void {
		$this->saveUserAferSubmit = $_POST[self::$name];
	}

	public function userAuthorized(\model\User $user) : bool {

		$data = $this->loginModel->readFromJSON();

		if($this->loginModel->validCredits($data, $user->getUserName(), $user->getPassword())) {
			return true;
		} 

		$this->setLoginMessage("Wrong name or password");
		return false;
	}

	public function loginUser(\model\User $user) : void {
		$this->loginModel->setLogin($user);
	}

	public function setLogoutMessage() : void {
		
		if (isset($_SESSION[self::$sessionUser])) {
			$this->setLoginMessage("Bye bye!");
		}
	}

	public function destroySessions () : void {
		unset($_SESSION[self::$sessionUser]);
		unset($_SESSION[self::$reloadPage]);

		if (isset($_COOKIE[self::$cookieName])) {
			$this->loginModel->deleteCookies();
		}
	}

	public function reload () : bool {
		if(isset($_SESSION[self::$reloadPage])) {
			return true;
		}
		
		$_SESSION[self::$reloadPage] = false;

		return false;
	}
}