<?php
require 'core/init.php';

if (!$userObj->isLoggedIn()) {
    $userObj->redirect('login.php');
}

$userObj->updateSession();

if (isset($_GET['username']) && !empty($_GET['username'])) {
    $profileData = $userObj->getUserByUsername($_GET['username']);
    $user = $userObj->userData();
//    $user2 = $userObj->getuser();
//    var_dump($userObj->getUserBySession($user->sessionID));
    if (!$profileData) {
        $userObj->redirect('videohome.php');
    } elseif ($profileData->username === $user->username) {
        $userObj->redirect('videohome.php');
    }
} else {
    $userObj->redirect('videohome.php');
}
$possition1 = $userObj->newPosition();
if ($possition1 == "patient") {
    $link = "userprofile.php";
    $user2 = $userObj->getDoctors();
} elseif ($possition1 == "doctor") {
    $link = "doctorprofile.php";
    $user2 = $userObj->getPatients();
}
//var_dump($profileData);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/chatprofile.css">
    <link rel="stylesheet" href="assets/css/videoInterface.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        const conn = new WebSocket('ws://localhost:8080/?token=<?php echo $userObj->sessionID;?>');
    </script>
</head>
<body style="background: url(assets/img/userbg1.jpg) right / cover no-repeat fixed, rgb(63,70,79);">

<!-- Start: nav bar -->
<div><!-- Start: Navbar Right Links -->
    <nav class="navbar navbar-expand-md bg-body py-3">
        <div class="container"><a class="navbar-brand d-flex align-items-center" href="#"
                                  style="padding-bottom: 0px;margin-top: 0px;padding-top: 0px;"><img
                        src="assets/img/logo.png"
                        style="width: 109px;"></a>
            <button data-bs-toggle="collapse" class="navbar-toggler"
                    data-bs-target="#navcol-2"><span class="visually-hidden">Toggle navigation</span><span
                        class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-2">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link itemnew" href="index.php"><strong><span
                                        style="color: rgb(0, 79, 95);">Home</span></strong></a></li>
                    <li class="nav-item"><a class="nav-link itemnew" href="aboutus.php"><strong>About Us</strong></a></li>
                    <li class="nav-item"><a class="nav-link itemnew" href="#"><strong>Contact Us</strong></a></li>
                </ul>
                <a class="btn btn-primary ms-md-2 loginbtn" role="button" href="process/logout.php" style="border-style: none;">
                    <i class="fa-solid fa-right-from-bracket fa-beat-fade"></i><strong> Logout</strong></a>
            </div>
        </div>
    </nav><!-- End: Navbar Right Links -->
</div><!-- End: nav bar --><!-- Start: heading -->
<div style="background: url(&quot;assets/img/doctor.jpg&quot;) no-repeat;background-size: cover;">
    <h1 style="text-align: center;color: rgb(255,255,255);margin: 0px;padding: 6px;padding-top: 40px;padding-bottom: 40px;">
        MHS VIDEOZ&nbsp;&nbsp;<i class="fa-solid fa-phone-flip fa-shake"></i>&nbsp;&nbsp;<i class="fa-solid fa-video fa-shake"></i></h1>
</div><!-- End: heading -->

<!--alert popup-->
<!--call popup-->
<div id="callBox" class="hidden z-10 transition absolute w-full h-full flex item-center justify-center popup ">
    <div class="pop-up flex justify-between w-96 bg-white rounded overflow-hidden ">
        <div class="row popupInside greenrowborder" style="margin-top: 15px" >
            <div class="col d-flex flex-nowrap py-2 overflow-hidden">
                <img id="profileImage" class="w-full  callimage" src="<?php echo BASE_URL . $profileData->profile_photo; ?>">
                <h5 id="username" class="mr-auto my-auto" style="color: white">&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $profileData->firstname." ".$profileData->lastname; ?><span style="color: white;font-size: 10px"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></h5>

                <button id="declineBtn" class="popupdecline" style="background-color: red;color: white;border-radius: 50%;width: 46px;height: 46px"><i class="fas fa-times-circle" style="font-size: 20px"></i></button>
                <button id="answerBtn" style="background-color: white;color: #00454f;border-radius: 50%;width: 46px;height: 46px"><i class="fas fa-phone"></i></button>

            </div>
        </div>
    </div>
</div>

