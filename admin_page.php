<?php
require 'core/init.php';
$user = $userObj->userData();

require_once "core/classes/DBConnector.php";
$con = \MyApp\DBConnector::getConnection();

$sql_table = 'SELECT DISTINCT user.user_id, user.firstname, user.lastname, user.profile_photo, therapist.description, therapist.approval FROM user, therapist, counselor, doctor WHERE (therapist.therapist_id = doctor.therapist_id AND user.user_id = doctor.user_id AND therapist.approval = "pending") OR (therapist.therapist_id = counselor.therapist_id AND user.user_id = counselor.user_id AND therapist.approval = "pending")';
$pstmt = $con->prepare($sql_table);
$pstmt->execute();
$rs = $pstmt->fetchAll(PDO::FETCH_OBJ);

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
            <a class="navbar-brand me-2 mb-1 d-flex align-items-center" href="index.php">
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
                    <span><i class="fa fa-quote-left"><strong class="d-none d-sm-block ms-1">welcome to admin panel</strong></i></span>
                </a>
            </li>
        </ul>
        <!-- Center elements -->

        <!-- Right elements -->
        <ul class="navbar-nav flex-row me-5">
            <li class="nav-item me-3 me-lg-1">
                <a class="nav-link d-sm-flex align-items-sm-center" href="#">
                    <img
                            src="assets/img/defaultImage.png"
                            class="rounded-circle"
                            height="22"
                            alt="Black and White Portrait of a Man"
                            loading="lazy"
                    />
                    <strong class="d-none d-sm-block ms-1">John</strong>

                </a>
            </li>
            <li class="nav-item me-3 me-lg-1">
                <a class="nav-link" href="#">
                    <span><i class="fas fa-users fa-lg"></i></span>
                    <span class="badge rounded-pill badge-notification bg-danger">2</span>
                </a>
            </li>
            <li class="nav-item me-3 me-lg-1">
                <a class="nav-link" href="#">
                    <span><i class="fas fa-plus-circle fa-lg"></i></span>
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
                    <i class="fas fa-comments fa-lg"></i>

                    <span class="badge rounded-pill badge-notification bg-danger">6</span>
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
                        <a class="dropdown-item" href="#">Something else here</a>
                    </li>
                </ul>
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
                    <i class="fas fa-bell fa-lg"></i>
                    <span class="badge rounded-pill badge-notification bg-danger">12</span>
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
                        <a class="dropdown-item" href="#">Something else here</a>
                    </li>
                </ul>
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
                        <a class="dropdown-item" href="#">Something else here</a>
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
                                <span class="h5 me-2">51 345</span>
                                <small class="text-danger text-sm"><i
                                            class="fas fa-arrow-down fasm me-1"></i>23.58%</small>
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
                            <i class="fas fa-user-doctor fa-lg text-white fa-fw"></i>
                        </div>

                        <div class="ms-4">
                            <p class="text-muted mb-2">Doctors | Councillor</p>
                            <p class="mb-0">
                                <span class="h5 me-2">124</span>
                                <small class="text-success text-sm"><i
                                            class="fas fa-arrow-up fasm me-1"></i>23.58%</small>
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

                            <i class="fas fa-wallet fa-lg text-white fa-fw"></i>
                        </div>

                        <div class="ms-4">
                            <p class="text-muted mb-2">Earning</p>
                            <p class="mb-0">
                                <span class="h5 me-2">$75,200</span>
                                <small class="text-success text-sm"><i
                                            class="fas fa-arrow-up fasm me-1"></i>23.58%</small>
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
                            <i class="fas fa-comments fa-lg text-white fa-fw"></i>
                        </div>

                        <div class="ms-4">
                            <p class="text-muted mb-2">Messages</p>
                            <p class="mb-0">
                                <span class="h5 me-2">51 345</span>
                                <small class="text-danger text-sm"><i class="fas fa-envelope fasm me-1"></i>23</small>
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
                                    <p class="text-muted mb-2">Users</p>
                                    <p class="mb-0">
                                        <span class="h4 me-2">14 567</span>
                                        <small class="text-success text-sm"><i class="fas fa-arrow-up fa-sm me-2"></i>13.45%</small>
                                    </p>
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
                                            <li><a class="dropdown-item text-info" href="#">All</a></li>
                                            <li><a class="dropdown-item text-info" href="#">This Month</a></li>
                                            <li><a class="dropdown-item text-info" href="#">This Year</a></li>
                                            <li>
                                                <hr class="dropdown-divider"/>
                                            </li>
                                            <li><a class="dropdown-item text-info" href="#">Doctors</a></li>
                                            <li><a class="dropdown-item text-info" href="#">Councillors</a></li>
                                            <li><a class="dropdown-item text-info" href="#">Patient</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Card body-->
                        <div class="p-4">
                            <div class="card-body chart-container" style="position: relative; height: auto; width: 100%;">
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
                                    <p class="text-muted mb-2">Users</p>
                                    <p class="mb-0">
                                        <span class="h4 me-2">14 567</span>
                                        <small class="text-success text-sm"><i class="fas fa-arrow-up fa-sm me-2"></i>13.45%</small>
                                    </p>
                                </div>
                                <div class="col-6 text-end">
                                    <div class="btn-group shadow-0">
                                        <button type="button"
                                                class="btn btn-link  btn-sm btn-outline-info dropdown-toggle"
                                                data-mdb-toggle="dropdown" aria-expanded="false"><i
                                                    class="fas fa-filter"></i>
                                            Filter
                                        </button>
                                        <ul class="dropdown-menu bg-glass" style="font-size: 14px">
                                            <li><a class="dropdown-item text-info" href="#">All</a></li>
                                            <li><a class="dropdown-item text-info" href="#">This Month</a></li>
                                            <li><a class="dropdown-item text-info" href="#">This Year</a></li>
                                            <li>
                                                <hr class="dropdown-divider"/>
                                            </li>
                                            <li><a class="dropdown-item text-info" href="#">Doctors</a></li>
                                            <li><a class="dropdown-item text-info" href="#">Councillors</a></li>
                                            <li><a class="dropdown-item text-info" href="#">Patient</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Card body-->
                        <div class="p-4">
                            <div class="card-body chart-container" style="position: relative; height: auto; width: 100%;">
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
                <table class="table text-white align-middle mb-0 table-borderless  ">
                    <thead>
                    <tr class="text-info">
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Role</th>
                        <th scope="col">Description</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!empty($rs)){
                    foreach ($rs as $therapist) {
                        ?>
                        <tr class="tb-row">
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo $therapist->profile_photo; ?>" alt=""
                                         style="width: 45px; height: 45px"
                                         class="rounded-circle"/>
                                    <div class="ms-3">
                                        <p class="fw-bold text-info mb-1"><?php echo $therapist->firstname . ' ' . $user->lastname; ?></p>
                                        <p class="text-muted mb-0"><?php echo $therapist->email ?></p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-warning d-inline">Pendding</span>
                            </td>
                            <td class="text-info">
                                <?php
                                 $role = substr($therapist->user_id,0,3);
                                     echo ($role == "DOC") ? "Doctor" : "Counselor";

                                ?>
                            </td>
                            <td>
                                <p class="text-muted mb-0"><?php echo $therapist->description ?></p>
                            </td>
                            <td>
                                <a href="admin_pdf_view.php?k=<?php echo $therapist->user_id ;?>">
                                    <button type="button" class="btn btn-link  btn-sm btn-rounded btn-outline-info">Check</button>
                                </a>
                            </td>
                        </tr>
                    <?php }}else {?>
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
<?php include_once "assets/js/admin_chat_js.php"?>
</body>
</html>