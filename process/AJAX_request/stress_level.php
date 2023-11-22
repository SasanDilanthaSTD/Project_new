<?php
use MyApp\Admin;
require_once "../../core/classes/Admin.php";

$admin = new Admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_REQUEST['stress_too_1'])){
        $set_indexing = $admin->stress_tool_type_1();
        echo json_encode($set_indexing);
    }
    if (isset($_REQUEST['stress_too_2'])){
        $set_indexing = $admin->stress_tool_type_2();
        echo json_encode($set_indexing);
    }
}