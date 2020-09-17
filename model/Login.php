<?php

namespace model;

class Login {
    
    public function isEmpty ($userName) {
        if(strlen($userName) == 0) {
            return true;
        }

        return false;
    }
}