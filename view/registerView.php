<?php

class RegisterView {
	private static $userName = "RegisterView::UserName";
	private static $passWord = "RegisterView::Password";
	private static $passWordRepeat = "RegisterView::PasswordRepeat";

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		$message = '';
		
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
		<h2>Register new user</h2>
		<form action="?register" method="post">
			<fieldset>
			<legend>Register a new user - Write username and password</legend>
				<p id="RegisterView::Message"></p>
				<label for="RegisterView::UserName" >Username :</label>
				<input type="text" size="20" name="RegisterView::UserName" id="RegisterView::UserName" value="">
				<br>
				<label for="RegisterView::Password" >Password  :</label>
				<input type="password" size="20" name="RegisterView::Password" id="RegisterView::Password" value="">
				<br>
				<label for="RegisterView::PasswordRepeat" >Repeat password  :</label>
				<input type="password" size="20" name="RegisterView::PasswordRepeat" id="RegisterView::PasswordRepeat" value="">
				<br>
				<input id="submit" type="submit" name="DoRegistration"  value="Register">
				<br>
			</fieldset>
		</form>
		';
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	public function getRequestUserName() {
		$uN = $_POST[self::$userName];
		$pW1 = $_POST[self::$passWord];
		$pW2 = $_POST[self::$passWordRepeat];

		echo $uN . ' ' . $pW1 . ' ' . $pW2;
	}
	
}