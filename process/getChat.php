<?php
require '../core/init.php';
require '../core/classes/SecureMessagingAndCommunication.php';

if (!$userObj->isLoggedIn()) {
    $userObj->redirect('login.php');
}
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $outgoingUname = $_POST["outgoingUname"];
    $incomingUname = $_POST["incomingUname"];
    $output = "";

//    echo $message.$incomingUname.$outgoingUname;
    $secureMsgObj = new \MyApp\SecureMessagingAndCommunication();
    $user = $secureMsgObj->getMsg($incomingUname, $outgoingUname);
    foreach ($user as $userMessage){
        if ($userMessage->outgoing_msg_uname === $outgoingUname) {
            $output .= '<div class=" chat chat-outgoing">
                             <div class="details">
                                  <p>'. $userMessage->message_info .'</p>
                             </div>
                         </div>';
        }else{
            $output .= '<div class=" chat chat-incoming">
                             <img src="'. $userMessage->profile_photo .'" alt="">
                                <div class="details">
                                    <p>'. $userMessage->message_info .'</p>
                                </div>
                         </div>';
        }
    }
    echo $output;
}