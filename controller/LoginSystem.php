<?php

namespace controller;

class LoginSystem {

	private $layoutView;
	private $registerView;
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

				if ($this->loginView->isUserNameValid($credits[0])) {

					if($this->loginView->isPassWordValid($credits[1])) {
						
						$this->loginView->analyzeCredits($credits[0], $credits[1]);

					}

				}

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