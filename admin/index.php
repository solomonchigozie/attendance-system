<?php
session_start();

/**
 * we use sessions to keep users logged in and restrict access to
 * various pages but for this page a user is allowed to 
 * access it without being logged in. 
 */


//this is the database configuration file
require('../config/db.php');

/**
 * check if a user is logged in then assign user session to a function 
 * which is used later beneath this page
 */

if (!(isset($_SESSION['userid'])) || $_SESSION['role'] != "admin") {
  echo "<script>location='../login.php'</script>";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Attendance System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

  <?php require("includes/header.php") ?>

  <!-- ======= Sidebar ======= -->
  <?php require("includes/sidebar.php") ?>
  <!-- End Sidebar-->


  <main id="main" class="main">

    <div class="pagetitle">
      <h1>ADMIN</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Attendance System</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <!-- Card -->
            <div class="col-xxl-4 col-md-4">
              <div class="card info-card members-card">

                <div class="card-body">
                  <h5 class="card-title">All Members<span></span></h5>
                  <h1>
                    <?php
                    $sql = mysqli_query($connection, "SELECT * FROM users ");
                    echo mysqli_num_rows($sql);
                    ?>
                  </h1>
                </div>

              </div>
            </div>
            <div class="col-xxl-4 col-md-4">
              <div class="card info-card members-card">

                <div class="card-body">
                  <h5 class="card-title">Pastors<span></span></h5>
                  <h1>
                    <?php
                    $sql = mysqli_query($connection, "SELECT * FROM users where membership='pastor' ");
                    echo mysqli_num_rows($sql);
                    ?>
                  </h1>
                </div>

              </div>
            </div>
            <div class="col-xxl-4 col-md-4">
              <div class="card info-card members-card">

                <div class="card-body">
                  <h5 class="card-title">Admins<span></span></h5>
                  <h1>
                    <?php
                    $sql = mysqli_query($connection, "SELECT * FROM users where role='admin' ");
                    echo mysqli_num_rows($sql);
                    ?>
                  </h1>
                </div>

              </div>
            </div>

            <div class="col-xxl-4 col-md-6">
              <div class="card info-card members-card">

                <div class="card-body">
                  <h5 class="card-title">Events<span></span></h5>
                  <h1>
                    <?php
                    $sql = mysqli_query($connection, "SELECT * FROM events ");
                    echo mysqli_num_rows($sql);
                    ?>
                  </h1>
                </div>

              </div>
            </div>

            <div class="col-xxl-4 col-md-6">
              <div class="card info-card members-card">

                <div class="card-body">
                  <h5 class="card-title">Total Attendance<span></span></h5>
                  <h1>
                    <?php
                    $sql = mysqli_query($connection, "SELECT * FROM attendance ");
                    echo mysqli_num_rows($sql);
                    ?>
                  </h1>
                </div>

              </div>
            </div>
            <!-- End Card -->


           
          </div>

        </div><!-- End Attendance Card -->

      </div>

      <!-- ======= Footer ======= -->
      <?php require("includes/footer.php") ?>

</body>

</html>