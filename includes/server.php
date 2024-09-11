<?php 
//database 
require('config/db.php');


$firstname= "";
$lastname= "";
$username="";
$email = "";
$password ="";
$error = [];

//log user in
if(isset($_POST['login'])){
    //this will accept both username and email
    $username = test_input(mysqli_real_escape_string($conn, $_POST['username']));
    $password = test_input(mysqli_real_escape_string($conn, $_POST['password']));

    if(empty($username)){array_push($error, "Username cannot be empty"); }

    if(empty($password)){array_push($error, "Password cannot be empty"); }

    $password = hash('sha256', $password);
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' OR email='$username' AND password='$password'");
    $num = mysqli_fetch_array($query);
            
    if($num != 0)
    {
        header('location:index.php');
        $_SESSION['userid'] = $num['userid'];
        $_SESSION['email'] = $num['email'];
        $_SESSION['username'] = $num['username'];
        $_SESSION['firstname'] = $num['firstname'];
        $_SESSION['lastname'] = $num['lastname'];
        $_SESSION['fullname'] = $num['firstname'] .' '.$num['lastname'];
        $_SESSION['picture'] = $num['profile_picture'];
        $_SESSION['phone'] = $num['phone'];
        $_SESSION['location'] = $num['location'];
        $_SESSION['joined'] = $num['date_joined'];
        $_SESSION['loggedin'] = true;
        session_unset($_SESSION['msg']);
        
    }else{
        array_push($error, "Invalid Credentials");
    }
            

}



function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>