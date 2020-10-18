<?php

namespace controller;

class Controller {

	private $layoutView;
	private $registerView;
	private $loginView;
	private $mailView;

	private static $sessionUser = 'sessionUser';

	public function __construct(\view\LayoutView $layoutView, \view\LoginView $loginView, \view\RegisterView $registerView, \view\MailView $mailView) {
        $this->layoutView = $layoutView;
		$this->registerView = $registerView;
		$this->loginView = $loginView;
		$this->mailView = $mailView;
	}

	public function doLogin() {

		if ($this->loginView->userWantsToLogin()) {

			try {

				$user = $this->loginView->getRequestCredits();

				if ($this->loginView->isUserNameValid($user->getUsername())) {

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
				$user = $this->registerView->getRequestCredits();
				$this->registerView->validateUser($user);

				$this->registerView->registerModel->saveUser($user);

			} catch (\Exception $e) {
				$this->registerView->setRegistrationMessage($e->getMessage());
			}
		}

	}

	public function doMail() {
		if ($this->mailView->wantsToSendMail()) {

			try {
				$mailData = $this->mailView->verifyCredits();

				if($mailData->morse) {
					$mailData->msg = $this->mailView->stringToMorse($mailData->msg);
				}

				if($this->mailView->formatAndSend($mailData)) {
					$this->mailView->setSuccessMessage();
				}
				
			} catch (\Exception $e) {
				$this->mailView->setErrorMessage($e->getMessage());
			}
		}
	}
}