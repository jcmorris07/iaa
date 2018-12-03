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
                <h3>Add Question to <?php echo $quizName ?> Assessment</h3>
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
                            <form action="addQuestion.php?qid=<?php echo $quizID ?>" method="post" class="text-center">	
                                <label>Question:</label> <input class="quizEditInput" type="text" name="questionContent" required></input><br>
                            <label>Correct Answer:</label> <input class="quizEditInput" type="text" name="correctAnswerContent" required></input><br>
                        <hr>
                        <label>Detractor Answer 1:</label> <input class="quizEditInput" type="text" name="answerContent1" required></input><br>
                    <label>Detractor Answer 2:</label> <input class="quizEditInput" type="text" name="answerContent2" required></input><br>
                <label>Detractor Answer 3:</label> <input class="quizEditInput" type="text" name="answerContent3" required></input><br><br>
            				<input class="btn btn-default" name="addQuestion" type="submit" value="Add Question">
            				</form>
        </div>
    </div>
</div>
</div>
</div>
<?php
    if(isset($_POST['addQuestion'])) {

        $duplicate = false;
        $questionContent = htmlspecialchars($_POST["questionContent"]);
        $correctAnswerContent = htmlspecialchars($_POST["correctAnswerContent"]);
        $answerContent1 = htmlspecialchars($_POST["answerContent1"]);
        $answerContent2 = htmlspecialchars($_POST["answerContent2"]);
        $answerContent3 = htmlspecialchars($_POST["answerContent3"]);

        // check to see if question exsists
        $sql = "SELECT questionContent
                FROM questions";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                if($questionContent == $row['questionContent']) {
                    $duplicate = true;
                } else {
                }
            }
        } else {
            echo "<p class='failMessage'>No results found.</p>";
        }            

        // add question into database
        if(!$duplicate) {
            $sql = "INSERT INTO questions
                        VALUES
                        (null, '$quizID', 1, '$questionContent', null)";
            $result = mysqli_query($conn, $sql);
            $num = mysqli_affected_rows($conn);

            if ($num > 0) {
                echo "<p class='successMessage'>Question added successfully.</p>";
            } else {
                echo "<p class='failMessage'>Error updating database.</p>";
            }
        } else {
            echo "<p class='failMessage'>Question already exsists.</p>";
        }

        // add answers into database
        if(!$duplicate) {
            $sql = "SELECT questionID
                        FROM questions
                        WHERE questionContent = '" . $questionContent . "'";

            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $questionID = $row['questionID'];
                }
            }

            // add correct answer to database
            $sql = "INSERT INTO answers
                    VALUES
                    (null, '$questionID', 1, '$correctAnswerContent')";

            $result = mysqli_query($conn, $sql);

            // add detractors to database
            for ($i = 1; $i <= 3; $i++) {
                $sql = "INSERT INTO answers
                        VALUES
                        (null, '$questionID', 0, '${'answerContent'.$i}')";

                $result = mysqli_query($conn, $sql);
            }
        }
    }
?>
</body>
</html>
