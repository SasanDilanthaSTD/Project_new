<?php
require_once "../../core/classes/Admin.php";

use MyApp\Admin;
$admin = new Admin();
$data = array();

// counselor data for bar chart
$cou_data_set = $admin->for_barchart_p();
$cou_data = [];

foreach ($cou_data_set as $doc) {
    if ($doc->registration_month == 1) {
        $cou_data[0] = $doc->registered_count;
    } elseif ($doc->registration_month == 2) {
        $cou_data[1] = $doc->registered_count;
    } elseif ($doc->registration_month == 3) {
        $cou_data[2] = $doc->registered_count;
    } elseif ($doc->registration_month == 4) {
        $cou_data[3] = $doc->registered_count;
    } elseif ($doc->registration_month == 5) {
        $cou_data[4] = $doc->registered_count;
    } elseif ($doc->registration_month == 6) {
        $cou_data[5] = $doc->registered_count;
    } elseif ($doc->registration_month == 7) {
        $cou_data[6] = $doc->registered_count;
    } elseif ($doc->registration_month == 8) {
        $cou_data[7] = $doc->registered_count;
    } elseif ($doc->registration_month == 9) {
        $cou_data[8] = $doc->registered_count;
    } elseif ($doc->registration_month == 10) {
        $cou_data[9] = $doc->registered_count;
    } elseif ($doc->registration_month == 11) {
        $cou_data[10] = $doc->registered_count;
    } elseif ($doc->registration_month == 12) {
        $cou_data[11] = $doc->registered_count;
    }
}

$data = array(
    "cou" => $cou_data
);

echo json_encode($data);