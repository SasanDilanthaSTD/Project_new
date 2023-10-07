<?php

namespace MyApp;
use MyApp\DBConnector;
use PDO;

class Doctor extends User{
    protected $doctorID;
    protected $dDescription;

    /**
     * @param mixed $dDescription
     */
    public function setDDescription($dDescription)
    {
        $this->dDescription = $dDescription;
    }
    public function getTherapistIDFromUserID(){
        $this->doctorID = $this->ID();
        $con = DBConnector::getConnection();

        $query = "SELECT therapist_id FROM doctor WHERE user_id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->doctorID);
        $pstmt->execute();
        $rs = $pstmt->fetch(PDO::FETCH_OBJ);
        return $rs;
    }
    public function updateDescription($therapist_id){
        $con = DBConnector::getConnection();

        $query = "UPDATE therapist SET description =? WHERE therapist_id =?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->dDescription);
        $pstmt->bindValue(2, $therapist_id);
        $pstmt->execute();
        if ($pstmt->rowCount() > 0) {
            return true;
        }else{
            return false;
        }
    }
    public function getApprovedDoctorDetails(){
        $con = DBConnector::getConnection();
        $query = "SELECT u.*, t.* FROM user u LEFT JOIN doctor c ON u.user_id = c.user_id
                  LEFT JOIN therapist t ON c.therapist_id = t.therapist_id WHERE t.approval = 'approved'";
        $pstmt = $con->prepare($query);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
        return $rs;
    }
}