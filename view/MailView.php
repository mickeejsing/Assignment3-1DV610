<?php

namespace view;

class MailView {

    private $sendTo;
    private $sendFrom;
    private $message;
    private $title;
    private $stateMsg = "";
    private $stateStyle = "";

    private $mailModel;

    private static $mailReference = "mail";
    private static $titleReference = "title";
    private static $sendToReference = "sendTo";
    private static $sendFromReference = "sendFrom";

    public function __construct (\model\Mail $mailModel) {
		$this->mailModel = $mailModel;
    }
    
    public function wantsToSendMail () {
        if(isset($_POST[self::$mailReference])) {
            return true;
        }

        return false;
    }

    public function returnMailForm() {
        return '<form method="post" action=""> 
                    <div id="' . $this->stateStyle . '"><p>' . $this->stateMsg . '</p></div>
                    <input type="text" name="title" placeholder="Enter your title">
                    <input type="text" name="sendFrom" placeholder="Sent from email">
                    <input type="text" name="sendTo" placeholder="Sent to email">
                    <textarea name="mail" placeholder="Enter your message"></textarea>
                    <input type="submit"  value="Send mail" id="btn" >
                </form>';
    }

    public function verifyCredits() {
        
        $obj = new \stdClass();

        $obj->title = $_POST[self::$titleReference];
        $obj->msg = $_POST[self::$mailReference];
        $obj->sendTo = $_POST[self::$sendToReference];
        $obj->sendFrom = $_POST[self::$sendFromReference];

        $message = "";

        if ($this->mailModel->isEmpty($obj->title)) {
            $message .= "The title was not entered. ";
        } 
        
        if ($this->mailModel->isEmpty($obj->msg)) {
            $message .= "Message is empty. ";
        } 
        
        if(!$this->mailModel->isMailValid($obj->sendTo)) {
            $message .= "The receivers mail is not valid. ";
        }

        if(!$this->mailModel->isMailValid($obj->sendFrom)) {
            $message .= "Sender's email is invalid.";
        }

        if(strlen($message) > 0) {
            throw new \Exception($message);
        }

        return $obj;
    }

    public function formatAndSend(object $obj) {
        $message = '
        <html>
            <head>
                <title>'. $obj->title .'</title>
            </head>
            <body>
                <h1>' . $obj->title . '</h1>
                <p>'. $obj->msg .'</p>
            </body>
        </html>';

        $obj->msg = $message;
        $obj->headers = "From: <". $obj->sendFrom ."> \r\n";
        $obj->headers .= "MIME-Version: 1.0\r\n";
        $obj->headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        if($this->mailModel->sendMail($obj)) {
            return true;
        }
        
        throw new \Exception('The mail was not sent.');
    }

    public function setErrorMessage(string $value) : void {
        $this->stateMsg = $value;
        $this->stateStyle = "errorMsg";
    }

    public function setSuccessMessage() : void {
        $this->stateMsg = "Your message has been sent.";
        $this->stateStyle = "successMsg";
    }

}