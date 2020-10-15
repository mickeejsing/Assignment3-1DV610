<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once('App.php');
$app = new App();
$app->run();