<?php
namespace MyApp;

use MyApp\DBConnector;
use PDO;

class User{

    public $userID, $sessionID;
    protected $position, $therapistID, $firstName, $lastName, $userName, $email, $unreguserID;

    public function __construct(){
        $this->userID = $this->ID();
        $this->sessionID = $this->getSessionID();
        $this->position = $this->newPosition();
    }

    public function ID(){
        if ($this->isLoggedIn()) {
            return $_SESSION["userID"];
        }
    }

    public function getSessionID(){
        return session_id();
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
    public function newPosition(){
        if ($this->isLoggedIn()) {
            return $_SESSION["position"];
        }
    }

    /**
     * @return mixed
     */
    public function getTherapistID()
    {
        return $this->therapistID;
    }

    /**
     * @param mixed $therapistID
     */
    public function setTherapistID($therapistID)
    {
        $this->therapistID = $therapistID;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getUnreguserID()
    {
        return $this->unreguserID;
    }

    /**
     * @param mixed $unreguserID
     */
    public function setUnreguserID($unreguserID)
    {
        $this->unreguserID = $unreguserID;
    }



    

    public function emailExists($email){
        $con = DBConnector::getConnection();

        $query = "SELECT * FROM user WHERE email=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1,$email);
        $pstmt->execute();
        $rs = $pstmt->fetch(PDO::FETCH_OBJ);

        if (!empty($rs)) {
            return $rs;
        }else{
            return false;
        }
    }

    public function hash($password){
        return password_hash($password,PASSWORD_DEFAULT);
    }

    public function redirect($location){
        header("Location:".BASE_URL.$location);
    }

    public function userData($userID = ''){
        $userID = ((!empty($userID)) ? $userID : $this->userID);
        $con = DBConnector::getConnection();

        $query = "SELECT * FROM user WHERE user_id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1,$userID);
        $pstmt->execute();
        $rs = $pstmt->fetch(PDO::FETCH_OBJ);
        return $rs;
    }

    public function isLoggedIn(){
        return ((isset($_SESSION["userID"])) ? true : false);
    }

    public function logout(){
        $_SESSION = array();
        session_destroy();
        session_regenerate_id();
        $this->redirect('login.php');
    }

    public function getuser(){
        $con = DBConnector::getConnection();

        $query = "SELECT * FROM user WHERE user_id!=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1,$this->userID);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
        return $rs;
//        foreach ($rs as $user) {
//            echo "
//                      <a href=".BASE_URL.$user->username.">
//                          <div>
//                              <div><img src='$user->profileImage' alt='' style='width: 50px'></div>
//                              <div>$user->name</div>
//                          </div>
//                      </a>
//                  ";
//        }
    }

    public function getUserByUsername($username){
        $con = DBConnector::getConnection();

        $query = "SELECT * FROM user WHERE username=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1,$username);
        $pstmt->execute();
        $rs = $pstmt->fetch(PDO::FETCH_OBJ);
        return $rs;
    }

    public function updateSession(){
        $con = DBConnector::getConnection();

        $query = "UPDATE user SET sessionID=? WHERE user_id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1,$this->sessionID);
        $pstmt->bindValue(2,$this->userID);
        $pstmt->execute();
    }

    public function getUserBySession($sessionID){
        $con = DBConnector::getConnection();

        $query = "SELECT * FROM user WHERE sessionID=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1,$sessionID);
        $pstmt->execute();
        $rs = $pstmt->fetch(PDO::FETCH_OBJ);
        return $rs;
    }

    public function updateConnection($connectionID, $userID){
        $con = DBConnector::getConnection();

        $query = "UPDATE user SET ConnectionID=? WHERE user_id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1,$connectionID);
        $pstmt->bindValue(2,$userID);
        $pstmt->execute();
    }



//    after add

    public function createUserID(){
        $min = 1;
        $max = 100000;
        $randomNumberInRange = rand($min, $max);
        if ($this->position == "patient") {
            $this->userID = "PAT" . $randomNumberInRange;
        } elseif ($this->position == "doctor") {
            $this->userID = "DOC" . $randomNumberInRange;
        } elseif ($this->position == "counselor") {
            $this->userID = "COU" . $randomNumberInRange;
        }

        $dbcon = DBConnector::getConnection();
        $query = "SELECT user_id FROM user";
        $pstmt = $dbcon->prepare($query);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($rs as $user) {
            if ($user->user_id == $this->userID) {
                $this->createUserID();
            }
        }
        return $this->userID;
    }
    public function createTherapistID(){
        $min = 1;
        $max = 100000;
        $randomNumberInRange = rand($min, $max);

        $this->therapistID = "TRP" . $randomNumberInRange;

        $dbcon = DBConnector::getConnection();
        $query = "SELECT therapist_id FROM therapist";
        $pstmt = $dbcon->prepare($query);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($rs as $user) {
            if ($user->therapist_id == $this->therapistID) {
                $this->createTherapistID();
            }
        }
        return $this->therapistID;
    }
    public function insertUser($uid, $tid, $password, $cv, $key) {
        $dbcon = DBConnector::getConnection();

        // Use parent class property names here
        if ($this->position == "patient") {
            $query = "INSERT INTO user(user_id, firstname, lastname, username, profile_photo, password, email, verify_key) VALUES (?,?,?,?,?,?,?,?)";
        } elseif ($this->position == "doctor") {
            $query = "INSERT INTO user(user_id, firstname, lastname, username, profile_photo, password, email, verify_key) VALUES (?,?,?,?,?,?,?,?)";
            $query2 = "INSERT INTO therapist(therapist_id, description, cv) VALUES (?,?,?)";
            $query3 = "INSERT INTO doctor(user_id, therapist_id) VALUES (?,?)";
        } elseif ($this->position == "counselor") {
            $query = "INSERT INTO user(user_id,firstname, lastname, username, profile_photo, password, email, verify_key) VALUES (?,?,?,?,?,?,?,?)";
            $query2 = "INSERT INTO therapist(therapist_id , description, cv) VALUES (?,?,?)";
            $query3 = "INSERT INTO counselor(user_id, therapist_id) VALUES (?,?)";
        }

        $pstmt = $dbcon->prepare($query);
        $pstmt->bindValue(1, $uid);
        $pstmt->bindValue(2, $this->firstName);
        $pstmt->bindValue(3, $this->lastName);
        $pstmt->bindValue(4, $this->userName);
        $pstmt->bindValue(5, "assets/img/defaultImage.png");
        $pstmt->bindValue(6, $password);
        $pstmt->bindValue(7, $this->email);
        $pstmt->bindValue(8,$key);
        try {
            $pstmt->execute();
        }catch (\PDOException $ex){
            echo "Error : " . $ex->getMessage();
        }
        if ($this->position == "doctor" || $this->position == "counselor") {
            $pstmt2 = $dbcon->prepare($query2);
            $pstmt2->bindValue(1, $tid);
            $pstmt2->bindValue(2, "Therapist Description");
            $pstmt2->bindValue(3, $cv);
            try {
                $pstmt2->execute();
            }catch (\PDOException $ex){
                echo "Error : " . $ex->getMessage();
            }

            $pstmt3 = $dbcon->prepare($query3);
            $pstmt3->bindValue(1, $uid);
            $pstmt3->bindValue(2, $tid);
            try {
                $pstmt3->execute();
            }catch (\PDOException $ex){
                echo "Error : " . $ex->getMessage();
            }
        }

        if ($pstmt->rowCount() > 0) {
            //$this->redirect("login.php?msg=1");
            return true;
        } else {
            //echo 'Please check again';
            return false;
        }
    }
    public function createUnregUserID(){
        $min = 1;
        $max = 100000;
        $randomNumberInRange = rand($min, $max);

        $this->unreguserID = "URU" . $randomNumberInRange;

        $dbcon = DBConnector::getConnection();
        $query = "SELECT user_id FROM user";
        $pstmt = $dbcon->prepare($query);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($rs as $user) {
            if ($user->user_id == $this->unreguserID) {
                $this->createUnregUserID();
            }
        }
        return $this->unreguserID;
    }
    public function updateUnregUserIDtoRegUID($unregID, $regID, $password){
        $dbcon = DBConnector::getConnection();

        $query1 = "UPDATE `user` SET user_id = ?, firstname = ?, lastname = ?, username = ?, profile_photo = ?, password = ?, email = ? WHERE user_id = ?";
        $query2 = "UPDATE patient SET user_id = ? WHERE user_id = ?";

        $pstmt = $dbcon->prepare($query1);
        $pstmt->bindValue(1,$regID);
        $pstmt->bindValue(2, $this->firstName);
        $pstmt->bindValue(3, $this->lastName);
        $pstmt->bindValue(4, $this->userName);
        $pstmt->bindValue(5, "assets/img/defaultImage.png");
        $pstmt->bindValue(6, $password);
        $pstmt->bindValue(7, $this->email);
        $pstmt->bindValue(8, $unregID);
        $pstmt->execute();

        $pstmt2 = $dbcon->prepare($query2);
        $pstmt2->bindValue(1,$regID);
        $pstmt2->bindValue(2,$unregID);
        $pstmt2->execute();

        if ($pstmt->rowCount() > 0) {
            if ($pstmt2->rowCount() > 0) {
                $this->redirect("login.php?msg=2");
            }
        } else {
            echo 'Please check again';
        }
    }
    public function updateStatus($status){
        $dbcon = DBConnector::getConnection();

        $query = "UPDATE user SET status = ? WHERE user_id = ?";
        $pstmt = $dbcon->prepare($query);
        $pstmt->bindValue(1,$status);
        $pstmt->bindValue(2, $this->userID);
        $pstmt->execute();
        if ($pstmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }
    public function getDoctors(){
        $con = DBConnector::getConnection();

        $query = "SELECT * FROM user WHERE user_id LIKE 'DOC%';";
        $pstmt = $con->prepare($query);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
        return $rs;
    }
    public function getPatients(){
        $con = DBConnector::getConnection();

        $query = "SELECT * FROM user WHERE user_id LIKE 'PAT%';";
        $pstmt = $con->prepare($query);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
        return $rs;
    }
    public function getDoctorsAndCounselors(){
        $con = DBConnector::getConnection();

        $query = "SELECT * FROM user WHERE user_id LIKE 'DOC%' OR user_id LIKE 'COU%';";
        $pstmt = $con->prepare($query);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
        return $rs;
    }

    public function user_verify($key)
    {
        $dbcon = DBConnector::getConnection();
        $sql = "SELECT user_id FROM user WHERE verify_key = ?";
        $pstmt = $dbcon->prepare($sql);
        $pstmt->bindValue(1,$key);
        try{
            $pstmt->execute();
            if($pstmt->rowCount() > 0){
                $rs = $pstmt->fetch(\PDO::FETCH_OBJ);
                $sql_update = "UPDATE user SET verify_key = 'verified' WHERE user_id = ?";
                $update = $dbcon->prepare($sql_update);
                $update->bindValue(1, $rs->user_id);
                try {
                    $update->execute();
                    return ($update->rowCount() > 0) ? true : false ;
                }catch (PDOException $e){
                    echo "Error : " . $e->getMessage();
                }
            }else{
                return false;
            }
        }catch(PDOException $ex){
            echo "Error : " . $ex->getMessage();
        }
    }

    public  function username_already_exists($username){
        $dbcon = DBConnector::getConnection();
        $sql = "SELECT * FROM user WHERE username = ?";
        $pstmt = $dbcon->prepare($sql);
        $pstmt->bindValue(1, $username);
        try {
            $pstmt->execute();
            return ($pstmt->rowCount() > 0) ? true : false;
        }catch (\PDOException $ex){
            echo "Error : " . $ex->getMessage();
        }
    }

    public  function mail_already_exists($mail){
        $dbcon = DBConnector::getConnection();
        $sql = "SELECT * FROM user WHERE email = ?";
        $pstmt = $dbcon->prepare($sql);
        $pstmt->bindValue(1, $mail);
        try {
            $pstmt->execute();
            return ($pstmt->rowCount() > 0) ? true : false;
        }catch (\PDOException $ex){
            echo "Error : " . $ex->getMessage();
        }
    }

    public function user_verify($key)
    {
        $dbcon = DBConnector::getConnection();
        $sql = "SELECT user_id FROM user WHERE verify_key = ?";
        $pstmt = $dbcon->prepare($sql);
        $pstmt->bindValue(1,$key);
        try{
            $pstmt->execute();
            if($pstmt->rowCount() > 0){
                $rs = $pstmt->fetch(\PDO::FETCH_OBJ);
                $sql_update = "UPDATE user SET verify_key = 'verified' WHERE user_id = ?";
                $update = $dbcon->prepare($sql_update);
                $update->bindValue(1, $rs->user_id);
                try {
                    $update->execute();
                    return ($update->rowCount() > 0) ? true : false ;
                }catch (PDOException $e){
                    echo "Error : " . $e->getMessage();
                }
            }else{
                return false;
            }
        }catch(PDOException $ex){
            echo "Error : " . $ex->getMessage();
        }
    }

    public  function username_already_exists($username){
        $dbcon = DBConnector::getConnection();
        $sql = "SELECT * FROM user WHERE username = ?";
        $pstmt = $dbcon->prepare($sql);
        $pstmt->bindValue(1, $username);
        try {
            $pstmt->execute();
            return ($pstmt->rowCount() > 0) ? true : false;
        }catch (\PDOException $ex){
            echo "Error : " . $ex->getMessage();
        }
    }

    public  function mail_already_exists($mail){
        $dbcon = DBConnector::getConnection();
        $sql = "SELECT * FROM user WHERE email = ?";
        $pstmt = $dbcon->prepare($sql);
        $pstmt->bindValue(1, $mail);
        try {
            $pstmt->execute();
            return ($pstmt->rowCount() > 0) ? true : false;
        }catch (\PDOException $ex){
            echo "Error : " . $ex->getMessage();
        }
    }

}
