<?php

namespace model;

class Time {

    public function getYear() : int {
        return date("Y");
    }

    public function getDay() : string {
        return date("l");
    }

    public function getIntDay() : int {
        return date("j");
    }

    public function getMonth() : string {
        return date("F");
    }

    public function getTime() : string {
        return date("h:i:s");
    }

}