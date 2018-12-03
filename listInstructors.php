<?php 
	// put on any page that needs to be protected
	session_start(); 
	if(!isset($_SESSION["user"])) header("location: login.php"); 
?>
<!DOCTYPE html>
<html>
<head>
    <?php require 'connection.php';?>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- user edit css -->
    <link rel="stylesheet" type="text/css" href="css/userEdit.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
    
<body>
    <div class="container">
        <div class="jumbotron">
            <img id="logo" src="images/Logo.png" />   
            <h2>User Settings</h2>
            <div class="row text-center">
                <div class="col-lg-12">
                </div>
            </div>
        </div>

        <a href="admin.php"><button type="button" class="btn btn-default">Go Back</button></a>
        <a href="addUser.php"><button type="button" class="btn btn-default">Add New User</button></a>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Instructor ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Role</th>
                <th>Phone Number</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody
            <!-- added $button2 for Deletion of instructor/user --> 
    <?php
        if ($result = $conn->query("SELECT instructorID, instructorFirst, instructorLast, role, instructorPhone, instructorEmail FROM instructors;")) {
            while($row = $result->fetch_array(MYSQLI_NUM)) {
                $button = sprintf('<a href="editInstructor.php?id=%s" type="button" class="btn btn-default">Edit</button>', $row[0]);
                $button2 = sprintf('<a href="" type="button" class="btn btn-default">Delete</button>', $row[1]);
                $tableRow = sprintf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $button, $button2);             
                echo $tableRow;
            }
            $result->close();
        }
    ?>
        </tbody>
    </table>

</body>
</html>