<div id="chatBody" class="glass wrapper "><!-- Start: Chat -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-xl-4" style="width: 310px;"><!-- Start: Me -->
                <div class="row">
                    <div
                            class="col d-flex flex-nowrap justify-content-md-center align-items-md-center justify-content-lg-center align-items-lg-center justify-content-xl-center align-items-xl-center py-2 greenrowborder"
                            style="background: rgb(0,69,79);height: 4rem;color: var(--bs-body-bg);">
                        <h5 class="mr-auto my-auto"><?php echo $user->firstname." ".$user->lastname;?>&nbsp; &nbsp;&nbsp;</h5><img width="46" height="46"
                                                                                                                                   src="<?php echo $user->profile_photo;?>" style="border-radius: 25px;">
                    </div>
                </div><!-- End: Me --><!-- Start: Search input -->
                <div class="row px-3 py-2">
                    <div class="col" style="border-radius: 25px;box-shadow: 0px 0px 5px var(--gray-dark);">
                        <form class="d-flex align-items-center px-2">
<!--                            <i class="fas fa-search fa-lg"></i>-->
<!--                            <input-->
<!--                                    class="shadow-none form-control flex-shrink-1" type="search"-->
<!--                                    placeholder="Search Docter Name"-->
<!--                                    style="border-radius: 13px;border-style: none;">-->
                            <input class="shadow-none form-control flex-shrink-1" type="search" id="myInput" placeholder="Search for names..." onkeyup="search();" style="border-color: #00454f">
                            <i class="fas fa-search fa-lg" style="margin-left: 5px"></i>
                        </form>
                    </div>
                </div><!-- End: Search input --><!-- Start: Chats -->

                <div class="row">

                    <div class="col" style="overflow-x: none;overflow-y: auto;max-height: 32.5rem;height: auto;">

                        <ul class="list-unstyled">
                            <?php
                            foreach ($user2 as $doctors) {
                                ?>
                                <a href="<?php echo BASE_URL . $doctors->username; ?>" style="text-decoration: none">
                                    <li style="cursor:pointer;">
                                        <div class="card border-0" id="myTable" style="margin: 5px;border-radius: 20px;">
                                            <div class="card-body">
                                                <h6 class="text-nowrap text-truncate card-title"><img
                                                            src="<?php echo $doctors->profile_photo; ?>" width="48"
                                                            height="47"
                                                            style="width: 46px;height: 46px;border-radius: 25px;">&nbsp;
                                                    &nbsp; <?php echo $doctors->firstname." ".$doctors->lastname;?></h6>
                                            </div>
                                        </div>
                                    </li>
                                </a>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div><!-- End: Chats -->
            </div>
            <div class="col d-lg-block d-xl-block"><!-- Start: In Chat With -->
                <div class="row">
                    <div class="col d-flex align-items-lg-center align-items-xl-center border-start border-muted greenrowborder"
                         style="background: rgb(0,69,79);height: 4rem;color: var(--bs-body-bg);">
                        <button
                                class="btn d-block d-sm-block d-md-block d-lg-none d-xl-none border-0 my-auto"
                                type="button"
                                style="width: 2.5rem;height: 2.5rem;">
<!--                            <i class="far fa-arrow-alt-circle-left"></i>-->
                        </button>
                        <h5 class="mr-auto my-auto"></h5><span class="my-auto"></span>
                    </div>
                </div><!-- End: In Chat With -->
                <div class="row" id="pic-and-name" style="text-align: center;">
                    <div class="col">
                        <div class="row">
                            <div class="col"><img width="300" height="289"
                                                  src="<?php echo BASE_URL . $profileData->profile_photo; ?>"
                                                  style="margin-top: 86px;margin-bottom: 20px;border-radius: 100%">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h1 style="margin-bottom: 10px;"><?php echo $profileData->firstname . " " .$profileData->lastname; ?><span style="font-size: 13px">(<?php echo $profileData->status;?>)</span></h1>
                                <!-- Start: Video call request -->
                                <div class="row px-3 py-2 greenrowborder"
                                     style="background: rgb(0,69,79);margin-top: 74.5px;color: var(--bs-body-bg);">
                                    <div class="col-9 col-sm-10 col-md-10 col-lg-10 col-xl-10"
                                         style="padding: 0;text-align: center;">
                                        <h6 style="text-align: center;padding-top: 10px;">Do you want to make a call
                                            ?</h6>
                                    </div>
                                    <div class="col-3 col-sm-2 col-md-2 col-lg-2 col-xl-2 text-nowrap d-md-flex justify-content-md-end p-0">
                                        <button id="callBtn" class="btn btn-light h-100 w-auto"
                                                data-user="<?php echo $profileData->user_id ; ?>" type="button"
                                                style="border-radius: 10px;"><i class="fa-solid fa-video fa-beat-fade"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- End: Video call request -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End: Chat -->
</div>

<div>
    <!--    video call-->


<!--    <div id="video" class="hidden glass">-->
<!--        <div>-->
<!--            <video src="" id="remoteVideo" style="width: 1080px;" autoplay playsinline></video>-->
<!--            <video src="" id="localVideo" autoplay playsinline></video>-->
<!--        </div>-->
<!--        <div>-->
<!--            <span id="minutes"></span>:<span id="seconds"></span>-->
<!--        </div>-->
<!--        <div>-->
<!--            <button id="hangupBtn">Hang up</button>-->
<!--        </div>-->
<!--    </div>-->
</div>



<div id="video" class="hidden glass" style="background-color: rgba(0,69,79,0.1)">
    <div class="container-fluid top-container">
        <div class="row">
            <div class="col-10 col-md-9 col-lg-9 col-xl-8 offset-0 offset-xl-0 align-self-center"
                 style="margin-bottom: 20px;">
                <div class="img-container" style="margin-left: 4px;">
                    <video src="" id="remoteVideo" class="" style="width: 108%;border-radius: 25px" autoplay playsinline></video>
                </div>
            </div>
            <div class="col-2 col-md-2 offset-xl-1 align-self-center">
                <div class="row justify-content-end img-row">
                    <div class="col">
                        <video src="" id="localVideo" class=" img-fluid" style="border-radius: 20px" autoplay playsinline></video>
                        <button id="hangupBtn" class="btn btn-primary btnCallEnd" type="button" style="border-radius: 12px;background: linear-gradient(131deg, #ff0000 19%, #000000 100%), rgba(191,0,0,0.89); border: none;">
                            <i class="fas fa-phone-slash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div id="back" style="text-align: center;margin-top: 54px;margin-bottom: 3vw"><a class="btn btn-primary ms-md-2 loginbtn btntype2" role="button"
                                                                                 href="index.php" style="border-style: none; margin-right: 10px"><i class="fa-solid fa-house fa-beat-fade"></i><strong>&nbsp; Home</strong></a><a
            class="btn btn-primary ms-md-2 loginbtn" role="button" href="<?php echo $link;?>" style="border-style: none;">
        <i class="fa-solid fa-backward fa-beat-fade"></i><strong>&nbsp; Profile</strong></a>
</div>

<div>
    <!-- Start: Footer Basic -->
    <footer class="text-center" style="background: rgb(255, 255, 255)">
        <div class="container text-muted py-4 py-lg-5">
            <ul class="list-inline" style="margin-top: -25px">
                <li class="list-inline-item me-4">
                    <a class="link-secondary" href="#"
                    ><br/><span
                                style="color: RGBA(86, 94, 100, var(--bs-link-opacity, 1))"
                        >mentalhealthservice@gmail.com</span
                        ></a
                    >
                </li>
                <li class="list-inline-item me-4">
                    <a class="link-secondary" href="#"
                    ><br/><span
                                style="color: RGBA(86, 94, 100, var(--bs-link-opacity, 1))"
                        >+94 91 890 4444</span
                        ></a
                    >
                </li>
            </ul>
            <ul class="list-inline">
                <li class="list-inline-item me-4">
                    <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="1em"
                            height="1em"
                            fill="currentColor"
                            viewBox="0 0 16 16"
                            class="bi bi-facebook"
                    >
                        <path
                                d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"
                        ></path>
                    </svg>
                </li>
                <li class="list-inline-item me-4">
                    <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="1em"
                            height="1em"
                            fill="currentColor"
                            viewBox="0 0 16 16"
                            class="bi bi-twitter"
                    >
                        <path
                                d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"
                        ></path>
                    </svg>
                </li>
                <li class="list-inline-item">
                    <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="1em"
                            height="1em"
                            fill="currentColor"
                            viewBox="0 0 16 16"
                            class="bi bi-instagram"
                    >
                        <path
                                d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"
                        ></path>
                    </svg>
                </li>
            </ul>
            <p class="mb-0">Copyright © 2023 Mental Health Service</p>
        </div>
    </footer>
    <!-- End: Footer Basic -->
</div>
<!-- End: footer -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/search.js"></script>
<!--<script type="text/javascript" src="assets/js/main.js"></script>-->
<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
</body>
</html>
