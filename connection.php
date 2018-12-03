<?php
            $serverName = "172.22.4.104";
            $userName = "iaa_user";
            $passWord = 'Fall2018.';
            $dbName = "iaa";

            $conn = new mysqli($serverName, $userName, $passWord, $dbName);

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
        ?> 