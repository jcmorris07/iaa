<!doctype html>
<html lang="en">
    <head>
        <?php require 'connection.php';?>

        <meta charset="utf-8" />
        <title>Interest Assessment Results</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous" />
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous" />
        <!-- user edit css -->
        <link rel="stylesheet" type="text/css" href="css/customstyles.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/resultsPrint.css" media="print"/>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="container">
            <div class="jumbotron">
                <img id="logo" src="images/Logo.png" />
                <p>Results</p>
            </div>

            <?php
//            $i = 1;
            $selectedQuizID = intval($_POST['selectedQuizID']);
//            $numOfQuestions = intval($_POST['numOfQuestions']);
//            $numCorrect = 0;
//            $percentCorrect = 0;
//
//            // Set up selectedAnswer variables for however many questions there are.
//            while ($i <= $numOfQuestions) {
//                ${selectedAnswer . $i} = intval($_POST['answer' . $i]);
//                $i++;
//            }
//
            $email = htmlspecialchars($_POST['studentEmail']);
            $fName = htmlspecialchars($_POST['studentFName']);
            $lName = htmlspecialchars($_POST['studentLName']);
            $studentID = intval($_POST['studentID']);
            $percentCorrect = intval($_POST['percentCorrect']);
//
//            // Find out if selected answers are correct
//            $i = 1;
//            while ($i <= $numOfQuestions) {
//
//                $sql = "SELECT * 
//                        FROM answers
//                        WHERE isCorrect = 1 
//                        AND answerID = " . ${selectedAnswer . $i};
//
//                $result = mysqli_query($conn, $sql);
//
//                if (mysqli_num_rows($result) > 0) {
//                    while($row = mysqli_fetch_assoc($result)) {
//                        $numCorrect++;
//                    }
//                } else {
//                }
//                $i++;
//            }
//
//            $percentCorrect = ($numCorrect / $numOfQuestions) * 100;
//            $percentCorrect = round($percentCorrect);

            ?>

            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-body panel-results">
                            <?php
                            echo "<h4>Test results for " . $fName . " " . $lName . ":</h4>";
                            ?>
                            <ul>
                                <?php
                                $sql = "SELECT quizName
                                        FROM quizzes
                                        WHERE quizID = " . $selectedQuizID;

                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<li>You completed the " . $row[quizName] . " assesment test.</li>";
                                    }
                                } else {
                                    echo "No results found.";
                                }
                                ?>
                                <?php echo "<li>Your score was: " . $percentCorrect . "%</li>"; ?>
                                <?php echo "<li>Please print these results for your records.</li>"; ?>
                            </ul>
                            <div class="text-right">
                                <button onclick="printThis()" type="button" class="btn btn-default">Print Results</button>
                                <script>
                                    function printThis() {
                                        window.print();
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-body panel-results">
                            <h4>Contact Information:</h4>
                            <ul>
                                <?php
                                $sql = "SELECT instructors.instructorPhone, instructors.instructorEmail, instructors.instructorFirst, instructors.instructorLast 
                                        FROM instructors JOIN quizzes 
                                        WHERE quizzes.instructorID = instructors.instructorID AND quizzes.quizID =" . $selectedQuizID;

                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $phone = $row[instructorPhone];
                                        echo "<li><b>Name:</b> " . $row[instructorFirst] . " " .  $row[instructorLast] . "</li>";
                                        echo "<li><b>Phone:</b> " . $phone . "</li>"; 
                                        echo "<li><b>Email:</b> " . $row[instructorEmail] . "</li>";
                                    }
                                } else {
                                    echo "No results found.";
                                }
                                ?>
                            </ul>
                            <div class="text-right">
                                <button type="button" class="btn btn-default">
                                    <a href='mailto:<?php
                                             $sql = "SELECT instructorEmail
                                            FROM instructors JOIN quizzes 
                                            WHERE quizzes.instructorID = instructors.instructorID AND quizzes.quizID =" . $selectedQuizID;

                                             $result = mysqli_query($conn, $sql);
                                             if (mysqli_num_rows($result) > 0) {
                                                 while ($row = mysqli_fetch_assoc($result)) {
                                                     echo $row[instructorEmail];
                                                 }
                                             } else {
                                                 echo "No results found.";
                                             }
                                             ?>?Subject=Test%20Results'>Email
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="moreInfo" class="col-lg-13">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4>For more information Visit: </h4>
                        <ul>
                            <?php

                            $sql = "SELECT quizName, deptURL 
                                        FROM quizzes 
                                        WHERE quizID =" . $selectedQuizID;
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<li> <a href='" . $row[deptURL] . "' target='_blank'>CWI " . $row[quizName] . " Department Page </a></li>";
                                }
                            }
                            else {echo "No Results Found";}
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- closes container -->
        <!-- Insert information into the database -->
        <?php
//        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//            $quizID = intval($_POST['selectedQuizID']);
//            $studentEmail = htmlspecialchars($_POST['studentEmail']);
//            $studentFName = htmlspecialchars($_POST['studentFName']);
//            $studentLName = htmlspecialchars($_POST['studentLName']);
//            $studentID    = intval($_POST['studentID']); 
//
//            // For student results insertion into database
//            // references each question and answers index
//            // by creating an abitrarily formatted string as 'Q:A, Q:A, ... '  
//            $numQs = intval($_POST['numOfQuestions']);
//            $answerList = "";
//            for($i = 1; $i < $numQs; $i++) {
//                $answerList .= $_POST['questionID-'.$i] . ":" . $_POST['answer'.$i] . ( $numQs-1 === $i ? "" : "," ); // if questions is at the end append nothing
//            }		
//
//            $mysqltime = date("Y-m-d H:i:s");
//
//            // added answerSet column and answer list
//            $sql = "INSERT INTO responses 
//                (responseID, quizID, studentEmail, studentFirst, studentLast, studentCwiID, studentScore, submitTime, answerSet)
//                VALUES
//                (null, '$quizID', '$studentEmail', '$studentFName', '$studentLName', '$studentID', '$percentCorrect', '$mysqltime', '$answerList')";
//
//            $result = mysqli_query($conn, $sql);
//        } else {
//            echo "Test";
//        }
        ?>
    </body>
</html>
