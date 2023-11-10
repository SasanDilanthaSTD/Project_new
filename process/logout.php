<?php

require '../core/init.php';

if (!$userObj->isLoggedIn()) {
    $userObj->redirect('login.php');
}
//$userObj->updateStatus("offline");
$userObj->logout();
