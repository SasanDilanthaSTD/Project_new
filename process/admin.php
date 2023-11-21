<?php
require_once '../core/init.php';
require_once "../core/classes/Admin.php";
use MyApp\Admin;

if (!$userObj->isLoggedIn()) {
    $userObj->redirect('login.php');
}

$admin = new Admin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /*------------------------------ add admin --------------------------------------------------------------- */
    if (isset($_POST['regAdmin'])){
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $uname = $_POST["uname"];
        $email = $_POST["email"];
        $pw = $_POST["pw"];
        $rpw = $_POST["rpw"];

        if ($pw == $rpw){
            $sanitizedAndValidatedfname = ucwords(trim(strip_tags($fname)));
            $sanitizedAndValidatedlname = ucwords(trim(strip_tags($lname)));
            $sanitizedAndValidateduname = trim(strip_tags($uname));
            $sanitizedAndValidatedemail = filter_var(trim(strip_tags(filter_var($email, FILTER_SANITIZE_EMAIL))), FILTER_VALIDATE_EMAIL);
            $hashedpassword = password_hash($pw, PASSWORD_DEFAULT);

            if ($admin->reg_admin($sanitizedAndValidatedfname,$sanitizedAndValidatedlname,$sanitizedAndValidateduname,$sanitizedAndValidatedemail,$hashedpassword)){
                header("Location:../admin_reg.php?msg=1");
            }else{
                header("Location:../admin_reg.php?error=3");
            }

        }else{
            header("Location:../admin_reg.php?error=2");
        }
    }

    /*------------------------------ admin delete --------------------------------------------------------------- */
   if (isset($_POST['del'])){
       $user_id = $_POST['del_id'];
       if (substr($user_id,0,3) == "ADM"){

       }else{

       }
   }
}