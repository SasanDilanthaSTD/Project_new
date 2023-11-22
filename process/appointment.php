<?php
require_once '../core/init.php';
require_once "../core/classes/Payment.php";
require_once "../core/classes/MailClass.php";

use MyApp\Payment;
use MyApp\MailClass;


$control_appointment = new Payment();


if ($_SERVER['REQUEST_METHOD'] ==='POST'){
    if (isset($_POST['btn_chanel'])){
        $p_name = filter_var($_POST['p_name'], FILTER_SANITIZE_STRING);
        $c_id = $_POST['cou'];
        $d_id = $_POST['doc'];

        $mail_data = $control_appointment->channel_doctor($p_name,$c_id,$d_id);
        if (!empty($mail_data)){
            if ($control_appointment->insert_apointmet_data($mail_data['appointment_key'],$mail_data['user_id'],$mail_data['therapist_id'])){
                $send_mailobj = new MailClass($mail_data['doctor_mail'],$mail_data['doctor name'],"You Have an Appointmet From HMS", "appointment");
                $send_mailobj->set_key($mail_data['appointment_key']);
                $send_mailobj->create_appointment();
            }else{
                header("Location:../doctors.php?err=1");
            }
        }
    }

    if (isset($_POST['btn_schedule'])){
        $key = $_POST['key'];
        $d_id = $_POST['doc'];
        $p_id = $_POST['pat'];
        $date = $_POST['date'];
        $time = $_POST['time'];

        $datetime = $date . ' ' . $time;
        if ($control_appointment->update_appointment_info($key,$datetime)){
            $datetime = $control_appointment->get_appointmet_info($key);
            $formattedDate = date('Y-m-d H:i:s', strtotime($datetime));
            $patient = $userObj->userData($p_id);

            $send_mailobj = new MailClass($patient->email,$patient->firstname . " " . $patient->lastname,"To pay for your therapy - MHS", "pay");
            $send_mailobj->setAdditional($formattedDate);
            $send_mailobj->set_key($key);
            $send_mailobj->pay();
        }else{
            header("Location:../set_appointment_time.php?err=1");
        }
    }
}
