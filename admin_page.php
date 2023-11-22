<?php
require_once 'core/init.php';
require_once 'core/classes/MassageCncpt.php';


require_once "core/classes/Admin.php";

use MyApp\Admin;

$massage = new \MyApp\MassageCncpt();

if (!$userObj->isLoggedIn()) {
    $userObj->redirect('login.php');
}
$userObj->updateStatus("online");
$user = $userObj->userData();
$admin_id = $userObj->ID();


$admin = new Admin();
$pending_count = $admin->get_pending_applications_count();
$rs = $admin->get_pending_applications();

// doctor data for bar chart
$doc_data_set = $admin->for_barchart_d();
$doc_data = [];

if (!empty($doc_data_set)){
    foreach ($doc_data_set as $doc) {
        if ($doc->registration_month == "1") {
            $doc_data[0] = $doc->registered_count;
        } elseif ($doc->registration_month == "2") {
            $doc_data[1] = $doc->registered_count;
        } elseif ($doc->registration_month == "3") {
            $doc_data[2] = $doc->registered_count;
        } elseif ($doc->registration_month == "4") {
            $doc_data[3] = $doc->registered_count;
        } elseif ($doc->registration_month == "5") {
            $doc_data[4] = $doc->registered_count;
        } elseif ($doc->registration_month == "6") {
            $doc_data[5] = $doc->registered_count;
        } elseif ($doc->registration_month == "7") {
            $doc_data[6] = $doc->registered_count;
        } elseif ($doc->registration_month == "8") {
            $doc_data[7] = $doc->registered_count;
        } elseif ($doc->registration_month == "9") {
            $doc_data[8] = $doc->registered_count;
        } elseif ($doc->registration_month == "10") {
            $doc_data[9] = $doc->registered_count;
        } elseif ($doc->registration_month == "11") {
            $doc_data[10] = $doc->registered_count;
        } elseif ($doc->registration_month == "12") {
            $doc_data[11] = $doc->registered_count;
        }
    }
}

// counselor data for bar chart
$cou_data_set = $admin->for_barchart_c();
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

    //view data for chart
    $chart = "month";
    if (isset($_GET['chart'])){
        if ($_GET['chart'] == "day")
        $chart = "day";
    }
    $viw_data_set_m = "";
    $viw_data_set = $admin->for_view_chart_month();
    $viw_data = [];
    $viw_data[0]=$viw_data[1]=$viw_data[2]=$viw_data[3]=$viw_data[4]=$viw_data[5]=$viw_data[6]=$viw_data[7]=$viw_data[8]=$viw_data[9]=$viw_data[10]=$viw_data[11]=0;
    foreach ($viw_data_set as $view){
        if ($view->month == 1){
            $viw_data[0] = $view->total_count;
        }elseif ($view->month == 2){
            $viw_data[1] = $view->total_count;
        }elseif ($view->month == 3){
            $viw_data[2] = $view->total_count;
        }elseif ($view->month == 4){
            $viw_data[3] = $view->total_count;
        }elseif ($view->month == 5){
            $viw_data[4] = $view->total_count;
        }elseif ($view->month == 6){
            $viw_data[5] = $view->total_count;
        }elseif ($view->month == 7){
            $viw_data[6] = $view->total_count;
        }elseif ($view->month == 8){
            $viw_data[7] = $view->total_count;
        }elseif ($view->month == 9){
            $viw_data[8] = $view->total_count;
        }elseif ($view->month == 10){
            $viw_data[9] = $view->total_count;
        }elseif ($view->month == 11){
            $viw_data[10] = $view->total_count;
        }elseif ($view->month == 12){
            $viw_data[11] = $view->total_count;
        }
    }

    $viw_data_set_m = $admin->for_view_chart_day();
    $viw_data_m =[];
    $i = 0;
    if (!empty($viw_data_set_m)){
        foreach ($viw_data_set_m  as $day){
            $viw_data_m[$i]['day'] = $day->date;
            $viw_data_m[$i]['count'] = $day->count;
            $i++;
        }
    }else{
        echo "erro";
    }
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ADMIN DASHBORD</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="assets/css/admin.css">


    <style>
        .chart-container {
            width: 100%;
            min-height: 300px;
            position: relative;
        }

    </style>

