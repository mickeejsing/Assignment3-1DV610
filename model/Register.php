<?php

namespace model;

class Register {
    
    public function isShortUsername ($userName) {
        if(strlen($userName) < 3) {
            return true;
        }

        return false;
    }

    public function isShortPassword ($passWord) {
        if(strlen($passWord) < 6) {
            return true;
        }

        return false;
    }
}