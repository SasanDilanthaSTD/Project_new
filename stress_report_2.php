<?php
use MyApp\Admin;
require_once "core/classes/Admin.php";

$admin = new Admin();
$REP_ID = "REP" . rand(10,10000);
$s_stast = $s_socore =$a_stast = $a_socore=$d_stast = $d_socore = "";
if (isset($_GET)){
    $a_socore = $_GET['Ascore'];
    $d_socore = $_GET['Dscore'];
    $s_socore = $_GET['Sscore'];

    if ($s_socore >= 0 || $s_socore <= 14){
        $s_stast = "<span class=\"text-success\"><strong class=\"font-monospace\">Normal</strong><br><small> Score Level | $s_socore</small></span>";
    }else if($s_socore >= 15 || $s_socore <= 18){
        $s_stast = "<span class=\"text-success\" style=\"color: #00cc66 !important;\"><strong class=\"font-monospace\">Mild</strong><br><small> Score Level | $s_socore</small></span>";
    }else if($s_socore >= 19 || $s_socore <= 25){
        $s_stast = "<span class=\"text-warning\"><strong class=\"font-monospace\">Moderate</strong><br><small> Score Level | $s_socore</small></span>";
    }else if($s_socore >= 26 || $s_socore <= 33){
        $s_stast = "<span class=\"text-success\" style=\"color: #CC3600FF !important;\"><strong class=\"font-monospace\">Severe</strong><br><small> Score Level | $s_socore</small></span>";
    }else if($s_socore >= 34){
        $s_stast = "<span class=\"text-danger\"><strong class=\"font-monospace\">Extremely Severe</strong><br><small> Score Level | $s_socore</small></span>";
    }

    if ($a_socore >= 0 || $a_socore <= 7){
        $a_stast = "<span class=\"text-success\"><strong class=\"font-monospace\">Normal</strong><br><small> Score Level | $s_socore</small></span>";
    }else if($a_socore >= 8 || $a_socore <= 9){
        $a_stast = "<span class=\"text-success\" style=\"color: #00cc66 !important;\"><strong class=\"font-monospace\">Mild</strong><br><small> Score Level | $s_socore</small></span>";
    }else if($a_socore >= 10 || $a_socore <= 14){
        $a_stast = "<span class=\"text-warning\"><strong class=\"font-monospace\">Moderate</strong><br><small> Score Level | $s_socore</small></span>";
    }else if($a_socore >= 15 || $a_socore <= 19){
        $a_stast = "<span class=\"text-success\" style=\"color: #CC3600FF !important;\"><strong class=\"font-monospace\">Severe</strong><br><small> Score Level | $s_socore</small></span>";
    }else if($a_socore >= 20){
        $a_stast = "<span class=\"text-danger\"><strong class=\"font-monospace\">Extremely Severe</strong><br><small> Score Level | $s_socore</small></span>";
    }

    if ($d_socore >= 0 || $d_socore <= 9){
        $d_stast = "<span class=\"text-success\"><strong class=\"font-monospace\">Normal</strong><br><small> Score Level | $s_socore</small></span>";
    }else if($d_socore >= 10 || $d_socore <= 13){
        $d_stast = "<span class=\"text-success\" style=\"color: #00cc66 !important;\"><strong class=\"font-monospace\">Mild</strong><br><small> Score Level | $s_socore</small></span>";
    }else if($d_socore >= 14 || $d_socore <= 20){
        $d_stast = "<span class=\"text-warning\"><strong class=\"font-monospace\">Moderate</strong><br><small> Score Level | $s_socore</small></span>";
    }else if($d_socore >= 21 || $d_socore <= 27){
        $d_stast = "<span class=\"text-success\" style=\"color: #CC3600FF !important;\"><strong class=\"font-monospace\">Severe</strong><br><small> Score Level | $s_socore</small></span>";
    }else if($d_socore >= 28){
        $d_stast = "<span class=\"text-danger\"><strong class=\"font-monospace\">Extremely Severe</strong><br><small> Score Level | $s_socore</small></span>";
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
                        <p style="color: #7e8d9f;font-size: 20px;">REPORT&gt;&gt; <strong>ID: <span id="unregid"><?=$REP_ID ?></span></strong></p>
                        <input type="hidden" id="url" value="<?php echo $url; ?>">
                    </div>
                </div>
                <div class="container">
                    <div class="col-md-12" style="margin-bottom: 20px;">
                        <div class="text-center">
                            <img src="assets/img/logo.png" alt="LOGO" class="d-block mx-auto img-fluid" style="max-width: 12rem;">
                        </div>
                    </div>
                    <div class="row my-2 mx-1 justify-content-center">
                        <div class="col-md-12 mb-4 mb-md-0">
                            <p class="fw-bold">Result of DASS21</p>
                            <p class="mb-1">
                                <span class="text-muted me-2">Stress Level : </span><?=$s_stast ?>
                            </p>
                            <p class="mb-1">
                                <span class="text-muted me-2">Anxiety Level : </span><?=$a_stast?>
                            </p>
                            <p class="mb-1">
                                <span class="text-muted me-2">Depression Level : </span><?=$d_socore?>
                            </p>
                            <p>
                                <span class="text-gray me-2"><small style="font-size: 12px">( © Base on DASS21 method - Lovibond, S H, and Peter F Lovibond. Manual for the Depression Anxiety Stress Scales. 2nd ed., Sydney,
N.S.W., Psychology Foundation of Australia, 1995.)</small></span>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xl-8">
                            <p class="ms-3 fw-bold">Add additional notes</p>
                            <img src="assets/img/stress.jpg" alt="">
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
            let url = "index.php?report_status=success&setcookie=yes&id="+unreg;
            $(location).attr('href',url);
        });
    });
</script>
</body>
</html>

