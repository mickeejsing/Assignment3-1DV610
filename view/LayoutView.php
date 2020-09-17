<?php


class LayoutView {

  private static $register = "register";
  
  public function render($isLoggedIn, LoginView $lv, DateTimeView $dtv, RegisterView $rv) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->getLink() . '
          ' . $this->renderIsLoggedIn($isLoggedIn) . '
          
          <div class="container">
              ' . $this->ShowCurrentPage($lv, $rv) . '
              
              ' . $dtv->show() . '
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
  private function getLink() {

    if(isset($_GET[self::$register])) {
      return "<a href='?'>Back to login</a>";      
    } 

    return "<a href='?register'>Register a new user</a>";
  }

  private function showCurrentPage($lv, $rv) {
    if(isset($_GET[self::$register])) {
      return $rv->response();
    } 

    return $lv->response();
  }
}
