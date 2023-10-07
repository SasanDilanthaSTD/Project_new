<?php
require '../core/init.php';
require '../core/classes/Counselor.php';
require '../core/classes/Doctor.php';

if (!$userObj->isLoggedIn()) {
    $userObj->redirect('login.php');
}
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if (isset($_POST["save"])){
        $description = $_POST["description"];
        $wordCount = str_word_count($description);

        $possition1 = $userObj->newPosition();
        if ($possition1 == "counselor") {
            if ($wordCount > 15) {
                $userObj->redirect('counselorprofile.php?msg=4');
            }else{
                $counselorObj = new \MyApp\Counselor();
                $counselorObj->setCDescription($description);
                $tID = $counselorObj->getTherapistIDFromUserID();
                foreach ($tID as $item){
                    //echo $item;
                    if ($counselorObj->updateDescription($item)) {
                        $userObj->redirect('counselorprofile.php?msg=3');
                    }else{
                        echo "error";
                    }
                }
            }

//            $counselorObj = new \MyApp\Counselor();
//            $counselorObj->setCDescription($description);
//            $tID = $counselorObj->getTherapistIDFromUserID();
//            foreach ($tID as $item){
//                //echo $item;
//                if ($counselorObj->updateDescription($item)) {
//                    $userObj->redirect('counselorprofile.php?msg=3');
//                }else{
//                    echo "error";
//                }
//            }

        } elseif ($possition1 == "doctor") {
            if ($wordCount > 15) {
                $userObj->redirect('doctorprofile.php?msg=4');
            }else{
                $doctorObj = new \MyApp\Doctor();
                $doctorObj->setDDescription($description);
                $tID = $doctorObj->getTherapistIDFromUserID();
                foreach ($tID as $item){
                    //echo $item;
                    if ($doctorObj->updateDescription($item)) {
                        $userObj->redirect('doctorprofile.php?msg=3');
                    }else{
                        echo "error";
                    }
                }
            }
//            $doctorObj = new \MyApp\Doctor();
//            $doctorObj->setDDescription($description);
//            $tID = $doctorObj->getTherapistIDFromUserID();
//            foreach ($tID as $item){
//                //echo $item;
//                if ($doctorObj->updateDescription($item)) {
//                    $userObj->redirect('doctorprofile.php?msg=3');
//                }else{
//                    echo "error";
//                }
//            }
        }
    }
}