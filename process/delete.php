<?php
require_once "../core/classes/DBConnector.php";
$con = \MyApp\DBConnector::getConnection();

if (isset($_POST['del'])){
    $id = $_POST['del'];
    $posision = substr(id,0,3);
    if ($posision == "ADM"){
        $sql = "DELETE FROM user WHERE user_id = ?";
        $pstmt = $con->prepare($sql);
        try {
            $pstmt->execute();

            $link = ($pstmt->rowCount() >0) ? "../admin_action.php?msg=yes" : "../admin_action.php?msg=no";
            header("Location: $link");
        }catch (PDOException $eex){
            echo $eex->getMessage();
        }
    }elseif ($posision == "COU"){
        $sql1 = "DELETE FROM counselor WHERE user_id = ?";
        $sql2 = "DELETE FROM user WHERE user_id = ?";
        $pstmt_1 = $con->prepare($sql1);
        $pstmt_2 = $con->prepare($sql2);

        try {
            $pstmt_1->execute();
            $pstmt_2->execute();
            if ($pstmt_1->rowCount()>0 && $pstmt_2->rowCount() > 0){
                $link = "../admin_action.php?msg=yes";
            }else{
                $link = "../admin_action.php?msg=no";
            }
            header("Location: $link");
        }catch (PDOException $ex){
            echo $ex->getMessage();
        }

    }elseif ($posision == "DOC"){
        $sql1 = "DELETE FROM doctor WHERE user_id = ?";
        $sql2 = "DELETE FROM user WHERE user_id = ?";
        $pstmt_1 = $con->prepare($sql1);
        $pstmt_2 = $con->prepare($sql2);

        try {
            $pstmt_1->execute();
            $pstmt_2->execute();
            if ($pstmt_1->rowCount()>0 && $pstmt_2->rowCount() > 0){
                $link = "../admin_action.php?msg=yes";
            }else{
                $link = "../admin_action.php?msg=no";
            }
            header("Location: $link");
        }catch (PDOException $ex){
            echo $ex->getMessage();
        }

    }
}