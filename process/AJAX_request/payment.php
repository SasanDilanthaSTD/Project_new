<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['pay'])){
        $payment_id = $_POST['payment_id'];
        $description = $_POST['description'];
        $user_id = $_POST['user_id'];
        $contact_therapist_id = $_POST['contact_therapist_id'];
        $treat_therapist_id = $_POST['treat_therapist_id'];

        $arr = array($payment_id,$description,$user_id,$contact_therapist_id,$treat_therapist_id);
        echo json_encode($arr);
    }
}
