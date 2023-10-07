<?php

use MyApp\User;

session_start();

require 'classes/DBConnector.php';
require 'classes/User.php';


$userObj = new \MyApp\User();

define('BASE_URL','http://localhost/Project_new/');

?>
