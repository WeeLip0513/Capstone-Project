<?php
    //step1 - creat connection to database
    $hostname = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'carpool';
    $conn = mysqli_connect($hostname,$user,$password,$database);
    if($conn === false){
      die('Connection Failed!'.mysqli_connect_error());
    } else {
      // echo 'Connection established!';
    }
?>