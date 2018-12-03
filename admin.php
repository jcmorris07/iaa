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
		
        <?php 
        // this is to display the instructor info and their quiz
        $emailSubmitted = htmlspecialchars($_SESSION["user"]);

        $sql = "SELECT instructors.instructorID, instructors.instructorEmail, quizzes.quizID, quizzes.quizName, instructors.instructorFirst, instructors.instructorLast 
                FROM instructors JOIN quizzes 
                WHERE instructors.instructorID = quizzes.instructorID AND instructors.instructorEmail = '" . $emailSubmitted."'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
			//4/11/2017 Added Array for the quizID --- Original code left in comments
			$quizID = array();
            while($row = mysqli_fetch_assoc($result)) {
                //$quizID = $row['quizID'];
				$quizID[] = $row['quizID']; 	//4/11/2017 Array Addition
                $quizName = $row['quizName'];
                $instructorName = $row['instructorFirst']. " " .$row['instructorLast'];
            }
        } else {
            echo "no results found";
        }
        ?>

        <div class="container" style="padding-bottom: 20px;"><!-- 4/12/2017 added inline style -->
            <div class="jumbotron">
                <img id="logo" src="images/Logo.png" />	
                <h3>Admin Panel</h3>
                <div class="row text-right">
                    <div class="col-lg-12">
                        <p>Welcome, <?php echo $instructorName; $_SESSION["instructorName"] = $instructorName; ?></p>
                        <span><a href="login.php?logout=1"><button type="button" class="btn btn-default">Log Out</button></a></span></p>
                </div>
            </div>
        </div>

        <div id="quizResults">
        	<!-- 4/12/2017 button added to link to quiz list page -->
        	<div class="row text-right"><span style="padding-right: 5%;"><a href="quizList.php"><button type="button" class="btn btn-default">Quiz List</button></a></span></div>
            <h4>Quiz Results</h4>
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Student First Name</th>
                        <th>Student Last Name</th>
                        <th>Student Email</th>
                        <th>Student CWI ID</th>
                        <th>Submit Date</th> <!-- 4/12/2017 new row added to table -->
                        <th>Quiz Taken</th>
                        <th>Score</th>
						<th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php //4/11/2017 changed = to IN in where clause, added $quizIDArray, changed $quizID to $quizIDArray in where clause
					$quizIDArray = implode(',',$quizID);
					//4/12/2017 changed $sql to use new select statment
                    /*
					$sql = "SELECT * 
                        FROM responses 
                        WHERE quizID = " . $quizID . " 
                        ORDER BY submitTime DESC";
					*/
					$sql = "SELECT studentFirst, studentLast, studentEmail, studentCwiID, submitTime, studentScore, responseID, quizName
						FROM responses JOIN quizzes on responses.quizID = quizzes.quizID
						WHERE responses.quizID IN (" . $quizIDArray . ") 
						ORDER BY submitTime DESC";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) { //4/12/2017 added row using for quizName
                            echo "<tr> 
                                <td>".$row['studentFirst']."</td>
                                <td>".$row['studentLast']."</td>
                                <td>".$row['studentEmail']."</td>
                                <td>".$row['studentCwiID']."</td> 
                                <td>".$row['submitTime']."</td>
								<td>".$row['quizName']."</td>
                                <td>".$row['studentScore']."</td>
                                <td>
                                    <button type='button' class='btn btn-default view-quiz' data-qid='".$row['responseID']."'>View</button>
                                </td>
                             </tr>";
                        }
                    } else {
                        echo "no results found";
                    }
                    ?>
                </tbody>
            </table>
        </div> <!-- quizResults -->

		<!-- 4/12/2017 Removed for the time being

        <div class="row" id="yourQuiz">
            <div class="col-lg-12">
                <h4><?php echo "Current " . $quizName . " Assessment Questions and Answers" ?><span id="quizEditButton"><a href="quizEdit.php"><button type="button" class="btn btn-default">Edit Quiz</button></a></span></h4>                
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php
							$i = 1;
							$sql = "SELECT questionContent, questionID
											FROM questions
											WHERE quizID = " . $quizID;
							$result = mysqli_query($conn, $sql);
		
							if (mysqli_num_rows($result) > 0) {
								while($row = mysqli_fetch_assoc($result)) {
									$sql2 = "SELECT answerContent, answerID
											 FROM answers
											 WHERE questionID = " . $row[questionID];
									$result2 = mysqli_query($conn, $sql2);
									echo "<h4>Question " . $i . "</h4>
												  <p>" . $row[questionContent] . "</p>";
									echo "<ul>";
									if (mysqli_num_rows($result2) > 0) {
										while($row = mysqli_fetch_assoc($result2)) {
											echo "<li>" . 
												$row[answerContent] . 
												"</li>";
										}
									} else {
										echo "No results found.";
									}
									echo "</ul>";
									++$i;
								}
							} else {
								echo "No results found.";
							}
                        ?>
                    </div>
                </div>
            </div>
        </div><!--Your Quiz Row -->
        </div> <!-- container -->
		
    </body>
</html>


