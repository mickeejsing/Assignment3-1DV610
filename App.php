<?php

session_start();

require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/MailView.php');
require_once('model/DateTime.php');
require_once('model/Register.php');
require_once('model/Login.php');
require_once('model/Mail.php');
require_once('controller/Controller.php');

class App {

    private $loginView;
    private $registerView;
    private $dateTimeView;
    private $layoutView;
    private $controller;
    private $mailView;

    public function __construct () {
        $this->loginView = new \view\LoginView(new \model\Login());
        $this->mailView = new \view\MailView(new \model\Mail());
        $this->registerView = new \view\RegisterView(new \model\Register());
        $this->dateTimeView = new \view\DateTimeView(new \model\DateTime());
        $this->layoutView = new \view\LayoutView();
        
        $this->controller = new \controller\Controller($this->layoutView, $this->loginView, $this->registerView, $this->mailView);
    }

    public function run () {
        $this->changeOfState();
        $this->renderOutput();
    }

    private function changeOfState() {
        $this->controller->doRegister();
        $this->controller->doLogin();
        $this->controller->doMail();
        $this->controller->doLogout();
	}

    public function renderOutput() {
        $this->layoutView->render($this->loginView->loginModel->loggedIn(), $this->loginView, $this->dateTimeView, $this->registerView, $this->mailView);
    }

}