</head>
<body>
<!--Navigaion Bar start-->

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid justify-content-between">
        <!-- Left elements -->
        <div class="d-flex">
            <!-- Brand -->
            <a class="navbar-brand me-2 mb-1 d-flex align-items-center" href="home.php">
                <img
                        src="assets/img/logo.png"
                        height="40"
                        alt="MHS Logo"
                        loading="lazy"
                        style="margin-top: 2px;margin-left: 2rem;width: 100%;"
                />
            </a>
        </div>
        <!-- Left elements -->

        <!-- Center elements -->
        <ul class="navbar-nav flex-row d-none d-md-flex">

            <li class="nav-item me-3 me-lg-1">
                <a class="nav-link text-info" href="admin_page.php">
                    <span><strong class="d-none d-sm-block ms-1 text-uppercase">welcome to admin panel</strong></span>
                </a>
            </li>
        </ul>
        <!-- Center elements -->

        <!-- Right elements -->
        <ul class="navbar-nav flex-row me-5">
            <li class="nav-item me-3 me-lg-1">
                <a class="nav-link d-sm-flex align-items-sm-center">
                    <img
                            src="<?php echo $user->profile_photo; ?>"
                            class="rounded-circle"
                            height="22"
                            alt="Admin"
                            loading="lazy"
                    />
                    <strong class="d-none d-sm-block ms-1"><?php echo $user->firstname . " " . $user->lastname; ?></strong>

                </a>
            </li>
            <li class="nav-item dropdown me-3 me-lg-1">
                <a
                        class="nav-link dropdown-toggle hidden-arrow"
                        href="#"
                        id="navbarDropdownMenuLink"
                        role="button"
                        data-mdb-toggle="dropdown"
                        aria-expanded="false"
                >
                    <i class="fas fa-chevron-circle-down fa-lg"></i>
                </a>
                <ul
                        class="dropdown-menu dropdown-menu-end"
                        aria-labelledby="navbarDropdownMenuLink"
                >
                    <li>
                        <a class="dropdown-item" href="#">Some news</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">Another news</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="process/logout.php"> <i
                                    class="fa fa-sign-out me-3"></i>Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Right elements -->
    </div>
</nav>

<!--Navigaion Bar end-->

