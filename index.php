<?php
session_start();

/**
 * we use sessions to keep users logged in and restrict access to
 * various pages but for this page a user is allowed to 
 * access it without being logged in. 
 */


//this is the database configuration file
require('config/db.php');

/**
 * check if a user is logged in then assign user session to a function 
 * which is used later beneath this page
 */

if (!(isset($_SESSION['userid']))) {
  echo "<script>location='login.php'</script>";
}

if(isset($_GET['eventid'])){
	$eventid= $_GET['eventid'];
	$sqlcheck = mysqli_query($connection, "SELECT * FROM attendance where eventid='$eventid' and userid={$_SESSION['userid']} ");

  //check if attendance record already exist
  if(mysqli_num_rows($sqlcheck) >0){
    echo "<script>alert('Attendance has already been marked')</script>";
    echo "<script>location='index.php'</script>";
  }else{
    //insert into the attendance table
    $insert = "INSERT INTO attendance(userid, eventid, status) 
    VALUES('{$_SESSION["userid"]}', '$eventid', 'present')";

    if(mysqli_query($connection, $insert)){
        $success = "<div class='text-success text-center'> Attendance was added successfully</div>";
        echo "<script>alert('Attendance Recorded Successfully')</script>";
        echo "<script>location='attendance.php'</script>";
    }else{
        $success = "<span class='text-danger'>failed".mysqli_error($connection)."</span>";
    }
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
      <h1>Welcome <?=$_SESSION['firstname']?>  <?=$_SESSION['lastname']?> </h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Attendance System</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">

        <!-- Last Attended -->
        <div class="col-12">
          <div class="card Last-Attended overflow-auto">

            <div class="card-body">
              <h5 class="card-title">Upcoming Events<span></span></h5>

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
                  while ($row = mysqli_fetch_assoc($sql)) {
                  ?>
                    <tr>
                      <th><?= $n++ ?></th>
                      <th><?php echo $row['title'] ?></th>
                      <th><?php echo $row['eventdate'] ?></th>
                      <th><?php echo $row['starttime'] ?></th>
                      <th><?php echo $row['endtime'] ?></th>
                      <th><?php if ($row['status'] == "past") {
                            echo "<span class='bg-danger text-white rounded p-1 mt-1'>" . $row['status'] . "</span>";
                          } else {
                            echo "<span class='bg-warning text-white rounded p-1 mt-1'>" . $row['status'] . "</span>";
                          }  ?></th>
                      <th>
                        <?php 
                          if($row['eventdate'] == Date("Y-m-d")){
                            echo '
                            <a href="index.php?eventid='.$row["id"].'" class="btn btn-success text-white">
                              <i class="bi bi-check-all"></i> Mark Attendance
                            </a>
                            ';
                          }
                          elseif($row['eventdate'] < Date("Y-m-d")){
                            echo '
                            <a onclick="alert(`You can no longer mark attendance for this event because its a past event`)" class=" text-danger">
                              <i class="bi bi-stop-btn"></i> Past Event
                            </a>
                            ';
                          }
                          else{
                            echo '
                              <a onclick="alert(`You can mark attendance for this event on the day of the event`)"  class="text-secondary">
                                <i class="bi bi-tag-fill"></i> Upcoming Event
                              </a>
                            ';
                          }
                        ?>
                        <!-- <a onclick="if(confirm('Are you sure')){location='events.php?eventid=<?php echo $row['id'] ?>'}" class="btn btn-danger">
                          Delete
                        </a> -->
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

      </div><!-- End Event Card -->

      <?php require('includes/footer.php') ?>

</body>

</html>