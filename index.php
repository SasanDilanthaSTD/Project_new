<?php
require 'core/init.php';
require 'core/classes/ResourceLibrary.php';

include_once ("process/view_count.php");

if (!$userObj->isLoggedIn()) {
    $set_btnLog = true;
    $link = "login.php";
}else{
    $set_btnLog = false;
    $possition1 = $userObj->newPosition();
    if ($possition1 == "patient") {
        $link = "userprofile.php";
    } elseif ($possition1 == "doctor") {
        header("Location: doctorprofile.php");
        //$link = "doctorprofile.php";
    }elseif ($possition1 == "counselor") {
        header("Location: counselorprofile.php");
        //$link = "counselorprofile.php";
    }elseif ($possition1 == "admin") {
        $link = "admin_page.php";
    }
}
$resourceLibrarayObj = new \MyApp\ResourceLibrary();
$resources = $resourceLibrarayObj->accessSixRandomResources();
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aclonica&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Actor&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Advent+Pro&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alatsi&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aldrich&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kavivanar&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Stick+No+Bills&amp;display=swap">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/home.css">
    <?php include_once ('assets/css/set_footer.php');?>

</head>
<body >
<!--style="background: rgb(221,221,221);"-->

<!-- Start: nav bar -->
<div><!-- Start: Navbar Right Links -->
    <nav class="navbar navbar-expand-md bg-body py-3">
        <div class="container"><a class="navbar-brand d-flex align-items-center" href="#"
                                  style="padding-bottom: 0px;margin-top: 0px;padding-top: 0px;"><img
                    src="assets/img/logo.png" style="width: 109px;"></a>
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-2"><span
                    class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcol-2">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active itemnew" href="index.php"><strong>Home</strong></a></li>
                    <li class="nav-item"><a class="nav-link itemnew" href="aboutus.php"><strong>About Us</strong></a></li>
                    <li class="nav-item"><a class="nav-link itemnew" href="contactUs.php"><strong>Contact Us</strong></a></li>
                </ul>
                <?php if($set_btnLog){ ?>
                <a class="btn btn-primary ms-md-2 loginbtn" role="button" href="<?php echo $link;?>" style="border-style: none;"><strong><i class="fa-solid fa-right-to-bracket fa-beat-fade"></i>&nbsp Login</strong></a>
                <?php }else{ ?>
                <a class="btn btn-primary ms-md-2 loginbtn" role="button" href="<?php echo $link;?>" style="border-style: none;"><strong><i class="fa-solid fa-right-to-bracket fa-beat-fade"></i>&nbsp Profile</strong></a>
                <?php }?>
            </div>
        </div>
    </nav><!-- End: Navbar Right Links --></div><!-- End: nav bar -->
<!-- Start: first img -->

<div class="bigdiv "
     style="height: 650px;color: rgb(0,79,95);background: url(assets/img/mental-health-7323725_1280.webp) left / cover no-repeat;padding-bottom: 0px;border-top-style: none;border-right-style: none;border-bottom-style: none;border-left-style: none;">

    <!-- Start: caption -->
    <div style="padding-top: 20px;padding-left: 20px;">

        <h1
            style="margin-bottom: 0px;text-shadow: 0px 0px 20px var(--bs-tertiary-color);"><span
                style="color: rgb(255, 255, 255);">Feeling Sad?</span></h1>
        <h1 style="margin-bottom: 0px;border-radius: 17px;border-width: 5px;border-style: none;padding-top: 0px;margin-top: 0px;text-shadow: 0px 0px 20px var(--bs-tertiary-color);font-family: Kavivanar, serif;">
            <span style="color: rgb(255, 255, 255);">சோகமாக இருக்கிறதா?</span></h1>
        <h1 style="margin-bottom: 0px;font-family: 'Stick No Bills', sans-serif;text-shadow: 0px 0px 20px var(--bs-tertiary-color);">
            <span style="color: rgb(255, 255, 255);">දුකක් දැනෙනවාද?</span></h1>
        <button class="btn btn-primary loginbtn stressbtn" data-bss-hover-animate="pulse" type="button"
                style="border-style: none;height: 61px;margin-top: 21px;box-shadow: 0px 0px 20px var(--bs-border-color-translucent);width: 202.125px;font-size: 20px;border-radius: 20px;">
            <strong>Check Stress Level</strong></button>
    </div>

    <!-- End: caption -->
