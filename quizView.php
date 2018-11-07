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
        <link rel="stylesheet" type="text/css" href="css/admin.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">

		<!-- DataTable plugin -->
		<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
		<script>
			
			jQuery(function($) {
				$(document).ready(function() {
					$("table").DataTable();
				});
			});
		</script>
		
	</head>

    <body>
		
     

        <div class="container">
            <div class="jumbotron">
                <img id="logo" src="images/Logo.png" />	
                <h3>Admin Panel</h3>
                <div class="row text-right">
                    <div class="col-lg-12">
                        <p><?php echo $instructorName; ?></p>
						<p>
							<a href="admin.php"><button type="button" class="btn btn-default">Go Back</button></a>
							<span><a href="login.php?logout=1"><button type="button" class="btn btn-default">Log Out</button></a></span>
						</p>
                </div>
            </div>
        </div>

        <div id="quizResults">
            <h4>Quiz Results</h4>
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Student First Name</th>
                        <th>Student Last Name</th>
                        <th>Student Email</th>
                        <th>Student CWI ID</th>
                        <th>Quiz Taken</th>
                        <th>Score</th>
						<th></th>
                    </tr>
                </thead>
                <tbody>
                   <?php
					
					// select the quiz by ID passed from admin.php
                    $sql = "SELECT * 
                        FROM responses 
                        WHERE responseID = " . $_GET['qid'] ."
                        ORDER BY submitTime DESC LIMIT 1";
                    $result = mysqli_query($conn, $sql);
					
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
							
							// display student info
                            echo "<tr> 
                                <td>".$row['studentFirst']."</td>
                                <td>".$row['studentLast']."</td>
                                <td>".$row['studentEmail']."</td>
                                <td>".$row['studentCwiID']."</td>
                                <td>".$row['submitTime']."</td>
                                <td>".$row['studentScore']."</td>
                                
                             </tr>";

							 // convert answerSet into string that was pulled from the database
							 $answers = explode(",",$row['answerSet']);
							 foreach($answers as $a) {
								$a = explode(":", $a); // split question and answer into sub array
								
								// fetch question content from db
								$sql = "SELECT questionContent FROM iaa.questions WHERE questionID = {$a[0]}";
								$question = mysqli_fetch_object( mysqli_query($conn, $sql) );
								
								// fetch answer contrent from db
								$sql = "SELECT * FROM iaa.answers WHERE answerID = {$a[1]}";
								$answer = mysqli_fetch_object( mysqli_query($conn, $sql) );
								$isCorrect = $answer->isCorrect;

								// display question/answer pair
								echo "<tr>
										<td><strong>Question:</strong></td>
										<td>{$question->questionContent}</td>
										<td><strong>Answer</strong></td>
										<td>{$answer->answerContent}</td>
										<td></td>
										<td><span class='glyphicon glyphicon-".($isCorrect ? "ok" : "remove")."' aria-hidden='true'></span></td>
										<td></td>
									</tr>
									 ";
								
							 }
                        }
                    } else {
                        echo "no results found";
                    }
                    ?>
                </tbody>
            </table>
        </div> <!-- quizResults -->

        <div class="row" id="yourQuiz">
            <div class="col-lg-12">
                <h4><?php echo $quizName ?></h4>
                <div class="panel panel-default">
                    <div class="panel-body">
                       

            </div>
        </div><!--Your Quiz Row -->
        </div> <!-- container -->
		
    </body>
</html>


