<?php

namespace MyApp;

require_once "DBConnector.php";

use MyApp\DBConnector;
use PDO;

class Payment
{
    private $con;

    public function __construct()
    {
        $this->con = DBConnector::getConnection();
    }

    public function create_pay_id(){
        $min = 1;
        $max = 100000;
        $randomNumberInRange = rand($min, $max);
        $pay_id = "PAY" . $randomNumberInRange;

        $query = "SELECT * FROM payment WHERE payment_id = ?";
        $pstmt = $this->con->prepare($query);
        $pstmt->bindValue(1,$pay_id);
        try {
            $pstmt->execute();
            if ($pstmt->rowCount() > 0){
                create_pay_id();
            }else{
                return $pay_id;
            }
        }catch (\PDOException $ex){
            echo "Error : " . $ex->getMessage();
        }
    }

    public function insert_payment_data($payment_id, $fee, $description, $user_id, $contact_therapist_id,$treat_therapist_id){
        $sql = "INSERT INTO payment(payment_id,fee,description,user_id,contact_therapist_id,treat_therapist_id) VALUES (?,?,?,?,?,?)";
        $pstmt = $this->con->prepare($sql);
        $pstmt->bindValue(1,$payment_id);
        $pstmt->bindValue(2,$fee);
        $pstmt->bindValue(3,$description);
        $pstmt->bindValue(4,$user_id);
        $pstmt->bindValue(5,$contact_therapist_id);
        $pstmt->bindValue(6,$treat_therapist_id);

        try {
            $pstmt->execute();
            return ($pstmt->rowCount() > 0) ? true : false;
        }catch (\PDOException $ex){
            echo "Error : " . $ex->getMessage();
        }
    }

    public function channel_doctor($patient_name, $counsselor_id, $doctor_id){
        $sql_1 = "SELECT * FROM user WHERE username = ?";
        $pstmt = $this->con->prepare($sql_1);
        $pstmt->bindValue(1, $patient_name);
        try {
            $pstmt->execute();
            if ($pstmt->rowCount() >0){
                $p_id = $pstmt->fetch(PDO::FETCH_OBJ)->user_id;
                $appointment_key = $counsselor_id . $doctor_id . $p_id;

                $sql = "SELECT user.*, doctor.therapist_id FROM user,doctor WHERE user.user_id = ? AND doctor.user_id = ?";
                $pstmt_1 = $this->con->prepare($sql);
                $pstmt_1->bindValue(1,$doctor_id);
                $pstmt_1->bindValue(2,$doctor_id);
                $pstmt_1->execute();
                if ($pstmt_1->rowCount() > 0){
                    $rs = $pstmt_1->fetch(PDO::FETCH_OBJ);
                    return array(
                        "appointment_key" => $appointment_key,
                        "doctor_mail" => $rs->email,
                        "doctor name" => $rs->firstname . " " . $rs->lastname,
                        "therapist_id" => $rs->therapist_id,
                        "user_id" => $p_id
                    );
                }

            }
        }catch (\PDOException $ex){
            echo "Error : " . $ex->getMessage();
        }
    }

    public function insert_apointmet_data($key,$u_id,$t_id){
        $sql = "INSERT INTO appointment(appointment_info, appointment_key, user_id, therapist_id) VALUES (?,?,?,?)";
        $pstmt = $this->con->prepare($sql);
        $pstmt->bindValue(1,"");
        $pstmt->bindValue(2,$key);
        $pstmt->bindValue(3,$u_id);
        $pstmt->bindValue(4,$t_id);

        try {
            $pstmt->execute();
            return ($pstmt->rowCount() > 0) ? true : false;
        }catch (\PDOException $ex){
           echo $ex->getMessage();
        }
    }

    public function update_appointment_info($key, $datetime){
        $sql = "UPDATE appointment SET appointment_info = ? WHERE appointment_key = ?";
        $pstmt = $this->con->prepare($sql);
        $pstmt->bindValue(1,$datetime);
        $pstmt->bindValue(2,$key);
        try {
            $pstmt->execute();
            return ($pstmt->rowCount() > 0) ? true : false ;
        }catch (\PDOException $ex){
            echo  $ex->getMessage();
        }
    }
    public function get_appointmet_info($key){
        $sql = "SELECT * FROM appointment WHERE appointment_key = ? ";
        $pstmt = $this->con->prepare($sql);
        $pstmt->bindValue(1,$key);
        try {
            $pstmt->execute();
            if ($pstmt->rowCount() > 0){
                return $pstmt->fetch(PDO::FETCH_OBJ)->appointment_info;
            }else{
                echo $pstmt->rowCount();
            }
        }catch (\PDOException $ex){
           echo $ex->getMessage();
        }
    }
}