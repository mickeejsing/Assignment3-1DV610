<?php

namespace controller;

class Router {

    private static $register = "register";

    public function route() {
        if(isset($_GET[self::$register])) {
            echo "Registrera!";
        }
    }
}