<?php

namespace MyApp;
use MyApp\DBConnector;
use PDO;

class ResourceLibrary{
    public function accessResources(){
        $con = DBConnector::getConnection();
        $query = "SELECT * FROM videolinks";
        $pstmt = $con->prepare($query);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
        return $rs;
    }
    public function accessSixRandomResources(){
        $con = DBConnector::getConnection();
        $query = "SELECT * FROM videolinks ORDER BY RAND() LIMIT 6";
        $pstmt = $con->prepare($query);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
        return $rs;
    }
    public function insertResourcelink($link){
        $con = DBConnector::getConnection();
        $query = "INSERT INTO videolinks(link) VALUES (?)";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $link);
        $pstmt->execute();
        if ($pstmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function deleteResourcelink($linkID){
        $con = DBConnector::getConnection();
        $query = "DELETE FROM videolinks WHERE linkID=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $linkID);
        $pstmt->execute();
        if ($pstmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function organizeResources(){

    }
    public function provideToolsAndTechniques(){

    }
}