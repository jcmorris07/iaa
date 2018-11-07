<?php 
// put on any page that needs to be protected
session_start(); 
if(!isset($_SESSION["user"])) header("location: login.php"); 
?>

<!doctype html>
<html lang="en">
    <head>
        <?php require 'connection.php';?>

        <script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>

        <meta charset="utf-8" />

        <title>Interest Assessment Quiz Edit</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
        <!-- user edit css -->
        <link rel="stylesheet" type="text/css" href="css/customstyles.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        
        <script>
		 jQuery(function($) {
				$(document).ready(function() {
					$(".add-question").click(function() {
						window.location.href = "./addQuestion.php?qid="+$(this).data("qid");
					});
					
					//update button now takes the user to a seperate question edit page
					$(".quizUpdateButton").click(function() {
						window.location.href = "./editQuestion.php?eqid="+$(this).data("eqid")+"&qid="+$(this).data("qid");
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
                WHERE instructors.instructorID = quizzes.instructorID AND instructors.instructorEmail = '" . $emailSubmitted."' AND quizzes.quizID ='" . $_GET['qid'] ."'";
				
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $quizID = $row['quizID'];
                $quizName = $row['quizName'];
                $instructorName = $row['instructorFirst']. " " .$row['instructorLast'];
            }
        } else {
            echo "no results found";
        }
        ?>
        
        

        <div class="container">
            <div class="jumbotron">
                <img id="logo" src="images/Logo.png" />   
                <h3>Edit Assessment</h3>
                <div class="row text-right">
                    <div class="col-lg-12">
                        <p>Welcome, <?php echo $instructorName; ?></p>
                        <span><a href="login.php?logout=1"><button type="button" class="btn btn-default">Log Out</button></a></span></p>
                </div>
            </div>    
        </div>
		<!-- 4/17/2017 edited buttons so they function properly -->
        <a href="quizlist.php"><button type="button" class="btn btn-default">Go Back</button></a>
        <button type="button" class="btn btn-default add-question" data-qid="<?php echo $quizID;?>">Add Question</button>

        <div class="container">            
            <h3><?php echo $quizName ?> Assessment</h3>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php
    $i = 1;
                $sql = "SELECT questionContent, questionID
                            FROM questions
                            WHERE quizID = " . $quizID;
                $result = mysqli_query($conn, $sql);
				
				$sqlDept = "SELECT deptURL
							FROM quizzes
							WHERE quizID = " . $quizID;
				$resultDept = mysqli_query($conn, $sqlDept);
				$rowDept = mysqli_fetch_assoc($resultDept);
				$url = $rowDept[deptURL];
							
				echo "<form action='' method='post'>";
				echo "<h4>Department URL</h4>";
				echo "<input class='quizEditInput' type='text' name='URLedit' value='$url' />";
				echo "<br /><br />
						<input class='btn btn-default' name='updateURL' type='submit' value='Update'>";
				
				if ( $_GET['sid'] == 1 ){
					echo "<p class='successMessage'>URL edited successfully.</p>";
				}
						
				echo "</form>";

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sql2 = "SELECT answerContent, answerID
                                     FROM answers
                                     WHERE questionID = " . $row[questionID];
                        $result2 = mysqli_query($conn, $sql2);

                        echo "<form action='' method='post'>";

                        echo "<h4>Question " . $i . "</h4>
                                    <div  style='padding-left: 3%;'>
									<p class='quizEditInput'><strong>" . $row[questionContent] . "</strong></p>";
                        echo "<br>";
                        if (mysqli_num_rows($result2) > 0) {
                            while($row2 = mysqli_fetch_assoc($result2)) {
                                echo "<p class='quizEditInput'> - " . $row2[answerContent] ."</p>";
                            }
                        } else {
                            echo "No results found.";
                        }
						//Gave the button a data attribute for questionID
                        echo "</div><input class='btn btn-default quizUpdateButton' name='update" . $row[questionID] . "' type='submit' value='Edit Question' 
						data-eqid='".$row[questionID]."'  data-qid='$quizID'";
                        echo "</form> <br /> <br />";
                        ++$i;
                    }
                } else {
                    echo "No results found.";
                }
                    ?>
                </div>
            </div>
        </div>
        <?php
			if (isset($_POST['updateURL'])){
				$urlContent = htmlspecialchars($_POST['URLedit']);
				
				$urlUp = "UPDATE quizzes
						  SET deptURL = '" . $urlContent . "'
						  WHERE quizID = " . $quizID;
				$urlResult = mysqli_query($conn, $urlUp);
				
				header("location:quizEdit.php?qid=$quizID&sid=1");
			}
		?>
    </body>
</html>
