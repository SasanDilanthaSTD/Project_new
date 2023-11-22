<?php
require_once "core/classes/Admin.php";

use MyApp\Admin;

$admin = new Admin();
$users = "";
$users = $admin->get_details_without_patient();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['type'])) {
        $userType = $_GET['type'];
        if ($userType == "Admin") {
            $users = $admin->get_admin_data();
        } elseif ($userType == "Doctor") {
            $users = $admin->get_doctor_data();
        } elseif ($userType == "Counselor") {
            $users = $admin->get_counselor_data();
        } else {
            $users = $admin->get_details_without_patient();
        }
    }
}


?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>add admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">

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
            href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css"
            rel="stylesheet"
    />


    <link rel="stylesheet" href="assets/css/admin_action.css">

    <?php include_once('assets/css/set_footer.php'); ?>
</head>

<body
        style="background: url(&quot;/Project_new/assets/img/aboutusbackground.jpg&quot;) no-repeat;background-size: cover;">
<!-- Start: nav bar -->
<div><!-- Start: Navbar Right Links -->
    <nav class="navbar navbar-expand-md bg-body py-3">
        <div class="container"><a class="navbar-brand d-flex align-items-center" href="home.php"
                                  style="padding-bottom: 0px;margin-top: 0px;padding-top: 0px;"><img
                        src="assets/img/logo.png"
                        style="width: 109px;"></a>
        </div>
    </nav><!-- End: Navbar Right Links -->
