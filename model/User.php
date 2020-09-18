<?php

namespace model;

class User {

    private $userName;
    private $passWord;

    public function setCredits ($userName, $passWord) {

        if (strlen($userName) < 3) {
            throw new \Exception("Username to short");
        }

        if (strlen($passWord) < 3) {
            throw new \Exception("Password to short");
        }

        $this->userName = $userName;
        $this->passWord = $passWord; 
    }

    public function toString () {
        return $this->userName . ' ' . $this->passWord;
    }

}