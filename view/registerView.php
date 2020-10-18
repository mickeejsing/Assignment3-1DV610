<?php

namespace view;

class RegisterView {
	private static $message = 'RegisterView::Message';
	private static $userName = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $messageId = 'RegisterView::Message';
	
	public $registrationMessage = '';
	public $registerModel;

	public function __construct (\model\Register $registerModel) {
		$this->registerModel = $registerModel;
	}

	public function response() {
		$message = $this->registrationMessage;
		
		$response = $this->generateRegisterFormHTML($message);
		return $response;
	}
	
	private function generateRegisterFormHTML(string $message) {
        return '
		<form action="?register" method="post" enctype="multipart/form-data">
			<fieldset>
			<legend>Register a new user - Write username and password</legend>
				<p id="RegisterView::Message">' . $message . '</p>
				<label for="RegisterView::UserName" >Username :</label>
				<input type="text" size="20" name="RegisterView::UserName" id="RegisterView::UserName" value="' . $this->writeValue(self::$userName) . '" />
				<br/>
				<label for="RegisterView::Password" >Password  :</label>
				<input type="password" size="20" name="RegisterView::Password" id="RegisterView::Password" value="' . $this->writeValue(self::$password) . '" />
				<br/>
				<label for="RegisterView::PasswordRepeat" >Repeat password  :</label>
				<input type="password" size="20" name="RegisterView::PasswordRepeat" id="RegisterView::PasswordRepeat" value="' . $this->writeValue(self::$passwordRepeat) . '" />
				<br/>
				<input id="RegisterView::Register" type="submit" name="RegisterView::Register" value="Register">
				<br/>
			</fieldset>
		</form>
		';
	}
	
	public function getRequestCredits() : \model\User {

		$user = new \model\User();

		$user->setUserName($_POST[self::$userName]);
		$user->setPassword($_POST[self::$password]);
		$user->setPasswordRepeat($_POST[self::$passwordRepeat]);

		return $user;
	}

	public function validateUser(\model\User $user) : \model\User {

		$errorMessage = "";

		if ($this->registerModel->isShortUsername($user->getUsername())) {
			$errorMessage.= "Username has too few characters, at least 3 characters.<br>";
		}

		if ($this->registerModel->isShortPassword($user->getPassword())) {
			$errorMessage.= "Password has too few characters, at least 6 characters.<br>"; 
		}
		
		if(!$this->registerModel->isEqual($user->getPassword(), $user->getPasswordRepeat())) {
			$errorMessage.= "Passwords do not match.<br>";
		}

		if(!$this->registerModel->userUnique($user->getUsername())) {
			$errorMessage.= "User exists, pick another username.<br>";
		}

		if(strlen($errorMessage) > 0) {
			throw new \Exception($errorMessage);
		}

		return $user;
	}

	public function userWantsToRegister() : bool {
		return isset($_POST[self::$userName]);
	}
	
	public function setRegistrationMessage($msg) : void {
		$this->registrationMessage.= $msg;
	}

	public function writeValue($value) : string {
		
		if(isset($_POST[$value])) {
			return $_POST[$value];
		}

		return "";
	}
	
}