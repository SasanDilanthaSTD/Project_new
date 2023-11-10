<?php
use MyApp\Admin;
require_once "../../core/classes/Admin.php";

$userObj = new Admin();
$arr = array();
if ($_SERVER['REQUEST_METHOD'] === "POST"){
    if (isset($_REQUEST['therapist_count'])){
        $arr['doctor'] = $userObj->get_therapist_count();
    }

    if (isset($_REQUEST['video_count'])){
        $arr['video_count'] = $userObj->get_videos_count();
    }

    // return summury value
    echo json_encode($arr);
}
