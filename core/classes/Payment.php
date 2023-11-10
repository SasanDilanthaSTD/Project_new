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
}