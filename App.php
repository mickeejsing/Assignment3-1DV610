<?php

    //INCLUDE THE FILES NEEDED...
    require_once('view/LoginView.php');
    require_once('view/RegisterView.php');
    require_once('view/DateTimeView.php');
    require_once('view/LayoutView.php');

    require_once('model/DateTime.php');
    require_once('model/Register.php');
    require_once('model/Login.php');

    require_once('controller/LoginSystem.php');

class App {

    private $loginView;
    private $registerView;
    private $dtv;
    private $lv;
    private $controller;

    public function __construct () {
        //CREATE OBJECTS OF THE VIEWS
        $this->loginView = new LoginView(new \model\Login());
        $this->registerView = new RegisterView(new \model\Register());
        $this->dateTimeView = new DateTimeView(new \model\DateTime());
        $this->layoutView = new LayoutView();

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
        $this->layoutView->render(false, $this->loginView, $this->dateTimeView, $this->registerView);
    }

}