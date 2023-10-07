<?php
require '../core/init.php';
session_start();
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

                if (isset($_SESSION["UnregUserID"])) {
                    $uuID = $_SESSION["UnregUserID"]; // this session will create sasa
                    $userObj->updateUnregUserIDtoRegUID($uuID, $uID, $hashedpassword);
                }else{
                    if ($userObj->getPosition() == "patient") {
                        $userObj->insertUser($uID, $tID, $hashedpassword, "");
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
}
