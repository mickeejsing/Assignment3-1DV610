<?php

namespace model;

class User {
    
    public function __construct ($userName, $passWord) {

        if (strlen($userName) < 3) {
            throw new \Exception("Username to short");
        }

        if (strlen($passWord) < 3) {
            throw new \Exception("Username to short");
        }

        $this->userName = $userName;
        $this->passWord = $passWord; 
    }

}