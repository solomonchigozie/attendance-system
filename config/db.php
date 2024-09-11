<?php 

$host = "localhost";
$database = "attendancesystem";
$username = "root";
$password = "";

$connection = mysqli_connect($host, $username, $password, $database);

if(!$connection){
    die('connection failed');
}



?>