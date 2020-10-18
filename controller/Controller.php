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

				$this->loginView->isUserNameValid($user);

				$this->loginView->isPassWordValid($user);

				$this->loginView->userAuthorized($user);
					
				$this->loginView->loginUser($user);
				
			} catch (\Exception $e) {
				$this->loginView->setLoginMessage($e->getMessage());
			}
		}

	}

	public function doLogout() {

		if ($this->loginView->userWantsToLogout()) {

			try {

				if($this->loginView->loggedIn()) {
					$this->loginView->generateLogoutMessage();
				}

				$this->loginView->destroySessions();

			} catch (\Exception $e) {
				echo $e->getMessage();
			}
		}
	}

	public function doRegister() {

		if ($this->registerView->userWantsToRegister()) {

			try {
				$user = $this->registerView->getRequestCredits();
				$this->registerView->validateUser($user);
				$this->registerView->saveUser($user);

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