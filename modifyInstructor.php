<?php

// this is where we actually update the database with user modification
require 'connection.php';

// setting variables to insert
if(isset($_POST['submit'])) 
{
    $instructorID = $_POST['instructorID'];
    $role = $_POST['role'];
    $instructorPassword = $_POST['password'];
    $instructorPhone = $_POST['phoneNumber'];
    $instructorEmail = $_POST['email'];
    $instructorFirst = $_POST['firstName'];
    $instructorLast = $_POST['lastName'];
    $cPassword = $_POST['cPassword'];
}

// password hashing for updating users
//     
    if($instructorPassword != $cPassword){
        echo "Please confirm passwords are the same";
    }
        else{
        $hash = crypt($instructorPassword, '$2a$07$fgshSy4snmsdfAVp$');
        $sql = "UPDATE instructors SET role = '$role', instructorPassword = '$hash', 
        instructorPhone = '$instructorPhone', instructorEmail = '$instructorEmail',
        instructorFirst = '$instructorFirst', instructorLast = '$instructorLast'
        WHERE instructorID = $instructorID";
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