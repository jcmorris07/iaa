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
	</head>

    <body>
		<?php 
        // this is to display the instructor info and their quiz
        $emailSubmitted = htmlspecialchars($_SESSION["user"]);

        $sql = "SELECT instructorID, instructorEmail, instructorFirst, instructorLast 
                FROM instructors 
                WHERE instructorEmail = '" . $emailSubmitted."' ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
            $instructorName = $row['instructorFirst']. " " .$row['instructorLast'];
			$instructorID = $row['instructorID'];
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
                        <p>Welcome, <?php echo $instructorName; ?></p>
                        <span><a href="login.php?logout=1"><button type="button" class="btn btn-default">Log Out</button></a></span></p>
                	</div>
            	</div>
       		</div>
            
            <a href="quizList.php"><button type="button" class="btn btn-default go-back">Go Back</button></a>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form action="addQuiz.php" method="post" class="text-center">	
                                <label>Quiz Name:</label> <input class="quizEditInput" type="text" name="quizNameContent" required></input>
                                <label>Department URL:</label> <input class="quizEditInput" type="text" name="deptURL" required></input>
                                <br />
                                <br />
           						<input class="btn btn-default" name="createQuiz" type="submit" value="Create Quiz">
           					</form>
        				</div>
              		</div>
              	</div>
       		</div><!-- row -->
        </div> <!-- container -->
		
        <?php
			if(isset($_POST['createQuiz'])){
				$duplicate = false;
				$quizName = htmlspecialchars($_POST["quizNameContent"]);
				$deptURL = htmlspecialchars($_POST["deptURL"]);
				
				$sql = "SELECT quizName
						FROM quizzes";
				$result = mysqli_query($conn, $sql);
				
				// check for duplicate Quiz Name
				if (mysqli_num_rows($result) > 0) {
					while($row = mysqli_fetch_assoc($result)) {
						if($quizName == $row['quizName']) {
							$duplicate = true;
						} else {
						}
					}
				}
				
				// If no duplicates, insert quiz in database
				if(!$duplicate) {
					$sql = "INSERT INTO quizzes
								VALUES (null, '$instructorID', '$quizName', '$deptURL', 1)";
					$result = mysqli_query($conn, $sql);
					$num = mysqli_affected_rows($conn);
		
					if ($num > 0) {
						echo "<p class='successMessage'>Quiz added successfully.</p>";
						$sql = "SELECT quizID
								FROM quizzes
								WHERE quizName = '" . $quizName . "'";
						$result =  mysqli_query($conn, $sql);
						if  (mysqli_num_rows($result) > 0) {
							while($row = mysqli_fetch_assoc($result)) {
								$quizID = $row['quizID'];
							}
							header("location: addQuestion.php?qid=$quizID");
						}
					} else {
						echo "<p class='failMessage'>Error updating database.</p>";
					}
				} else {
					echo "<p class='failMessage'Quiz Name already exsists.</p>";
				}
			}
		?>
        
    </body>
</html>


