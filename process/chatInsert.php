<?php
require '../core/init.php';
require '../core/classes/SecureMessagingAndCommunication.php';

if (!$userObj->isLoggedIn()) {
    $userObj->redirect('login.php');
}
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $outgoingUname = $_POST["outgoingUname"];
    $incomingUname = $_POST["incomingUname"];
    $message = $_POST["message"];
//    echo $message.$incomingUname.$outgoingUname;
    $secureMsgObj = new \MyApp\SecureMessagingAndCommunication();
    $secureMsgObj->insertMessage($incomingUname, $outgoingUname, $message);
}