</div><!-- End: nav bar --><!-- Start: 2 Rows 1+1 Columns -->
<div class="container content" style="margin-top: 20px;">
    <div>
        <h6 style="margin-top: 20px;background: rgba(255,255,255,0.58);padding-top: 10px;padding-left: 14px;padding-bottom: 10px;margin-left: -12px;margin-right: -12px;">
            Add Admin
            <a href="admin_reg.php">
                <button class="btn btn-primary addadminbtn" type="button"
                        style="margin-left: 88px;background: rgb(0, 115, 139);border-style: none;">
                    Click Here
                </button>
            </a>
        </h6>
    </div>
    <div class="row" style="margin-top: 0px;">
        <div class="col-md-12" style="background: rgba(255,255,255,0.58);margin-top: 0px;">
            <div>
                <h4 style="margin-top: 10px;"><span style="color: rgb(16, 123, 146);">User Details</span></h4>
                <div class="dropdown">
                    <button class="btn btn-primary addadminbtn dropdown-toggle filterbtn" aria-expanded="false"
                            data-bs-toggle="dropdown" type="button"
                            style="border-radius: 0px;border-style: none;box-shadow: inset 0px 0px 1px 0px rgb(0,115,139);">
                        <strong>Filter</strong>
                        <i class="fa fa-filter" style="margin-left: 5px;"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="admin_action.php?type=All">
                            <label for="admin">All</label>
                        </a>
                        <a class="dropdown-item" href="admin_action.php?type=Admin">
                            <label for="admin">Admin</label>
                        </a>
                        <a class="dropdown-item" href="admin_action.php?type=Doctor">
                            <label for="doctor">Doctor</label>
                        </a>
                        <a class="dropdown-item" href="admin_action.php?type=Counselor">
                            <label for="counselor">Counselor</label>
                        </a>
                    </div>
                </div>

                <!-- Search form -->
                <div class="d-flex justify-content-end" style="margin-bottom: 2vh">
                    <form class="form-inline d-flex justify-content-end md-form form-sm active-cyan-2 mt-2" style="">
                        <!--                    <input class="form-control form-control-sm mr-3 w-75" type="text" placeholder="Search" aria-label="Search" oninput="search();">-->
                        <input class="form-control form-control-sm mr-3 w-75" type="text" placeholder="Search"
                               aria-label="Search" id="myInput" oninput="search();">

                        <i class="fas fa-search" aria-hidden="true"></i>
                    </form>
                </div>
            </div>
            <div><!-- Start: Table With Search -->
                <div class="col-md-12 search-table-col" style="margin-top: 0px;">
                    <div class="table-responsive table table-hover table-bordered results" style="margin-bottom: 0px;">
                        <table class="table table-hover table-bordered" id="myTable">
                            <thead class="bill-header cs">
                            <tr>
                                <th id="trs-hd-3" class="col-lg-3">Name</th>
                                <th id="trs-hd-4" class="col-lg-2">Role</th>
                                <th id="trs-hd-6" class="col-lg-2">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($users as $user) {
                                $role = substr($user->user_id, 0, 3)
                                ?>
                                <tr>
                                    <td class="name"><?= $user->firstname . " " . $user->lastname ?></td>
                                    <?php if ($role == "ADM") { ?>
                                        <td>Admin</td>
                                    <?php } else if ($role == "DOC") { ?>
                                        <td>Doctor</td>
                                    <?php } else if ($role == "COU") { ?>
                                        <td>Counselor</td>
                                    <?php } ?>
                                    <td>
                                        <div style="text-align: center;">
                                            <form action="process/admin.php" method="post">
                                                <input type="hidden" name="del_id" id="del_id"
                                                       value="<?= $user->user_id ?>">
                                                <button class="btn btn-danger"
                                                        style="margin-left: 5px;text-align: left;" type="submit"
                                                        name="del" onclick="confirm('Are you sure delete this? ')">
                                                    <i class="fa fa-trash" style="font-size: 15px;"></i>
                                                    <small style="margin-left: 5px;">
                                                        <strong>Delete</strong>
                                                    </small>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- End: Table With Search -->
            </div>
        </div>
    </div>
    <div class="row" style="margin-bottom: 0px;padding-bottom: 0px;">
        <div class="col-md-12" style="background: rgba(255,255,255,0);margin-bottom: 0px;margin-top: 11px;">
            <!-- Start: Intro -->
            <div class="intro">
                <div style="text-align: center;margin-bottom: 0px;margin-top: 0px;"><img src="assets/img/logo.png"
                                                                                         style="width: 141px;padding-top: 20px;padding-bottom: 20px;">
                </div>
            </div><!-- End: Intro -->
        </div>
    </div>
</div><!-- End: 2 Rows 1+1 Columns --><!-- Start: footer -->
<div><!-- Start: Footer Basic -->
    <footer class="text-center" style="background: rgb(255,255,255);">
        <div class="container text-muted py-4 py-lg-5">
            <ul class="list-inline" style="margin-top: -25px;">
                <li class="list-inline-item me-4"><a class="link-secondary" href="#"><br><span
                                style="color: RGBA(86,94,100,var(--bs-link-opacity,1)) ;">mentalhealthservice@gmail.com</span></a>
                </li>
                <li class="list-inline-item me-4"><a class="link-secondary" href="#"><br><span
                                style="color: RGBA(86,94,100,var(--bs-link-opacity,1)) ;">+94 76 890 4453</span></a>
                </li>
            </ul>
            <ul class="list-inline">
                <li class="list-inline-item me-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                         fill="currentColor" viewBox="0 0 16 16" class="bi bi-facebook">
                        <path
                                d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z">
                        </path>
                    </svg>
                </li>
                <li class="list-inline-item me-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                         fill="currentColor" viewBox="0 0 16 16" class="bi bi-twitter">
                        <path
                                d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z">
                        </path>
                    </svg>
                </li>
                <li class="list-inline-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                         fill="currentColor" viewBox="0 0 16 16" class="bi bi-instagram">
                        <path
                                d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z">
                        </path>
                    </svg>
                </li>
            </ul>
            <p class="mb-0">Copyright © 2023 Mental Health Service</p>
        </div>
    </footer><!-- End: Footer Basic -->
</div><!-- End: footer -->
<!-- MDB -->
<script
        type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"
></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>


<!-- import jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- js AJAX code -->

<script>
    function search() {
        // Get the search input value
        const searchInput = document.getElementById('myInput');
        const searchTerm = searchInput.value.toLowerCase();

        // Get all table rows
        const tableRows = document.querySelectorAll('tbody tr');

        // Hide all table rows except those that match the search term
        for (const tableRow of tableRows) {
            const nameElement = tableRow.querySelector('.name');
            const name = nameElement.textContent.toLowerCase();

            if (name.includes(searchTerm)) {
                tableRow.style.display = '';
            } else {
                tableRow.style.display = 'none';
            }
        }
    }
</script>

</body>

</html>