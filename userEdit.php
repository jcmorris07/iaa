<!DOCTYPE html>
<html>
<head>
    <?php require 'connection.php';?>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- user edit css -->
    <link rel="stylesheet" type="text/css" href="css/userEdit.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
    
<body>
    <div class="container">
        <div class="jumbotron">
            <img id="logo" src="images/Logo.png" />   
            <h2>User Settings</h2>
            <div class="row text-center">
                <div class="col-lg-12">
                </div>
            </div>
        </div>

        <a href="superAdmin.php"><button type="button" class="btn btn-default">Go Back</button></a>
        <a href="editUser.php"><button type="button" class="btn btn-default">Add New User</button></a>

        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="text-center">	
                            <label>Name:</label> <input type="text"></input><br>
                            <label>Email:</label> <input type="text"></input><br>
                            <label>Phone:</label> <input type="text"></input><br>
                            <label>Password:</label><input type="text"></input><br>
                            <button type="button" class="btn btn-default">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
