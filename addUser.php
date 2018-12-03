<?php 
	// put on any page that needs to be protected
	session_start(); 
	if(!isset($_SESSION["user"])) header("location: login.php"); 
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require 'connection.php';?>
		
		<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

        <!-- admin css -->
        <link rel="stylesheet" type="text/css" href="css/customstyles.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">

		<!-- DataTable plugin -->
		<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
		<script>
			
			jQuery(function($) {
				$(document).ready(function() {
					$("table").DataTable( {
                        "order": [[ 4, "desc" ]]
                    });

					$(".view-quiz").click(function() {
						window.location.href = "./quizView.php?qid="+$(this).data("qid");
					});
				});
			});
		</script>
		
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
        
        <!-- This is the form where we add a new user -->
        <form action="insertUser.php" method="post">
        <div class="form-group row">
            <label for="firstName" class="col-2 col-form-label">First Name</label>
                <div class="col-10">
                <input class="form-control" type="text" name="firstName">
                </div>
            </div>
            <div class="form-group row">
            <label for="lastName" class="col-2 col-form-label">Last Name</label>
                <div class="col-10">
                <input class="form-control" type="text"  name="lastName">
                </div>
            </div>
            <div class="form-group row">
            <label for="role" class="col-2 col-form-label">Role</label>
                <div class="col-10">
                <input class="form-control" type="text"  name="role">
                </div>
            </div>
            <div class="form-group row">
            <label for="phoneNumber" class="col-2 col-form-label">Phone Number</label>
                <div class="col-10">
                <input class="form-control" type="text" name="phoneNumber">
                </div>
            </div>
            <div class="form-group row">
            <label for="email" class="col-2 col-form-label">Email</label>
                <div class="col-10">
                <input class="form-control" type="email" name="email">
                </div>
            </div>
            <div class="form-group row">
            <label for="password" class="col-2 col-form-label">Password</label>
                <div class="col-10">
                <input class="form-control" type="password" name="password">
                </div>
            </div>
             <div class="form-group row">
            <label for="cPassword" class="col-2 col-form-label">Confirm Password</label>
                <div class="col-10">
                <input class="form-control" type="password" name="cPassword">
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-default">Submit</button>
            
            
        
        </form>
    </body>
    </html>