</div>

<!-- End: first img -->

<!--free counseling button start-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .fill-button {
            text-align: center;
            margin-top: 2%;
            margin-bottom: 2%;
        }

        .counselorbtn {
            border: 3px solid #00454f;
            color: #00454f;
            background: none;
            cursor: pointer;
            padding: 2% 6%; /* Adjust padding as needed */
            font-size: 2vw; /* Adjust font size as needed */
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            outline: none;
            position: relative;
            transition: all 1s;
        }

        .counselorbtn:hover {
            color: #fff;
        }

        .counselorbtn::after {
            content: '';
            position: absolute;
            z-index: -1;
            transition: all 1s;
            width: 0%;
            height: 100%;
            top: 0;
            left: 0;
            background: #00454f;
        }

        .counselorbtn:hover::after {
            width: 100%;
        }
    </style>
</head>
<body >
<hr style="margin-left: 20px; margin-right: 20px; margin-bottom: 30px;">
<div class="fill-button">
    <a href="counselors.php" style="text-decoration: none"><button class="counselorbtn">Free Counseling</button></a>
</div>
</body>
</html>
<!--free counseling button end-->

<!-- Start: content -->
<hr style="margin-left: 20px; margin-right: 20px; margin-bottom: 30px;">
<div class="videobackground content" style="background: url(assets/img/indexbg.jpeg) top / cover no-repeat fixed, rgb(63,70,79);">
    <h1 style="@import url('https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap');text-align: center;font-size: 56.52px;margin-bottom: 8px;padding-top: 20px;margin-top: 8px;color: rgb(253,253,253);text-shadow: 2px 3px 0px rgb(79,115,124);font-weight: bold;">
        <span style="">Relax&nbsp;</span>Yourself
    </h1>

    <div>
<?php
foreach ($resources as $resource) {

?>
        <div class="video-container">
            <iframe src="<?php echo $resource->link;?>" title="YouTube video" allowfullscreen></iframe>
        </div>
        <?php
}
        ?>

    </div>

    <div style="text-align: center; padding-bottom: 50px;border-radius: 50px">
        <a href="resourceVideosView.php" style="text-decoration: none"><button class="glow-on-hover" type="button" style="font-weight: bold; border-radius: 20px">Watch More</button></a>
    </div>

</div>
<!-- End: chatcounselor -->
<!-- Start: footer -->
<div>
    <!-- Start: Footer Basic -->
    <footer class="text-center" style="background: rgb(255,255,255);">
        <div class="container text-muted py-4 py-lg-5">
            <ul class="list-inline">
                <li class="list-inline-item me-4"><a class="link-secondary" href="#">mentalhealthservice@gmail.com</a>
                </li>
                <li class="list-inline-item me-4"><a class="link-secondary" href="#">+94 91 890 4444</a></li>
            </ul>
            <ul class="list-inline">
                <li class="list-inline-item me-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                         viewBox="0 0 16 16" class="bi bi-facebook">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"></path>
                    </svg>
                </li>
                <li class="list-inline-item me-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                         viewBox="0 0 16 16" class="bi bi-twitter">
                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"></path>
                    </svg>
                </li>
                <li class="list-inline-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                         viewBox="0 0 16 16" class="bi bi-instagram">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"></path>
                    </svg>
                </li>
            </ul>
            <p class="mb-0">Copyright © 2023 Mental Health Service</p></div>
    </footer><!-- End: Footer Basic --></div><!-- End: footer -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/script.min.js"></script>
</body>
</html>
