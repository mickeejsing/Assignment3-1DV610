<?php

namespace model;

class User {
    private $username;
    private $password;
    private $keepLoggedIn;
    private $passwordRepeat;
    
    public function setUsername(string $name) {
        $this->username = $name;
    }

    public function getUsername() : string {
        return $this->username;
    }

    public function setPassword(string $password) {
        $this->password = $password;
    }

    public function getPassword() : string {
        return $this->password;
    }

    public function setKeepLoggedIn(bool $value) {
        $this->keepLoggedIn = $value;
    }

    public function getKeepLoggedIn() : bool {
        return $this->keepLoggedIn;
    }

    public function setPasswordRepeat(string $value) {
        $this->passwordRepeat = $value;
    }

    public function getPasswordRepeat() : string {
        return $this->passwordRepeat;
    }
}