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
       <?php
            //populate HTML form with selected data based on instructor's ID
            if ($result = $conn->query("SELECT instructorID, instructorFirst, instructorLast, role, instructorPhone, instructorEmail FROM instructors WHERE instructorID = ".$_GET["id"])) {
                $row = $result->fetch_row();
            }
        ?> 
        <!-- This is the form where we begin our edits -->
        <div class="form-group">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                          <form class="form-horizontal" action="modifyInstructor.php" method="post">
                            <label class="col-2 col-form-label">Instructor ID</label>&nbsp;&nbsp;&nbsp;
                            <input class="form-control" type="text" value="<?=$row[0]?>" name="instructorID"></input><br>	
                            <label class="col-2 col-form-label">First Name:</label>&nbsp;&nbsp;&nbsp;
                            <input class="form-control" type="text" value="<?=$row[1]?>" name="firstName"></input><br>
                            <label class="col-2 col-form-label">Last Name:</label>&nbsp;&nbsp;&nbsp; 
                            <input class="form-control" type="text" value="<?=$row[2]?>" name="lastName"></input><br>
                            <label class="col-2 col-form-label">Role:</label>&nbsp;&nbsp;&nbsp; 
                            <input class="form-control" type="text" value="<?=$row[3]?>" name="role"></input><br>
                            <label class="col-2 col-form-label">Phone:</label>&nbsp;&nbsp;&nbsp;
                            <input class="form-control" type="text" value="<?=$row[4]?>" name="phoneNumber"></input><br>
                            <label class="col-2 col-form-label">Email:</label>&nbsp;&nbsp;&nbsp; 
                            <input class="form-control" type="email" value="<?=$row[5]?>" name="email"></input><br>
                            <label class="col-2 col-form-label">New Password:</label>&nbsp;&nbsp;&nbsp;
                            <input class="form-control" type="password" name="password"></input><br>
                            <label class="col-2 col-form-label">Confirm New Password:</label>&nbsp;&nbsp;&nbsp;
                            <input class="form-control" type="password" name="cPassword"></input><br>
                            <button type="submit" name="submit" class="btn btn-default">Submit</button>                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    </body>
    </html>
