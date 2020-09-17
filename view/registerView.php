<?php

class RegisterView {
	private static $message = 'RegisterView::Message';
	private static $userName = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $messageId = 'RegisterView::Message';
	
	public $registrationMessage = '';
	private $registerModel;

	// private static $cookieName = 'LoginView::CookieName';
	// private static $cookiePassword = 'LoginView::CookiePassword';
	// private static $keep = 'LoginView::KeepMeLoggedIn';
	// private static $messageId = 'LoginView::Message';

	public function __construct (\model\Register $registerModel) {
		$this->registerModel = $registerModel;
	}

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		$message = $this->registrationMessage;
		
		$response = $this->generateRegisterFormHTML($message);
		return $response;
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateRegisterFormHTML($message) {
        return '
            <form action="?register" method="post" enctype="multipart/form-data">
                <fieldset>
                <legend>Register a new user - Write username and password</legend>
                    <p id="' . self::$message . '">' . $message . '</p>
                    <label for="RegisterView::UserName" >Username :</label>
                    <input type="text" size="20" name="RegisterView::UserName" id="RegisterView::UserName" value="" />
                    <br/>
                    <label for="RegisterView::Password" >Password  :</label>
                    <input type="password" size="20" name="RegisterView::Password" id="RegisterView::Password" value="" />
                    <br/>
                    <label for="RegisterView::PasswordRepeat" >Repeat password  :</label>
                    <input type="password" size="20" name="RegisterView::PasswordRepeat" id="RegisterView::PasswordRepeat" value="" />
                    <br/>
                    <input id="submit" type="submit" name="DoRegistration"  value="Register" />
                    <br/>
                </fieldset>
            </form>
		';
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	public function getRequestUserName() {
		//RETURN REQUEST VARIABLE: USERNAME
		
		// $credits['userName'] = $_POST[self::$userName];
		// $credits['passWord1'] = $_POST[self::$password];
		// $credits['passWord2'] = $_POST[self::$passwordRepeat];

		if ($this->registerModel->isShortUsername($_POST[self::$userName])) {
			$this->setRegistrationMessage("Username has too few characters, at least 3 characters.<br>");
		}

		if ($this->registerModel->isShortPassword($_POST[self::$password])) {
			$this->setRegistrationMessage("Password has too few characters, at least 6 characters.<br>");
		}
		
	}

	public function userWantsToRegister() {
		if(isset($_POST[self::$userName])) {
			return true;
		}
	}
	
	public function setRegistrationMessage($msg) {
		$this->registrationMessage.= $msg;
	}
	
}