<!-- Created 4/26/2017 -->

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
	</head>

<body>
	<p>Loading</p>
	<?php
		$quizID = $_GET['qid'];
		$sql = "SELECT * 
				FROM quizzes 
				WHERE quizID = " . $quizID;
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		if ($row['quizShow'] != 0){
			$sql2 = "UPDATE quizzes 
					 SET quizShow = 0 
					 WHERE quizID = " . $quizID;
			$result2 = mysqli_query($conn, $sql2);
		} else {
			$sql3 = "UPDATE quizzes 
					 SET quizShow = 1 
					 WHERE quizID = " . $quizID;
			$result3 = mysqli_query($conn, $sql3);
		}
		header ("location: quizList.php");
	?>
</body>


</html>