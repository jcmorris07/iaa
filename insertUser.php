<?php
require 'connection.php';

// this is where we execute the query to add a new user

// setting variables to insert
if(isset($_POST['submit'])) {
    $role = $_POST['role'];
    $instructorPassword = $_POST['password'];
    $instructorPhone = $_POST['phoneNumber'];
    $instructorEmail = $_POST['email'];
    $instructorFirst = $_POST['firstName'];
    $instructorLast = $_POST['lastName'];
    $cPassword = $_POST['cPassword'];
    
// password hashing for adding new users
    if($instructorPassword != $cPassword){
        echo "Please confirm passwords are the same";
    }
        else{
        $hash = crypt($instructorPassword,'$2a$07$fgshSy4snmsdfAVp$');
        $sql = "INSERT INTO instructors (role, instructorPassword, instructorPhone, instructorEmail, instructorFirst, instructorLast) 
        VALUES ('$role', '$hash', '$instructorPhone', '$instructorEmail', 
        '$instructorFirst', '$instructorLast')";
        }
    }
// error handling to reflect success or failure
if(mysqli_query($conn, $sql)){
    echo "Records added successfully.";
   
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}
 
// close connection
mysqli_close($conn);
?>










?>