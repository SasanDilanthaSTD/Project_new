<?php

namespace MyApp;
use MyApp\DBConnector;
use PDO;

class SecureMessagingAndCommunication{
    public function insertMessage($incomingUname, $outgoingUname, $message){
        $con = DBConnector::getConnection();

        $query = "INSERT INTO message(message_info, incoming_msg_uname, outgoing_msg_uname) VALUES (?,?,?)";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $message);
        $pstmt->bindValue(2, $incomingUname);
        $pstmt->bindValue(3, $outgoingUname);
        $pstmt->execute();
        if ($pstmt->rowCount() > 0) {
            return true;
        }else{
            return false;
        }
    }
    public function getMsg($incomingUname, $outgoingUname){
        $con = DBConnector::getConnection();

        $query = "SELECT * FROM message
                  LEFT JOIN user ON user.username = message.outgoing_msg_uname
                  WHERE (outgoing_msg_uname=? AND incoming_msg_uname=?) OR (outgoing_msg_uname=? AND incoming_msg_uname=?) ORDER BY message_id  ";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $outgoingUname);
        $pstmt->bindValue(2, $incomingUname);
        $pstmt->bindValue(3, $incomingUname);
        $pstmt->bindValue(4, $outgoingUname);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
        return $rs;
    }

}