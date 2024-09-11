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


$title="";
$eventdate ="";
$starttime ="";
$endtime ="";
$status ="";
$id ="";
$eventid ="";
//get the event data using the id sent using get request
if(isset($_GET['id'])){
	$id= $_GET['id'];
	$sql = mysqli_query($connection, "SELECT * FROM events where id='$id'");
	while($row= mysqli_fetch_assoc($sql)){
		$title = $row['title'];
		$eventdate = $row['eventdate'];
		$starttime = $row['starttime'];
		$endtime = $row['endtime'];
		$status = $row['status'];
		$id = $row['id'];
        $eventid = $row['id'];
	}
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

    <style>
        table,
        tr,
        td {
            white-space: nowrap;
            /** prevent line breaking in table */
        }
    </style>
</head>

<body>

    <?php require("includes/header.php") ?>

    <!-- ======= Sidebar ======= -->
    <?php require("includes/sidebar.php") ?>
    <!-- End Sidebar-->


    <main id="main" class="main">

        <div class="pagetitle">
            
            <div class="d-flex justify-content-between">
                <h1>Attendance for <?=$title?></h1>
                <a href="attendance.php" class="btn btn-primary"> <i class="bi bi-arrow-left-circle"></i> Go back</a>
            </div>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">View Attendance</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-12">
                    <div class="row justify-content-center">
                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card members-card">

                                <div class="card-body">
                                    <h5 class="card-title">Members Present<span></span></h5>
                                    <h1>
                                        <?php
                                            $sql = mysqli_query($connection, "SELECT * FROM attendance where eventid=$eventid and status='present' ");
                                            echo mysqli_num_rows($sql);
                                        ?>
                                    </h1>
                                </div>

                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card members-card">

                                <div class="card-body">
                                    <h5 class="card-title">Members Absent<span></span></h5>
                                    <h1>
                                        <?php
                                            //subtract present users from all users to get the absent users
                                            $sqlusers = mysqli_query($connection, "SELECT * FROM users ");

                                            $sql = mysqli_query($connection, "SELECT * FROM attendance where eventid=$eventid and status='present' ");
                                            $totalabsent = mysqli_num_rows($sql);
                                            $totalusers = mysqli_num_rows($sqlusers);

                                            echo ($totalusers - $totalabsent);
                                        ?>
                                    </h1>
                                </div>

                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card members-card">

                                <div class="card-body">
                                    <h5 class="card-title">Event Date<span></span></h5>
                                    <h1>
                                        <?php
                                           echo $eventdate
                                        ?>
                                    </h1>
                                </div>

                            </div>
                        </div>


                    </div>

                </div><!-- End Attendance Card -->


                <!-- Last Attended -->
                <div class="col-12">
                    <div class="card Last-Attended overflow-auto">

                        <div class="card-body">
                            <h5 class="card-title">All Members Attendance<span></span></h5>

                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Fullname</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Membership</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = mysqli_query($connection, "SELECT users.firstname, users.lastname,
                                        users.phone,users.membership, attendance.*
                                        FROM attendance
                                        JOIN users ON attendance.userid = users.id where eventid=$eventid ");
                                    $n = 1;
                                    while ($row = mysqli_fetch_assoc($sql)) {
                                    ?>
                                        <tr>
                                            <th><?= $n++ ?></th>
                                            <th><?=$row['firstname'] ?> <?=$row['lastname'] ?></th>
                                            <th><?php echo $row['phone'] ?></th>
                                            <th><?php echo $row['membership'] ?></th>
                                            <th><?php if($row['status'] =="absent"){echo "<span class='bg-danger text-white rounded p-1 mt-1'>".$row['status']."</span>";}else{echo "<span class='bg-success text-white rounded p-1 mt-1'>".$row['status']."</span>";}  ?></th>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div><!-- End Last Attended -->
            </div>

            <!-- ======= Footer ======= -->
            <?php require("includes/footer.php") ?>

</body>

</html>