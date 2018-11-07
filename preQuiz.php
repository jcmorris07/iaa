<!doctype html>
<html lang="en">
    <head>
        <?php require 'connection.php';?>
        <meta charset="utf-8" />
        <title>Interest Assessment Pre-Quiz</title>
        <script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!-- user edit css -->
        <link rel="stylesheet" type="text/css" href="css/customstyles.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </head>
    
    <body>
      <div class="container">
        <div class="jumbotron">
          <img id="logo" src="images/Logo.png" />
          <p>Admin Login</p>
          <span>
            <a href="login.php">
              <button type="button" class="btn btn-default">Log In</button>
            </a>
          </span>
        </div>
        <div class="panel panel-default">
          <div class="panel-body">
            <h2 class="text-left">Interest Assessment </h2>
            <p class="text-left">This is not a test to determine if you get into the program.  This is simply a tool to help us understand your current skill level and help you determine if a specific program is a good fit.  Select a program then click below to begin the quiz!</p>

            <form action="quiz.php" method="post">
              <?php
			  			// 10-14-2016 jwokersien added where clause to limit quizzes displayed
                        $sql = "SELECT quizName, 
                                   quizID
                            FROM quizzes 
							Where quizShow = 0";// 4/17/2017 where clause updated
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<input type='radio' name='quizSelect' value='" . $row[quizID] . "' required>" . $row[quizName] . "</input><br>";
                            }
                        }else {
                            echo "No results found.";
                        }
                        ?>
              <input id="startButton" class="btn btn-default" type="submit" value="Start Assessment">
                    </form>
            </div>
          </div>
        </div>
      </body>
</html>
