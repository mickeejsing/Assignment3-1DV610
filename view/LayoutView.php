<?php

namespace view;

class LayoutView {

  private static $register = "register";
  
  public function render($isLoggedIn, LoginView $lv, DateTimeView $dtv, RegisterView $rv, MailView $mv) {
    
    echo '<!DOCTYPE html>
          <html lang="en">
            <head>
              <meta charset="utf-8">
              <title>Login Example</title>
              <link rel="stylesheet" href="style/style.css">
            </head>
            <body>
              
              <h1>Assignment 3</h1>
              ' . $this->getLink($lv) . '
              ' . $this->renderIsLoggedIn($isLoggedIn) . '
            
              <div id="wrapper">
                <div class="container">
                ' . $this->ShowCurrentPage($lv, $rv, $mv) . '

                ' . $dtv->show() . '
                </div>
              </div>
            </body>
          </html>
    ';
  }
  
  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }

  // Generates link.
  private function getLink($lv) {

    if(isset($_GET[self::$register])) {
      return "<a id='navigate' href='?'>Back to login</a>";      
    } 

    if(!$lv->loginModel->loggedIn()) {
      return "<a id='navigate' href='?register'>Register a new user</a>";
    }
  }

  private function showCurrentPage($lv, $rv, $mv) {
    if(isset($_GET[self::$register])) {
      return $rv->response();
    } 
    
    if($lv->loginModel->loggedIn()) {
      return $lv->response() . $mv->returnMailForm();
    } else {
      return $lv->response();
    }
  }
}
