<?php
require '../core/init.php';
require '../core/classes/MailClass.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST)) {
        $email = trim(stripcslashes(htmlentities($_POST["email"])));
//        echo $email;
        $mailObj = new \MyApp\MailClass($email, "MHS User,", "Reset Your Password", "reset");
        $mailObj->send_mail_verify_key();

    }
}