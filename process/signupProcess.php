<?php
require_once '../core/classes/MailClass.php';
use MyApp\MailClass;

require '../core/init.php';

if ($userObj->isLoggedIn()) {
    $userObj->redirect('videohome.php');
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["submit"])) {
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $uname = $_POST["uname"];
        $email = $_POST["email"];
        $pw = $_POST["pw"];
        $rpw = $_POST["rpw"];
        $position = $_POST["p"];

        if ($userObj->emailExists($email)) {
            header("Location:../register.php?error=1");
        }else{
            if ($pw == $rpw) {
                $userObj->setPosition($position);
                $uID = $userObj->createUserID();
                $tID = $userObj->createTherapistID();

                $sanitizedAndValidatedfname = ucwords(trim(strip_tags($fname)));
                $sanitizedAndValidatedlname = ucwords(trim(strip_tags($lname)));
                $sanitizedAndValidateduname = trim(strip_tags($uname));
                $sanitizedAndValidatedemail = filter_var(trim(strip_tags(filter_var($email, FILTER_SANITIZE_EMAIL))), FILTER_VALIDATE_EMAIL);
                $hashedpassword = $userObj->hash($pw);

                $userObj->setFirstName($sanitizedAndValidatedfname);
                $userObj->setLastName($sanitizedAndValidatedlname);
                $userObj->setUserName($sanitizedAndValidateduname);
                $userObj->setEmail($sanitizedAndValidatedemail);

                // setup name and  verify key
                $name = $sanitizedAndValidatedfname . " " . $sanitizedAndValidatedlname;
                $key = sha1(rand(5, 10));

                if (isset($_SESSION["UnregUserID"])) {
                    $uuID = $_SESSION["UnregUserID"]; // this session will create sasa
                    $userObj->updateUnregUserIDtoRegUID($uuID, $uID, $hashedpassword);
                }else{
                    if ($userObj->getPosition() == "patient") {
                        if ($userObj->insertUser($uID, $tID, $hashedpassword, "", $key)){
                            $mail_obj = new MailClass($sanitizedAndValidatedemail, $name, "Account Verification", "verify");
                            $mail_obj->set_key($key);
                            $mail_obj->send_mail_verify_key();
                        }else{
                            echo 'Please check again';
                        }
                    } elseif ($userObj->getPosition() == "doctor" || $userObj->getPosition() == "counselor") {

                        $targetDirectory = "../assets/cv/";
                        $orginalfileName = basename($_FILES["cv"]["name"]);
                        $fileType = pathinfo($orginalfileName, PATHINFO_EXTENSION);
                        $newfileName = $uID.".".$fileType;
                        $targetFilePath = $targetDirectory . $newfileName;

                        if (strtolower($fileType) === "pdf"){
                            if (move_uploaded_file($_FILES["cv"]["tmp_name"], $targetFilePath)) {
                                $userObj->insertUser($uID, $tID, $hashedpassword, $newfileName);
                            } else {
                                echo "there was an error uploading your PDF file.";
                            }
                        }else{
                            header("Location:../register.php?error=3");
                        }
                    }
                }
            } else {
                header("Location:../register.php?error=2");
            }
        }

    }
}elseif ($_SERVER["REQUEST_METHOD"] === "GET"){
    if(isset($_GET['key'])){
        $key = $_GET['key'];
        if ($userObj->user_verify($key)){
            header("Location: ../login.php?msg=1");
        }
    }
}

