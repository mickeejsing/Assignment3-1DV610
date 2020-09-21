<?php

namespace model;

class DateTime {

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

    public function getPrefix ($number) : string {
        $dateLength = strlen($number);

        if ($dateLength == 1 || $dateLength == 2 && $number > 20) {
            
            // Minus 1 to get index of number in int. 
            $number = substr($number, $dateLength -1);

            if ($number == 1) {
                return "st";
            } else if ($number == 2) {
                return "nd";
            } else if ($number == 3) {
                return "rd";
            } else if ($number > 3) {
                return "th";
            }
        }

        return "th";
    }
}