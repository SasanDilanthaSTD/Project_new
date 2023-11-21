<?php

require '../../core/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    // check username is alread exists
    if (isset($_POST['check_username'])){
        if (!empty($_POST['check_username'])){
            $username = ucwords(trim(strip_tags($_POST['check_username'])));
            if ($userObj->username_already_exists($username)){
                echo '<div class="text-danger" role="alert">!! Username already exists !! </div>';
                echo '<script>$("#submitBtn").prop("disabled",true);</script>';
            }else{
                echo '<div class="text-success" role="alert">Username Available</div>';
                echo '<script>$("#submitBtn").prop("disabled",false);</script>';
            }
        }else{
            echo '<div class="text-warning" role="alert">Enter your Username</div>';
        }
    }

    // check email is alread exists
    if (isset($_POST['check_mail'])){
        if (!empty($_POST['check_mail'])){
            $mail = ucwords(trim(strip_tags($_POST['check_mail'])));
            if ($userObj->mail_already_exists($mail)){
                echo '<div class="text-danger" role="alert">!! Email already exists !! </div>';
                echo '<script>$("#submitBtn").prop("disabled",true);</script>';
            }else{
                echo '<div class="text-success" role="alert">Email Available</div>';
                echo '<script>$("#submitBtn").prop("disabled",false);</script>';
            }
        }else{
            echo '<div class="text-warning" role="alert">Enter your Email</div>';
        }
    }
}