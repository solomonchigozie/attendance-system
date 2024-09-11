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



$success = "";
$error = array();
//if form is submitted
if(isset($_POST['submit'])){
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $eventdate = mysqli_real_escape_string($connection, $_POST['eventdate']);
    $starttime = mysqli_real_escape_string($connection, $_POST['starttime']);
    $endtime = mysqli_real_escape_string($connection, $_POST['endtime']);

    //lets check for erros in the fields
    if(empty($title)){
        array_push($error, "title cannot be empty");
    }
    if(empty($eventdate)){
        array_push($error, "event date cannot be empty");
    }
    if(empty($starttime)){
        array_push($error, "start time cannot be empty");
    }
    if(empty($endtime)){
        array_push($error, "end time cannot be empty");
    }
    
    //if there are no errors in the form then continue
    if(count($error)==0){

        //insert into the database
        $insert = "INSERT INTO events(title, eventdate, starttime, endtime) 
        VALUES('$title', '$eventdate', '$starttime','$endtime')";

        if(mysqli_query($connection, $insert)){
            $success = "<div class='text-success text-center'>
                Event was added successfully</div>";
        }else{
            $success = "<span class='text-danger'>failed".mysqli_error($connection)."</span>";
        }        
    }

}

if(isset($_GET['eventid'])){
	$id= $_GET['eventid'];
	$sql = mysqli_query($connection, "DELETE FROM events where id='$id'");
	
	echo "<script>alert('Event Deleted')</script>";
    echo "<script>location='events.php'</script>";
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
        table, tr,td{
            white-space: nowrap; /** prevent line breaking in table */
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
            <h1>Events</h1>
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
                    <div class="row justify-content-center">
                        <div class="card mb-3 col-md-6">

                            <div class="card-body">

                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Add Event</h5>
                                </div>

                                <form class="row g-3 needs-validation" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                                
                                    <?php echo $success; ?>
                                    <?php
                                        foreach($error as $errors){
                                            echo "<p class='text-danger text-center'>".
                                                $errors . "<br> </p>";
                                        }
                                    ?>

                                    <div class="col-12">
                                        <label for="title" class="form-label">Event Title</label>
                                        <div class="input-group has-validation">
                                            <input type="text" name="title" class="form-control" id="title" value="<?php echo $title ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="eventdate" class="form-label">Event Date</label>
                                        <div class="input-group has-validation">
                                            <input type="date" name="eventdate" class="form-control" id="eventdate" value="<?php echo $eventdate ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="starttime" class="form-label">Event Start Time</label>
                                        <div class="input-group has-validation">
                                            <input type="time" name="starttime" class="form-control" id="starttime" value="<?php echo $starttime ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="endtime" class="form-label">Event End Time</label>
                                        <div class="input-group has-validation">
                                            <input type="time" name="endtime" class="form-control" id="endtime" value="<?php echo $endtime ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit" name="submit">Add Event</button>
                                    </div>
                                </form>

                            </div>
                        </div>


                    </div>

                </div><!-- End Attendance Card -->


                <!-- Last Attended -->
                <div class="col-12">
                    <div class="card Last-Attended overflow-auto">

                        <div class="card-body">
                            <h5 class="card-title">All Events<span></span></h5>

                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Event Title</th>
                                        <th scope="col">Event Date</th>
                                        <th scope="col">Start Time</th>
                                        <th scope="col">End Time</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $sql = mysqli_query($connection, "SELECT * FROM events order by id DESC");
                                        $n = 1;
                                        while($row =mysqli_fetch_assoc($sql)){
                                    ?>
                                    <tr>
                                        <th><?=$n++ ?></th>
                                        <th><?php echo $row['title'] ?></th>
                                        <th><?php echo $row['eventdate'] ?></th>
                                        <th><?php echo $row['starttime'] ?></th>
                                        <th><?php echo $row['endtime'] ?></th>
                                        <th><?php if($row['status'] =="past"){echo "<span class='bg-danger text-white rounded p-1 mt-1'>".$row['status']."</span>";}else{echo "<span class='bg-success text-white rounded p-1 mt-1'>".$row['status']."</span>";}  ?></th>
                                        <th>
                                            <a href="events_edit.php?eventid=<?php echo $row['id'] ?>" class="btn btn-success">
                                                Update 
                                            </a>
                                            <a onclick="if(confirm('Are you sure')){location='events.php?eventid=<?php echo $row['id'] ?>'}"  class="btn btn-danger">
                                                Delete
                                            </a>
                                        </th>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>

            <!-- ======= Footer ======= -->
            <?php require("includes/footer.php") ?>

</body>

</html>