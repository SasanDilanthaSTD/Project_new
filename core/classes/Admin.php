<?php

namespace MyApp;

require_once "DBConnector.php";

use MyApp\DBConnector;
use PDO;
class Admin
{
    private $con;

    public function __construct()
    {
        $this->con = DBConnector::getConnection();
    }

    public function get_videos_count(){
        $sql_1 = "SELECT COUNT(*) AS total_videos FROM videolinks";
        $sql_2 = "SELECT COUNT(*) AS total_new_added_videos FROM videolinks WHERE videolinks.date BETWEEN DATE_FORMAT(NOW(), '%Y-%m-01') AND NOW()";
        $stmt_1 = $this->con->prepare($sql_1);
        $stmt_2 = $this->con->prepare($sql_2);
        try {
            $stmt_1->execute();
            $rs_1 = $stmt_1->fetch(PDO::FETCH_OBJ);
            $count = $rs_1->total_videos;

            $stmt_2->execute();
            $rs_2 = $stmt_2->fetch(PDO::FETCH_OBJ);
            $new_count = $rs_2->total_new_added_videos;

            return array(
                "count" => $count,
                "new_video_count" => $new_count
            );
        }catch (PDOException $ex ){
            echo "Error : " . $ex->getMessage();
        }
    }

    public function get_pending_applications(){
        $sql_table = 'SELECT DISTINCT user.user_id, user.firstname, user.lastname, user.profile_photo, therapist.description, therapist.approval FROM user, therapist, counselor, doctor WHERE (therapist.therapist_id = doctor.therapist_id AND user.user_id = doctor.user_id AND therapist.approval = "pending") OR (therapist.therapist_id = counselor.therapist_id AND user.user_id = counselor.user_id AND therapist.approval = "pending")';
        $pstmt = $this->con->prepare($sql_table);
        try {
            $pstmt->execute();
            if ($pstmt->rowCount() > 0){
                return $pstmt->fetchAll(PDO::FETCH_OBJ);
            }
        }catch (\PDOException $ex){
            echo "Error : " . $ex->getMessage();
        }

    }

    public function get_admin_name($id){
        $sql = "SELECT firstname,lastname FROM user WHERE user_id = ?";
        $pstmt = $this->con->prepare($sql);
        $pstmt->bindValue(1,$id);
        try {
            $pstmt->execute();
            if ($pstmt->rowCount() > 0){
                $rs = $pstmt->fetch(PDO::FETCH_OBJ);
                return $rs->firstname . " " . $rs->lastname;
            }
        }catch (\PDOException $ex){
            echo "Error : " . $ex->getMessage();
        }
    }

    public function get_therapist_count(){
        $sql = "SELECT COUNT(*) AS total_therapist FROM therapist";
        $sql_1 = "SELECT COUNT(*) AS total_doctor FROM doctor";
        $sql_2 = "SELECT COUNT(*) AS total_counselor FROM counselor";

        $stmt = $this->con->prepare($sql);
        $stmt_1 = $this->con->prepare($sql_1);
        $stmt_2 = $this->con->prepare($sql_2);

        try {
            $stmt->execute();
            $stmt_1->execute();
            $stmt_2->execute();
            if ($stmt->rowCount() > 0 && $stmt_1->rowCount() > 0 && $stmt_2->rowCount() > 0){
                $coun_t = $stmt->fetch(PDO::FETCH_OBJ)->total_therapist;
                $coun_d = $stmt_1->fetch(PDO::FETCH_OBJ)->total_doctor;
                $coun_c =  $stmt_2->fetch(PDO::FETCH_OBJ)->total_counselor;

                return array(
                    "count_t" => $coun_t,
                    "count_d" => $coun_d,
                    "count_c" => $coun_c
                );

            }
        }catch (\PDOException $ex){
            echo "Error : " . $ex->getMessage();
        }
    }

    public  function accept_therapist($id, $table){
        $sql = "UPDATE therapist SET approval = 'approved' WHERE therapist_id = (SELECT therapist_id FROM $table WHERE user_id = ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(1,$id);
        try {
            $stmt->execute();
            if ($stmt->rowCount() >0){
                header("Location: admin_page.php?msg=accept");
            }else{
                header("Location: admin_page.php?msg=acceptERR");
            }
        }catch (PDOException $ex){
            echo "Error" . $ex->getMessage();
        }
    }

    public  function reject_therapist($id, $table){
        $sql = "UPDATE therapist SET approval = 'reject' WHERE therapist_id = (SELECT therapist_id FROM $table WHERE user_id = ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(1,$id);
        try {
            $stmt->execute();
            if ($stmt->rowCount() >0){
                header("Location: admin_page.php?msg=reject");
            }else{
                header("Location: admin_page.php?msg=rejectERR");
            }
        }catch (PDOException $ex){
            echo "Error" . $ex->getMessage();
        }
    }


}