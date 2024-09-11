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
    $firstname = mysqli_real_escape_string($connection, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($connection, $_POST['lastname']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $membership = mysqli_real_escape_string($connection, $_POST['membership']);
    $role = mysqli_real_escape_string($connection, $_POST['role']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    //lets check for erros in the fields
    if(empty($firstname)){
        array_push($error, "firstname cannot be empty");
    }
    if(empty($lastname)){
        array_push($error, "lastname cannot be empty");
    }
    if(empty($email)){
        array_push($error, "email cannot be empty");
    }
    if(empty($membership)){
        array_push($error, "membership cannot be empty");
    }
    if(empty($role)){
        array_push($error, "role cannot be empty");
    }
    if(empty($phone)){
        array_push($error, "phone number cannot be empty");
    }
    if(empty($password)){
        array_push($error, "password cannot be empty");
    }
    
    //if there are no errors in the form then continue
    if(count($error)==0){

        $pass = md5($password);
        //insert into the database
        $insert = "INSERT INTO users(firstname, lastname, email, membership, phone, role, password) 
        VALUES('$firstname', '$lastname', '$email','$membership', '$phone', '$role','$pass')";

        if(mysqli_query($connection, $insert)){
            $success = "<div class='text-success text-center'>New member was added successfully</div>";
            echo "<script>alert('New member added successfully')</script>";
            echo "<script>location='members.php'</script>";

        }else{
            $success = "<span class='text-danger'>failed".mysqli_error($connection)."</span>";
        }        
    }

}

if(isset($_GET['userid'])){
	$id= $_GET['userid'];
	$sql = mysqli_query($connection, "DELETE FROM users where id='$id'");
	
	echo "<script>alert('Member Deleted')</script>";
    echo "<script>location='members.php'</script>";
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
            <h1>Members</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Members</a></li>
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
                                    <h5 class="card-title text-center pb-0 fs-4">Add Members and Pastors</h5>
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
                                        <label for="firstname" class="form-label">First Name</label>
                                        <div class="input-group has-validation">
                                            <input type="text" name="firstname" class="form-control" id="firstname" value="<?php echo $firstname ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="lastname" class="form-label">Last Name</label>
                                        <div class="input-group has-validation">
                                            <input type="text" name="lastname" class="form-control" id="lastname" value="<?php echo $lastname ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="email" class="form-label">Email</label>
                                        <div class="input-group has-validation">
                                            <input type="email" name="email" class="form-control" id="email" value="<?php echo $email ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="membership" class="form-label">Membership</label>
                                        <div class="input-group has-validation">
                                            <select name="membership" id="membership" class="form-control" required>
                                                <option value="">select</option>
                                                <option value="member">Member</option>
                                                <option value="pastor">Pastor</option>
                                                <option value="deacon">Deacon</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="role" class="form-label">Role</label>
                                        <div class="input-group has-validation">
                                            <select name="role" id="role" class="form-control" required>
                                                <option value="">select</option>
                                                <option value="user">User</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="phone" class="form-label">phone</label>
                                        <div class="input-group has-validation">
                                            <input type="phone" name="phone" class="form-control" id="phone" value="<?php echo $phone ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" id="yourPassword" required>
                                        <div class="invalid-feedback">Please enter your password!</div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit" name="submit">Add Member</button>
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
                            <h5 class="card-title">All Members<span></span></h5>

                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Fullname</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Membership</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Added</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $sql = mysqli_query($connection, "SELECT * FROM users order by id DESC");
                                        $n = 1;
                                        while($row =mysqli_fetch_assoc($sql)){
                                    ?>
                                    <tr>
                                        <th><?=$n++ ?></th>
                                        <th><?php echo $row['firstname'] ?> <?php echo $row['lastname'] ?></th>
                                        <th><?php echo $row['email'] ?></th>
                                        <th><?php echo $row['phone'] ?></th>
                                        <th><?php echo $row['membership'] ?></th>
                                        <th><?php echo $row['role'] ?></th>
                                        <th><?php echo $row['created_at'] ?></th>
                                        <th>
                                            <a href="members_edit.php?userid=<?php echo $row['id'] ?>" class="btn btn-success">
                                                Update 
                                            </a>
                                            <a onclick="if(confirm('Are you sure')){location='members.php?userid=<?php echo $row['id'] ?>'}"  class="btn btn-danger">
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
                </div><!-- End Last Attended -->
            </div>

            <!-- ======= Footer ======= -->
            <?php require("includes/footer.php") ?>

</body>

</html>