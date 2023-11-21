<?php
require '../core/init.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST)) {
        $email = trim(stripcslashes(htmlentities($_POST["email"])));
        $password = trim(stripcslashes(htmlentities($_POST["password"])));
        $rpassword = trim(stripcslashes(htmlentities($_POST["rpassword"])));
//        echo $email." ".$password." ".$rpassword;
        if ($password != $rpassword) {
            header("Location:../resetPassword.php?mail={$email}&msg=1");
        }else{
            $userObj->setEmail($email);
            $newPassword = $userObj->hash($password);
            $userObj->updatePassword($newPassword);
            header("Location:../login.php?msg=4");
        }
    }
}