<section class="home">
    <div class="container pt-5">
        <!--   section - admin summery     -->
        <section class="">
            <div class="row gx-lg-5">
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <!-- CARD -->
                    <a href="#"
                       class="bg-glass d-flex align-items-center p-4 shadow-4-strong rounded-6 text-reset ripple"
                       data-ripple-color="hsl(0,0%,75%)">
                        <div class="bg-theme p-3 rounded-4">
                            <i class="fas fa-users fa-lg text-white fa-fw"></i>
                        </div>

                        <div class="ms-4">
                            <p class="text-muted mb-2">Page views</p>
                            <p class="mb-0">
                                <span class="h5 me-2"><span id="visitCount">0</span></span>
                                <small class="text-warning text-sm">
                                    <i class="fa-solid fa-eye fa-beat-fade"></i>
                                    <span id="visitCountMonth">0</span>
                                </small>
                            </p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <!-- CARD -->
                    <a href="#"
                       class="bg-glass d-flex align-items-center p-4 shadow-4-strong rounded-6 text-reset ripple"
                       data-ripple-color="hsl(0,0%,75%)">
                        <div class="bg-theme p-3 rounded-4">
                            <i class="fa-solid fa-hand-holding-medical fa-lg text-white fa-fw"></i>
                            <!--<i class="fas fa-wallet fa-lg text-white fa-fw"></i>-->
                            <!--<i class="fa-solid fa-heart-circle-plus"></i>-->
                        </div>

                        <div class="ms-4">
                            <p class="text-muted mb-2">Registred patients</p>
                            <p class="mb-0">
                                <span class="h5 me-2"><span id="pat_T"></span> </span>
                                <small class="text-success text-sm">
                                    <i class="fa-solid fa-user-tie fa-beat-fade"></i>
                                    <span id="pat_Tm"></span>
                                </small>
                            </p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <!-- CARD -->
                    <a href="admin_action.php"
                       class="bg-glass d-flex align-items-center p-4 shadow-4-strong rounded-6 text-reset ripple"
                       data-ripple-color="hsl(0,0%,75%)">
                        <div class="bg-theme p-3 rounded-4">
                            <i class="fas fa-user-doctor fa-lg text-white fa-fw"></i>
                        </div>

                        <div class="ms-4">
                            <p class="text-muted mb-2">Doctors | Councillor</p>
                            <p class="mb-0">
                                <span class="h5 me-2"><span id="countT"></span></span>
                                <small class="text-warning text-sm">
                                    <i class="fa-solid fa-user-doctor fa-beat-fade me-1"></i><span id="countD"></span> |
                                    <i class="fa-solid fa-user-nurse fa-beat-fade me-1"></i><span id="countC"></span>
                                </small>
                            </p>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <!-- CARD -->
                    <a href="add_video.php"
                       class="bg-glass d-flex align-items-center p-4 shadow-4-strong rounded-6 text-reset ripple"
                       data-ripple-color="hsl(0,0%,75%)">
                        <div class="bg-theme p-3 rounded-4">
                            <i class="fa-solid fa-pen-to-square fa-lg text-white fa-fw"></i>
                        </div>

                        <div class="ms-4">
                            <p class="text-muted mb-2">Add New Video</p>
                            <p class="mb-0">
                                <span class="h5 me-2"><span id="videoCount"></span></span>
                                <small class="text-success text-sm">
                                    <i class="fa-regular fa-file-video fa-beat-fade"></i>
                                    <span id="newVideo"></span>
                                </small>
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- section - statistic -->
        <section class="mb-5 pt-5">

            <div class="row gx-lg-5">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <!--Card-->
                    <div class="bg-glass shadow-4-strong rounded-6">
                        <!--Card header-->
                        <div class="p-4 border-bottom">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <p class="text-muted mb-2">Web Visit</p>
                                    <!--<p class="mb-0">
                                        <span class="h4 me-2">14 567</span>
                                        <small class="text-success text-sm"><i class="fas fa-arrow-up fa-sm me-2"></i>13.45%</small>
                                    </p>-->
                                </div>
                                <div class="col-6 text-end">
                                    <div class="btn-group shadow-0">
                                        <button type="button"
                                                class="btn btn-link  btn-sm btn-outline-info dropdown-toggle"
                                                data-mdb-toggle="dropdown" aria-expanded="false"><i
                                                    class="fas fa-filter"></i>
                                            Filter
                                        </button>
                                        <ul class="dropdown-menu bg-glass">
                                            <li><a class="dropdown-item text-info" href="admin_page.php?chart=month">Monthly</a></li>
                                            <li><a class="dropdown-item text-info" href="admin_page.php?chart=day">Nearest 5 days</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Card body-->
                        <div class="p-4">
                            <div class="card-body chart-container"
                                 style="position: relative; height: auto; width: 100%;">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <!--Card-->
                    <div class="bg-glass shadow-4-strong rounded-6">
                        <!--Card header-->
                        <div class="p-4 border-bottom">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <p class="text-muted mb-2">Therapists</p>
                                    <!--<p class="mb-0">
                                        <span class="h4 me-2">14 567</span>
                                        <small class="text-success text-sm"><i class="fas fa-arrow-up fa-sm me-2"></i>13.45%</small>
                                    </p>-->
                                </div>
                                <div class="col-6 text-end">

                                </div>
                            </div>
                        </div>
                        <!--Card body-->
                        <div class="p-4">
                            <div class="card-body chart-container"
                                 style="position: relative; height: auto; width: 100%;">
                                <canvas id="barChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- section - user details -->
        <section class="mb-5 pt-5">
            <div class="table-responsive bg-glass shadow-4-strong rounded-6">
                <!--Card header-->
                <div class="p-4 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <p class="h3 text-muted mb-2">Pending Theraphists</p>
                            <p class="mb-0 text-warning">
                                <!--<i class="fa-solid fa-hourglass-end fa-fade me-2"></i>-->
                                <i class="fa-solid fa-person-dots-from-line fa-fade fa-lg fa-fw me-2"></i>
                                <span class="h4  me-2"><?= $pending_count ?></span>
                            </p>
                        </div>
                        <div class="col-6 text-end"></div>
                    </div>
                </div>
                <table class="table text-white align-middle mb-0 table-borderless  ">
                    <thead>
                    <tr class="text-info">
                        <th scope="col" class="text-center">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Role</th>
                        <th scope="col">Description</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (!empty($rs)) {
                    foreach ($rs as $therapist) {
                    $name = $therapist->firstname . ' ' . $therapist->lastname;
                    ?>
                    <tr class="tb-row">
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="<?php echo $therapist->profile_photo; ?>" alt=""
                                     style="width: 45px; height: 45px"
                                     class="rounded-circle"/>
                                <div class="ms-3">
                                    <p class="fw-bold text-info mb-1"><?php echo $name; ?></p>
                                    <p class="text-muted mb-0"><?php echo $therapist->email; ?></p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-warning d-inline">Pending</span>
                        </td>
                        <td class="text-info">
                            <?php
                            $role = substr($therapist->user_id, 0, 3);
                            echo ($role == "DOC") ? "Doctor" : "Counselor";

                            ?>
                        </td>
                        <td>
                            <p class="text-muted mb-0"><?php echo $therapist->description ?></p>
                        </td>
                        <td>
                            <a href="admin_pdf_view.php?k=<?php echo $therapist->user_id; ?>">
                                <button type="button" class="btn btn-link  btn-sm btn-rounded btn-outline-info">
                                    Check
                                </button>
                            </a>
                        </td>
                    </tr>
                    <?php }
                    } else { ?>
                        <tr class="tb-row">
                            <p class="h3 text-info">New Application haven't Arrived !</p>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</section>


<!--MDB JS-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
<!--MDB JS-->

<!-- Link to Chart.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
<!-- Link to Chart.js library -->
<!-- Jquery library-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Jquery library-->
<?php include_once "assets/js/admin_chat_js.php" ?>
<?php include_once "AJAX/admin_js.php" ?>

</body>
</html>