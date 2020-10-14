<?php

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

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {

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

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message) {
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
					
					<input type="submit" name="' . self::$login . '" value="login" />
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

	public function isUserNameValid($userName) {

		if ($this->loginModel->isEmpty($userName)) {

			$this->setLoginMessage("Username is missing");

			return false;

		}

		return true;
	}

	public function isPassWordValid($password) {

		$this->saveUserAferSubmit();

		if ($this->loginModel->isEmpty($password)) {

			$this->setLoginMessage("Password is missing");

			return false;

		} 

		return true;
	}

	public function userWantsToLogin() {
		if(isset($_POST[self::$name])) {
			return true;
		}
	}

	public function userWantsToLogout() {
		if(isset($_POST[self::$logout])) {
			return true;
		}
	}
	
	public function setLoginMessage($msg) {
		$this->loginMessage.= $msg;
	}

	private function saveUserAferSubmit() {
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

	public function loginUser(\model\User $user) {
		$this->loginModel->setLogin($user);
	}

	public function setLogoutMessage() {
		
		if (isset($_SESSION[self::$sessionUser])) {
			$this->setLoginMessage("Bye bye!");
		}
	}

	public function destroySessions () {
		unset($_SESSION[self::$sessionUser]);
		unset($_SESSION[self::$reloadPage]);

		if (isset($_COOKIE[self::$cookieName])) {
			$this->loginModel->deleteCookies();
		}
	}

	public function reload () {
		if(isset($_SESSION[self::$reloadPage])) {
			return true;
		}
		
		$_SESSION[self::$reloadPage] = false;

		return false;
	}
}