<?php

namespace model;

class User {

    private $userName;
    private $passWord;
    private $keepLoggedIn;

    public function __construct ($userName, $passWord) {

        if (strlen($userName) < 3) {
            throw new \Exception("Username to short");
        }

        if (strlen($passWord) < 3) {
            throw new \Exception("Password to short");
        }

        $this->userName = $userName;
        $this->passWord = $passWord; 
    }

    public function setKeepLoggedIn($value) {
        $this->keepLoggedIn = $value; 
    }

    public function getName() {
        return $this->userName;
    }

    public function getPassword() {
        return $this->passWord;
    }

    public function getKeepLoggedin() {
        return $this->keepLoggedIn;
    }
}