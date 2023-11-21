<?php
require_once "../../core/classes/Payment.php";
use MyApp\Payment;

$pay = new Payment();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['pay'])){
        $payment_id = $_POST['payment_id'];
        $description = $_POST['description'];
        $user_id = $_POST['user_id'];
        $contact_therapist_id = $_POST['contact_therapist_id'];
        $treat_therapist_id = $_POST['treat_therapist_id'];

        // create pay here hash
        $merchant_id = "1224607";
        $order_id = $payment_id;
        $amount = 2500;
        $currency = "LKR";
        $merchant_secret = "MjUyOTY3MTQyNzE0OTc3NDE3MjUxODM4Njc1NTI5MjE3ODQwMDA2Mw==";
        $hash = strtoupper(
            md5(
                $merchant_id .
                $order_id .
                number_format($amount, 2, '.', '') .
                $currency .
                strtoupper(md5($merchant_secret))
            )
        );

        //insert payment data in database
        if ($pay->insert_payment_data($payment_id,$amount,$description,$user_id,$contact_therapist_id,$treat_therapist_id)){
            $arr = array(
                "order_id" => $order_id,
                "item" => $description,
                "amount" => $amount,
                "hash" => $hash
            );
            echo json_encode($arr);
        }
    }
}
