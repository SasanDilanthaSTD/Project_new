<?php

namespace MyApp;
use MyApp\DBConnector;
use PDO;

class Counselor extends User {
    protected $counselorID;
    protected $cDescription;

    /**
     * @param mixed $cDescription
     */
    public function setCDescription($cDescription)
    {
        $this->cDescription = $cDescription;
    }

    public function getTherapistIDFromUserID(){
        $this->counselorID = $this->ID();
        $con = DBConnector::getConnection();

        $query = "SELECT therapist_id FROM counselor WHERE user_id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->counselorID);
        $pstmt->execute();
        $rs = $pstmt->fetch(PDO::FETCH_OBJ);
        return $rs;
    }
    public function updateDescription($therapist_id){
        $con = DBConnector::getConnection();

        $query = "UPDATE therapist SET description =? WHERE therapist_id =?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->cDescription);
        $pstmt->bindValue(2, $therapist_id);
        $pstmt->execute();
        if ($pstmt->rowCount() > 0) {
            return true;
        }else{
            return false;
        }
    }
    public function getApprovedCounselorDetails(){
        $con = DBConnector::getConnection();
        $query = "SELECT u.*, t.* FROM user u LEFT JOIN counselor c ON u.user_id = c.user_id
                  LEFT JOIN therapist t ON c.therapist_id = t.therapist_id WHERE t.approval = 'approved'";
        $pstmt = $con->prepare($query);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
        return $rs;
    }


}