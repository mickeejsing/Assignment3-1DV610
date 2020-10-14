<?php

namespace controller;

class LoginSystem {

	private $layoutView;
	private $registerView;
	private $loginView;

	private static $sessionUser = 'sessionUser';

	public function __construct($layoutView, $loginView, $registerView) {
        $this->layoutView = $layoutView;
		$this->registerView = $registerView;
		$this->loginView = $loginView;
	}

	public function doLogin() {

		if ($this->loginView->userWantsToLogin()) {

			try {

				$user = $this->loginView->getRequestUserName();

				if ($this->loginView->isUserNameValid($user->GetName())) {
					

					if($this->loginView->isPassWordValid($user->getPassword())) {

						if($this->loginView->userAuthorized($user)) {
							
							$this->loginView->loginUser($user);

						} 
					} 
				}

			} catch (\Exception $e) {
				//$this->view->setNameWasTooShort();
			}
		}

	}

	public function doLogout() {

		if ($this->loginView->userWantsToLogout() && isset($_SESSION[self::$sessionUser])) {

			try {

				$this->loginView->setLogoutMessage();
				$this->loginView->destroySessions();

			} catch (\Exception $e) {
				//$this->view->setNameWasTooShort();
			}
		}
	}

	public function doRegister() {

		if ($this->registerView->userWantsToRegister()) {

			try {
				$this->registerView->getRequestUserName();
			} catch (\Exception $e) {
				//$this->view->setNameWasTooShort();
			}
		}

	}
}