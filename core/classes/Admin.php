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

    private function crate_id($set){
        $min = 1;
        $max = 100000;
        $randomNumberInRange = rand($min, $max);
        if ($set == "admin"){
            $user_id = "ADM" . $randomNumberInRange;
        }elseif($set == "unreg"){
            $user_id = "URP" . $randomNumberInRange;
        }

        $query = "SELECT * FROM payment WHERE user_id = ?";
        $pstmt = $this->con->prepare($query);
        $pstmt->bindValue(1,$user_id);
        try {
            $pstmt->execute();
            if ($pstmt->rowCount() > 0){
                create_id();
            }else{
                return $user_id;
            }
        }catch (\PDOException $ex){
            echo "Error : " . $ex->getMessage();
        }
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
        $sql_table = "SELECT user.user_id, user.firstname, user.lastname, user.profile_photo, therapist.description, therapist.approval FROM doctor INNER JOIN user ON doctor.user_id = user.user_id INNER JOIN therapist ON doctor.therapist_id = therapist.therapist_id WHERE therapist.approval = 'pending' UNION SELECT user.user_id, user.firstname, user.lastname, user.profile_photo, therapist.description, therapist.approval FROM counselor INNER JOIN user ON counselor.user_id = user.user_id INNER JOIN therapist ON counselor.therapist_id = therapist.therapist_id WHERE therapist.approval = 'pending';";
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

    public function get_pending_applications_count(){
        $sql = "SELECT COUNT(*) AS sum_pending FROM therapist WHERE therapist.approval = 'pending'";
        $stmt = $this->con->prepare($sql);

        try {
            $stmt->execute();
            $count =  $stmt->fetch(PDO::FETCH_OBJ)->sum_pending;
            return ($stmt->rowCount() >0) ? $count : 0 ;
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

    public function get_details_without_patient(){
        $sql = "SELECT user.user_id, user.firstname, user.lastname FROM user WHERE user_id LIKE \"ADM%\" OR user_id LIKE \"DOC%\" OR user_id LIKE \"COU%\"";
        $stmt = $this->con->prepare($sql);
        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0){
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
        }catch (\PDOException $ex){
            echo "Error : ". $ex->getMessage();
        }

    }

    public function get_admin_data(){
        $sql = "SELECT * FROM user WHERE user_id LIKE \"ADM%\" ";
        $stmt = $this->con->prepare($sql);
        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0){
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
        }catch (\PDOException $ex){
            echo "Error : ". $ex->getMessage();
        }
    }
    public function get_doctor_data(){
        $sql = "SELECT * FROM user WHERE user_id LIKE \"DOC%\" ";
        $stmt = $this->con->prepare($sql);
        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0){
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
        }catch (\PDOException $ex){
            echo "Error : ". $ex->getMessage();
        }
    }
    public function get_counselor_data(){
        $sql = "SELECT * FROM user WHERE user_id LIKE  \"COU%\"";
        $stmt = $this->con->prepare($sql);
        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0){
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
        }catch (\PDOException $ex){
            echo "Error : ". $ex->getMessage();
        }
    }



    public function reg_admin($first_name, $last_name,$username, $email, $password){
        $admin_id = $this->crate_id("admin");
        $sql = "INSERT INTO user(user_id, firstname, lastname, username,password, email,verify_key) VALUES (?,?,?,?,?,?,?)";
        $pstmt = $this->con->prepare($sql);
        $pstmt->bindValue(1,$admin_id);
        $pstmt->bindValue(2,$first_name);
        $pstmt->bindValue(3,$last_name);
        $pstmt->bindValue(4,$username);
        $pstmt->bindValue(5,$password);
        $pstmt->bindValue(6,$email);
        $pstmt->bindValue(7,"verified");
        try {
            $pstmt->execute();
            return ($pstmt->rowCount() > 0) ? true : false;
        }catch (\PDOException $ex){
            echo "Error : ". $ex->getMessage();
        }
    }

    public function patient_count(){
        $sql = "SELECT COUNT(*) AS total_patient FROM user WHERE user_id LIKE \"PAT%\" ";
        $sql_m = "SELECT COUNT(*) AS total_patient_m FROM user WHERE user_id LIKE \"PAT%\" AND user.time BETWEEN DATE_FORMAT(NOW(), '%Y-%m-01') AND NOW()";
        $stmt =$this->con->prepare($sql);
        $stmt_m = $this->con->prepare($sql_m);

        try {
            $stmt->execute();
            $stmt_m->execute();
            if ($stmt->rowCount() > 0 && $stmt_m->rowCount() >0){
                $rs = $stmt->fetch(PDO::FETCH_OBJ)->total_patient;
                $rs_m = $stmt_m->fetch(PDO::FETCH_OBJ)->total_patient_m;
                return array(
                    "total_patient" => $rs,
                    "total_patient_m" => $rs_m
                );

            }
        }catch (\PDOException $ex) {
            echo "Error : " . $ex->getMessage();
        }

    }

    public function get_page_view_counts(){
        $query = "SELECT SUM(count) AS sum_count FROM view_counts";
        $stmt = $this->con->prepare($query);
        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $viewCount = $row['sum_count'];

                return ['count' => $viewCount];
            } else {
                return ['count' => 0];
            }
        }catch (PDOException $ex){
            echo "Error" . $ex->getMessage();
        }
    }
    public function get_page_view_month_counts(){
        $query = "SELECT SUM(count) AS sum_month_count FROM view_counts WHERE date BETWEEN DATE_FORMAT(NOW(), '%Y-%m-01') AND NOW()";
        $stmt = $this->con->prepare($query);
        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $viewCount = $row['sum_month_count'];

                return ['count_m' => $viewCount];
            } else {
                return ['count_m' => 0];
            }
        }catch (PDOException $ex){
            echo "Error" . $ex->getMessage();
        }
    }

    public function for_barchart_c(){
        $sql_c = "SELECT MONTH(user.time) AS registration_month, COUNT(*) AS registered_count  FROM user WHERE user.user_id LIKE 'COU%' GROUP BY MONTH(user.time) ORDER BY registration_month DESC";
        $stmt_c = $this->con->prepare($sql_c);
        try {
            $stmt_c->execute();
            if ($stmt_c->rowCount() > 0) {
                return $stmt_c->fetchAll(PDO::FETCH_OBJ);
            }else{
                echo $stmt_c->rowCount();
            }
        }catch (\PDOException $ex){
            echo "Error : ". $ex->getMessage();
        }

    }
    public function for_barchart_d(){
        $sql_d = "SELECT MONTH(user.time) AS registration_month, COUNT(*) AS registered_count FROM user WHERE user.user_id LIKE 'DOC%' GROUP BY MONTH(user.time) ORDER BY registration_month DESC";
        $stmt = $this->con->prepare($sql_d);
        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }else{
                echo $stmt->rowCount();
            }
        }catch (\PDOException $ex){
            echo "Error : ". $ex->getMessage();
        }
    }

    public function for_view_chart_month(){
        $sql = "SELECT MONTH(date) AS month, SUM(count) AS total_count FROM view_counts GROUP BY MONTH(date)";
        $stmt = $this->con->prepare($sql);
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }catch (\PDOException $ex){
            echo "Error : " . $ex->getMessage();
        }
    }
    public function for_view_chart_day(){
        $sql = "SELECT date, count FROM view_counts WHERE date >= CURDATE() - INTERVAL 5 DAY";
        $stmt = $this->con->prepare($sql);
        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0){
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }else{
                echo $stmt->rowCount();
            }

        }catch (\PDOException $ex){
            echo "Error : " . $ex->getMessage();
        }
    }

    public function stress_tool_type_1(){
        $set_indexing = array();
        $sql = "SELECT stress_tool.q_id, stress_tool.questions FROM stress_tool WHERE stress_tool.method = 'PSS' ORDER BY RAND()";
        $resutl = $this->con->prepare($sql);
        try {
            $resutl->execute();
            if ($resutl->rowCount() > 0){
                while ($result_set = $resutl->fetch(PDO::FETCH_OBJ)) {
                    $set_indexing[] = array(
                        "q_id" => $result_set->q_id,
                        "q" => $result_set->questions
                    );
                }
                return $set_indexing;
            }
        }catch (\PDOException $ex){
            echo  $ex->getMessage();
        }
    }
    public function stress_tool_type_2(){
        $set_indexing = array();
        $sql = "SELECT * FROM stress_tool WHERE stress_tool.method = 'DASS21' ORDER BY RAND()";
        $resutl = $this->con->prepare($sql);
        try {
            $resutl->execute();
            if ($resutl->rowCount() > 0){
                while ($result_set = $resutl->fetch(PDO::FETCH_OBJ)) {
                    $set_indexing[] = array(
                        "type" => $result_set->type,
                        "q" => $result_set->questions
                    );
                }
                return $set_indexing;
            }
        }catch (\PDOException $ex){
            echo  $ex->getMessage();
        }
    }

    public function get_unreg_id(){
       return $this->crate_id("unreg");
    }

    public function insert_unreg_user($id){
        $sql = "INSERT INTO user(user_id) VALUES (?)";
        $pstmt = $this->con->prepare($sql);
        $pstmt->bindValue(1,$id);
        try {
            $pstmt->execute();
            return ($pstmt->rowCount() > 0) ? true : false;
        }catch (\PDOException $ex){
            echo $ex->getMessage();
        }
    }
    public function stress_tool_insert_1($user_id,$history,$status){
        $sql = "INSERT INTO patient(user_id,History_of_medicine,status) VALUES (?,?,?)";
        $pstmt = $this->con->prepare($sql);
        $pstmt->bindValue(1,$user_id);
        $pstmt->bindValue(2,$history);
        $pstmt->bindValue(3,$status);
        try {
            $pstmt->execute();
            return ($pstmt->rowCount() > 0) ? true : false;
        }catch (\PDOException $ex){
            echo $ex->getMessage();
        }
    }
    public function stress_tool_update_1($user_id,$history,$status){
        $sql = "UPDATE patient SET History_of_medicine = ?,status = ? WHERE user_id = ? ";
        $pstmt = $this->con->prepare($sql);
        $pstmt->bindValue(1,$history);
        $pstmt->bindValue(2,$status);
        $pstmt->bindValue(3,$user_id);
        try {
            $pstmt->execute();
            return ($pstmt->rowCount() > 0) ? true : false;
        }catch (\PDOException $ex){
            echo $ex->getMessage();
        }
    }



}