<?php

namespace view;

class LayoutView {

  private static $register = "register";
  
  // TODO: Type safety.
  public function render(bool $isLoggedIn, \view\LoginView $lv, \view\DateTimeView $dtv, \view\RegisterView $rv, \view\MailView $mv) {
    
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
  
  private function renderIsLoggedIn($isLoggedIn) : string  {
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

  private function showCurrentPage(\view\LoginView $loginView, \view\RegisterView $registerView, \view\MailView $mailView) : string  {
    if(isset($_GET[self::$register])) {
      return $registerView->response();
    } 
    
    if($loginView->loginModel->loggedIn()) {
      return $loginView->response() . $mailView->returnMailForm();
    }
    
    return $loginView->response();
    
  }
}
