<?php

use MyApp\DBConnector;

require_once "core/classes/DBConnector.php";

//session_start();
$con = DBConnector::getConnection();

// Check if a cookie named 'visited' exists
if (!isset($_COOKIE['visited'])) {
    // Check if a cookie named 'isAdmin' exists
    if (isset($_SESSION["position"])) {
        if ($_SESSION["position"] !== "admin") {
            // If the cookie doesn't exist, create a new cookie with an expiration time of present day
            $now = new DateTime();
            $now->setTime(23, 59, 59);
            $expires = $now->format('U');
            setcookie('visited', 'true', $expires);

            // If the user is not an admin, increment the view count
            $date = date('Y-m-d');

            $query = "SELECT count FROM view_counts WHERE date = ?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $date);

            try {
                $pstmt->execute();
                if ($pstmt->rowCount() == 0) {
                    // If there is no view count for the current date, insert a new record
                    $query = "INSERT INTO view_counts (date, count) VALUES (?, ?)";
                    $pstmt_2 = $con->prepare($query);
                    $pstmt_2->bindValue(1, $date);
                    $pstmt_2->bindValue(2,1);
                    try {
                        $pstmt_2->execute();
                        $_SESSION['visited_count_today'] = 1;
                    }catch (PDOException $ex_2){
                        echo "Error" . $ex_2->getMessage();
                    }
                } else {
                    // If there is a view count for the current date, increment the count
                    $row = $pstmt->fetch(PDO::FETCH_ASSOC);
                    $count = $row['count'] + 1;

                    $query = "UPDATE view_counts SET count = ? WHERE date = ?";
                    $pstmt_3 = $con->prepare($query);
                    $pstmt_3->bindValue(1, $count);
                    $pstmt_3->bindValue(2, $date);
                    try {
                        $pstmt_3->execute();
                        $_SESSION['visited_count_today'] = $count;
                    }catch (PDOException $ex_3){
                        echo "Error : ". $ex_3->getMessage();
                    }
                }
            } catch (PDOException $ex) {
                echo "Error : " . $ex->getMessage();
            }
        }
    }

}elseif ($_COOKIE['visited'] == 'true'){
    if (isset($_SESSION['visited_count_today'])){
        $old_count = $_SESSION['visited_count_today'];
        $new_count = $old_count + 1;
        $date = date('Y-m-d');

        $query = "UPDATE view_counts SET count = ? WHERE date = ?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $new_count);
        $pstmt->bindValue(2, $date);
        try {
            $pstmt->execute();
            $_SESSION['visited_count_today'] = $new_count;
        }catch (PDOException $ex_3){
            echo "Error : ". $ex_3->getMessage();
        }
    }else{
        $date = date('Y-m-d');

        $query = "SELECT count FROM view_counts WHERE date = ?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $date);

        try {
            $pstmt->execute();
            // If there is a view count for the current date, increment the count
            $row = $pstmt->fetchAll(PDO::FETCH_OBJ);
            $count = $row->count + 1;

            $query = "UPDATE view_counts SET count = ? WHERE date = ?";
            $pstmt_3 = $con->prepare($query);
            $pstmt_3->bindValue(1, $count);
            $pstmt_3->bindValue(2, $date);
            try {
                $pstmt_3->execute();
                $_SESSION['visited_count_today'] = $count;
            }catch (PDOException $ex_3){
                echo "Error : ". $ex_3->getMessage();
            }
        }catch (PDOException $ex){
            echo "Error : ". $ex->getMessage();
        }
    }

}


