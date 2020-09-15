<?php

namespace controller;

class Router {

    private static $register = "register";

    public function route($rV) {

        if(isset($_GET[self::$register])) {
            if(count($_POST) > 0) {
                $rV->getRequestUserName();
            }
        }
    }
}