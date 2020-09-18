<?php

namespace controller;

class LoginSystem {

	private $layoutView;
	// private $registerView;
	private $loginView;
	// private $user;

	public function __construct($layoutView, $loginView, $registerView) {
        $this->layoutView = $layoutView;
		
		$this->registerView = $registerView;
		$this->loginView = $loginView;
	}

	public function doLogin() {

		if ($this->loginView->userWantsToLogin()) {
			try {

				$credits = $this->loginView->getRequestUserName();
				$this->loginView->handleInputFromForm($credits);

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