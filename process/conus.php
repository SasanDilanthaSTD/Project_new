<?php
require '../core/init.php';
require '../core/classes/MailClass.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST)) {
        $name = trim(stripcslashes(htmlentities($_POST["name"])));
        $email = trim(stripcslashes(htmlentities($_POST["email"])));
        $message = trim(stripcslashes(htmlentities($_POST["message"])));
//        echo $email. " ".$name." ".$message;
        $mailObj = new \MyApp\MailClass("project1.mhs@gmail.com", "MHS Admin,", "Feedback from user", "aboutus");
        $mailObj->setMsg($message);
        $mailObj->send_mail_verify_key();

    }
}