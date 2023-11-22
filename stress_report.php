<?php
use MyApp\Admin;
require_once "core/classes/Admin.php";

$admin = new Admin();

$score=$msg=$unregid= "";
$bd_msg=$status="";

if (isset($_COOKIE['unreg_id'])){
    $unregid = $_COOKIE['unreg_id'];
    if (isset($_GET['score'])){
        $score_get = (int)$_GET['score'];
        if ($score_get >= 0 && $score_get <= 13){
            $score = "<span class=\"text-success fw-nomal\" style=\"font-size: 25px;\" id=\"score\">$score_get</span>";
            $msg = "<span class=\"text-success\"><strong class=\"font-monospace\">Low Stress</strong><br><small>Great news! Your stress level is within the normal range. You're welcome to explore our website and discover various relaxation features that can help you unwind and further enhance your well-being.</small></span>";
            $status = "Normal";
            $bd_msg = "Individual's stress level is within a healthy and manageable range, as measured by our stress level questions. They are likely feeling relatively calm and composed, with no immediate need for intervention or additional support.";
        }elseif ($score_get >=14 && $score_get <= 26){
            $score = "<span class=\"text-warning fw-nomal\" style=\"font-size: 25px;\" id=\"score\">$score_get</span>";
            $msg = "<span class=\"text-warning\"><strong class=\"font-monospace\">Moderate Stress.</strong><br><small>Since your stress level is in the moderate range, it may be beneficial for your overall well-being to consider contacting one of our counsellors. They are here to provide support and guidance to help you maintain good mental health.</small></span>";
            $status = "Moderate";
            $bd_msg = "The person is experiencing a moderate amount of stress, as determined by our stress level questions. While it may not be at a critical level, it's essential to acknowledge and address their stress to prevent it from escalating further.";
        }else{
            $score = "<span class=\"text-danger fw-nomal\" style=\"font-size: 25px;\" id=\"score\">$score_get</span>";
            $msg = "<span class=\"text-danger\"><strong class=\"font-monospace\">High perceived Stress.</strong><br><small>We're genuinely concerned about your high stress level. It's essential to prioritize your well-being. Please consider reaching out to one of our counsellors immediately for expert guidance and support.</small></span>";
            $status = "High Perceived";
            $bd_msg = "Individual is under significant stress and experiencing high tension, as measured by our stress level questions. It's a critical indicator that immediate action should be taken to address their stress levels. Encouraging them to reach out to a counsellor or seek professional help is essential in this situation.";
        }
        if (!($admin->stress_tool_update_1($unregid,$bd_msg,$status))){
            echo "ERROR_2 : Data Inasert Failed!";
        }
    }

}else{
    $unregid = $admin->get_unreg_id();
    setcookie('unreg_id',$unregid, time()+(3600 *24 *365));

    if ($admin->insert_unreg_user($unregid)){
        if (isset($_GET)){
            if (isset($_GET['score'])){
                $score_get = (int)$_GET['score'];
                if ($score_get >= 0 && $score_get <= 13){
                    $score = "<span class=\"text-success fw-nomal\" style=\"font-size: 25px;\" id=\"score\">$score_get</span>";
                    $msg = "<span class=\"text-success\"><strong class=\"font-monospace\">Low Stress</strong><br><small>Great news! Your stress level is within the normal range. You're welcome to explore our website and discover various relaxation features that can help you unwind and further enhance your well-being.</small></span>";
                    $status = "Normal";
                    $bd_msg = "Individual's stress level is within a healthy and manageable range, as measured by our stress level questions. They are likely feeling relatively calm and composed, with no immediate need for intervention or additional support.";
                }elseif ($score_get >=14 && $score_get <= 26){
                    $score = "<span class=\"text-warning fw-nomal\" style=\"font-size: 25px;\" id=\"score\">$score_get</span>";
                    $msg = "<span class=\"text-warning\"><strong class=\"font-monospace\">Moderate Stress.</strong><br><small>Since your stress level is in the moderate range, it may be beneficial for your overall well-being to consider contacting one of our counsellors. They are here to provide support and guidance to help you maintain good mental health.</small></span>";
                    $status = "Moderate";
                    $bd_msg = "The person is experiencing a moderate amount of stress, as determined by our stress level questions. While it may not be at a critical level, it's essential to acknowledge and address their stress to prevent it from escalating further.";
                }else{
                    $score = "<span class=\"text-danger fw-nomal\" style=\"font-size: 25px;\" id=\"score\">$score_get</span>";
                    $msg = "<span class=\"text-danger\"><strong class=\"font-monospace\">High perceived Stress.</strong><br><small>We're genuinely concerned about your high stress level. It's essential to prioritize your well-being. Please consider reaching out to one of our counsellors immediately for expert guidance and support.</small></span>";
                    $status = "High Perceived";
                    $bd_msg = "Individual is under significant stress and experiencing high tension, as measured by our stress level questions. It's a critical indicator that immediate action should be taken to address their stress levels. Encouraging them to reach out to a counsellor or seek professional help is essential in this situation.";
                }
                if (!($admin->stress_tool_insert_1($unregid,$bd_msg,$status))){
                    echo "ERROR_2 : Data Inasert Failed!";
                }
            }
        }
    }else{
        echo "ERROR_1 : Data Inasert Failed!";
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PSS Report</title>
    <!-- Font Awesome -->
    <link
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
            rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
            href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
            rel="stylesheet"
    />
    <!-- MDB -->
    <link
            href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css"
            rel="stylesheet"
    />

    <style>

        .bg-glass{
            background: hsla(0, 11%, 61%, 0.07);
            backdrop-filter: blur(30px);
        }
        .bg-glass_sub{
            background: hsla(0, 0%, 94%, 0.07);
            backdrop-filter: blur(2px);
        }

        .txt-gradient{
            background: linear-gradient(-70deg, #00ff81 0%, #006eff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bg-theme{
            background-color: hsl(218,41%,25%);
        }

        .text-muted{
            color: hsla(194, 100%, 50%, 0.73) !important;
        }
        .text-info{
            color: hsl(194, 100%, 50%) !important;
        }
        .text-success{
            color: hsl(144, 100%, 45%) !important;
        }
        .text-danger{
            color: hsl(350, 100%, 60%) !important;
        }
        .tb-row:hover {
            background-color: hsla(219, 79%, 82%, 0.49);
            transition-delay: 0.5ms;
        }
        .btn-txt-color{
            color: hsl(0, 13%, 89%) ;
        }
        .btn-txt-color:hover{
            color: hsla(220, 81%, 61%, 0.32) !important;
        }
        @media(max-width: 992px) {
            body{
                height: 100%;
            }
        }
    </style>

</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <div class="container mb-5 mt-3">
                <div class="row d-flex align-items-baseline">
                    <div class="col-xl-9">
                        <p style="color: #7e8d9f;font-size: 20px;">REPORT&gt;&gt; <strong>ID: <span id="unregid"><?php echo $unregid; ?></span></strong></p>
                        <input type="hidden" id="url" value="<?php echo $url; ?>">
                    </div>
                </div>
                <div class="container">
                    <div class="col-md-12" style="margin-bottom: 20px;">
                        <div class="text-center">
                            <img src="assets/img/logo.png" alt="LOGO" class="d-block mx-auto img-fluid" style="max-width: 12rem;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="margin-top: 20px;">
                            <div class="text-center">
                                <p class="text-black"><span class="text-black me-3"> Your Score : <?php echo $score ;?></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="row my-2 mx-1 justify-content-center">
                        <div class="col-md-12 mb-4 mb-md-0">
                            <p class="fw-bold">Status</p>
                            <p class="mb-1">
                                <span class="text-muted me-2">Stress Level : </span><?php echo $msg;?>
                            </p>
                            <p>
                                <span class="text-gray me-2"><small style="font-size: 12px">( © Base on PSS method - State of New Hampshire Employee Assistance Program)</small></span>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xl-8">
                            <p class="ms-3 fw-bold">Add additional notes</p>
                            <ul class="list-unstyled">
                                <li class="text-muted ms-3">
                                    <i class="fas fa-feather-pointed me-2"></i>
                                    <span class="text-black fw-light me-4">Scores ranging from 0-13 would be considered low stress.</span>
                                </li>
                                <li class="text-muted ms-3 mt-2">
                                    <i class="fas fa-feather-pointed me-2"></i>
                                    <span class="text-black fw-light me-4">Scores ranging from 14-26 would be considered moderate stress.</span>
                                </li>
                                <li class="text-muted ms-3 mt-2">
                                    <i class="fas fa-feather-pointed me-2"></i>
                                    <span class="text-black fw-light me-4">Scores ranging from 27-40 would be considered high perceived stress.</span>
                                </li>
                            </ul>
                        </div>

                        <div class="col-xl-3">
                            <ul class="list-unstyled">
                                <li class="text-muted ms-3"><button type="button" id="btnView" class="btn btn-outline-primary btn-rounded" data-mdb-ripple-color="dark">View Counseler</button></li>
                                <li class="text-muted ms-3 mt-2"><button type="button" id="btnHome" class="btn btn-outline-primary btn-rounded" data-mdb-ripple-color="dark">Go to Home Page</button></li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>

<script
        type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"
></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function (){
        let unreg =  $("#unregid").text();
        let txtScore = $('#score').text();
        let  score = parseInt(txtScore);
        if (score < 14){
            $("#btnView").hide();
        }else {
            $("#btnView").show();
        }
        console.log(txtScore);

        $("#btnView").click(function (){
            let url = "counselors.php";
            $(location).attr('href',url);
        });

        $("#btnHome").click(function (){
            let url = "../index.php?report_status=success&setcookie=yes&id="+unreg;
            $(location).attr('href',url);
        });
    });
</script>
</body>
</html>

