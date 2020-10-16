<?php

namespace view;

class MailView {

    private $sendTo;
    private $sendFrom;
    private $message;
    private $title;
    private $errorMsg = "";
    private $styleMsgID = "";

    private $mailModel;

    private static $mailReference = "mail";
    private static $titleReference = "title";
    private static $sendToReference = "sendTo";

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
                    <div id="' . $this->styleMsgID . '"><p>' . $this->errorMsg . '</p></div>
                    <input type="text" name="title" placeholder="Enter your title">
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

        $message = "";

        if ($this->mailModel->isEmpty($obj->title)) {
            $message .= "The title was not entered. ";
        } 
        
        if ($this->mailModel->isEmpty($obj->msg)) {
            $message .= "Message is empty. ";
        } 
        
        if(!$this->mailModel->isMailValid($obj->sendTo)) {
            $message .= "Mail is not valid.";
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
                <p>'. $obj->msg .'</p>
            </body>
        </html>';

        $obj->msg = $message;

        $this->mailModel->sendMail($obj);
    }

    public function setErrorMessage(string $value) {
        $this->errorMsg = $value;
        $this->styleMsgID = "errorMsg";
    }

}