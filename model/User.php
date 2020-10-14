<?php

namespace model;

class User {
    private $username;
    private $password;
    private $keepLoggedIn;
    
    public function setUsername($name) {
        $this->username = $name;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    
    public function getPassword() {
        return $this->password;
    }

    public function setKeepLoggedIn($value) {
        $this->keepLoggedIn = $value;
    }

    public function getKeepLoggedIn() {
        return $this->keepLoggedIn;
    }
}