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
}