<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

require_once('controller/Authorization.php');

require_once('model/Time.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// * Ser till att rätt saker händer när användaren gör en förändring i programmet.
$authorization = new \controller\Authorization();
$authorization->login();

//CREATE OBJECTS OF THE VIEWS
$v = new LoginView();
$dtv = new DateTimeView(new \model\Time());
$lv = new LayoutView();


$lv->render(false, $v, $dtv);

