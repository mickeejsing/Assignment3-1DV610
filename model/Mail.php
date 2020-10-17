<?php

namespace model;

class Mail {

    private $mail;

    public function isMailValid(string $mail) {
        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        
        return false;
    }

    public function isEmpty($value) {
        if(strlen($value) == 0) {
            return true;
        }

        return false;
    }

    public function sendMail (object $mail) {
        if(mail($mail->sendTo,$mail->title,$mail->msg, $mail->headers)) {
            return true;
        }

        else false;
    }

}