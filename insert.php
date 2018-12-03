<?php
require 'connection.php';

$i = 1;
$selectedQuizID = intval($_POST['selectedQuizID']);
$numOfQuestions = intval($_POST['numOfQuestions']);
$numCorrect = 0;
$percentCorrect = 0;

// Set up selectedAnswer variables for however many questions there are.
while ($i <= $numOfQuestions) {
    ${'selectedAnswer' . $i} = intval($_POST['answer' . $i]);
    $i++;
}

$email = htmlspecialchars($_POST['studentEmail']);
$fName = htmlspecialchars($_POST['studentFName']);
$lName = htmlspecialchars($_POST['studentLName']);
$studentID = intval($_POST['studentID']);

// Find out if selected answers are correct
$i = 1;
while ($i <= $numOfQuestions) {

    $sql = "SELECT * 
                        FROM answers
                        WHERE isCorrect = 1 
                        AND answerID = " . ${'selectedAnswer' . $i};

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $numCorrect++;
        }
    } else {
    }
    $i++;
}

$percentCorrect = ($numCorrect / $numOfQuestions) * 100;
$percentCorrect = round($percentCorrect);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quizID = intval($_POST['selectedQuizID']);
    $studentEmail = htmlspecialchars($_POST['studentEmail']);
    $studentFName = htmlspecialchars($_POST['studentFName']);
    $studentLName = htmlspecialchars($_POST['studentLName']);
    $studentID    = intval($_POST['studentID']); 

    // For student results insertion into database
    // references each question and answers index
    // by creating an abitrarily formatted string as 'Q:A, Q:A, ... '  
    $numQs = intval($_POST['numOfQuestions']);
    $answerList = "";
    for($i = 1; $i < $numQs; $i++) {
        $answerList .= $_POST['questionID-'.$i] . ":" . $_POST['answer'.$i] . ( $numQs-1 === $i ? "" : "," ); // if questions is at the end append nothing
    }	

    $mysqltime = date("Y-m-d H:i:s");

    // added answerSet column and answer list
    $sql = "INSERT INTO responses 
                (responseID, quizID, studentEmail, studentFirst, studentLast, studentCwiID, studentScore, submitTime, answerSet)
                VALUES
                (null, '$quizID', '$studentEmail', '$studentFName', '$studentLName', '$studentID', '$percentCorrect', '$mysqltime', '$answerList')";

   $result = mysqli_query($conn, $sql);
?>
<form action="results.php" method="post" name="resultsForm">
    <?php
    echo "<input type='hidden' name='selectedQuizID' value='" . $quizID . "'>",
    "<input type='hidden' name='studentFName' value='" . $studentFName . "'>",
    "<input type='hidden' name='studentLName' value='" . $studentLName . "'>",
    "<input type='hidden' name='studentID' value='" . $studentID . "'>",
    "<input type='hidden' name='percentCorrect' value='" . $percentCorrect . "'>",
    "<input type='hidden' name='studentEmail' value='" . $email . "'>";
    ?>
    <noscript><input class="btn btn-default" name="submit" type="submit" value="Confirm Assesment Submission"></noscript>
</form>

<script type="text/javascript">
    document.resultsForm.submit();
</script>

<?php
} else {
    header("Location: error.php", true, 303);
}

?>