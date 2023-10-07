<?php

namespace MyApp;
use MyApp\DBConnector;
use PDO;
class RegisterdUser extends User{
    public function updateUserDetails($fname, $lname, $uname, $password, $image, $email){
        $userID = ((!empty($userID)) ? $userID : $this->userID);
        $con = DBConnector::getConnection();

        $query = "UPDATE `user` SET firstname = ?, lastname = ?, username = ?, profile_photo = ?, password = ?, email = ? WHERE user_id = ?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $fname);
        $pstmt->bindValue(2, $lname);
        $pstmt->bindValue(3, $uname);
        $pstmt->bindValue(4, $image);
        $pstmt->bindValue(5, $password);
        $pstmt->bindValue(6, $email);
        $pstmt->bindValue(7, $userID);
        $pstmt->execute();

        if ($pstmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}