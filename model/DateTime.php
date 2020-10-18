<?php

namespace model;

class DateTime {

    public function calculatePrefix ($number) : string {

        $dateLength = strlen($number);
        if ($dateLength == 1 || $dateLength == 2 && $number > 20) {
            
            // Minus 1 to get index of number in int. 
            $number = substr($number, $dateLength -1);
        }

        return $number;
    }
}