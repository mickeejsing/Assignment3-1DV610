<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

require_once('model/DateTime.php');

require_once('controller/Router.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$loginView = new LoginView();
$registerView = new RegisterView();
$dtv = new DateTimeView(new \model\DateTime());
$lv = new LayoutView();

$lv->render(false, $loginView, $dtv, $registerView);

$router = new \controller\Router();
$router->route($registerView);