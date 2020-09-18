<?php

// Start session.
// session_start();

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

require_once('model/DateTime.php');
require_once('model/Register.php');
require_once('model/Login.php');
// require_once('model/User.php');

require_once('controller/LoginSystem.php');

class App {

    private $loginView;
    private $registerView;
    private $dateTimeView;
    private $layoutView;
    private $controller;
    private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';

    public function __construct () {
        //CREATE OBJECTS OF THE VIEWS
        $this->loginView = new LoginView(new \model\Login());
        $this->registerView = new RegisterView(new \model\Register());
        $this->dateTimeView = new DateTimeView(new \model\DateTime());
        $this->layoutView = new LayoutView();
        // $this->user = new User();

        $this->controller = new \controller\LoginSystem($this->layoutView, $this->loginView, $this->registerView);
    }

    public function run () {
        $this->changeOfState();
        $this->renderOutput();
    }

    private function changeOfState() {
        $this->controller->doRegister();
        $this->controller->doLogin();
		// $this->storage->saveUser($this->user);
	}

    public function renderOutput() {
        $loggedIn = false;

        if (isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword])) { $loggedIn = true; }

        $this->layoutView->render($loggedIn, $this->loginView, $this->dateTimeView, $this->registerView);
    }

}