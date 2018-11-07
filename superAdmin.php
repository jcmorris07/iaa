<!DOCTYPE html>
<html>
    <head>
        <?php require 'connection.php';?>
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

        <!-- super admin -->
        <link rel="stylesheet" type="text/css" href="css/superAdmin.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </head>

    <body>

        <div class="container">
            <div class="jumbotron">
                <img id="logo" src="images/Logo.png" />	
                <h3>Super Admin Panel</h3>
                <div class="row text-right">
                    <div class="col-lg-12">
                        <p>Admin Name Here</p><span><a href="login.php"><button type="button" class="btn btn-default">Log Out</button></a></span>
                    </div>
                </div>
            </div>

            <table class="table table-bordered">

                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Password</th>
                    <th>Options</th>
                </tr>
                <tr>
                    <td>Data</td>
                    <td>Data</td>
                    <td>Data</td>
                    <td>Data</td>
                    <td>Data</td>
                    <td>
                        <a href="userEdit.php"><button type="button" class="btn btn-default">Edit</button></a>
                        <button type="button" class="btn btn-default">Delete</button>
                    </td>
                </tr>
            </table>
            <!-- adminUsers -->

            <div class="quizResultsWrapper">
                <div class="quizResults">
                    <h4>Quiz Results 1</h4>
                    <table class="table table-bordered">

                        <tr>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                        </tr>
                        <tr>
                            <td>Data</td>
                            <td>Data</td>
                            <td>Data</td>
                            <td>Data</td>
                            <td>Data</td>
                            <td>Data</td>
                            <td>
                                <button type="button" class="btn btn-default">View</button>
                                <button type="button" class="btn btn-default">Delete</button>
                            </td>
                        </tr>
                    </table>
                </div> <!-- quizResults -->

                <div class="quizResults">
                    <h4>Quiz Results 2</h4>
                    <table class="table table-bordered">

                        <tr>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                        </tr>
                        <tr>
                            <td>Data</td>
                            <td>Data</td>
                            <td>Data</td>
                            <td>Data</td>
                            <td>Data</td>
                            <td>Data</td>
                            <td>
                                <button type="button" class="btn btn-default">View</button>
                                <button type="button" class="btn btn-default">Delete</button>
                            </td>
                        </tr>
                    </table>
                </div> <!-- quizResults -->

                <div class="quizResults">
                    <h4>Quiz Results 3</h4>
                    <table class="table table-bordered">

                        <tr>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                        </tr>
                        <tr>
                            <td>Data</td>
                            <td>Data</td>
                            <td>Data</td>
                            <td>Data</td>
                            <td>Data</td>
                            <td>Data</td>
                            <td>
                                <button type="button" class="btn btn-default">View</button>
                                <button type="button" class="btn btn-default">Delete</button>
                            </td>
                        </tr>
                    </table>
                </div> <!-- quizResults -->

                <div class="quizResults">
                    <h4>Quiz Results 4</h4>
                    <table class="table table-bordered">

                        <tr>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                            <th>Heading</th>
                        </tr>
                        <tr>
                            <td>Data</td>
                            <td>Data</td>
                            <td>Data</td>
                            <td>Data</td>
                            <td>Data</td>
                            <td>Data</td>
                            <td>
                                <button type="button" class="btn btn-default">View</button>
                                <button type="button" class="btn btn-default">Delete</button>
                            </td>
                        </tr>
                    </table>
                </div> <!-- quizResults -->
            </div><!-- closes quizResultsWrapper -->

            <div class="row" id="yourQuiz">
                <div class="col-lg-12">
                    <a href="admin.php"><button type="button" class="btn btn-default">Go to Admin Panel</button></a>

                </div>
            </div><!--Your Quiz Row -->

        </div><!-- container -->
    </body>
</html>
