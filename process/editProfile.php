<?php
require '../core/init.php';
require '../core/classes/RegisterdUser.php';

if (!$userObj->isLoggedIn()) {
    $userObj->redirect('login.php');
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["save"])) {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        $userdata = $userObj->userData();
        $oldpassword = $userdata->password;
        if (!empty($password)) {
            $newpassword = $password;
            $newHashedPassword = $userObj->hash($newpassword);
        } else {
            $newHashedPassword = $oldpassword;
        }

        $uID = $userObj->ID();
        $targetDirectory = "../assets/profileImages/";
        $orginalfileName = basename($_FILES["image"]["name"]);
        $fileType = pathinfo($orginalfileName, PATHINFO_EXTENSION);
        $newfileName = $uID.".".$fileType;
        $targetFilePath = $targetDirectory . $newfileName;

        $possition1 = $userObj->newPosition();
        if ($possition1 == "patient") {
            $link = "userprofile.php";
        } elseif ($possition1 == "doctor") {
            $link = "doctorprofile.php";
        } elseif ($possition1 == "counselor") {
            $link = "counselorprofile.php";
        }

        if (!empty($orginalfileName)) {
            if (strtolower($fileType) === "jpg" || strtolower($fileType) === "jpeg" || strtolower($fileType) === "heic" || strtolower($fileType) === "png"){
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                    $registeresUserObj = new \MyApp\RegisterdUser();
                    if ($registeresUserObj->updateUserDetails($firstname, $lastname, $username, $newHashedPassword, "assets/profileImages/".$newfileName, $email)) {
                        $userObj->redirect($link."?msg=1");
                    } else {
//                        echo "error";
                        $userObj->redirect($link."?msg=1");
                    }
                } else {
//                    echo "there was an error uploading your image file.";
                    $userObj->redirect($link."?msg=2");
                }
            } else {
                $userObj->redirect("profedit.php?msg=1");
            }
        } else {
            $registeresUserObj = new \MyApp\RegisterdUser();
            $oldimage = $userdata->profile_photo;
            if ($registeresUserObj->updateUserDetails($firstname, $lastname, $username, $newHashedPassword, $oldimage, $email)) {
                $userObj->redirect($link."?msg=1");
            } else {
                echo "error";
            }
        }
    }
}