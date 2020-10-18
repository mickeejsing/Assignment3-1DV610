<?php

namespace model;

class Mail {

    private $mail;

    public function isMailValid(string $mail) : bool {
        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        
        return false;
    }

    public function isEmpty(string $value) : bool {
        if(strlen($value) == 0) {
            return true;
        }

        return false;
    }

    public function sendMail (object $mail) : bool {
        if(mail($mail->sendTo,$mail->title,$mail->msg, $mail->headers)) {
            return true;
        }

        return false;
    }

}