<?php

namespace view;

class MailView {

    private $sendTo;
    private $sendFrom;
    private $message;
    private $title;

    private $mailModel;

    public function __construct (\model\Mail $mailModel) {
		$this->mailModel = $mailModel;
    }
    
    public function wantsToSendMail () {
        if(isset($_POST["mail"])) {
            echo "finns";
        }   else {
            echo "finns inte";
        }
    }

    public function returnMailForm() {
        return '<form method="post" action=""> 
                    <input type="text" name="title" placeholder="Enter your title">
                    <input type="text" name="sendTo" placeholder="Sent to email">
                    <textarea name="mail" placeholder="Enter your message"></textarea>
                    <input type="submit"  value="Send mail" id="btn" >
                </form>';
    }

    public function verifyCredits() {
        echo "Here is a mail!";
    }

    public function handleMessage() {
        $message = '
        <html>
            <head>
                <title>Birthday Reminders for August</title>
            </head>
            <body>
                <p>Here are the birthdays upcoming in August!</p>
            <table>
                <tr>
                <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
                </tr>
                <tr>
                <td>Johny</td><td>10th</td><td>August</td><td>1970</td>
                </tr>
                <tr>
                <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
                </tr>
            </table>
            </body>
        </html>';
    }

}