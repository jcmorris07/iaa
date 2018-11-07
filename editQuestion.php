<?php require 'connection.php';?>
<?php 
// put on any page that needs to be protected
session_start(); 
if(!isset($_SESSION["user"])) header("location: login.php"); 
?>

<!DOCTYPE html>
<html>
    <head>
        <script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

        <!--stylesheet-->
        <link rel="stylesheet" type="text/css" href="css/customstyles.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        
        <script>
		 jQuery(function($) {
				$(document).ready(function() {
					$(".go-back").click(function() {
						window.location.href = "./quizEdit.php?qid="+$(this).data("qid");
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
                WHERE instructors.instructorID = quizzes.instructorID AND instructors.instructorEmail = '" . $emailSubmitted."' AND quizzes.quizID ='" . $_GET['qid'] ."' ";
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
                <h3>Edit Question</h3>
                <div class="row text-center">
                    <div class="col-lg-12">
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-default go-back" data-qid="<?php echo $quizID;?>">Go Back</button>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
						<?php 
                        echo"<form method='post' class='text-center' action='editQuestion.php?eqid=" . $_GET['eqid'] ."&qid=$quizID'> ";
						$sql = "SELECT questionID, questionContent
								FROM questions
								WHERE questionID ='" . $_GET['eqid'] ."' AND quizID = '" . $quizID . "'";
						$result = mysqli_query($conn, $sql);
						
						while($row = mysqli_fetch_assoc($result)) {
							$questionContent = $row['questionContent'];
							$questionID = $row['questionID'];
						}
                            echo "	<h4>Question Editor</h4>
									<br />
									<br />
                                    <input class='quizEditInput' 
                                            type='text' 
                                            name='questionEdit' 
                                            value='$questionContent' />					
									<br />
									<br />";
								  
							// the first anwser wasn't always the correct one
							// changed to two sql statments to correct for this
                        	$sql2 = "SELECT answerContent, answerID
                                     FROM answers
                                     WHERE questionID ='" . $questionID ."' AND isCorrect = 1";
                        	$result2 = mysqli_query($conn, $sql2);
							echo "<h5>Correct Answer</h5>";
							if (mysqli_num_rows($result2) > 0) {
                            	while($row2 = mysqli_fetch_assoc($result2)) {
                                	echo "<input class='quizEditInput' type='text' name='answerID" . $row2[answerID] . "' value='" . $row2[answerContent] . "'><br>";
                            	}
							}
							$sql3 = "SELECT answerContent, answerID
                                     FROM answers
                                     WHERE questionID ='" . $questionID ."' AND isCorrect = 0";
                        	$result3 = mysqli_query($conn, $sql3);
							echo "<h5>Detractor Answers</h5>";
							if (mysqli_num_rows($result3) > 0) {
                            	while($row3 = mysqli_fetch_assoc($result3)) {
                                	echo "<input class='quizEditInput' type='text' name='answerID" . $row3[answerID] . "' value='" . $row3[answerContent] . "'><br>";
                            	}
							}
						
                        echo"<br>
						<input class='btn btn-default update-question' name='editQuestion' type='submit' value='Update'>
						<input class='btn btn-default delete-question' name='deleteQuestionConfirm' type='submit' value='Delete'>";
						
						if (isset($_POST['deleteQuestionConfirm'])) {
								echo "<p class='successMessage'style='color:red;'>Delete Question?</p>
								<input class='btn btn-default delete-question' name='deleteQuestion' type='submit' value='Confirm'>";
							}
						
                        
						echo"</form>";							
						?>
                        <!-- Added this in for a confirmation message -->
						<?php
                            if ( $_GET['sid'] == 1 ){
                                echo "<p class='successMessage'>Question edited successfully.</p>";
							}
                        ?>
                        
						</div>
                       
		
					</div>
				</div>
			</div>
		</div>
        <!-- MOVED UPDATE OUTSIDE OF INITAL PHP -->
        	<!-- Discovered Problem: $qUp is not reciving $questionID -->
            <!-- Question Content is now Updating Properly -->
            	<!-- Answers not yet working... No update for them yet -->
                <!-- Answers Update correctly -->
        <?php
        	if(isset($_POST['editQuestion'])) {
				$questionID = $_GET['eqid']; // added to retrieve questionID
				$questionContent = htmlspecialchars($_POST['questionEdit']);
				
				$qUp = "UPDATE questions
						 SET questionContent = '" . $questionContent . "'
						 WHERE questionID = " . $questionID ;
            	$qUpResults = mysqli_query($conn, $qUp);
				
				// update for quesitons not in existence yet
				// probably will have to run through a while loop
				
				$sql4 = "SELECT *
						 FROM answers
						 WHERE questionID = " . $questionID;
				$result4 = mysqli_query($conn, $sql4);
				if (mysqli_num_rows($result4) > 0){
					while($row = mysqli_fetch_assoc($result4)){
						$answerID = $row['answerID'];
						$answerHold = 'answerID' . $answerID;
						$answerContent = htmlspecialchars($_POST[$answerHold]);
						$ansUp = "UPDATE answers
								  SET answerContent = '" . $answerContent . "'
								  WHERE answerID = " . $answerID;
						$ansUpResults = mysqli_query($conn, $ansUp);
					}
				}
				
				header("location: editQuestion.php?eqid=$questionID&qid=$quizID&sid=1");
			}
		?>
        
        <?php
        	if(isset($_POST['deleteQuestion'])) {
				$questionID = $_GET['eqid']; 
				$questionContent = htmlspecialchars($_POST['questionEdit']);

				$sql5 = "SELECT *
						 FROM answers
						 WHERE questionID = " . $questionID;
				$result5 = mysqli_query($conn, $sql5);
				if (mysqli_num_rows($result5) > 0){
					while($row = mysqli_fetch_assoc($result5)){
						$answerID2 = $row['answerID'];
						$answerHold2 = 'answerID' . $answerID2;
						$answerContent2 = htmlspecialchars($_POST[$answerHold2]);
						$ansDel = "DELETE FROM answers
								  WHERE answerID = " . $answerID2;
						$ansDelResults = mysqli_query($conn, $ansDel);
					}
				}
				
				$qDel = "DELETE FROM questions
						 WHERE questionID = " . $questionID ;
            	$qDelResults = mysqli_query($conn, $qDel);

				header("location: quizEdit.php?qid=$quizID");
			}
		?>

</body>
</html>