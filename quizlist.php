<!-- Created 4/13/2017 -->

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
                        "order": [[ 0, "desc" ]]
                    });
					//4/17/2017 Altered function to work with edit button changes
					$(".edit-quiz").click(function() {
						window.location.href = "./quizEdit.php?qid="+$(this).data("qid");
					});
					
   					$(".hide-quiz").click(function () {
      					window.location.href = "./quizDisplay.php?qid="+$(this).data("qid");
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
			$quizID = array();
            while($row = mysqli_fetch_assoc($result)) {
				$quizID[] = $row['quizID']; 	//4/11/2017 Array Addition
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
                        <p>Welcome, <?php echo $instructorName; ?></p>
                        <span><a href="login.php?logout=1"><button type="button" class="btn btn-default">Log Out</button></a></span></p>
                </div>
            </div>
        </div>

        <div id="quizResults">
        	<!-- 4/12/2017 button added to link to quiz list page -->
        	<div class="row text-left">
            <span style="padding-left: 5%;"><a href="admin.php"><button type="button" class="btn btn-default">Go back</button></a></span>
            <span style="padding-left: 5%;"><a href="addQuiz.php"><button type="button" class="btn btn-default">New Quiz</button></a></span>
            </div>
            <h4>Quiz List</h4>
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Quiz Name</th>
                        <th style="display: none; visibility:collapse;">Quiz ID Number</th>                        
                        <th></th>
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
					$sql = "SELECT *
						FROM quizzes 
						WHERE quizID IN (" . $quizIDArray . ") 
						ORDER BY quizName DESC";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) { //4/12/2017 added row using for quizName
							//4/17/2017 added row for quizID
							//4/17/2017 altered the edit quiz button 
							//4/18/2017 added button for quizShow
                            echo "<tr>
								<td>".$row['quizName']."</td>
								<td style='display: none; visibility: collapse;'>".$row['quizID']."</td>
								<td>
                                    <button type='button' class='btn btn-default edit-quiz' data-qid='".$row['quizID']."'>Edit</button>
                                </td>";
							if ($row['quizShow'] == 0 ){
								echo "<td>
										<button type='button' class='btn btn-default hide-quiz' data-qid='".$row['quizID']."'>Hide</button>
									  </td>								
                             		  </tr>";
							} else {
								echo "<td>
										<button type='button' class='btn btn-default hide-quiz' data-qid='".$row['quizID']."'>Show</button>
									  </td>								
                             		  </tr>";
							}
                        }
                    } else {
                        echo "no results found";
                    }
                    ?>
                </tbody>
            </table>
        </div> <!-- quizResults -->